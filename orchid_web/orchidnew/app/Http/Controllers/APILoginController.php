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
            $credentials = request(['email', 'password']);
            if (!$token = auth('api')->attempt($credentials)) {
                return response()->json([
                        'status_code' => 401, 
                        'status' => 'Failure',
                        'message' => 'Unauthorized'
                    ], 401);
            }
            return response()->json([
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Login Successful',
                'token' => $token
                //'expires' => auth('api')->factory()->getTTL() * 43200,
            ]);
        } elseif(!$user){
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
                                'message' => 'Login Successful. New User Created.',
                                'token'=>$token
                ));
        }
    }
}
