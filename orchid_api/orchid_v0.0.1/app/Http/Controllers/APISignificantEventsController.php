<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APISignificantEventsController extends Controller
{
    public function createSignificantEvent (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'creator_user_id' => 'required|exists:users,user_id',
            'name' => 'required|string',
            'se_type_id' => 'required|integer',
            'se_relationship_id' => 'required|integer',
            'event_user_id' => 'nullable|exists:users,user_id',
            'se_date' => 'required|date_format:Y-m-d',
            'se_frequency' => 'nullable|string'                                   
        ]);
        
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $creator_user_id = $request->get('creator_user_id');
        $name = $request->get('name');
        $se_type_id = $request->get('se_type_id');
        $se_relationship_id = $request->get('se_relationship_id');
        $event_user_id = $request->get('event_user_id');
        $se_date = $request->get('se_date');
        $se_frequency = $request->get('se_frequency');
        
        
        $s_events_id = DB::table('significant_events')->insertGetId([
            'creator_user_id' => $creator_user_id,
            's_event_name' => $name,
            'se_type_id' => $se_type_id,
            'se_relationship_id' => $se_relationship_id,
            'event_user_id' => $event_user_id,
            'se_date' => $se_date,
            'se_frequency' => $se_frequency,            
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
        
        if(!$s_events_id){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Cannot create event'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Added Successfully',
            's_events_id' => $s_events_id
        ));
    }
    
    public function showSignificantEvent (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'creator_user_id' => 'required|exists:users,user_id',
            's_events_id' => 'required|exists:significant_events,s_events_id'                                               
        ]);
        
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $creator_user_id = $request->get('creator_user_id');
        $s_events_id = $request->get('s_events_id');
        
        $significant_event = DB::table('significant_events')
                ->join('significant_events_type','significant_events.se_type_id','=','significant_events_type.se_type_id')
                ->join('user_relationship','user_relationship.relationship_id','=','significant_events.se_relationship_id')
                ->leftjoin('users','users.user_id','=','significant_events.event_user_id')
                ->where('significant_events.creator_user_id','=',$creator_user_id)
                ->where('significant_events.s_events_id','=',$s_events_id)
                ->select(
                        'significant_events.s_events_id',
                        'significant_events.s_event_name',
                        'significant_events.se_type_id',
                        'significant_events_type.se_type_name',
                        'significant_events_type.se_type_image',
                        'significant_events.se_relationship_id',
                        'user_relationship.relationship',
                        'users.user_id as event_user_id',
                        'users.first_name',
                        'users.middle_name',
                        'users.last_name',
                        'significant_events.se_date',
                        'significant_events.se_frequency'                    
                        )
                ->first();
        
        if(!count($significant_event)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No Significants Events Found'            
            ));
        }
        
        $app_url =  env("APP_URL");
        $other_image = env("SE_OTHERS");
        $birthday_image = env("SE_BIRTHDAY");
        $anniversary_image = env("SE_ANNIVERSARY");
                
        
        $type = $significant_event->se_type_name;
        $type_image = $significant_event->se_type_image;

        if(empty($type_image)){
            if($type == 'OTHER'){
                $significant_event->se_type_image = $app_url.$other_image;
            }elseif($type == 'BIRTHDAY'){
                $significant_event->se_type_image = $app_url.$birthday_image;
            }elseif($type == 'ANNIVERSARY'){
                $significant_event->se_type_image = $app_url.$anniversary_image;
            }
        }else{
            $significant_event->se_type_image = $app_url.$significant_event->se_type_image;
        }
        
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Cards Retrieved Successfully',
            'output' => $significant_event
        ));
        
    }
    
    public function updateSignificantEvent (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'creator_user_id' => 'required|exists:users,user_id',
            's_events_id' => 'required|exists:significant_events,s_events_id',
            'name' => 'nullable|string',
            'se_type_id' => 'nullable|integer',
            'se_relationship_id'=> 'nullable|integer',
            'event_user_id' => 'nullable|exists:users,user_id',
            'se_date' => 'nullable|date',
            'se_frequency' => 'nullable|string'                                   
        ]);
        
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $creator_user_id = $request->get('creator_user_id');
        $s_events_id = $request->get('s_events_id');
        $name = $request->get('name');
        $se_type_id = $request->get('se_type_id');
        $se_relationship_id = $request->get('se_relationship_id');
        $event_user_id = $request->get('event_user_id');
        $se_date = $request->get('se_date');
        $se_frequency = $request->get('se_frequency');
        
        $significant_event = DB::table('significant_events')
                ->where('creator_user_id','=',$creator_user_id)
                ->where('s_events_id','=',$s_events_id)
                ->select('significant_events.*')
                ->orderBy('se_date','asc')
                ->first();
        
        if(!count($significant_event)){
            return response()->json(array(
                            'status_code' => 400, 
                            'status' => 'Failure',    
                            'message' => 'Event does not exist or user is not allowed to make changes'
                        ));
        }
        
        $existing_name = $significant_event->s_event_name;
        $existing_se_type_id = $significant_event->se_type_id;
        $existing_se_relationship_id = $significant_event->se_relationship_id;
        $existing_event_user_id = $significant_event->event_user_id;
        $existing_se_date = $significant_event->se_date;
        $existing_se_frequency = $significant_event->se_frequency;
        
        if(!$name){
            $name = $existing_name;
        }
        
        if(!$se_type_id){
            $se_type_id = $existing_se_type_id;
        }
        
        if(!$se_relationship_id){
            $se_relationship_id = $existing_se_relationship_id;
        }
        
        if(!$event_user_id){
            $event_user_id = $existing_event_user_id;
        }
        
        if(!$se_date){
            $se_date = $existing_se_date;
        }
        
        if(!$se_frequency){
            $se_frequency = $existing_se_frequency;
        }
        
        if($name || $se_type_id || $se_relationship_id || $se_date || $se_frequency){
            DB::table('significant_events')
                ->where('creator_user_id','=', $creator_user_id)
                ->where('s_events_id','=',$s_events_id)
                ->update([
                       's_event_name' => $name,
                       'se_type_id' => $se_type_id,
                       'se_relationship_id' => $se_relationship_id,
                       'event_user_id' => $event_user_id,
                       'se_date' => $se_date,
                       'se_frequency' => $se_frequency,
                       'updated_at'=>now()
                ]);
            
            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Significant Event Successfully Updated',
                's_events_id' => $s_events_id
            ));
        }else{
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No Data to Update'            
            ));
        }
    }
    
    public function listSignificantEvents (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'creator_user_id' => 'required|exists:users,user_id'                                               
        ]);
        
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $creator_user_id = $request->get('creator_user_id');
        
        $significant_events = DB::table('significant_events')
                ->join('significant_events_type','significant_events.se_type_id','=','significant_events_type.se_type_id')
                ->join('user_relationship','user_relationship.relationship_id','=','significant_events.se_relationship_id')
                ->leftjoin('users','users.user_id','=','significant_events.event_user_id')
                ->where('significant_events.creator_user_id','=',$creator_user_id)
                ->select(
                        'significant_events.s_events_id',
                        'significant_events.s_event_name',
                        'significant_events.se_type_id',
                        'significant_events_type.se_type_name',
                        'significant_events_type.se_type_image',
                        'significant_events.se_relationship_id',
                        'user_relationship.relationship',
                        'users.user_id as event_user_id',
                        'users.first_name',
                        'users.middle_name',
                        'users.last_name',
                        'significant_events.se_date',
                        'significant_events.se_frequency'                    
                        )
                ->get();
        
        if(!count($significant_events)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No Significant Events Found'            
            ));
        }
        
        $output = $significant_events->toArray();
        
        $app_url =  env("APP_URL");
        $other_image = env("SE_OTHERS");
        $birthday_image = env("SE_BIRTHDAY");
        $anniversary_image = env("SE_ANNIVERSARY");
                
        foreach($output as $data){
            $type = $data->se_type_name;
            $type_image = $data->se_type_image;
            
            if(empty($type_image)){
                if($type == 'OTHER'){
                    $data->se_type_image = $app_url.$other_image;
                }elseif($type == 'BIRTHDAY'){
                    $data->se_type_image = $app_url.$birthday_image;
                }elseif($type == 'ANNIVERSARY'){
                    $data->se_type_image = $app_url.$anniversary_image;
                }
            }else{
                $data->se_type_image = $app_url.$data->se_type_image;
            }
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Significant Events Retrieved Successfully',
            'output' => $output
        ));
    }
    
    public function deleteSignificantEvents (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'creator_user_id' => 'required|exists:users,user_id',
            's_events_id' => 'required',            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
            
        
        $creator_user_id = $request->get('creator_user_id');
        $s_events_id = $request->get('s_events_id');
        
        $deleted_significant_event = DB::table('significant_events')
                ->whereIn('significant_events.s_events_id',$s_events_id)
                ->where('significant_events.creator_user_id','=',$creator_user_id)
                ->delete();
        
        if (!$deleted_significant_event) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Cannot Delete Significant Event. Either event does not exists or user not authorised. '            
            ));
        }
                       
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Significant Event(s) Deleted Successfully.'            
        ));
     
    }
    
    public function listSignificantEventTypes (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'creator_user_id' => 'required|exists:users,user_id'                                               
        ]);
        
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
                
        $significant_events_type = DB::table('significant_events_type')
                ->select(
                        'significant_events_type.se_type_id',
                        'significant_events_type.se_type_name'                                            
                        )
                ->get();
        
        if(!count($significant_events_type)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No Significant Events Type Found'            
            ));
        }
        
        $output = $significant_events_type->toArray();
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Significant Events Type Retrieved Successfully',
            'output' => $output
        ));
    }
    
    public function listUserRelationships (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'creator_user_id' => 'required|exists:users,user_id'                                               
        ]);
        
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
                
        $userRelationships = DB::table('user_relationship')
                ->select(
                        'user_relationship.relationship_id',
                        'user_relationship.relationship'                                            
                        )
                ->get();
        
        if(!count($userRelationships)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No Relationship List Found'            
            ));
        }
        
        $output = $userRelationships->toArray();
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Relationship List Retrieved Successfully',
            'output' => $output
        ));
    }
}
