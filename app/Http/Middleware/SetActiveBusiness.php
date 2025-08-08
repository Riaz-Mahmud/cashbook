<?php

namespace App\Http\Middleware;

use App\Models\Business;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetActiveBusiness
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user()) {
            $activeId = session('active_business_id');
            if (!$activeId) {
                $activeId = $request->user()->businesses()->value('business_id');
                if ($activeId) {
                    session(['active_business_id' => $activeId]);
                }
            }
            if ($activeId) {
                $request->attributes->set('activeBusiness', Business::find($activeId));
            }
        }
        return $next($request);
    }
}
