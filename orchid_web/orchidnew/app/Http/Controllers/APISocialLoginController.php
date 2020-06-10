<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\SocialLogin;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Tymon\JWTAuth\Exceptions\JWTException;
class APISocialLoginController extends Controller
{
   public function socialLogin (Request $request){
       $validator = Validator::make($request->all(), [
                           'first_name' => 'nullable|string|max:255',
                           'middle_name'=> 'nullable|string|max:255',
                           'last_name' => 'nullable|string|max:255',
                           'phone_number' => 'nullable|string|max:20',
                           'dob'=>'date',
                           'profile_picture'=>'nullable|string',
                           'email' => 'required|nullable|string|email|max:255',
                           'provider'=> 'required|max:255',
                           'profile_id'=> 'required|max:255',
                           //'token'=>'nullable|max:255'
                       ]);
       if ($validator->fails()) {
           return response()->json(array(
                       'status_code' => 400,
                       'status' => 'Failure',
                       'message' =>$validator->errors()
                   ));
       }

       $first_name = $request->get('first_name');
       $middle_name = $request->get('middle_name');
       $last_name = $request->get('last_name');
       $phone_number = $request->get('phone_number');
       $dob = $request->get('dob');
       $profile_picture = $request->get('profile_picture');
       $email_id = $request->get('email');
       $provider = $request->get('provider');
       $profile_id = $request->get('profile_id');

       $user = DB::table('users')
       ->where('email','=',$email_id)
       ->select('users.*')
       ->first();

       $socialMedia = DB::table('social_media_login')
       ->where('email','=',$email_id)
       ->where('provider','=',$provider)
       ->where('profile_id','=',$profile_id)
       ->select('social_media_login.*')
       ->first();

       if(!$user && !$socialMedia){
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

           DB::table('social_media_login')->insert([
                   ['user_id' => $user_id,
                   'email' => $email_id,
                   'provider' => $provider,
                   'profile_id' => $profile_id,
                   'created_at'=>now(),
                   'updated_at'=>now()]
               ]);

           return Response::json(array(
                       'status_code' => 200,
                       'status' => 'Success',
                       'message' => 'Login Successful. New User Created',
                       compact('token'),
                       'user_id' => $user_id
                   ));
       }  elseif ($user && !$socialMedia){
           $user_id = $user->user_id;
           $token = $user->remember_token;

           $f_name = $user->first_name;
           $m_name = $user->last_name;
           $l_name = $user->last_name;
           $ph_no = $user->phone_number;
           $date_ob = $user->dob;
           $profile_pic = $user->profile_picture;

           DB::table('social_media_login')->insert([
                   ['user_id' => $user_id,
                   'email' => $email_id,
                   'provider' => $provider,
                   'profile_id' => $profile_id,
                   'created_at'=>now(),
                   'updated_at'=>now()]
               ]);

           if(($f_name == null || $f_name == "") && ($first_name)){
               DB::table('users')
               ->where('user_id', $user_id)
               ->update(['first_name' => $first_name]);
           }

           if(($m_name == null || $m_name == "") && ($middle_name)){
               DB::table('users')
               ->where('user_id', $user_id)
               ->update(['middle_name' => $middle_name]);
           }

           if(($l_name == null || $l_name == "") && ($last_name)){
               DB::table('users')
               ->where('user_id', $user_id)
               ->update(['last_name' => $last_name]);
           }

           if(($ph_no == null || $ph_no == "") && ($phone_number)){
               DB::table('users')
               ->where('user_id', $user_id)
               ->update(['phone_number' => $phone_number]);
           }

           if(($date_ob == null || $date_ob == "") && ($dob)){
               DB::table('users')
               ->where('user_id', $user_id)
               ->update(['dob' => $dob]);
           }

           if(($profile_pic == null || $profile_pic == "") && ($profile_picture)){
               DB::table('users')
               ->where('user_id', $user_id)
               ->update(['profile_picture' => $profile_picture]);
           }

           return Response::json(array(
                       'status_code' => 200,
                       'status' => 'Success',
                       'message' => 'Login Successful. New Social Media Profile added',
                       'token' => $token,
                       'user_id' => $user_id
                   ));

       } elseif ($user && $socialMedia){
           $user_id = $user->user_id;
           $email_id = $user->email;
           $token = $user->remember_token;

           return response()->json([
                       'status_code' => 200,
                       'status' => 'Success',
                       'message' => 'Login Successful',
                       'token' => $token,
                       'user_id' => $user_id
                   ]);

       }
   }
}
