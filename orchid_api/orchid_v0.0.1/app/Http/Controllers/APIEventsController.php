<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Events;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIEventsController extends Controller
{
    public function createEvents (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_name' => 'required|string|max:255',
            'event_description' => 'nullable|string|max:255',
            'event_type_id' => 'required|max:255|exists:event_type_master,event_type_id',
            'event_start_time' => 'required|date_format:Y-m-d H:i:s',
            /*
            'event_end_time' => 'nullable|date_format:Y-m-d H:i:s',
            */
            'event_response_by_time' => 'before_or_equal:event_start_time|date_format:Y-m-d H:i:s',
            /*
            'event_venue_name' => 'nullable|string|max:255',
            'event_venue_address_1' => 'nullable|string|max:255',
            'event_venue_address_2' => 'nullable|string|max:255',
            'event_venue_city' => 'nullable|string|max:255',
            'event_state' => 'nullable|string|max:255',
            'event_country' => 'nullable|string|max:255',
            'event_zip_code' => 'nullable|string|max:255',
            */
            'event_created_by' => 'required|max:255|exists:users,user_id',
            /*
            'event_modified_by' => 'nullable|string|max:255'
            */
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        $createdEvent = Events::create([
            'event_name' => $request->get('event_name'),
            'event_description' => $request->get('event_description'),
            'event_type_id' => $request->get('event_type_id'),
            'event_start_time' => $request->get('event_start_time'),
            /*
            'event_end_time' => $request->get('event_end_time'),
            */
            'event_response_by_time' => $request->get('event_response_by_time'),
            /*
            'event_venue_name' => $request->get('event_venue_name'),
            'event_venue_address_1' => $request->get('event_venue_address_1'),
            'event_venue_address_2' => $request->get('event_venue_address_2'),
            'event_venue_city' => $request->get('event_venue_city'),
            'event_state' => $request->get('event_state'),
            'event_country' => $request->get('event_country'),
            'event_zip_code' => $request->get('event_zip_code'),
            */
            'event_created_by' => $request->get('event_created_by')
            /*   
            'event_modified_by' => $request->get('event_modified_by')
            */
        ]);
        
        $event_id = $createdEvent->id; 
        
        $role = DB::table('event_participants_role_master')
                ->where('event_participants_role_master.role_name','SUPER ADMIN')
                ->select('event_participants_role_master.role_id')
                ->first();
       
        $role_id =  $role->role_id;
                
        DB::table('event_participants')->insert([
            ['event_id' => $event_id, 
             'user_id' => $request->get('event_created_by'),
             'role_id'=>$role_id,
             'event_invitation_id'=>0,
             'created_at'=>now(),
             'updated_at'=>now()]
        ]);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Created Successfully',
            'event_id'=> $event_id
        ));
    }
    
    public function showEvent(Request $request)
    {
        $event_id = $request->get('event_id');
        /*
        $event1 = Events::where('event_id',$event_id)->first();
        
        $event3 = DB::table('view_events')
                ->where('view_events.event_id',$event_id)
                ->select('view_events.*')
                ->get();
        */
        $event = DB::table('events')
                ->join('users', 'events.event_created_by', '=', 'users.user_id')
                ->join('event_type_master','events.event_type_id', '=', 'event_type_master.event_type_id')
                ->where('events.event_id',$event_id)
                ->select('events.event_id',
                        'events.event_name',
                        'events.event_description',
                        'events.event_type_id',
                        'event_type_master.event_type_name',
                        'events.event_start_time',
                        'events.event_response_by_time',
                        'events.event_created_by as event_created_by_id',
                        'users.first_name as created_by_first_name',
                        'users.middle_name as created_by_middle_name',
                        'users.last_name as created_by_last_name',
                        'events.created_at',
                        'events.updated_at')
                ->get();
        
        if (!count($event)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Event Not Found'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Retrieved Successfully',
            'output' => $event->toArray()
            /*
            'output2'=> $event3->toArray(),
            'output3'=> $event1->toArray()
            */
        ));
    }
    
    public function updateEvents (Request $request, Events $event)
    {
       
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'event_id' => 'exists:events,event_id',
            'event_name' => 'nullable|string|max:255',
            'event_description' => 'nullable|string|max:255',
            'event_type_id' => 'nullable|integer|max:255|exists:event_type_master,event_type_id',
            'event_start_time' => 'nullable|date_format:Y-m-d H:i:s',
            /*
            'event_end_time' => 'nullable|date_format:Y-m-d H:i:s',
            */
            'event_response_by_time' => 'before_or_equal:event_start_time|date_format:Y-m-d H:i:s',
            /*
            'event_venue_name' => 'nullable|string|max:255',
            'event_venue_address_1' => 'nullable|string|max:255',
            'event_venue_address_2' => 'nullable|string|max:255',
            'event_venue_city' => 'nullable|string|max:255',
            'event_state' => 'nullable|string|max:255',
            'event_country' => 'nullable|string|max:255',
            'event_zip_code' => 'nullable|string|max:255',
            */
            'event_created_by' => 'required|max:255|exists:users,user_id',
            /*
            'event_modified_by' => 'nullable|string|max:255'
            */
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $event->event_id = $input['event_id'];
        $event->event_name = $input['event_name'];
        $event->event_description = $input['event_description'];
        $event->event_type_id = $input['event_type_id'];
        $event->event_start_time = $input['event_start_time'];
        /*
        $event->event_end_time = $input['event_end_time'];
        */
        $event->event_response_by_time = $input['event_response_by_time'];
        /*
        $event->event_venue_name = $input['event_venue_name'];
        $event->event_venue_address_1 = $input['event_venue_address_1'];
        $event->event_venue_address_2 = $input['event_venue_address_2'];
        $event->event_venue_city = $input['event_venue_city'];
        $event->event_state = $input['event_state'];
        $event->event_country = $input['event_country'];
        $event->event_zip_code = $input['event_zip_code'];
        */
        $event->event_created_by = $input['event_created_by'];
        /*
        $event->event_modified_by = $input['event_modified_by'];
        */
        // $event->save();
        Events::where('event_id',$event->event_id)->update($input);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Updated Successfully'            
        ));
    }
    
    public function listCreatedEvents(Request $request)
    {
        $user_id = $request->get('user_id');
        
        $event = DB::table('events')
                ->join('users', 'events.event_created_by', '=', 'users.user_id')
                ->join('event_type_master','events.event_type_id', '=', 'event_type_master.event_type_id')
                ->where('events.event_created_by',$user_id)
                ->select('events.event_id',
                        'events.event_name',
                        'events.event_description',
                        'events.event_type_id',
                        'event_type_master.event_type_name',
                        'events.event_start_time',
                        'events.event_response_by_time',
                        'events.event_created_by as event_created_by_id',
                        'users.first_name as created_by_first_name',
                        'users.middle_name as created_by_middle_name',
                        'users.last_name as created_by_last_name',
                        'events.created_at',
                        'events.updated_at')
                ->get();
        
        if (!count($event)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Event Not Found'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Retrieved Successfully',
            'output' => $event->toArray()
        ));
    }
    
    public function listParticipatingEvents(Request $request)
    {
        $user_id = $request->get('user_id');
        
        $event = DB::table('event_participants')
                ->join('events', 'events.event_id', '=', 'event_participants.event_id')
                ->join('users', 'users.user_id', '=', 'event_participants.user_id')
                ->join('event_type_master','events.event_type_id', '=', 'event_type_master.event_type_id')
                ->join('event_participants_role_master','event_participants_role_master.role_id', '=','event_participants.role_id')
                ->where('event_participants.user_id',$user_id)
                ->select('events.event_id',
                        'events.event_name',
                        'events.event_description',
                        'events.event_type_id',
                        'event_type_master.event_type_name',
                        'events.event_start_time',
                        'events.event_response_by_time',
                        'events.event_created_by as event_created_by_id',
                        'users.first_name as created_by_first_name',
                        'users.middle_name as created_by_middle_name',
                        'users.last_name as created_by_last_name',
                        'event_participants.role_id',
                        'event_participants_role_master.role_name',
                        'events.created_at',
                        'events.updated_at')
                ->get();
        
        if (!count($event)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Event Not Found'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Retrieved Successfully',
            'output' => $event->toArray()
        ));
    }
    
    public function listUpcomingParticipatingEvents(Request $request)
    {
        $user_id = $request->get('user_id');
        
        $event = DB::table('event_participants')
                ->join('events', 'events.event_id', '=', 'event_participants.event_id')
                ->join('users', 'users.user_id', '=', 'event_participants.user_id')
                ->join('event_type_master','events.event_type_id', '=', 'event_type_master.event_type_id')
                ->join('event_participants_role_master','event_participants_role_master.role_id', '=','event_participants.role_id')
                ->where('event_participants.user_id',$user_id)
                ->whereDate('events.event_start_time','>=',date('Y-m-d'))
                ->select('events.event_id',
                        'events.event_name',
                        'events.event_description',
                        'events.event_type_id',
                        'event_type_master.event_type_name',
                        'events.event_start_time',
                        'events.event_response_by_time',
                        'events.event_created_by as event_created_by_id',
                        'users.first_name as created_by_first_name',
                        'users.middle_name as created_by_middle_name',
                        'users.last_name as created_by_last_name',
                        'event_participants.role_id',
                        'event_participants_role_master.role_name',
                        'events.created_at',
                        'events.updated_at')
                ->get();
       //return now();
        if (!count($event)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Event Not Found'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Retrieved Successfully',
            'output' => $event->toArray()
        ));
    }
    
    public function listPastParticipatingEvents(Request $request)
    {
        $user_id = $request->get('user_id');
        
        $event = DB::table('event_participants')
                ->join('events', 'events.event_id', '=', 'event_participants.event_id')
                ->join('users', 'users.user_id', '=', 'event_participants.user_id')
                ->join('event_type_master','events.event_type_id', '=', 'event_type_master.event_type_id')
                ->join('event_participants_role_master','event_participants_role_master.role_id', '=','event_participants.role_id')
                ->where('event_participants.user_id',$user_id)
                ->whereDate('events.event_start_time','<=',date('Y-m-d'))
                ->select('events.event_id',
                        'events.event_name',
                        'events.event_description',
                        'events.event_type_id',
                        'event_type_master.event_type_name',
                        'events.event_start_time',
                        'events.event_response_by_time',
                        'events.event_created_by as event_created_by_id',
                        'users.first_name as created_by_first_name',
                        'users.middle_name as created_by_middle_name',
                        'users.last_name as created_by_last_name',
                        'event_participants.role_id',
                        'event_participants_role_master.role_name',
                        'events.created_at',
                        'events.updated_at')
                ->orderBy('events.event_start_time','desc')
                ->get();
       //return now();
        if (!count($event)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Event Not Found'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Retrieved Successfully',
            'output' => $event->toArray()
        ));
    }
    
    public function deleteMyEvent(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'event_id' => 'required|array',            
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
        
         $deleteMyParticipation = DB::table('event_participants')
                ->whereIn('event_participants.event_id', $event_id)
                ->where('event_participants.user_id','=', $user_id)
                ->delete();
         
        $users_event = DB::table('events')
                ->whereIn('events.event_id',$event_id)
                ->where('events.event_created_by','=',$user_id)
                ->whereDate('events.event_start_time','>',date('Y-m-d'))
                ->select('events.event_id','events.event_created_by')
                ->get();
        
        if(count($users_event)){
            
            $deletedEvent = DB::table('events')
                ->whereIn('events.event_id',$event_id)
                ->where('events.event_created_by','=',$user_id)
                ->whereDate('events.event_start_time','>',date('Y-m-d'))
                ->delete();
            
            $event_to_delete = $users_event->toArray();
            foreach($event_to_delete as $data){
                $delete_event_id =  $data->event_id;
                
                $deletedParticipants = DB::table('event_participants')
                    ->where('event_participants.event_id','=',$delete_event_id)
                    ->delete();
                
                $ce_mapping = DB::table('cards_events_mapping')
                        ->where('cards_events_mapping.event_id','=',$delete_event_id)
                        ->select('cards_events_mapping.ce_mapping_id')
                        ->first();
                
                if(!empty($ce_mapping)){
                    $ce_mapping_id = $ce_mapping->ce_mapping_id;

                    $delete_CE_mapping = DB::table('cards_events_mapping')
                            ->where('cards_events_mapping.event_id','=',$delete_event_id)
                            ->delete();

                    $delete_messages = DB::table('cards_messages')
                            ->where('cards_messages.ce_mapping_id','=',$ce_mapping_id)
                            ->delete();
                }
            }
        }
               
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Deleted Successfully.'            
        ));
        
    }
}
