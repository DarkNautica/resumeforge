<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Stripe\Stripe;
use Stripe\Subscription as StripeSubscription;

class BillingController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $nextBillingDate = null;
        $cancelAtPeriodEnd = false;

        if ($user->stripe_customer_id && $user->isSubscribed()) {
            try {
                Stripe::setApiKey(config('services.stripe.secret'));

                $subscriptions = StripeSubscription::all([
                    'customer' => $user->stripe_customer_id,
                    'status'   => 'all',
                    'limit'    => 1,
                ]);

                $sub = $subscriptions->data[0] ?? null;

                if ($sub) {
                    $nextBillingDate = $sub->current_period_end
                        ? \Carbon\Carbon::createFromTimestamp($sub->current_period_end)
                        : null;
                    $cancelAtPeriodEnd = (bool) ($sub->cancel_at_period_end ?? false);
                }
            } catch (\Throwable $e) {
                \Log::warning('Billing: failed to fetch Stripe subscription', ['error' => $e->getMessage()]);
            }
        }

        return view('billing.index', compact('user', 'nextBillingDate', 'cancelAtPeriodEnd'));
    }
}
