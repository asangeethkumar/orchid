<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Storage;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIFriendsController extends Controller
{
    public function SendFriendRequest (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sender_user_id' => 'required|exists:users,user_id',
            'receiver_user_id' => 'required|exists:users,user_id',
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $sender_user_id = $request->get('sender_user_id');
        $receiver_user_id = $request->get('receiver_user_id');
        
        $existing_request = DB::table('friend_request')
                    ->where('sender_id','=',$sender_user_id)
                    ->where('receiver_id','=',$receiver_user_id)
                    ->select('friend_request.*')
                    ->get();
        
        if(count($existing_request)){
            return Response::json(array(
                'status_code' => 409,
                'status' => 'Conflict',
                'message' => 'Friend Request Already Sent Earlier.'
            ));
        }
        
        $request_id = DB::table('friend_request')->insertGetId([
            ['sender_id' => $sender_user_id, 
             'receiver_id' => $receiver_user_id,
             'request_sent_date' => now(),
             'request_status' => 'SENT',
             'status_change_date' => now(),
             'created_at'=>now(),
             'updated_at'=>now()]
        ]);
        
        if($request_id){
            $is_blocked = DB::table('block_user')
                    ->where('blocked_user_id','=',$sender_user_id)
                    ->where('blocked_by_user_id','=',$receiver_user_id)
                    ->select('block_user.*')
                    ->get();
            
            if(!count($is_blocked)){
                $user_details = DB::table('users')
                        ->where('user_id','=',$sender_user_id)
                        ->select('users.*')
                        ->first();
                
                $first_name = $user_details->first_name;
                
                $message = $first_name.' has sent you a friend request.';
                
                DB::table('notifications')->insert([
                    ['user_id' => $receiver_user_id, 
                     'notification_messages' => $message,
                     'message_status' => 'NEW',
                     'reference' => 'request_id',
                     'reference_parameter' => $request_id,
                     'created_at'=>now(),
                     'updated_at'=>now()]
                ]);
                
            }
        }
            
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Friend Request Sent Successfully.'
        ));
    }
    
    public function listReceivedFriendRequests (Request $request){
        $validator = Validator::make($request->all(), [
            'receiver_user_id' => 'required|exists:users,user_id',
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $receiver_user_id = $request->get('receiver_user_id');
        
        $blocked_users = DB::table('block_user')
                    ->where('blocked_by_user_id','=',$receiver_user_id)
                    ->select('block_user.*')
                    ->get();
        
        if(count($blocked_users)){
            $blocked_user_ids = $blocked_users->toArray();
        }else{
            $blocked_user_ids = [];
        }
        
        $received_requests = DB::table('friend_request')
                ->join('users','users.user_id','=','friend_request.sender_id')
                ->where('friend_request.receiver_id','=',$receiver_user_id)
                ->whereNotIn('');
        
        
    }
    
    public function listSentFriendRequests (Request $request){
        $validator = Validator::make($request->all(), [
            'sender_user_id' => 'required|exists:users,user_id'            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $sender_user_id = $request->get('sender_user_id');
    }
    
    public function acceptFriendRequest (Request $request){
        $validator = Validator::make($request->all(), [
            'receiver_user_id' => 'required|exists:users,user_id'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $receiver_user_id = $request->get('receiver_user_id');
    }
    
    public function deleteReceivedFriendRequests (Request $request){
        $validator = Validator::make($request->all(), [
            'receiver_user_id' => 'required|exists:users,user_id'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $receiver_user_id = $request->get('receiver_user_id');
    }
    
    public function deleteSentFriendRequests (Request $request){
        $validator = Validator::make($request->all(), [
            'sender_user_id' => 'required|exists:users,user_id',
            'friend_request_ids' => 'required|array',
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $sender_user_id = $request->get('sender_user_id');
    }
    
    public function blockFriendRequests (Request $request){
        $validator = Validator::make($request->all(), [
            'blocked_by_user_id' => 'required|exists:users,user_id',
            'blocked_user_id' => 'required|exists:users,user_id',
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $blocked_by_user_id = $request->get('blocked_by_user_id');
        $blocked_user_id = $request->get('blocked_user_id');
    }
}
