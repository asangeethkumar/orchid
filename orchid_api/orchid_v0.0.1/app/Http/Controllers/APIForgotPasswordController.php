<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\ForgotPassword;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Mail;

class APIForgotPasswordController extends Controller
{
    public function sendOTP (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|email|exists:users,email',
            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $email_id = $request->get('email');
        
        $user = DB::table('users')
                ->where('users.email',$email_id)
                ->select('users.user_id')
                ->first();
        
        $user_id =  $user->user_id;
        
        $otp = mt_rand(100000, 999999);
        
        DB::table('forgot_password_otp')
                ->where('forgot_password_otp.user_id','=',$user_id)
                ->delete();
                
        DB::table('forgot_password_otp')->insert([
            ['user_id' => $user_id, 
             'otp' => $otp,
             'created_at'=>now(),
             'updated_at'=>now()]
        ]);
        
       
        $data = array('otp'=>$otp);
        
        Mail::send('mail', $data, function($message) use ($email_id) {
         $message->to($email_id, 'OTP')->subject
            ('OTP for password reset');
         $message->from('orchidrus@dameeko.com','Orchid');
      });
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Email with OTP sent Successfully'            
        ));
    }
    
    public function reSendOTP (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|max:255|email|exists:users,email',
            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $email_id = $request->get('email');
        
        $user = DB::table('users')
                ->where('users.email',$email_id)
                ->select('users.user_id')
                ->first();
                      
        $user_id =  $user->user_id;
                     
        $forgotPwd = DB::table('forgot_password_otp')
                ->where('forgot_password_otp.user_id','=',$user_id)
                ->select('forgot_password_otp.otp','forgot_password_otp.created_at')
                ->first();
        
        if(!count($forgotPwd)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'OTP does not exist for the user'            
            ));
        }
        
        $otp = $forgotPwd->otp;
        $createdAt = $forgotPwd->created_at;
        
        $halfHr = date('Y-m-d H:i:s',strtotime('-30 minutes',strtotime(now())));
        
        if(strtotime($createdAt) < strtotime($halfHr)){
            $otp = mt_rand(100000, 999999);
            
             DB::table('forgot_password_otp')
                ->where('forgot_password_otp.user_id','=',$user_id)
                ->delete();
                
            DB::table('forgot_password_otp')->insert([
                ['user_id' => $user_id, 
                 'otp' => $otp,
                 'created_at'=>now(),
                 'updated_at'=>now()]
            ]);
        }
                    
        $data = array('otp'=>$otp);
        
        Mail::send('mail', $data, function($message) use ($email_id) {
         $message->to($email_id, 'OTP')->subject
            ('OTP for password reset');
         $message->from('orchidrus@dameeko.com','Orchid');
      });
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Email with OTP sent Successfully'            
        ));
    }
    
    public function verifyOTP (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|integer|max:999999',
            'email' => 'required|string|max:255|email|exists:users,email',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $email_id = $request->get('email');
        $verifyOTP = $request->get('otp');
        $password = bcrypt($request->get('password'));
        
        $user = DB::table('users')
                ->where('users.email',$email_id)
                ->select('users.user_id')
                ->first();
        
        $user_id =  $user->user_id;
        
        $forgotPwd = DB::table('forgot_password_otp')
                ->where('forgot_password_otp.user_id','=',$user_id)
                ->select('forgot_password_otp.otp','forgot_password_otp.created_at')
                ->first();
        
        if(!count($forgotPwd)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'OTP does not exist for the user'            
            ));
        }
        
        $otp = $forgotPwd->otp;
        $createdAt = $forgotPwd->created_at;
        
        $halfHr = date('Y-m-d H:i:s',strtotime('-30 minutes',strtotime(now())));
        
        if(strtotime($createdAt) < strtotime($halfHr)){
                return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'OTP expired'            
            ));
        } elseif ($otp != $verifyOTP) {
                return Response::json(array(
                    'status_code' => 400,
                    'status' => 'Failure',
                    'message' => 'OTP is wrong'            
                ));
        }
        
        DB::table('users')
                     ->where('email','=', $email_id)
                     ->update([
                            'password' => $password,                            
                            'updated_at'=>now()
                        ]);
                   
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'OTP is correct. Password is updated.'            
        ));
    }
}
