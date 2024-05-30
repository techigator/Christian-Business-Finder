<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class AuthenticationController extends Controller
{
    public function admin_authentication(Request $request)
	{
		$request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password, 'type' => ['admin', 'sales_person']]))
        	return redirect()->intended('admin/dashboard')->with('SUCCESS','Signed in successfully');

  		return redirect("admin/login")->with('ERROR','Login details are not valid');
	}

}
