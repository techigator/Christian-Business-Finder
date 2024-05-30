<?php

namespace App\Http\Controllers;

use App\Models\AdminNotification;
use App\Models\SalesPersonUser;
use App\Models\User;
use App\Models\Buisness;
use App\Exports\UsersExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Kreait\Firebase\Exception\FirebaseException;
use Kreait\Firebase\Exception\MessagingException;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function userIndex($slug = null)
    {
        if ($slug === null) {
            $slug = '';
        }

        $loggedInUser = Auth::user();
        $userTypes = [
            'church',
            'consumer',
            'business',
            'paid_member',
            'sales_person',
        ];

        if ($loggedInUser->type === 'sales_person') {
            $salesPersons = SalesPersonUser::with('users')->where('referral_id', $loggedInUser->id)->get();
            $userIds = $salesPersons->pluck('users.id')->filter()->all();
            $users = User::whereIn('id', $userIds)->orderBy('created_at', 'desc')->paginate(20);
        } else {
            $users = User::with('referral_person')->where('type', $slug)->orderBy('created_at', 'desc')->latest()->paginate(10);
        }

        return view('users.index', compact('users', 'userTypes', 'loggedInUser', 'slug'));
    }

    public function addUser(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'number' => 'required',
            'date_of_birth' => 'required',
            'gender' => 'required',
            'profile_image' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $loggedInUser = Auth::user();

        $referred_id = $request->input('referred_id');
        $referral_code = $request->input('referral_code');
        $name = $request->input('name');
        $email = $request->input('email');
        $number = $request->input('number');
        $date_of_birth = $request->input('date_of_birth');
        $gender = $request->input('gender');
        $password = $request->input('password');
        $userType = $request->input('type');

        $user = new User();
        if ($userType === 'sales_person') {
            $user->referral_code = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);
            $user->type = $userType;
        } else {
            $user->type = $userType;
        }

        $user->login_from = 'website';
        $user->name = $name;
        $user->email = $email;
        $user->number = $number;
        $user->date_of_birth = $date_of_birth;
        $user->gender = $gender;
        $user->password = Hash::make($password);

        if ($request->hasFile('profile_image')) {
            $profile_image = Str::random(17) . $request->file('profile_image')->getClientOriginalName();
            $request->profile_image->move(public_path('assets/uploads/user'), $profile_image);
            $user->profile_image = $profile_image;
        }
        $user->save();

        if ($loggedInUser->type === 'sales_person') {
            $salesPerson = new SalesPersonUser();
            $salesPerson->user_id = $user->id;
            $salesPerson->referral_id = $referred_id;
            $salesPerson->referral_code = $referral_code;

            $salesPerson->save();
        }

        if (Auth::user()->type === 'admin') {
            return redirect()->route('user.index', $userType)
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
                        'image' => asset('') . '/uploads/business/' . $businessData->images,
                        'opening_hour' => $businessData->opening_hour,
                        'detail' => $businessData->detail,
                        'location' => $businessData->location,
                        'longitude' => $businessData->longtitude,
                        'latitude' => $businessData->latitude,
                    ];
                });
            }
        }

        $data = [
            'type' => $user->type === 'paid_member' ? 'Paid' : 'Non-Paid',
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

    public function userStatus(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $isPaid = $request->input('is_paid') === '0';
        $user->type = $isPaid ? 'paid_member' : 'business';
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Status changed to ' . ($isPaid ? 'paid member' : 'business') . '.'
        ]);
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

    public function notificationIndex()
    {
        $notifications = AdminNotification::all();

        return view('notifications.index', compact('notifications'));
    }

    public function notificationStore(Request $request)
    {
        try {
            $userId = $request->input('user_id');
            $userType = $request->input('user_type');
            $notificationTitle = $request->input('notification_title');
            $notificationDescription = $request->input('notification_description');

            $notification = AdminNotification::create([
                'user_id' => $userId,
                'user_type' => implode(',', $userType),
                'notification_title' => $notificationTitle,
                'notification_description' => $notificationDescription,
            ]);

            $notification = new AdminNotification();
            $notification->user_id = $userId;
            $notification->user_type = implode(',', $userType);
            $notification->notification_title = $notificationTitle;
            $notification->notification_description = $notificationDescription;

            if ($request->hasFile('image')) {
                $image = Str::random(6) . '_' . $request->file('image')->getClientOriginalName();
                $request->image->move(public_path('uploads/notification/'), $image);
                $notification->image = $image;
            }


            $notification->save();

            $types = explode(',', $notification->user_type);
            $users = User::whereIn('type', $types)->get();

            $fcmTokens = [];
            foreach ($users as $user) {
                $fcmTokens[] = $user->fcm_token;
            }

            $factory = (new Factory)->withServiceAccount([
                "type" => "service_account",
                "project_id" => "christian-business-finder-app",
                "private_key_id" => "f7b0be0056ede86fb7d941448935e8673349fcaa",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvAIBADANBgkqhkiG9w0BAQEFAASCBKYwggSiAgEAAoIBAQDo3SEGdOXsw4nh\nIgF5oNk2BhB1R8AoS+i40fEKq1NrsUyGEEbXx1lZJdYZiFSzadv+LNoq/4P4wFlz\nkp8MV0wvfWSxAVu8zv9Hm1aL2gGZxb5NNUj1NH+eou03yzOADMlKk2B3eMuhp8cI\nHPHJa9e9k0Mud+4+npPI2Oytt4b7dbZsrilvKkQfvKNspzaUxR+9IDacjnkWN2nd\nSma3ZGslu4MJ/Cw2HGGfM2I3b1rs6J4PV5wce1qYOBUk3rp46l0/DPH9LpSNNLpR\n0dok2j9WSGzm8wGuyp1s6rlwxg94wU8LpiWalCPiM3+YXQt/FwNcV6rKtAhWdxaB\nFAHfSWzZAgMBAAECggEAElYLOi9tRXH2QvCDDjlAsVTT6fA+7M1hY2BAqzbnaDT7\nUhkpAuezHOZyT+tgxAnjZUXR3g3lreozgPq8JGQhXyHwElIJj7n69v//1h5R/vJH\ntFusRYafP/YTWM/a28vl88XcFDxCSJXmAbkJvvMLd2WHpjqSW4LwHyIZrOolKlqp\nigAFub2rH3d5+BmPCTaP54bPZaxUHzsQZ8kmc0J4eYzHn82r3Nb23TUw000AbwS2\n3V/7rlOXr1swDUV6Pym46wfsgZRhzrz2Ge+bDy320cMhkEtzz6fAnREXbzxGQIhY\nZ+crlNcjQnFBflDcheFF0MctIjqzIE/HwGmIelr/gQKBgQD98+j5FKsQAAbjV0f9\nM+CqPeFOs3emt//Oz2FJECMUymAdSGNXyFIqTsvtXwCJtjNnzJ3Jny6Ns52OeFTH\nF1ImflwuJkbpFnQQh3VQ+w/eXDP/qbTgBwMnvyGUy/JkJLwERXT/CSUHFjKw6y6f\nTsLVT5Vri5VWDV3j3HRNBnx8uQKBgQDqvbJtD2VwcKPLqb81Rbo2V5k+v9qiEnUJ\ntibqSgWMbZmYxgWveH0qVUmqWP/iDfKoIWWpAIxSg3pvPIYBiYe9eW/gXRlbfY9v\niAz3J2iAyfZ/RngLB2tf6Ptx90OotWVC0xxqWzoTtvgBUoF/n3was0q40I2G5zPV\nfsiwELWhIQKBgFxeA+Xc059dMyQrUd7RqKyjFzkF48Y69IsnOK5XdTsRpMXh12hN\nTz1eLaQnws1T/PyLGvUDte4KX4s7TzKe0912ZlbOy0nqRcrhShVrS8lH5g3ejxBQ\n3J/vT+qMB5zPE6fGD5jXnaUnOMbKs8lz3z+w05srSOTktbq0K4T8j/jZAoGAUhhV\ntl6UE2bRYgDTpkXkgezQ42klhVj/JY5Wvcl1d089UHiwtFVnMM7zHGhT1TMbkkFb\n1GckrBbfUtfP5em7V0CJJ+ZnX9/hshfasPVPTvtTAeAbS4AkxT4t8gWP3AjUiTJb\n1bZh8VMkGRJJx+B2/r+Fem01keB5+EiG10yAuQECgYAXPYzQUBiGSkNMdekFCGN4\nk/0xHbCZodZOTMibz2llfEjq0HjnJ+B8W08ad/iH1nFMGAS5+E2LaFLwxcLrDKv6\ny4xTPwU6j3j1K1X4HpTZI1/5xQsoRziw1exIHMvzMVUAyqqVkkwMDAWtlII59Phr\ncs18spIZENGJkFivRKIEYw==\n-----END PRIVATE KEY-----\n",
                "client_email" => "firebase-adminsdk-f7vc8@christian-business-finder-app.iam.gserviceaccount.com",
                "client_id" => "100015504870668066714",
                "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
                "token_uri" => "https://oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/firebase-adminsdk-f7vc8%40christian-business-finder-app.iam.gserviceaccount.com",
                "universe_domain" => "googleapis.com"
            ]);

            $messaging = $factory->createMessaging();
            $firebaseMessage = CloudMessage::new()
                ->withNotification([
                    'title' => $notificationTitle,
                    'body' => strip_tags($notificationDescription),
                ]);

            foreach ($fcmTokens as $token) {
                $messageToSend = clone $firebaseMessage;
                $messageToSend->withTarget('token', $token);
                $messaging->send($messageToSend);
            }

            return redirect()->route('notification.index')->with('success', 'Notification Send Successfully');
        } catch (\Exception $e) {
            return redirect()->route('notification.index')->with('error', $e->getMessage());
        } catch (MessagingException|FirebaseException $e) {
            return redirect()->route('notification.index')->with('error', $e->getMessage());
        }
    }

    public function notificationShow($id)
    {
        $notification = AdminNotification::find($id);

        $data = [
            'user_type' => explode(',', $notification->user_type),
            'image' => asset('uploads/notification/' . $notification->image),
            'notification_title' => $notification->notification_title,
            'notification_description' => $notification->notification_description,
        ];

        return response()->json($data);
    }

    public function notificationDestroy($id)
    {
        try {
            $notification = AdminNotification::find($id);
            $notification->delete();

            return response()->json([
                'success' => 'Notification Deleted Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ]);
        }
    }
}
