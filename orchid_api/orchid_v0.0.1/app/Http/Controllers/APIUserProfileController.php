<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\File;
use Storage;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Image;

class APIUserProfileController extends Controller
{
    public function showUserProfile (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id'                       
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        
        $user = DB::table('users')
                ->where('user_id','=', $user_id)
                ->select(
                            'users.first_name',
                            'users.middle_name',
                            'users.last_name',
                            'users.first_name',
                            'users.phone_number',
                            'users.dob as date_of_birth',
                            'users.profile_picture',
                            'users.email'
                        )
                ->get();
        
        if (!count($user)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'User Not Found'            
            ));
        }
        
        $userProfile = $user->toArray();
        
        $serverName = request()->getSchemeAndHttpHost();
        
        $app_url =  env("APP_URL");
        $default_profile_pic = env("DEFAULT_PROFILE_PIC");
        
        foreach ($userProfile as $data) {
            $uri = $data->profile_picture;
            
            if(empty($uri)){
                $data->profile_picture = $app_url.$default_profile_pic;
            }elseif(!preg_match( '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i' ,$uri)){
                $data->profile_picture = $app_url.$data->profile_picture;
            }
        }
        
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'User Retrieved Successfully',
            'output' => $userProfile
        ));
    }
    
    public function updateUserProfile (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'first_name' => 'nullable|string|max:255',
            'middle_name'=> 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'phone_number' => 'nullable|string|max:20',
            'dob'=>'nullable|date',
            'profile_picture'=>'nullable|string'                        
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        $first_name = $request->get('first_name');
        $middle_name = $request->get('middle_name');
        $last_name = $request->get('last_name');
        $phone_number = $request->get('phone_number');
        $dob = $request->get('dob');
        $pro_picture = $request->get('profile_picture');
                      
        $profile_picture = base64_decode($pro_picture);
        
        //return $profile_picture;
        
        $user = DB::table('users')
                ->where('user_id','=',$user_id)
                ->select('users.*')
                ->first();
        
        if($user){
            $existing_first_name = $user->first_name;
            $existing_middle_name = $user->middle_name;
            $existing_last_name = $user->last_name;
            $existing_phone_number = $user->phone_number;
            $existing_dob = $user->dob;
            $existing_profile_picture = $user->profile_picture;
        }
        
        if(!$first_name){
            $first_name = $existing_first_name;
        }
        
        if(!$middle_name){
            $middle_name = $existing_middle_name;
        }
        
        if(!$last_name){
            $last_name = $existing_last_name;
        }
        
        if(!$phone_number){
            $phone_number = $existing_phone_number;
        }
        
        if(!$dob){
            $dob = $existing_dob;
        }
        
        if(!$profile_picture){
            $profile_picture = $existing_profile_picture;
        }elseif($profile_picture){
            //$filename = time().'_'.$user_id.'_'.str_replace(' ', '_', $profile_picture->getClientOriginalName());
            $filename = time().'_'.str_random(10).'.'.'png';
            Storage::put('/public/images/profilePictures/'. $filename, $profile_picture);
            //Storage::exists('/public/images/profilePictures/'.$filename);
            //return basename($path);
            //$path = Storage::putFileAs('/public/images/profilePictures', $profile_picture, $filename,'public');
            $url = Storage::url('public/images/profilePictures/'.$filename);
            //return $url;
            $profile_picture = $url;
            if($existing_profile_picture){
                $existing_file_name = explode("/", $existing_profile_picture);
                $existing_pp_name = end($existing_file_name);
                $file_exist = Storage::exists('/public/images/profilePictures/'.$existing_pp_name);
                if($file_exist){
                    Storage::delete('/public/images/profilePictures/'.$existing_pp_name);
                }                
            }
        }
        
        if($first_name || $middle_name || $last_name || $phone_number || $dob || $profile_picture){
            DB::table('users')
                ->where('user_id','=', $user_id)
                ->update([
                       'first_name' => $first_name,
                       'middle_name' => $middle_name,
                       'last_name' => $last_name,
                       'phone_number' => $phone_number,
                       'dob' => $dob,
                       'profile_picture' => $profile_picture,
                       'updated_at'=>now()
                ]);
            
            $updated_profile = DB::table('users')
                    ->where('users.user_id','=',$user_id)
                    ->select(
                                'users.first_name',
                                'users.middle_name',
                                'users.last_name',
                                'users.phone_number',
                                'users.dob',
                                'users.profile_picture'                                
                            )
                    ->get();
            
            $updated_profile->toArray();
            
            $app_url =  env("APP_URL");
            $default_profile_pic = env("DEFAULT_PROFILE_PIC");

            foreach ($updated_profile as $data) {
                $uri = $data->profile_picture;

                if(empty($uri)){
                    $data->profile_picture = $app_url.$default_profile_pic;
                }elseif(!preg_match( '/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i' ,$uri)){
                    $data->profile_picture = $app_url.$data->profile_picture;
                }
            }
            
            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'User Profile Updated',
                'output' => $updated_profile
            ));
            
        }else{
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No Data to Update'            
            ));
        }
        
    }
    
    public function showConnectedSocialMedia (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id'                       
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        
        $social_media = DB::table('social_media_login')
                ->where('user_id','=',$user_id)
                ->select(
                        'social_media_login.email',
                        'social_media_login.provider',
                        'social_media_login.profile_id',
                        'social_media_login.social_access_token',
                        'social_media_login.social_refresh_token',
                        'social_media_login.social_screen_name'
                        )
                ->get();
        
        if (!count($social_media)) {
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Social Media Profiles Not Found'            
            ));
        }
        
        $connected_social_media = $social_media->toArray();
                    
        return Response::json(array(
            'status_code' => 200,
            'status' => 'Success',
            'message' => 'Social Media Profiles Retrieved Successfully',
            'output' => $connected_social_media
        ));
    }
    
    public function addSocialMediaProfile (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'email' => 'nullable|email',
            'provider'=> 'required',
            'profile_id'=> 'required',
            'social_access_token'=>'nullable|string',
            'social_refresh_token' => 'nullable|string',
            'social_screen_name'=> 'nullable|string'            
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        $email_id = $request->get('email');
        $provider = $request->get('provider');
        $profile_id = $request->get('profile_id');
        $sm_access_token = $request->get('social_access_token');
        $sm_refresh_token = $request->get('social_refresh_token');
        $sm_screen_name = $request->get('social_screen_name');
        
        $provider = strtoupper($provider);
        
        $user = DB::table('users')
                ->where('user_id','=',$user_id)
                ->select('users.*')
                ->first();
        
        $existing_social_media = DB::table('social_media_login')
                ->where('provider','=',$provider)
                ->where('profile_id','=',$profile_id)
                ->select('social_media_login.*')
                ->first();
        
        if(count($existing_social_media)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Social Media Profile Already Connected to a Different Account'                
            ));
        }
        
        $registered_email = $user->email;
                
        if(!$email_id){
            $email_id = $registered_email;
        }
        
        $social_media_id = DB::table('social_media_login')->insertGetId(
            [
                'user_id' => $user_id,
                'email' => $email_id, 
                'provider' => $provider,
                'profile_id' => $profile_id,
                'social_access_token' => $sm_access_token,
                'social_refresh_token' => $sm_refresh_token,
                'social_screen_name' => $sm_screen_name,
                'created_at' => now(),
                'updated_at' => now()
            ]
        );
        
        if($social_media_id){
            return Response::json(array(
                'status_code' => 200,
                'status' => 'Success',
                'message' => 'Social Media Profile Added Successfully'                
            ));
        }else{
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'Social Media Profile Cannot be Added'            
            ));
        }
    }
    
    public function showNewNotifications (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id'                       
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        
        $notifications = DB::table('notifications')
                ->join('users','notifications.user_id','=','users.user_id')
                ->where('notifications.user_id','=',$user_id)
                ->where('notifications.message_status','=','NEW')
                ->select('notifications.*')
                ->orderBy('notifications.updated_at','desc')
                ->get();
        
        $notifications = $notifications->toArray();
        
        if(!count($notifications)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No notifications to show'            
            ));
        }
                                      
        foreach($notifications as $data){
            $reference = $data->reference;
            $reference_parameter = $data->reference_parameter;
            
            if($reference_parameter){
                $data->reference_parameter = (int)$reference_parameter;
            }
            
        }
        
        return Response::json(array(
              'status_code' => 200,
              'status' => 'Success',
              'message' => 'Notifications Successfully Retrieved',
              'output' => $notifications  
          ));     
        
    }
    
    public function showAllNotifications (Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id'                       
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        
        $notifications = DB::table('notifications')
                ->join('users','notifications.user_id','=','users.user_id')
                ->where('notifications.user_id','=',$user_id)
                ->select('notifications.*')
                ->orderBy('notifications.updated_at','desc')
                ->get();
        
        $notifications = $notifications->toArray();
        
        if(!count($notifications)){
            return Response::json(array(
                'status_code' => 400,
                'status' => 'Failure',
                'message' => 'No notifications to show'            
            ));
        }
                                      
        foreach($notifications as $data){
            $reference = $data->reference;
            $reference_parameter = $data->reference_parameter;
            
            if($reference_parameter){
                $data->reference_parameter = (int)$reference_parameter;
            }
            
        }
        
        return Response::json(array(
              'status_code' => 200,
              'status' => 'Success',
              'message' => 'Notifications Successfully Retrieved',
              'output' => $notifications  
          ));     
        
    }
    
    public function changePassword (Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,user_id',
            'old_password' => 'required',
            'new_password' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }
        
        $user_id = $request->get('user_id');
        $old_password = $request->get('old_password');
        $new_password = bcrypt($request->get('new_password'));
                
        $user = DB::table('users')
                ->where('user_id','=',$user_id)
                ->select('users.*')
                ->first();
        
        $user_password = $user->password;
                            
        if (Hash::check($old_password, $user_password)){
            DB::table('users')
                     ->where('user_id','=', $user_id)
                     ->update([
                            'password' => $new_password,
                            'updated_at'=>now()
                        ]);
        }else{
            return Response::json(array(
              'status_code' => 400,
              'status' => 'Failure',
              'message' => 'Old Password does not match',              
          ));
        }
        
        return Response::json(array(
              'status_code' => 200,
              'status' => 'Success',
              'message' => 'Password Updated Successfully',
          ));
        
    }
}
