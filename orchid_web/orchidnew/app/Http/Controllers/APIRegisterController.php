<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;

class APIRegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'middle_name'=> 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'dob'=>'date',
            'profile_picture'=>'nullable|string',
            'email' => 'required|string|email|max:255|unique:users',
            'password'=> 'required|min:6'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        User::create([
            
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
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        
        return Response::json(array(
                            'status_code' => 200,
                            'status' => 'Success',
                            'message' => 'Login Successful',
                            compact('token')
            ));
    }
}