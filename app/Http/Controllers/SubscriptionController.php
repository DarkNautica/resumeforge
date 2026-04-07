<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Stripe\Checkout\Session;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;
use Stripe\Webhook;

class SubscriptionController extends Controller
{
    public function plans(): View
    {
        return view('plans');
    }

    public function buyCredit(Request $request): RedirectResponse
    {
        $user = $request->user();
        Stripe::setApiKey(config('services.stripe.secret'));

        $customerId = $this->resolveCustomer($user);

        $session = Session::create([
            'customer'    => $customerId,
            'mode'        => 'payment',
            'line_items'  => [[
                'price'    => config('services.stripe.credit_price_id'),
                'quantity' => 1,
            ]],
            'metadata'           => ['type' => 'credit', 'user_id' => $user->id],
            'success_url'        => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'         => route('plans'),
        ]);

        return redirect($session->url);
    }

    public function subscribe(Request $request): RedirectResponse
    {
        $user = $request->user();
        Stripe::setApiKey(config('services.stripe.secret'));

        $customerId = $this->resolveCustomer($user);

        $session = Session::create([
            'customer'    => $customerId,
            'mode'        => 'subscription',
            'line_items'  => [[
                'price'    => config('services.stripe.subscription_price_id'),
                'quantity' => 1,
            ]],
            'metadata'           => ['type' => 'subscription', 'user_id' => $user->id],
            'success_url'        => route('subscription.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'         => route('plans'),
        ]);

        return redirect($session->url);
    }

    public function success(Request $request): View|RedirectResponse
    {
        $sessionId = $request->query('session_id');

        if (! $sessionId) {
            return redirect()->route('dashboard');
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        $session = Session::retrieve($sessionId);

        if ($session->payment_status !== 'paid' && $session->status !== 'complete') {
            return redirect()->route('plans')->with('warning', 'Payment not completed. Please try again.');
        }

        $user = $request->user();
        $type = $session->metadata->type ?? null;

        if ($type === 'credit') {
            $user->increment('tailor_credits');
            $message = 'Credit added! You can now tailor one resume.';
        } elseif ($type === 'subscription') {
            $user->update(['subscription_status' => 'active']);
            $message = 'Subscription active! Tailor unlimited resumes.';
        } else {
            return redirect()->route('dashboard');
        }

        return view('subscription.success', compact('message', 'type'));
    }

    public function cancel(Request $request): RedirectResponse
    {
        $request->validate([
            'confirmation' => 'required|in:CANCEL',
        ], [
            'confirmation.in' => 'You must type CANCEL exactly to confirm.',
        ]);

        $user = $request->user();

        if (! $user->isSubscribed() || ! $user->stripe_customer_id) {
            return redirect()->route('billing.index')
                ->with('warning', 'No active subscription to cancel.');
        }

        try {
            Stripe::setApiKey(config('services.stripe.secret'));

            $subscriptions = StripeSubscription::all([
                'customer' => $user->stripe_customer_id,
                'status'   => 'active',
                'limit'    => 1,
            ]);

            $sub = $subscriptions->data[0] ?? null;

            if (! $sub) {
                $user->update(['subscription_status' => null]);
                return redirect()->route('billing.index')
                    ->with('warning', 'Subscription was already inactive.');
            }

            // Cancel at period end so the user keeps access until billing date
            StripeSubscription::update($sub->id, [
                'cancel_at_period_end' => true,
            ]);

            $user->update(['subscription_status' => 'canceling']);

            return redirect()->route('billing.index')
                ->with('success', 'Your subscription has been cancelled. You\'ll keep access until the end of your current billing period.');
        } catch (\Throwable $e) {
            \Log::error('Subscription cancel failed', ['error' => $e->getMessage()]);
            return redirect()->route('billing.index')
                ->with('warning', 'We couldn\'t cancel your subscription right now. Please try again or contact support.');
        }
    }

    public function webhook(Request $request): Response
    {
        $payload   = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent(
                $payload,
                $sigHeader,
                config('services.stripe.webhook_secret')
            );
        } catch (SignatureVerificationException $e) {
            return response('Invalid signature.', 400);
        }

        match ($event->type) {
            'customer.subscription.updated' => $this->handleSubscriptionUpdated($event->data->object),
            'customer.subscription.deleted' => $this->handleSubscriptionDeleted($event->data->object),
            default                         => null,
        };

        return response('OK', 200);
    }

    // ─── Private helpers ─────────────────────────────────────────────────────

    private function resolveCustomer(User $user): string
    {
        if ($user->stripe_customer_id) {
            return $user->stripe_customer_id;
        }

        $customer = \Stripe\Customer::create([
            'email'    => $user->email,
            'name'     => $user->name,
            'metadata' => ['user_id' => $user->id],
        ]);

        $user->update(['stripe_customer_id' => $customer->id]);

        return $customer->id;
    }

    private function handleSubscriptionUpdated(object $subscription): void
    {
        $user = User::where('stripe_customer_id', $subscription->customer)->first();

        if (! $user) {
            return;
        }

        $status = match ($subscription->status) {
            'active', 'trialing' => 'active',
            default              => null,
        };

        $user->update(['subscription_status' => $status]);
    }

    private function handleSubscriptionDeleted(object $subscription): void
    {
        $user = User::where('stripe_customer_id', $subscription->customer)->first();
        $user?->update(['subscription_status' => null]);
    }
}
