<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller as Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Storage;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Image;
use Mail;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TwitterNotification;
use NotificationChannels\Twitter\TwitterChannel;

class APIEventInvitationController extends Controller
{
    public function inviteToEvent (Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'event_id' => 'required|exists:events,event_id', 
            'invitation_sent_by' => 'required|exists:users,user_id',
            'invitee.*.invitation_sent_to' => 'nullable|exists:users,user_id',
            'invitee.*.invitation_sent_via' => 'nullable|string',
            'invitee.*.invitee_profile' => 'nullable|string'            
        ]);
        /*if ($validator->fails()) {
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' =>$validator->errors()
                    ));
        }*/
                
        $event_id = $request->get('event_id');
        $invitation_sent_by = $request->get('invitation_sent_by');
        $invitee = $request->input('invitee.*');
        
        $app_url =  env("APP_URL_1");
        $encoded_event_id = base64_encode($event_id);
        $encoded_sender_id = base64_encode($invitation_sent_by);
        
        $invitation_url = $app_url.'?l='.$encoded_event_id.'&e='.$encoded_sender_id;
        return $invitation_url;
        $event_creator = DB::table('users')
                ->where('user_id','=',$invitation_sent_by)
                ->select('users.*')
                ->first();
        
        $event_creator_name = $event_creator->first_name;
        
        $event = DB::table('events')
                ->where('event_id','=',$event_id)
                ->select('events.*')
                ->first();
        
        $event_participant = DB::table('event_participants')
                ->where('event_id','=',$event_id)
                ->where('user_id','=',$invitation_sent_by)
                ->select('event_participants.*')
                ->first();
        
        if($event_participant){
            $role_id = $event_participant->role_id;
            
            $role = DB::table('event_participants_role_master')
                    ->where('role_id','=',$role_id)
                    ->select('event_participants_role_master.*')
                    ->first();
            
            if($role){
                $role_name = $role->role_name;
            }else{
                return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' => 'User Role does not exist'
                    ));
            }
        }else{
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' => 'Either event does not exist Or User is not a part of the event'
                    ));
        }
        
        /*
        if(($role_name != 'SUPER ADMIN') && ($role_name != 'ADMIN')){
            return response()->json(array(
                                'status_code' => 400, 
                                'status' => 'Failure',    
                                'message' => 'Only Admin can send invites for an event'
                    ));
        }
        */           
        $invitation_sent_to = null;
        $invitation_sent_via = null;
        $invitee_profile = null;
        $invitation_id = null;
        
        foreach($invitee as $data){
            $invitation_sent_to = $data['invitation_sent_to'];
            $invitation_sent_via = $data['invitation_sent_via'];
            $invitee_profile = $data['invitee_profile'];
            
            $email_id = $invitee_profile;
            $event_name = $event->event_name;
                            
            if($invitation_sent_via == 'EMAIL'){
                $user = DB::table('users')
                        ->where('email','=',$invitee_profile)
                        ->select('users.*')
                        ->first();
                
                if(count($user)){
                    $invitation_sent_to = $user->user_id;
                }
                
                $emailData = array(
                        'event_creator_name' => $event_creator_name, 
                        'event_name' => $event_name,
                        'url'  => $invitation_url
                    );
                               
                Mail::send('eventInvite', $emailData, function($message) use ($email_id) {
                    $message->to($email_id, 'Event Invitation')->subject
                       ('Event Invitation from Orchid');
                    $message->from('orchidrus@dameeko.com','Orchid');
                });
            }elseif($invitation_sent_via == 'TWITTER'){
                
                $twitterData = array(
                   'event_creator_name' => $event_creator_name, 
                   'event_name' => $event_name,
                   'url'  => $invitation_url
                );
                $message = "Hi, ".$twitterData['event_creator_name']." has invited you to participate in the event ".$twitterData['event_name'].". Please click on the following link to join or login to Orchid to view the invitation. ".$twitterData['url']."";
                try{
                Notification::route(TwitterChannel::class, '')
                    ->notify(new TwitterNotification($invitee_profile, $message));
                }catch(\NotificationChannels\Twitter\Exceptions\CouldNotSendNotification $e){
                    
                }
            }elseif($invitee_profile){
                $invitee_social_profile = DB::table('social_media_login')
                        ->join('users','social_media_login.user_id','=','users.user_id')
                        ->where('social_media_login.profile_id','=',$invitee_profile)
                        ->orderBy('users.created_at','desc')
                        ->select('social_media_login.*','users.*')
                        ->first();
                               
                if(count($invitee_social_profile)){
                    $invitation_sent_to = $invitee_social_profile->user_id;                     
                }
            }
            
            $existing_invitation = DB::table('event_invitation')
                    ->where('event_id','=',$event_id)
                    ->where('invitation_sent_by','=',$invitation_sent_by)
                    ->where('invitation_sent_to','=',$invitation_sent_to)
                    ->where('invitation_sent_via','=',$invitation_sent_via)
                    ->where('invitee_profile','=',$invitee_profile)
                    ->select('event_invitation.*')
                    ->first();
            
            if(count($existing_invitation)){
                $invitation_id = $existing_invitation->invitation_id;
                
                DB::table('event_invitation')
                    ->where('invitation_id', $invitation_id)
                    ->update(['invitation_status' => 'RE-SENT','updated_at' => now()]);
            }else{
                $invitation_id = DB::table('event_invitation')->insertGetId(
                    [
                        'event_id' => $event_id,
                        'invitation_sent_by' => $invitation_sent_by,
                        'invitation_sent_to' => $invitation_sent_to,
                        'invitation_sent_via' => $invitation_sent_via,
                        'invitee_profile' => $invitee_profile,
                        'invitation_status' => 'SENT',
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
            }
            
            if(($invitation_sent_to != null) && $invitation_id){
                $invitee_role = DB::table('event_participants_role_master')
                        ->where('role_name','=','MEMBER')
                        ->where('is_active','=','Y')
                        ->select('event_participants_role_master.*')
                        ->first();
                
                $invitee_role_id = $invitee_role->role_id;
                
                $notification = ''.$event_creator_name.' has invited you to participate in the event '.$event_name.'';                        
                
                $existing_notification = DB::table('notifications')
                        ->where('user_id','=',$invitation_sent_to)
                        ->where('notification_messages','=',$notification)
                        ->where('message_status','=','NEW')
                        ->where('reference','=','EVENT_ID')
                        ->where('reference_parameter','=',(string)$event_id)
                        ->select('notifications.*')
                        ->get();
                
                if(!count($existing_notification)){
                    $event_notification = DB::table('notifications')->insertGetId(
                                [
                                    'user_id' => $invitation_sent_to,
                                    'notification_messages' => $notification,
                                    'message_status' => 'NEW',
                                    'reference' => 'EVENT_ID',
                                    'reference_parameter' => (string)$event_id,
                                    'created_at' => now(),
                                    'updated_at' => now()
                                ]
                            );
                }                               
                
                $existing_participant = DB::table('event_participants')
                        ->where('event_id','=',$event_id)
                        ->where('user_id','=',$invitation_sent_to)
                        ->select('event_participants.*')
                        ->first();
                
                if(!count($existing_participant)){
                 
                    $event_participants = DB::table('event_participants')->insertGetId(
                        [
                            'event_id' => $event_id,
                            'user_id' => $invitation_sent_to,
                            'role_id' => $invitee_role_id,
                            'event_invitation_id' => $invitation_id,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );
                                    
                }
                                              
            }

        }
        
        return response()->json(array(
                                'status_code' => 200, 
                                'status' => 'Success',    
                                'message' => 'Selected Users Successfully Invited to Event'
                    ));
        
    }
    
    public function blockInvitation (Request $request)
    {
        
    }
    
    public function acceptInvitation (Request $request)
    {
        
    }
}
