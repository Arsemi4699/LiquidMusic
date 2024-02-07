<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, int $requRank=1): Response
    {
        if (!Auth::guard('admin')->check())
            return redirect(route('admin.login'));

        $adminRole = Auth::guard('admin')->user()->role;
        $rank = 1;
        if ($adminRole == 'super')
            return $next($request);
        else if ($adminRole == 'master')
            $rank = 2;
        if ($rank < $requRank)
            return redirect(route('admin.dashboard'));
        return $next($request);
    }
}
