<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureBusinessRole
{
    /**
     * Ensure the authenticated user has one of the allowed roles on the active business.
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();
        $business = $request->attributes->get('activeBusiness');
        if (!$user || !$business) {
            abort(403);
        }
        $role = $user->businesses()->where('business_id', $business->id)->value('role');
        if (!$role || (!empty($roles) && !in_array($role, $roles))) {
            abort(403);
        }
        return $next($request);
    }
}
