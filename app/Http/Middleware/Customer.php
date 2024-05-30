<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\Auth;

class customer
{
    public function handle($request, Closure $next)
    {
        if (Auth::check() && (Auth::user()->type === 'sales_person' || Auth::user()->type === 'admin')) {
            return $next($request);
        } elseif (Auth::check() && Auth::user()->type == null) {
            return redirect()->route('admin/dashboard')->with('ERROR', "Session expire again login to access admin panel.");
        } else {
            return redirect()->route('admin.login')->with('ERROR', "Session expire again login to access admin panel.");
        }
    }
    public function terminate($request, $response){

    }
}
