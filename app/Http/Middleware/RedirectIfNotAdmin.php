<?php
namespace App\Http\Middleware;
use Closure;
class RedirectIfNotAdmin
{
    public function handle($request, Closure $next, $adminLvl)
    {
        dd($adminLvl);
        if(!auth()->guard('admin')->check()) {
            return redirect(route('admin.login'));
        }
        return $next($request);
    }
}
