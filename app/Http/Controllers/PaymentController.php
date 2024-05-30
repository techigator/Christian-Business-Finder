<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user')->orderBy('created_at', 'desc')
            ->latest()
            ->paginate(10);

        return view('payment.index', compact('payments'));
    }

    public function show($id)
    {
        $user = User::find($id);

        $data = [
            'type' => $user->type === 'paid_member' ? 'Paid' : 'Non-Paid',
            'name' => $user->name,
            'email' => $user->email,
            'number' => $user->number,
            'date_of_birth' => $user->date_of_birth,
            'gender' => $user->gender,
            'home_church_name' => $user->home_church_name,
            'home_church_address' => $user->home_church_address,
            'denomination' => $user->denomination,
            'profile' => asset('assets/uploads/user') . '/' . $user->profile_image,
        ];

        return response()->json([
            'data' => $data
        ]);
    }

    public function delete($id)
    {
        $payment = Payment::find($id);
        $payment->delete();

        return response()->json([
            'message' => 'Payment deleted successfully'
        ]);
    }
}
