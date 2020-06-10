<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;

class APILoginController extends Controller
{
    public function login(Request $request) {
        $email_id = $request->get('email');
        
        $user = DB::table('users')
                ->where('email','=',$email_id)
                ->select('users.*')
                ->first();
        
        if($user){
            $user_id = $user->user_id;
            $credentials = request(['email', 'password']);
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                        'status_code' => 401, 
                        'status' => 'Failure',
                        'message' => 'Email or password is wrong'
                    ], 401);
            }
            return response()->json([
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Login Successful',
                'token' => $token,
                //'expires' => auth('api')->factory()->getTTL() * 43200,
                'user_id' => $user_id
            ]);
        } elseif(!$user){
            
            //The following code to be implemented
            
            return Response::json(array(
                'status_code' => 206,
                'status' => 'Partial Content',
                'message' => 'New User. Please confirm password and accept T&C',              
            ));
            //Till here
            
            //Following to be removed Starts Here
            /*
            $createdUser = User::create([
            
                'first_name' => $request->get('first_name'),
                'middle_name' => $request->get('middle_name'),
                'last_name' => $request->get('last_name'),
                'phone_number' => $request->get('phone_number'),
                'dob' => $request->get('dob'),
                'profile_picture'=>$request->get('profile_picture'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'is_active' => 'Y'
            ]);
            $user_id = $createdUser->id;
            $user = User::first();
            $token = JWTAuth::fromUser($user);
            
            $input['remember_token'] = $token;
            $user->remember_token = $input['remember_token'];
            User::where('user_id',$user_id)->update($input);
            
            $email_id = $request->get('email');
            
            $event_invitations = DB::table('event_invitation')
                    ->where('invitee_profile','=',$email_id)
                    ->select('event_invitation.*')
                    ->get();
            
                       
            if(count($event_invitations)){
                $invitations_list = $event_invitations->toArray();
                
                $role = DB::table('event_participants_role_master')
                        ->where('role_name','=','MEMBER')
                        ->select('event_participants_role_master.*')
                        ->first();
                
                if(count($role)){
                    $role_id = $role->role_id;
                }else{
                    $role_id = null;
                }
                
                foreach($invitations_list as $data){
                    $invitation_id = $data->invitation_id;
                    $event_id = $data->event_id;
                    
                    $event = DB::table('events')
                            ->where('event_id','=',$event_id)
                            ->select('events.*')
                            ->first();
                    
                    if(count($event)){
                        $event_start_date = $event->event_start_time;                        
                    }else{
                        $event_start_date = now();
                    }
                    
                    if($event_start_date > now()){
                        $existing_participant = DB::table('event_participants')
                            ->where('event_id','=',$event_id)
                            ->where('user_id','=',$user_id)
                            ->select('event_participants.*')
                            ->first();

                        if(!count($existing_participant)){

                            $event_participants = DB::table('event_participants')->insertGetId(
                                [
                                    'event_id' => $event_id,
                                    'user_id' => $user_id,
                                    'role_id' => $role_id,
                                    'event_invitation_id' => $invitation_id,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ]
                            );
                        }
                    }
                }
            }

            return Response::json(array(
                                'status_code' => 200,
                                'status' => 'Success',
                                'message' => 'Login Successful. New User Created.',
                                'token'=> $token,
                                'user_id'=>$user_id
                ));
            */
            //Ends Here Remove till here
            
        }
   
    }
    
    public function registerUser (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'nullable|string|max:255',
            'middle_name'=> 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'dob'=>'nullable|date',
            'profile_picture'=>'nullable|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $createdUser = User::create([
            
                'first_name' => $request->get('first_name'),
                'middle_name' => $request->get('middle_name'),
                'last_name' => $request->get('last_name'),
                'phone_number' => $request->get('phone_number'),
                'dob' => $request->get('dob'),
                'profile_picture'=>$request->get('profile_picture'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->get('password')),
                'is_active' => 'Y'
            ]);
            $user_id = $createdUser->id;
            $user = User::first();
            $token = JWTAuth::fromUser($user);
            
            $input['remember_token'] = $token;
            $user->remember_token = $input['remember_token'];
            User::where('user_id',$user_id)->update($input);
            
            $email_id = $request->get('email');
            
            $event_invitations = DB::table('event_invitation')
                    ->where('invitee_profile','=',$email_id)
                    ->select('event_invitation.*')
                    ->get();
            
                       
            if(count($event_invitations)){
                $invitations_list = $event_invitations->toArray();
                
                $role = DB::table('event_participants_role_master')
                        ->where('role_name','=','MEMBER')
                        ->select('event_participants_role_master.*')
                        ->first();
                
                if(count($role)){
                    $role_id = $role->role_id;
                }else{
                    $role_id = null;
                }
                
                foreach($invitations_list as $data){
                    $invitation_id = $data->invitation_id;
                    $event_id = $data->event_id;
                    
                    $event = DB::table('events')
                            ->where('event_id','=',$event_id)
                            ->select('events.*')
                            ->first();
                    
                    if(count($event)){
                        $event_start_date = $event->event_start_time;                        
                    }else{
                        $event_start_date = now();
                    }
                    
                    if($event_start_date > now()){
                        $existing_participant = DB::table('event_participants')
                            ->where('event_id','=',$event_id)
                            ->where('user_id','=',$user_id)
                            ->select('event_participants.*')
                            ->first();

                        if(!count($existing_participant)){

                            $event_participants = DB::table('event_participants')->insertGetId(
                                [
                                    'event_id' => $event_id,
                                    'user_id' => $user_id,
                                    'role_id' => $role_id,
                                    'event_invitation_id' => $invitation_id,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ]
                            );
                        }
                    }
                }
            }

            return Response::json(array(
                                'status_code' => 200,
                                'status' => 'Success',
                                'message' => 'Login Successful. New User Created.',
                                'token'=> $token,
                                'user_id'=>$user_id
                ));
    }
}
