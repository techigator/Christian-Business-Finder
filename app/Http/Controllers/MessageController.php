<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use App\Models\Message;
use App\Models\User;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;
use Pusher\Pusher;
use Validator;

class MessageController extends Controller
{
    public function index()
     {
         $messages = Message::with('sender', 'recipient')->get();

         return response()->json($messages);
     }

     public function sendMessage(Request $request)
     {
 //        $validator = Validator::make($request->all(), [
 //            'sender_id' => 'required|exists:users,id',
 //            'recipient_id' => 'required|exists:users,id',
 //            'message' => 'required|string',
 //        ]);
 //
 //        if ($validator->fails()) {
 //            return response()->json([
 //                'response_code' => 0,
 //                'message' => $validator->errors()->first(),
 //            ], 422);
 //        }

         try {
             $message = Message::create([
                 'sender_id' => $request->input('sender_id'),
                 'recipient_id' => $request->input('recipient_id'),
                 'content' => $request->input('message'),
             ]);

             $pusher = new Pusher(
                 env('PUSHER_APP_KEY'),
                 env('PUSHER_APP_SECRET'),
                 env('PUSHER_APP_ID'),
                 [
                     'cluster' => env('PUSHER_APP_CLUSTER'),
                     'useTLS' => true
                 ]
             );

             $pusher->trigger('my-chat-channel', 'my-new-message-event', ['message' => $request->input('message')]);

             return response()->json([
                 'response_code' => 1,
                 'message' => 'Message sent successfully.',
             ]);
         } catch (\Exception $e) {
             return response()->json([
                 'response_code' => 0,
                 'message' => $e->getMessage(),
             ], 500);
         }
     }

    /* Pusher Using Real Time Chat */
    /*public function index()
    {
        return view('index');
    }

    public function broadcast(Request $request)
    {
        broadcast(new NewMessage($request->get('message')))->toOthers();

        return view('broadcast', ['message' => $request->get('message')]);
    }

    public function receive(Request $request)
    {
        return view('receive', ['message' => $request->get('message')]);
    }*/
    /* Pusher Using Real Time Chat */
}
