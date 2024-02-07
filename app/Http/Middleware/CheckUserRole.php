<?php

namespace App\Http\Middleware;

use Closure;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        if ($user == null)
            return redirect('/');
        if ($user->role == 'artist')
            return redirect(RouteServiceProvider::STUDIO);

        if ($user->subscribe_ends)
            if ($user->subscribe_ends < Carbon::now())
                $user->update(['role' => 'basic']);
        return $next($request);
    }
}
