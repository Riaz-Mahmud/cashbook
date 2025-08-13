<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
        $book = $request->route('book');
        if (!$user || !$business || (!$book && empty($roles))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden 1'], 403);
            }
            abort(403);
        }
        $role = $book ? $user->getBookRole($book) : $user->businesses()->where('business_id', $business->id)->value('role');
        if (!$role || (!empty($roles) && !in_array($role, $roles))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Forbidden 1'], 403);
            }
            abort(403);
        }
        return $next($request);
    }
}
