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
            'email_id' => 'required|string|max:255|email|exists:users,email',
            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $email_id = $request->get('email_id');
        
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
         $message->from('orchidrus@dameeko.com','OrchidRUs');
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
            'email_id' => 'required|string|max:255|email|exists:users,email',
            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $email_id = $request->get('email_id');
        
        $user = DB::table('users')
                ->where('users.email',$email_id)
                ->select('users.user_id')
                ->first();
        
        $user_id =  $user->user_id;
                     
        $forgotPwd = DB::table('forgot_password_otp')
                ->where('forgot_password_otp.user_id','=',$user_id)
                ->select('forgot_password_otp.otp','forgot_password_otp.created_at')
                ->first();
        
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
         $message->from('orchidrus@dameeko.com','OrchidRUs');
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
            'otp' => 'required|integer|max:6',
            'email_id' => 'required|string|max:255|email|exists:users,email'            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $email_id = $request->get('email_id');
        $verifyOTP = $request->get('otp');
        
        $user = DB::table('users')
                ->where('users.email',$email_id)
                ->select('users.user_id')
                ->first();
        
        $user_id =  $user->user_id;
        
        $forgotPwd = DB::table('forgot_password_otp')
                ->where('forgot_password_otp.user_id','=',$user_id)
                ->select('forgot_password_otp.otp','forgot_password_otp.created_at')
                ->first();
        
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
                   
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'OTP is correct'            
        ));
    }
}
