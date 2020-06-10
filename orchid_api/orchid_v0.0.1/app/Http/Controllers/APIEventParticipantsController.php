<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\EventParticipants;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIEventParticipantsController extends Controller
{
    public function showEventParticipants (Request $request)
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
        
        $participants = DB::table('event_participants')
                ->join('users','users.user_id','=','event_participants.user_id')
                ->join('event_participants_role_master','event_participants_role_master.role_id','=','event_participants.role_id')
                ->where('event_participants.event_id','=',$event_id)
                ->select(
                            'users.user_id',
                            'users.first_name',
                            'users.middle_name',
                            'users.last_name',
                            'users.profile_picture',
                            'event_participants_role_master.role_id',
                            'event_participants_role_master.role_name'
                        )
                ->get();
        
        if(!count($participants)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Participants not found for the Event'            
            ));
        }
        
        $participants_list = $participants->toArray();
        
         //$serverName = request()->getSchemeAndHttpHost();
         
        $app_url =  env("APP_URL");
        $default_profile_pic = env("DEFAULT_PROFILE_PIC");
        
        foreach ($participants_list as $data) {
            $uri = $data->profile_picture;
            
            if(empty($uri)){
                $data->profile_picture = $app_url.$default_profile_pic;
            }elseif(!preg_match( '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i' ,$uri)){
                $data->profile_picture = $app_url.$data->profile_picture;
            }         
        }
        
        return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Participants list retrieved successfully',
                'output' => $participants_list
            ));
    }
    
    public function removeEventParticipants (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'event_id' => 'required|exists:events,event_id',
            'participant_ids' => 'required|array'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        $event_id = $request->get('event_id');
        $participant_ids = $request->get('participant_ids');
                       
        $is_admin = DB::table('event_participants')
                ->where('user_id','=',$user_id)
                ->where('event_id','=',$event_id)
                ->select('event_participants.*')
                ->first();
        
        if(!count($is_admin)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Not allowed to delete participants by this user'            
            ));
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
                'message' => 'User must be Admin to delete participants'            
            ));
        }
        
        $superAdmin = DB::table('event_participants')
                ->join('event_participants_role_master','event_participants_role_master.role_id','=','event_participants.role_id')
                ->whereIn('event_participants.user_id',$participant_ids)
                ->where('event_participants_role_master.role_name','=','SUPER ADMIN')
                ->select('event_participants.*')
                ->first();
        
        if(count($superAdmin)){
            $superAdmin_id = $superAdmin->user_id;
            $key = array_search($superAdmin_id, $participant_ids);
            unset($participant_ids[$key]);
        }
        
        $deletedParticipants = DB::table('event_participants')
                ->whereIn('event_participants.user_id',$participant_ids)
                ->where('event_participants.event_id','=',$event_id)
                ->delete();
        
        if(!$deletedParticipants){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No participants to delete'            
            ));
        }
        
        return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Participants deleted from the event'            
            ));
        
    }
}
