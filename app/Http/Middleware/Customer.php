<?php
namespace App\Http\Middleware;
use Closure;
use Auth;
class customer
{
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            if (Auth::user()->type == 'admin') {
                return $next($request);
            } elseif (Auth::user()->type == null) {
                return redirect()->route('dashboard')->with('ERROR', "Session expire again login to access admin panel.");
            } else {
                return redirect()->route('admin.login')->with('ERROR', "Session expire again login to access admin panel.");
            }
        } else {
            return redirect()->route('admin.login');
        }
    }
    public function terminate($request, $response){
        
    }
}
