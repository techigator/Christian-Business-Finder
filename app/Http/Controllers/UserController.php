<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Buisness;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userIndex()
    {
        $loggedInUser = Auth::user();

        if ($loggedInUser->type === 'sales_person') {
            $users = User::where('created_by', $loggedInUser->id)
                ->orderBy('created_at', 'desc')->latest()->paginate(20);
            $userTypes = [
                'user',
                'sales_person'
            ];
        } else {
            $users = User::orderBy('created_at', 'desc')->latest()->paginate(10);
            $userTypes = [
                'admin',
                'user',
                'sales_person'
            ];
        }
        
        return view('users.index', compact('users', 'userTypes'));
    }
    
    public function userAddByAdmin(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => ['required', 'string', 'max:255'],
            'user_email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'user_password' => ['required', 'string', 'min:8', 'confirmed'],
            'user_number' => 'required',
            'date_of_birth' => 'required',
            'user_gender' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'success' => false,
        //         'Errors' => $validator->messages()
        //     ]);
        // }

        $created_by = $request->created_by;
        $user_name = $request->user_name;
        $user_email = $request->user_email;
        $user_number = $request->user_number;
        $date_of_birth = $request->date_of_birth;
        $user_gender = $request->user_gender;
        $password = $request->user_password;

        $user = new User();
        $user->type = 'user';
        $user->created_by = $created_by;
        $user->login_from = 'website';
        $user->name = $user_name;
        $user->email = $user_email;
        $user->number = $user_number;
        $user->date_of_birth = $date_of_birth;
        $user->gender = $user_gender;
        $user->password = Hash::make($password);

        if ($request->hasFile('profile_image')) {
            $profile_image = Str::random(17) . $request->file('profile_image')->getClientOriginalName();
            $request->profile_image->move(public_path('assets/uploads/user'), $profile_image);
            $user->profile_image = $profile_image;
        }

        $user->save();

        if (Auth::user()->type === 'admin') {
            return redirect()->route('user.index')
                ->with('success', 'User created successfully');
        } else {
            return redirect()->route('user.sales.index')
                ->with('success', 'User created successfully');
        }
    }
    
    public function show($id)
    {
        $user = User::find($id);
        $business = null;

        if ($user) {
            $businesses = Buisness::with('category')->where('user_id', $user->id)->get();

            if ($businesses) {
                $business = $businesses->map(function ($businessData) {
                    return [
                        'category_name' => $businessData->category->name,
                        'name' => $businessData->name,
                        'state' => $businessData->state,
                        'rating' => $businessData->rating,
                        'image' => asset('') .'/uploads/business/'. $businessData->images,
                        'opening_hour' => $businessData->opening_hour,
                        'detail' => $businessData->detail,
                        'location' => $businessData->location,
                        'longtitude' => $businessData->longtitude,
                        'latitude' => $businessData->latitude,
                    ];
                });
            }
        }

        $data = [
            'type' => $user->type,
            'name' => $user->name,
            'email' => $user->email,
            'number' => $user->number,
            'date_of_birth' => $user->date_of_birth,
            'gender' => $user->gender,
            'home_church_address' => $user->home_church_address,
            'denomination' => $user->denomination,
            'profile' => asset('assets/uploads/user') . '/' . $user->profile_image,
        ];

        return response()->json([
            'user' => $data,
            'business' => $business,
        ]);
    }
    
    public function userEdit($id)
    {
        $user = User::find($id);
        return response()->json($user);
    }

    public function userUpdate(Request $request)
    {
        $this->validate($request, [
            'user_type' => 'required',
        ]);

        $id = $request->input('id');
        $newRole = $request->input('user_type');

        $user = User::find($id);
        $user->type = $newRole;
        $user->save();

        return redirect()->route('user.index')
            ->with('success', 'User role updated successfully');
    }
    
    public function exportUsers()
    {
        $loggedInUser = Auth::user();

        if ($loggedInUser->type === 'sales_person') {
            $users = User::where('created_by', $loggedInUser->id)
                ->orderBy('created_at', 'desc')->latest()->paginate(20);
            $user_report = $users->map(function ($user, $index) {
                $type = str_replace('_', ' ', ucwords($user->type));
                return [
                    $index + 1,
                    $type,
                    $user->name,
                    $user->email,
                ];
            });

            return Excel::download(new UsersExport($user_report->toArray()), 'users-report.xlsx');
        } else {
            $users = User::all();
            $user_report = $users->map(function ($user, $index) {
                $type = str_replace('_', ' ', ucwords($user->type));
                return [
                    $index + 1,
                    $type,
                    $user->name,
                    $user->email,
                ];
            });

            return Excel::download(new UsersExport($user_report->toArray()), 'users-report.xlsx');
        }
    }
}
