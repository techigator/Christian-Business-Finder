<?php

namespace App\Http\Controllers;

use App\Models\setting;
use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\DB;
use Helper;
use Auth;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function setting_index()
    {
        $menu = 'setting';
        $setting = setting::find(1);
        return view('setting.index', compact('setting', "menu"));
    }
    public function setting_update(Request $request)
    {
        $this->validate($request, [
            'company' => 'required',
            'facebook' => 'required',
            'twitter' => 'required',
            'instagram' => 'required',
            // 'linkedin' => 'required',
            // 'trustpilot' => 'required',
            // 'reviews' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'copyright' => 'required',
        ]);
        $data = array();
        $data['company'] = $request->input('company');
        $data['facebook'] = $request->input('facebook');
        $data['twitter'] = $request->input('twitter');
        $data['instagram'] = $request->input('instagram');
        // $data['linkedin'] = $request->input('linkedin');
        // $data['trustpilot'] = $request->input('trustpilot');
        // $data['reviews'] = $request->input('reviews');
        $data['address'] = $request->input('address');
        $data['phone'] = $request->input('phone');
        $data['email'] = $request->input('email');
        $data['copyright'] = $request->input('copyright');
        $setting = setting::where('id', 1)->update($data);
        return redirect()->route('setting_index')
            ->with('success', 'Setting updated successfully');
    }
}
