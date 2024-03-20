<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; 
use App\Model\groups; 
use App\Models\chat; 
use App\Models\Product_request; 
use App\Model\group_user; 
use App\Model\block_connection; 
use Auth;
use Crypt;

class ChatController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
 
   public function chat($id){
    $messages = chat::where("group_id",$id)->orWhere("to_user_id" ,Auth::user()->id)->orWhere("from_user_id" , Auth::user()->id)->where("is_active" ,1)->get();
    $group_id=$id;
    $product_user_request = Product_request::where('id',$group_id)->where('product_user_id',Auth::user()->id)->first();

    if ($product_user_request) {
        $user_id = $product_user_request['user_request_id'];
        $touser = User::where('id', $user_id)->first();
    }else{
        $user_request = Product_request::where('id',$group_id)->where('user_request_id',Auth::user()->id)->first();
        $user_id = $user_request['product_user_id'];
        $touser = User::where('id', $user_id)->first();
    }
    // dd($user_id);
    return view('web.chat')->with(compact('messages','group_id','touser'));
    }

    public function save_msg(Request $request){
        if(Auth::check() == true){
            
            $chatting = new chat();
            $chatting->message = $request->message;
            $product_user_request = Product_request::where('id',$request->group_id)->where('product_user_id',Auth::user()->id)->first();

            if ($product_user_request) {
                $chatting->to_user_id = $product_user_request['user_request_id'];
            }else{
                $user_request = Product_request::where('id',$request->group_id)->where('user_request_id',Auth::user()->id)->first();
                $chatting->to_user_id = $user_request['product_user_id'];
            }
            $chatting->from_user_id = Auth::user()->id;
            $chatting->group_id = $request->group_id;
            
             if($chatting->save()){

                $fromuser =User::find($chatting->from_user_id);
                
                if (isset($request->group_id)) {
                    $touser =User::find($request->to_user_id);
                    $response['tousername'] = "";
                    $response['touserimage'] = "";
                    $response['to_user_id'] = "";
                }else{
                    $touser =User::find($request->to_user_id);
                    $response['tousername'] = $touser->name;
                    $response['touserimage'] = $touser->profile_image;
                    $response['to_user_id'] = $request->to_user_id;
                }

                $response['fromusername'] = $fromuser->name;
                $response['fromuserimage'] = $fromuser->profile_image;
                $response['message'] = $request->message;
                
                $response['from_user_id'] = Auth::user()->id;
                $response['created_at'] = $chatting->created_at->diffForHumans();
                $response['clock']="";
                $response['status'] = true;
                return redirect()->back()->with('success',"Message successfuly sent...");

             }else{
                $response['status']=false;
                return redirect()->back()->with('error',"Something wrong");
             }   
        //   return json_encode($response);   
        }else
        {
            return redirect('login')->with('error',"Kindly login First");
        }
 }
 
 public function fetch_msg()
    {
        // dd($_POST);
        if(Auth::check() == true){
            $fromuser = Auth::user();
            $touser = User::where('id', $_POST['to'])->first();
            $chatting = chat::where("to_user_id" , $_POST['to'])->where("from_user_id" , $fromuser->id)
            ->orWhere("from_user_id" , $_POST['to'])->where("to_user_id" , $fromuser->id)
            ->where("is_active" ,1)->get();
            if($chatting){
                // to
                $touser =User::find($_POST['to']);
                $body = '';
                foreach($chatting as $chat){
                    //From body
                    if($chat->from_user_id == $fromuser->id){
                        $image=asset('web/images/icons/avatars/'. strtoupper($fromuser['name'][0]).'.svg');
                        $body .= '<div class="prof-icon d-flex"><img src="'.$image.'" alt=""><p><strong>'.$fromuser['name'].'</strong><br>'.date("F j, Y",strtotime($chat['created_at'])).'</p></div><div class="send"><div class="chat-text"><p>'.$chat['message'].'</p></div></div>';        
                    }else{
                        $image=asset('web/images/icons/avatars/'. strtoupper($touser['name'][0]).'.svg');
                        $body .= '<div class="prof-icon d-flex"><img src="'.$image.'" alt=""><p><strong>'.$touser['name'].'</strong><br>'.date("F j, Y",strtotime($chat['created_at'])).'</p></div><div class="send"><div class="chat-text"><p>'.$chat['message'].'</p></div></div>';
                    }
                }
                
                $response['body'] = $body;
                //$response['clock']="";
                $response['status'] = true;

             }else{
                $response['status']=false;
             }   
          return json_encode($response);   
        }else
        {
            return redirect('login')->with('error',"Kindly login First");
        }
    }
}

