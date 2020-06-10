<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Storage;
use App\Cards;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Image;

class APICardsController extends Controller
{
    public function uploadCards (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cards_category_id' => 'required|exists:cards_category_master,cards_category_id', 
            'cards_name' => 'nullable|string|max:255',
            'cards_description' => 'nullable|string|max:255',
            'is_user_uploaded' => 'required|string|max:10|in:Y,N',
            'user_id_if_user_uploaded' => 'required_if:is_user_uploaded,Y',
            'file' => 'required|string'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        $msg_file = $request->get('file');
                
        $file = base64_decode($msg_file);
        
        $filename = time().'_'.str_random(10).'.'.'png';
            
                   
        if(($request->get('is_user_uploaded')) == 'Y'){
            
            Storage::put('/public/images/cards/user/original/'. $filename, $file);    
            $url = Storage::url('public/images/cards/user/original/'.$filename);
                                    
            $userId = $request->get('user_id_if_user_uploaded');
            
            $cardsCategory = DB::table('cards_category_master')
                ->where('cards_category_master.cards_category_name','USER UPLOADED')
                ->select('cards_category_master.cards_category_id')
                ->first();
            
            $categoryId = $cardsCategory->cards_category_id;
                      
            $cards_name = $userId.'_'.$filename;
            
        } elseif (($request->get('is_user_uploaded')) == 'N'){
            $categoryId = $request->get('cards_category_id');
            $userId = null;
            $cards_name = $request->get('cards_name');
            
            Storage::put('/public/images/cards/admin/original/'. $filename, $file);    
            $url = Storage::url('public/images/cards/admin/original/'.$filename);                        
        }
        $cards_id = DB::table('cards_master')->insertGetId([
            'cards_category_id' => $categoryId,
            'cards_name' => $cards_name,
            'cards_description' => $request->get('cards_description'),
            'cards_location_url' => $url,
            'is_active' => 'Y',
            'is_user_uploaded' => $request->get('is_user_uploaded'),
            'user_id_if_user_uploaded' => $userId, 
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Card Uploaded Successfully',
            'cards_id'=> $cards_id
        ));
    }
    
    public function listAllCards (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        
        $cards = DB::table('cards_master')
                ->where('is_active','Y')
                ->where(function ($query) use ($user_id) {
                    $query->where('is_user_uploaded', '=', 'N')
                          ->orWhere('user_id_if_user_uploaded', '=', $user_id);
                })
                ->select(
                            'cards_id',
                            'cards_category_id',
                            'cards_name',
                            'cards_description',
                            'cards_location_url',
                            'user_id_if_user_uploaded'
                        )
                ->get();
        
        if (!count($cards)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Cards Not Found'            
            ));
        }
        
        $cardsList = $cards->toArray();
        
        //$serverName = request()->getSchemeAndHttpHost();
        
        $app_url =  env("APP_URL");
        
        //return $app_url;
                
        foreach ($cardsList as $data) {
            $data->cards_location_url = $app_url.$data->cards_location_url;
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Cards Retrieved Successfully',
            'output' => $cardsList
        ));
    }
    
    public function selectCard (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cards_id' => 'required|exists:cards_master,cards_id',
            'event_id' => 'required|exists:events,event_id',
            'selected_by_user_id' => 'required|exists:users,user_id',
            'recipient_id' => 'nullable|exists:users,user_id',
            'recipient_email' => 'nullable|email',
            'send_card_date' => 'required|date|date_format:Y-m-d H:i:s|after_or_equal:today',
            'recipient_social_media_id' => 'nullable|string|max:1024',
            'message' => 'nullable|string|max:1024',
            'message_file' => 'nullable|string',
            'file_extension' => 'nullable|string',
            'scrible_file' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $cards_id = $request->get('cards_id');
        $event_id = $request->get('event_id');
        $selected_by_user_id = $request->get('selected_by_user_id');
        $recipient_id = $request->get('recipient_id');
        $recipient_email = $request->get('recipient_email');
        $send_card_date = $request->get('send_card_date');
        $recipient_social_media_id = $request->get('recipient_social_media_id');
        $message = $request->get('message');
        $msg_file = $request->get('message_file');
        $file_extension = $request->get('file_extension');
        $scrible = $request->get('scrible_file');
        
        $file = base64_decode($msg_file);
        $scrible_message = base64_decode($scrible);
                
        $event_created = DB::table('events')
                ->where('event_id','=', $event_id)
                ->select('events.*')
                ->first();
            
        $event_created_by = $event_created->event_created_by;
        
        if($event_created_by != $selected_by_user_id){
            return Response::json(array(
                    'status_code' => 400,
                    'status' => 'Failure',
                    'message' => 'Only the creator of the event can add card'                   
                ));
        }
        
        if($file){
            $filename = time().'_'.str_random(10).'.'.$file_extension;
            Storage::put('/public/messageFiles/user/original/'. $filename, $file);    
            $url = Storage::url('public/messageFiles/user/original/'.$filename);
            
        } else{
            $filename = null;
            $url = null;
        }
        
        if($scrible_message){
            $scrible_image_name = time().'_'.str_random(10).'.'.'png';
            Storage::put('/public/messageFiles/user/original/'. $scrible_image_name, $scrible_message);    
            $scrible_url = Storage::url('public/messageFiles/user/original/'.$scrible_image_name);
            
        } else{
            $scrible_image_name = null;
            $scrible_url = null;
        }
        
        $event = DB::table('cards_events_mapping')
                ->where('event_id','=',$event_id)
                ->select('cards_events_mapping.*')
                ->first();
        
        
               
        if(!$event){
            $ce_mapping_id = DB::table('cards_events_mapping')->insertGetId([
                'cards_id' => $cards_id,
                'event_id' => $event_id,
                'recipient_id' => $recipient_id,
                'recipient_email' => $recipient_email,
                'send_card_date' => $send_card_date,
                'recipient_social_media_id' => $recipient_social_media_id,
                'email_sent_status' => 'NEW',
                'created_at'=>now(),
                'updated_at'=>now()
            ]);

            if($message || $file){
                $message_id = DB::table('cards_messages')->insertGetId([
                    'ce_mapping_id' => $ce_mapping_id,
                    'user_id' => $selected_by_user_id,
                    'message' => $message,
                    'file_location' => $url,
                    'file_name' => $filename,
                    'scrible_image' => $scrible_url,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);

            } else{
                $message_id = null;
            }

            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Card added to event Successfully',
                'cards_events_mapping_id' => $ce_mapping_id,
                'message_id' => $message_id
            ));
        } elseif ($event){
            $ev_id = $event->event_id;
            $ce_mapping_id = $event->ce_mapping_id;
            DB::table('cards_events_mapping')
                ->where('ce_mapping_id', $ce_mapping_id)
                ->update([
                            'cards_id' => $cards_id,
                            'event_id' => $event_id,
                            'recipient_id' => $recipient_id,
                            'recipient_email' => $recipient_email,
                            'send_card_date' => $send_card_date,
                            'recipient_social_media_id' => $recipient_social_media_id,
                            'updated_at'=>now()
                        ]);

            $cards_message = DB::table('cards_messages')
                    ->where('user_id','=', $selected_by_user_id)
                    ->where('ce_mapping_id','=', $ce_mapping_id)
                    ->select('cards_messages.*')
                    ->first();

            

            if(!$cards_message && ($message || $file)){
                $message_id = DB::table('cards_messages')->insertGetId([
                    'ce_mapping_id' => $ce_mapping_id,
                    'user_id' => $selected_by_user_id,
                    'message' => $message,
                    'file_location' => $url,
                    'file_name' => $filename,
                    'scrible_image' => $scrible_url,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);

            }elseif($cards_message && ($message || $file)){
                $message_id = $cards_message->message_id;
                DB::table('cards_messages')
                    ->where('message_id','=', $message_id)
                    ->update([
                        'ce_mapping_id' => $ce_mapping_id,
                        'user_id' => $selected_by_user_id,
                        'message' => $message,
                        'file_location' => $url,
                        'file_name' => $filename,
                        'scrible_image' => $scrible_url,
                        'created_at'=>now(),
                        'updated_at'=>now()
                    ]);
            } else{
                $message_id = null;
            }

            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Card updated to event Successfully',
                'cards_events_mapping_id' => $ce_mapping_id,
                'message_id' => $message_id
            ));
                    
        }
    }
    
    public function showSelectedCard(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,event_id'                  
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $event_id = $request->get('event_id');
        
        //$serverName = request()->getSchemeAndHttpHost();

        $app_url =  env("APP_URL");

        //return public_path();
        
        $card_data = DB::table('cards_events_mapping')
                ->join('cards_master','cards_master.cards_id','=','cards_events_mapping.cards_id')
                ->join('events','events.event_id','=','cards_events_mapping.event_id')
                ->leftjoin('users','users.user_id','=','cards_events_mapping.recipient_id')
                ->leftjoin('event_type_master','events.event_type_id','=','event_type_master.event_type_id')
                ->where('cards_events_mapping.event_id','=', $event_id)
                ->select(
                            'cards_events_mapping.ce_mapping_id',
                            'cards_events_mapping.event_id',
                            'events.event_name',
                            'cards_master.cards_id',
                            'cards_master.cards_name',
                            'cards_master.cards_location_url',
                            'cards_events_mapping.recipient_id as recipient_user_id',
                            'users.first_name as recipient_first_name',
                            'users.middle_name as recipient_middle_name',
                            'users.last_name as recipient_last_name',
                            'cards_events_mapping.recipient_email',
                            'cards_events_mapping.send_card_date',
                            'cards_events_mapping.recipient_social_media_id',
                            'event_type_master.event_type_id',
                            'event_type_master.event_type_name'
                        )
                ->first();
        
        if (!count($card_data)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Card Not Found For The Event'            
            ));
        }
        
        $messages = DB::table('cards_events_mapping')
                ->join('cards_messages','cards_messages.ce_mapping_id','=','cards_events_mapping.ce_mapping_id')
                ->join('users','users.user_id','=','cards_messages.user_id')
                ->join('events','events.event_id','=','cards_events_mapping.event_id')
                ->where('events.event_id','=', $event_id)
                ->select(
                            'cards_messages.message_id',
                            'cards_messages.message',
                            'cards_messages.file_location',
                            'cards_messages.file_name',
                            'cards_messages.scrible_image',
                            'users.user_id',
                            'users.first_name',
                            'users.middle_name',
                            'users.last_name',
                            'users.email',
                            'users.profile_picture'
                        )
                ->get();
        
        if (!count($messages) && !count($card_data)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Card Not Found For The Event'            
            ));
        }else{
        
            $user_mesaages = $messages->toArray();
            $default_profile_pic = env("DEFAULT_PROFILE_PIC");

            foreach ($user_mesaages as $data) {

                if($data->file_location != null){
                    $data->file_location = $app_url.$data->file_location;
                }
                
                if($data->scrible_image != null) {
                    $data->scrible_image = $app_url.$data->scrible_image;
                }
                
                $uri = $data->profile_picture;
            
                if(empty($uri)){
                    $data->profile_picture = $app_url.$default_profile_pic;
                }elseif(!preg_match( '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i' ,$uri)){
                    $data->profile_picture = $app_url.$data->profile_picture;
                }
            }
        }
        
        $card_data->cards_location_url = $app_url.$card_data->cards_location_url;
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Card Retrieved Successfully',
            'card_data' => $card_data,
            'user_messages' => $user_mesaages            
        ));
    }
    
    public function createMessage (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,event_id',
            'ce_mapping_id' => 'required|exists:cards_events_mapping,ce_mapping_id',
            'user_id' => 'required|exists:users,user_id',
            'message' => 'nullable|string|max:1024',
            'message_file' => 'nullable|string',
            'file_extension' => 'nullable',
            'scrible_file' => 'nullable|string'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $event_id = $request->get('event_id');
        $ce_mapping_id = $request->get('ce_mapping_id');
        $user_id = $request->get('user_id');
        $message = $request->get('message');
        $msg_file = $request->get('message_file');
        $file_ext = $request->get('file_extension');
        $scrible = $request->get('scrible_file');
        
        $file = base64_decode($msg_file);
        $scrible_message = base64_decode($scrible);
        //$serverName = request()->getSchemeAndHttpHost();
        $file_extension = strtolower($file_ext);
        
        $app_url =  env("APP_URL");
                
        $user = DB::table('event_participants')
                ->where('event_id','=', $event_id)
                ->where('user_id','=', $user_id)
                ->select('event_participants.*')
                ->first();
        
                
        if($user){
            $role_id = $user->role_id;
            
            $role = DB::table('event_participants_role_master')
                    ->where('role_id','=', $role_id)
                    ->where('is_active','=', 'Y')
                    ->select('event_participants_role_master.*')
                    ->first();
            if($role){
                $role_name = $role->role_name;
            }else{
                $role_name = null;
            }
        }else{
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'User not part of the event'            
            ));
        }
        
        $event = DB::table('events')
                ->where('event_id','=',$event_id)
                ->select('events.*')
                ->first();
        
        if($event){
            $response_by_time = $event->event_response_by_time;
        }
        
        $cards_events = DB::table('cards_events_mapping')
                ->where('event_id','=',$event_id)
                ->select('cards_events_mapping.*')
                ->first();
        
        if($cards_events){
            $send_card_date = $cards_events->send_card_date;
        }       
        
        if((now()>$response_by_time) && ($role_name != 'ADMIN') && ($role_name != 'SUPER ADMIN')){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Response by time is over. Cannot Add messages now.',
                $role_name
            ));
        }elseif(now()>$send_card_date){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Card is already sent. Cannot Add messages now.'            
            ));
        }
        
        if($role_name == 'MEMBER' || $role_name == 'ADMIN' || $role_name == 'SUPER ADMIN'){
                 
            $cards_message = DB::table('cards_messages')
                    ->where('cards_messages.ce_mapping_id','=', $ce_mapping_id)
                    ->where('cards_messages.user_id','=', $user_id)
                    ->select('cards_messages.*')
                    ->first();                    
                   
            if($cards_message){
                $message_id = $cards_message->message_id;
                $existing_message = $cards_message->message;
                $existing_file_location = $cards_message->file_location;
                $existing_file_name = $cards_message->file_name;
                $existing_scrible_url = $cards_message->scrible_image;
            }else{
                $message_id = null;
                $existing_message = null;
                $existing_file_location = null;
                $existing_file_name = null;
                $existing_scrible_url = null;
            }
            
        }else{
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'User does not have permission to write messages'            
            ));
        }
        
        if($file){
                //$filename = time().'_'.str_random(6).'_'.str_replace(' ', '_', $file->getClientOriginalName());
                $filename = time().'_'.str_random(10).'.'.$file_extension;
                Storage::put('/public/messageFiles/user/original/'. $filename, $file);    
                //$path = Storage::putFileAs('/public/messageFiles/user/original', $file, $filename,'public');
                //$url = Storage::url($path);
                $url = Storage::url('public/messageFiles/user/original/'.$filename);
                
                if($existing_file_location){
                    Storage::delete('/public/messageFiles/user/original/'.$existing_file_name);                    
                }               
                
            }elseif(!$file && $existing_file_location){
                $filename = $existing_file_name;
                $url = $existing_file_location;
                
            }elseif(!$file && !$existing_file_location){
                $filename = null;
                $url = null;
            }
        
        if($scrible_message){
            $scrible_image_name = time().'_'.str_random(10).'.'.'png';
            Storage::put('/public/messageFiles/user/original/'. $scrible_image_name, $scrible_message);    
            $scrible_url = Storage::url('public/messageFiles/user/original/'.$scrible_image_name);
            
        } elseif(!$scrible_message && $existing_scrible_url){
            $scrible_url = $existing_scrible_url;
        }else{
            $scrible_url = null;
        }
        
        if($url == null){
            $app_url = null;
        }
        
        if(!$message){
            $message = $existing_message;
        }
        
        if(($message && $message_id)||($file && $message_id) || ($scrible_message && $message_id)){
            DB::table('cards_messages')
                     ->where('message_id','=', $message_id)
                     ->update([
                            'message' => $message,
                            'file_location' => $url,
                            'file_name' => $filename,
                            'scrible_image' => $scrible_url,
                            'updated_at'=>now()
                        ]);
            
            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Message updated successfully',
                'message_id' => $message_id,
                'file_name' => $filename,
                'file_location' => $app_url.$url,
                'scrible_image' => $app_url.$scrible_url
            ));
             
        }elseif(($message && !$message_id)||($file && !$message_id) || ($scrible_message && !$message_id)){
            $message_id = DB::table('cards_messages')->insertGetId([
                    'ce_mapping_id' => $ce_mapping_id,
                    'user_id' => $user_id,
                    'message' => $message,
                    'file_location' => $url,
                    'file_name' => $filename,
                    'scrible_image' => $scrible_url,
                    'created_at'=>now(),
                    'updated_at'=>now()
                ]);
            
            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Message created successfully',
                'message_id' => $message_id,
                'file_name' => $filename,
                'file_location' => $app_url.$url,
                'scrible_image' => $app_url.$scrible_url
            ));
        }        
    }
    
    public function deleteCardMessages (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'ce_mapping_id' => 'required|exists:cards_events_mapping,ce_mapping_id',
            'message_ids' => 'required|array'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        $ce_mapping_id = $request->get('ce_mapping_id');
        $message_ids = $request->get('message_ids');
                       
        $event = DB::table('cards_messages')
                ->join('cards_events_mapping','cards_events_mapping.ce_mapping_id','=','cards_messages.ce_mapping_id')
                ->join('events','cards_events_mapping.event_id','=','events.event_id')
                ->where('cards_messages.ce_mapping_id','=',$ce_mapping_id)
                ->select('cards_events_mapping.*')
                ->first();
        
        if(!count($event)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No messages associated with the event'            
            ));
        }
        
        $event_id = $event->event_id;
        
        $is_admin = DB::table('event_participants')
                ->where('user_id','=',$user_id)
                ->where('event_id','=',$event_id)
                ->select('event_participants.*')
                ->first();
             
        if(!count($is_admin)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Not allowed to delete messages by this user'            
            ));
        }
        
        $card_send = DB::table('cards_events_mapping')
                ->where('ce_mapping_id','=',$ce_mapping_id)
                ->whereIn('event_id','=',$event_id)
                ->select('cards_events_mapping.*')
                ->first();
        
        if(count($card_send)){
            $send_card_date = $card_send->send_card_date;
            if($send_card_date < now()){
                return Response::json(array(
                    'status_code' => 400,
                    'status' => 'Failure',
                    'message' => 'Card already sent. Cannot delete messages now'            
                ));
            }
        }
        
        $role_id = $is_admin->role_id;
        
        $role = DB::table('event_participants_role_master')
                ->where('event_participants_role_master.role_id','=', $role_id)
                ->select('event_participants_role_master.*')
                ->first();
        
        if(!count($role)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'User role does not exist in role master'            
            ));
        }
        
        $role_name = $role->role_name;
        
        if(($role_name != 'SUPER ADMIN') && ($role_name != 'ADMIN')){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'User must be Admin to delete messages'            
            ));
        }
        
               
        $deletedMessages = DB::table('cards_messages')
                ->whereIn('cards_messages.message_id',$message_ids)
                ->where('cards_messages.ce_mapping_id','=',$ce_mapping_id)
                ->delete();
        
        if(!$deletedMessages){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No messages to delete'            
            ));
        }
        
        return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Messages deleted from the card'            
            ));
    }
    
    public function deleteMyMessage (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'ce_mapping_id' => 'required|exists:cards_events_mapping,ce_mapping_id',
            'message_ids' => 'required|integer'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        $ce_mapping_id = $request->get('ce_mapping_id');
        $message_id = $request->get('message_ids');
        
        $event = DB::table('cards_messages')
                ->join('cards_events_mapping','cards_events_mapping.ce_mapping_id','=','cards_messages.ce_mapping_id')
                ->join('events','cards_events_mapping.event_id','=','events.event_id')
                ->where('cards_messages.ce_mapping_id','=',$ce_mapping_id)
                ->select('cards_events_mapping.*')
                ->first();
        
        if(!count($event)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No messages associated with the event'            
            ));
        }
        
        $event_id = $event->event_id;
        
        $card_send = DB::table('cards_events_mapping')
                ->where('ce_mapping_id','=',$ce_mapping_id)
                ->whereIn('event_id','=',$event_id)
                ->select('cards_events_mapping.*')
                ->first();
        
        if(count($card_send)){
            $send_card_date = $card_send->send_card_date;
            if($send_card_date < now()){
                return Response::json(array(
                    'status_code' => 400,
                    'status' => 'Failure',
                    'message' => 'Card already sent. Cannot delete messages now'            
                ));
            }
        }
        
        $deletedMessage = DB::table('cards_messages')
                ->where('cards_messages.message_id',$message_id)
                ->where('cards_messages.ce_mapping_id','=',$ce_mapping_id)
                ->where('cards_messages.user_id','=',$user_id)
                ->delete();
        
        if(!$deletedMessage){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No messages to delete'            
            ));
        }
        
        return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Message deleted from the card'            
            ));
    }
    
}
