<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Mail;

class APIsendCardController extends Controller
{
    public function sendCardViaEmail ()
    {
        $card_event_mappings = DB::table('cards_events_mapping')
                //->whereDate('cards_events_mapping.send_card_date','<=',now())
                ->where('cards_events_mapping.email_sent_status','<>','SENT')
                ->select('cards_events_mapping.*')
                ->get();
        
        if(!count($card_event_mappings)){
            return "Hi";
        }
                       
        $card_mapping = $card_event_mappings->toArray();
            
        foreach($card_mapping as $data){
            $ce_mapping_id =  $data->ce_mapping_id;
            $recipient_email = $data->recipient_email;
            $recipient_id = $data->recipient_id;
            $event_id = $data->event_id;
            $cards_id = $data->cards_id;
            
            $event = DB::table('events')
                    ->join('users','users.user_id','=','events.event_created_by')
                    ->where('events.event_id','=',$event_id)
                    ->select('users.first_name','events.event_name')
                    ->first();
                                    
            $event_creator_name = $event->first_name;
            $event_name = $event->event_name;
            
            
            
            $participants = DB::table('event_participants')
                    ->where('event_participants.event_id','=',$event_id)
                    ->select('event_participants.ep_id')
                    ->get();
            
            if(count($participants)>1){
                $etAl = 'and others ';
            }else{
                $etAl = null;
            }
            
            $card = DB::table('cards_master')
                    ->where('cards_master.cards_id','=',$cards_id)
                    ->select('cards_master.*')
                    ->first();
            
            $app_url =  env("APP_URL");
            
            if(count($card)){
                                
                $link = $card->cards_location_url;
                
                $cards_url = $app_url.$link;
                
            }
            
            $user_messages = DB::table('cards_messages')
                    ->join('users','users.user_id','=','cards_messages.user_id')
                    ->where('cards_messages.ce_mapping_id','=',$ce_mapping_id)
                    ->select(
                                'cards_messages.message_id',
                                'cards_messages.message',
                                'cards_messages.file_location',
                                'cards_messages.user_id',
                                'users.first_name',
                                'users.middle_name',
                                'users.last_name'
                            )
                    ->get();
            
            $user_message = $user_messages->toArray();
            
            return $user_message;
            
            if(!empty($recipient_id)){
                $user = DB::table('users')
                        ->where('users.user_id','=',$recipient_id)
                        ->select('users.*')
                        ->first();
                
                $account_email = $user->email;
            }
            
            if(!empty($recipient_email)){
                $recipient_account = DB::table('users')
                        ->where('users.email','=',$recipient_email)
                        ->select('users.*')
                        ->first();
                
                if($recipient_account){
                    $recipient_user_id = $recipient_account->user_id;
                }
            }
            
            if(!empty($account_email) && ($account_email != $recipient_email)){
                $emailData = array(
                        'event_creator_name' => $event_creator_name, 
                        'event_name' => $event_name,
                        'user_messages' => $user_messages,
                        'card_link' => $cards_url,
                        'etAl' => $etAl
                    );
                               
                Mail::send('emailCard', $emailData, function($message) use ($account_email) {
                    $message->to($account_email, 'Event Invitation')->subject
                       ('Card from Orchid');
                    $message->from('orchidrus@dameeko.com','Orchid');
                });
                
                Mail::send('emailCard', $emailData, function($message) use ($recipient_email) {
                    $message->to($recipient_email, 'Event Invitation')->subject
                       ('Card from Orchid');
                    $message->from('orchidrus@dameeko.com','Orchid');
                });
                
                if( count(Mail::failures()) > 0 ){
                    foreach(Mail::failures() as $email_address){
                        if($email_address == $recipient_email){
                            return;
                        }
                    }

                }else{
                    DB::table('cards_events_mapping')
                    ->where('ce_mapping_id','=', $ce_mapping_id)
                    ->where('event_id','=',$event_id)                    
                    ->update([
                           'email_sent_status'=>'SENT',
                           'updated_at'=>now()
                    ]);
                } 
            }elseif(!empty($account_email) && ($account_email == $recipient_email)){
                $emailData = array(
                        'event_creator_name' => $event_creator_name, 
                        'event_name' => $event_name,
                        'user_messages' => $user_messages,
                        'card_link' => $cards_url,
                        'etAl' => $etAl
                    );
                               
                Mail::send('emailCard', $emailData, function($message) use ($recipient_email) {
                    $message->to($recipient_email, 'Event Invitation')->subject
                       ('Card from Orchid');
                    $message->from('orchidrus@dameeko.com','Orchid');
                });
                
                if( count(Mail::failures()) > 0 ){
                    foreach(Mail::failures() as $email_address){
                        if($email_address == $recipient_email){
                            return;
                        }
                    }

                }else{
                    DB::table('cards_events_mapping')
                    ->where('ce_mapping_id','=', $ce_mapping_id)
                    ->where('event_id','=',$event_id)                    
                    ->update([
                           'email_sent_status'=>'SENT',
                           'updated_at'=>now()
                    ]);
                }
            }elseif(empty($account_email) && $recipient_email){
                $emailData = array(
                        'event_creator_name' => $event_creator_name, 
                        'event_name' => $event_name,
                        'user_messages' => $user_messages,
                        'card_link' => $cards_url,
                        'etAl' => $etAl
                    );
                               
                Mail::send('emailCard', $emailData, function($message) use ($recipient_email) {
                    $message->to($recipient_email, 'Event Invitation')->subject
                       ('Card from Orchid');
                    $message->from('orchidrus@dameeko.com','Orchid');
                });
                
                if( count(Mail::failures()) > 0 ){
                    foreach(Mail::failures() as $email_address){
                        if($email_address == $recipient_email){
                            return;
                        }
                    }

                }else{
                    DB::table('cards_events_mapping')
                    ->where('ce_mapping_id','=', $ce_mapping_id)
                    ->where('event_id','=',$event_id)                    
                    ->update([
                           'email_sent_status'=>'SENT',
                           'updated_at'=>now()
                    ]);
                }
            }
 
        }
    }
}
