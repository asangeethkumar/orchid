<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\EventType;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIEventTypeController extends Controller
{
    public function createEventType (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'event_type_name' => 'required|string|max:255',
            'event_type_description' => 'nullable|string|max:255'            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        Events::create([
            'event_type_name' => $request->get('event_type_name'),
            'event_type_description' => $request->get('event_type_description')            
        ]);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Type Created Successfully'            
        ));
    }
    
    public function updateEventType (Request $request, EventType $eventType)
    {
       
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'event_type_id' => 'exists:event_type_master,event_type_id',
            'event_type_name' => 'required|string|max:255',
            'event_type_description' => 'nullable|string|max:255'            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $eventType->event_type_id = $input['event_type_id'];
        $eventType->event_type_name = $input['event_type_name'];
        $eventType->event_type_description = $input['event_type_description'];
        
        Events::where('event_type_id',$eventType->event_type_id)->update($input);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Type Updated Successfully'            
        ));
    }
    
    public function listEventType()
    {
        $eventTypeList = DB::table('event_type_master')
                ->select('event_type_master.*')
                ->get();
       
        if (is_null($eventTypeList)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Event Type Not Found'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Event Type List Retrieved Successfully',
            'output' => $eventTypeList->toArray()            
        ));
    }
    
    public function deleteEventType(Request $request)
    {
        $input = $request->all();
        $event_type_id = $input['event_type_id'];
        $event_type_name = $input['event_type_name'];
        DB::table('users')
                ->where('event_type_id', '=', $event_type_id)
                ->where('event_type_name','=', $event_type_name)
                ->delete();
        
        $eventType = DB::table('event_type_master')
                    ->where('event_type_id', '=', $event_type_id)
                    ->select('event_type_master.*')
                    ->get();
       
        if (is_null($eventType)) {
            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Event Type Deleted Successfully'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 400,
            'status' => 'Failure',
            'message' => 'Unable to Delete Event Type'         
        ));
    }
}
