<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Only the site owner is allowed past this point.
     * Anyone else gets a 404 — we don't reveal the route exists.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || $request->user()->email !== 'jaydenlyricr@gmail.com') {
            abort(404);
        }

        return $next($request);
    }
}
