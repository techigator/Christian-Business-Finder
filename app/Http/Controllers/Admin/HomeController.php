<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use App\Models\Order;

use Auth;
use Gate;

class HomeController extends Controller
{
    public function dashboard()
    {

        if (auth()->check()) {
            return view('admin.dashboard');
        } else {
            return redirect()->route('admin.login')->with('ERROR', 'Session expire again login to access admin panel.');
        }
	    /*if (Gate::denies('isAdmin'))
			abort(403);*/

        $bookings = Order::selectRaw("COUNT(*) t_orders, DATE_FORMAT(created_at, '%Y-%m-%e') date")/*->where('status',6)*/->groupBy('date')->get()->toArray();

        $total_orders = array_column($bookings, 't_orders');
        $created_at = array_column($bookings, 'date');

        return view('admin.dashboard')->with('total_orders', $total_orders)->with('created_at', $created_at);
    }

    public function logout()
    {
    	Auth::logout();
  		return redirect('admin');
    }
    public function category_index()
    {
    	$category= category::where('is_active',1)->get();
  		return view('admin.category.index',compact('category'))->with('i', (request()->input('page', 1) - 1) * 100);;
    }
}
