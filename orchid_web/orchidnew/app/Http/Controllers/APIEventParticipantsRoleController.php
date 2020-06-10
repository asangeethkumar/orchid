<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class APIEventParticipantsRoleController extends Controller
{
    //
    public function createEventParticipantsRole(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'role_name' => 'required|string|max:255',
            'role_description' => 'nullable|string|max:255',
            'is_active' => 'required|string|max:10'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        Events::create([
            'role_name' => $request->get('role_name'),
            'role_description' => $request->get('role_description'),
            'is_active' => $request->get('is_active')
        ]);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Role Created Successfully'            
        ));
    }
    
    public function updateEventParticipantsRole (Request $request, EventParticipantsRole $eventParticipantsRole)
    {
       
        $input = $request->all();
        
        $validator = Validator::make($input, [
            'role_id' => 'exists:event_participants_role_master,role_id',
            'role_name' => 'required|string|max:255',
            'role_description' => 'nullable|string|max:255',
            'is_active' => 'required|string|max:10'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $eventParticipantsRole->role_id = $input['role_id'];
        $eventParticipantsRole->role_name = $input['role_name'];
        $eventParticipantsRole->role_description = $input['role_description'];
        $eventParticipantsRole->is_active = $input['is_active'];
        
        Events::where('role_id',$eventParticipantsRole->role_id)->update($input);
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Role Updated Successfully'            
        ));
    }
    
    public function listEventParticipantsRole()
    {
        $eventParticipantsRoleList = DB::table('event_participants_role_master')
                ->select('event_participants_role_master.*')
                ->get();
       
        if (is_null($eventParticipantsRoleList)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Role List Not Found'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Role List Retrieved Successfully',
            'output' => $eventParticipantsRoleList->toArray()            
        ));
    }
    
    public function deleteEventParticipantsRole(Request $request)
    {
        $input = $request->all();
        $role_id = $input['role_id'];
        $role_name = $input['role_name'];
        DB::table('users')
                ->where('role_id', '=', $role_id)
                ->where('role_name','=', $role_name)
                ->delete();
        
        $eventParticipantsRole = DB::table('event_participants_role_master')
                    ->where('event_participants_role_master', '=', $role_id)
                    ->select('event_participants_role_master.*')
                    ->get();
       
        if (is_null($eventParticipantsRole)) {
            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Role Deleted Successfully'            
            ));
        }
        
        return Response::json(array(
            'status_code' => 400,
            'status' => 'Failure',
            'message' => 'Unable to Delete Role'         
        ));
    }
}
