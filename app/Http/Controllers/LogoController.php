<?php

namespace App\Http\Controllers;

use App\Models\logo;
use Illuminate\Http\Request;
// use Request;
use Illuminate\Support\Facades\DB;
use Helper;
use Auth;
use Illuminate\Support\Str;

class LogoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function logo_index()
        {
        $menu = 'logo';
        $logo = logo::find(1);
        return view('logo.index', compact('logo', "menu"));
    }
    public function logo_update(Request $request)
    {
          $this->validate($request, [
            'file' => 'required|mimes:jpeg,png,jpg,gif,svg|max:50000',
        ]);
         $logo = logo::find(1);
         $path = "";
        if ($request->file('file') != '') {
            $filenumber = rand();
            $file = $request->file('file');
            $file->move(base_path('public/uploads/logo'), '_' . $filenumber . '.' . $file->getClientOriginalName());
            $path = 'uploads/logo/' . '_' . $filenumber . '.' . $file->getClientOriginalName();
        }
        $logo->img = $path;
        $logo->save();
        return redirect()->route('logo_index')
            ->with('success', 'Logo updated successfully');
    }
}
