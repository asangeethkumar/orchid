<?php

namespace App\Http\Controllers;

use App\Classes\SlackClass;
use App\Classes\TwitterClass;
use Illuminate\Http\Request;
use App\Classes\ApiConsumptionClass;
use Illuminate\Support\Facades\Redirect;

class EventController extends Controller
{
    /*for listing upcoming events in Home page*/
    public function upcomingEventsInfo($sendData){
        $uri = '/listUpcomingParticipatingEvents';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*for listing past events in Home page*/
    public function pastEventsInfo($sendData){
        $uri = '/listPastParticipatingEvents';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*for listing events in homepage*/
    public function eventsList(){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            session_start();
            $userid = $_COOKIE['orchid_unumber'];
            $sendData = [
                'user_id' => $userid
            ];
            /*getting user profile*/
            $sendData2 = [ 'user_id' => $userid ];
            $uri2 = '/showUserProfile';
            $apiObject2 = new ApiConsumptionClass();
            $jsonResponseData2 = $apiObject2->postMethodApiConsumptionWithToken($uri2, $sendData2);
            $result2 = json_decode($jsonResponseData2, true);
            $data2 =  $result2['output']; 
            //return "hi";
            if(isset($_SESSION['login_eventid']) && isset($_SESSION['eventsend_user'])){
                $ivitation_details = [ 
                    "invitation_sent_to" => $userid,
                    "invitation_sent_via" => "",
                    "invitee_profile" => ""
                ];
                $getevent = [
                    'event_id'  => $_SESSION['login_eventid'],
                    'invitation_sent_by' => $_SESSION['eventsend_user'],
                    'invitee' => [$ivitation_details]
                ];
                $uri_invite = '/inviteToEvent';
                $apiObject3 = new ApiConsumptionClass();
                $jsonResponseData3 = $apiObject3->postMethodApiConsumptionWithToken($uri_invite, $getevent);
                $result_inviteevent = json_decode($jsonResponseData3, true);
            }
            if($data2[0]['first_name'] != null){
                $user_name = $data2[0]['first_name'];
            }else{
                $user_name = $data2[0]['email'];
            } 
            if($result2['status_code'] == 200){
                $_SESSION['user_profile_pic'] = $data2[0]['profile_picture'];
                $_SESSION['user_profile_name'] = $user_name;
            }
            /*for listing upcoming events in Home page*/
            $jsonResponseData = $this->upcomingEventsInfo($sendData);
            $result = json_decode($jsonResponseData, true);
            /*for listing past events in Home page*/
            $jsonResponse = $this->pastEventsInfo($sendData);
            $eventresult = json_decode($jsonResponse, true);
            if($result['status_code'] == 200  || $eventresult['status_code'] == 200){
                if(isset($_SESSION['status_code']) && isset($_SESSION['message'])){ 
                    return view('pages/homepage')->with('upcomingevents', $result)->with('pastevents', $eventresult)->with("message", $_SESSION['message'])->with("status", $_SESSION['status_code']);
                }elseif(isset($_SESSION['status_code']) && isset($_SESSION['nocardmessage'])) {
                      return view('pages/homepage')->with('upcomingevents', $result)->with('pastevents', $eventresult)->with("message", $_SESSION['nocardmessage'])->with("status", $_SESSION['status_code']);
                } else{
                    return view('pages/homepage')->with('upcomingevents', $result)->with('pastevents', $eventresult)->with('status', "");
                }
            } else{
                if(isset($_SESSION['status_code']) && isset($_SESSION['message'])){ 
                    return view('pages/homepage')->with('upcomingevents', $result)->with('pastevents', $eventresult)->with("message", $_SESSION['message'])->with("status", $_SESSION['status_code']);
                }elseif(isset($_SESSION['status_code']) && isset($_SESSION['nocardmessage'])) {
                      return view('pages/homepage')->with('upcomingevents', $result)->with('pastevents', $eventresult)->with("message", $_SESSION['nocardmessage'])->with("status", $_SESSION['status_code']);
                } else{
                    return view('pages/homepage')->with('upcomingevents', $result)->with('pastevents', $eventresult)->with('status', "");
                }
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    
    
    /*for cards in create event page*/
    public function getEventsInfo($sendData){
        $uri = '/listEventType';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*for all cards in create events page*/
    public function allCardsInfo($sendData){
        $uri = '/listAllCards';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*for cards category in create events page*/
    public function cardsCategoryInfo($sendData){
        $uri = '/listCardsCategory';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /* Display Create events page*/
    public function displayCreateEventsPage(){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $user_id = $_COOKIE['orchid_unumber'];
            $sendData = [
                'user_id' => $user_id
            ];
            //for significant events
            $jsonResponseData = $this->getEventsInfo($sendData);
            $result = json_decode($jsonResponseData, true);
            //for listing all cards
            $cardsResponse = $this->allCardsInfo($sendData);
            $cardsresult = json_decode($cardsResponse, true);
            //for cards category
            $cardsCategoryResponse = $this->cardsCategoryInfo($sendData);
            $cardscategory = json_decode($cardsCategoryResponse, true);
            if($result['status_code'] == 200){
                return view('pages/createevents')->with('significantevents', $result)->with('cardslist', $cardsresult)->with('cardscategory', $cardscategory);
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    
    
    /*for create event page*/
    public function createEvent(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $data = $request->all();            
            session_start();
               $_SESSION['edit_event_id'] = "";         
            $eventnames       = $data['eventnames'];
            $eventtype        = $data['eventtype'];
            $eventdescription = $data['eventdescription'];
            $eventdate        = $data['eventdate'];
                $sec = strtotime($eventdate);
                $date = date("Y-m-d H:i", $sec); 
                $start_time = $date . ":00"; 
            $responsedate     = $data['responsedate'];
                $sec = strtotime($responsedate);
                $date = date("Y-m-d ", $sec); 
                $response_time = $date . "23:59:59"; 
            $createdby        = $_COOKIE['orchid_unumber'];
            $sendData = [
                'event_name'                 => $eventnames,
                'event_type_id'              => $eventtype,
                'event_description'          => $eventdescription,
                'event_start_time'           => $start_time,
                'event_response_by_time'     => $response_time,
                'event_created_by'           => $createdby
            ];
            $uri = '/createEvents';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message']; 
            $_COOKIE['event_id'] = $result['event_id'];
            $event_id = $_COOKIE['event_id'];
            if(isset($data['card'])){$cardsid         = $data['card'];}
            if(isset($data['cards'])){$cardsid         = $data['cards'];}
            if(isset($cardsid)){
                $cards_value = explode("&&",$cardsid);
                $card_id  = $cards_value[0];
                $card_url = $cards_value[1];
                $cards_id              = $data['recipent_mail'];
                $add_message           = $data['addmessage'];
                $cards_id              = $card_id;
                $recipient_email       = $data['recipent_mail'];
                $file                  = $request->file('file-upload');
                if(isset($data['signature_data'])){
                    $scrible               = $data['signature_data'];
                }else{
                    $scrible               = null;
                }
                if(isset($file)){
                $ext                   = $file->getClientOriginalName();
                $extension             = pathinfo($ext);
                }else{
                    $extension = null;
                }
                $msg_file = "";
                if($file){
                   $msg_file = base64_encode(file_get_contents($file));
                }
                $cardData = [
                    'cards_id'                  => $cards_id,
                    'event_id'                  => $event_id,
                    'recipient_email'           => $recipient_email,
                    'send_card_date'            => $start_time,
                    'message'                   => $add_message,
                    'selected_by_user_id'       => $createdby,
                    'message_file'              => $msg_file,
                    'file_extension'            => $extension['extension'],
                    'scrible_file'              => $scrible
                ];
                $uri = '/selectCard';
                $apiObject = new ApiConsumptionClass();
                $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $cardData);
                $resultCard = json_decode($jsonResponseData, true);
            }
            if($result['status_code'] == 200){
                setcookie('event_id', $result['event_id'], time() + (86400 * 30), "/");
    //            return redirect()->to('/add-friends-to-event');
                return redirect()->to('/invite-friends?ifte='.$result['event_id']);
            }else{
                return Redirect::back();
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    
    
    /*to show created events to edit*/
    public function editEventsInfo($sendData){
        $uri = '/showEvent';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*to show user profile in profile page*/
    public function showUserProfile($sendData){
        $uri = '/showUserProfile';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    } 
    /*to show selected card in addmessage page*/
    public function showSelectedCard($sendData){
        $uri = '/showSelectedCard';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    } 

    
    /*for add people in create events page*/
    public function addPeople($sendData){
        $uri = '/showConnectedSocialMedia';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*dispaly add friends page*/
    public function displayAddFriendsPage(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            try{
                $data = $request->all();
                $aev = $data['ifte'];
                session_start();
                $_SESSION['edit_event_id'] = $aev;
                $event_id = [ 'event_id'  => $aev];
                $user_id = $_COOKIE['orchid_unumber'];
                $sendData = [ 'user_id' => $user_id ];
                //to add people
                $jsonResponse = $this->addPeople($sendData);
                $addpeople = json_decode($jsonResponse, true);
                /*to show selected card in addmessage page*/
                $selectedCard = $this->showSelectedCard($event_id);
                $showselectedcard = json_decode($selectedCard, true);
                
                if($showselectedcard['status_code'] == 400){
                    $_SESSION['status_code'] = $showselectedcard['status_code'];
                    $_SESSION['nocardmessage'] = $showselectedcard['message']; 
                    return redirect()->to('/up-events');
                }
                //get user & events info
                $sendData2 = [ 'user_id' => $user_id, 'event_id' =>  $aev];
                $userData = $this->getUserAndEventsInfo($sendData2);
                //get Twitter & Slack friendList
                $friendList = $this->getSocialMediaFriendList($user_id);
        //print_r($friendList); exit();
                return view('pages/addfriends')->with('userData', $userData)->with('addpeople', $addpeople)->with('friendList', $friendList)->with("event_id", $aev);
            }catch(\Symfony\Component\Debug\Exception\FatalErrorException $e){
                return Redirect::back();
            }//catch(\Exception $e){
               // return redirect()->to('/show-card');
            //}
        }else{
            return redirect()->to('/logout');
        }
    }   
    //get user & events info
    public function getUserAndEventsInfo($sendData){
        $jsonResponse = $this->getEventsInfoByEventId($sendData['event_id']);
        $eventData = json_decode($jsonResponse, true);
        $event_name = "";
        $event_id = "";
        $name = "";
        $uniqueTokenWithProjectBaseUrl = env("PROJECT_BASE_URL");
        if($eventData['status_code'] == 200){
            $event_id = $eventData['output'][0]['event_id'];
            $event_name = $eventData['output'][0]['event_name'];
            if($eventData['output'][0]['created_by_first_name']){
                $name = $eventData['output'][0]['created_by_first_name'];
            }else{
                $name = $this->getUserNameByUseerId($sendData['user_id']);
            }
        }
        $responseData = ['event_id'=>$event_id, 
            'event_name'=>$event_name, 
            'user_name'=>$name, 
            'base_url'=>$uniqueTokenWithProjectBaseUrl, 
            'project_name'=>env("PROJECT_NAME"),
            'android_app'=>env("ANDROID_APP_URL"),
            'ios_app'=> env("IOS_APP_URL")
        ];
        return $responseData;
    }
    //get events info
    public function getEventsInfoByEventId($event_id){
        $sendData = [ 'event_id' => $event_id ];
        $uri = '/showEvent';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    //get user & events info
    public function getUserNameByUseerId($user_id){
        $name = "";
        $sendData = [ 'user_id' => $user_id ];
        $uri = '/showUserProfile';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        $userData = json_decode($jsonResponseData, true);
        if($userData['status_code'] == 200){
            if(!$userData['output'][0]['first_name']){
                $name = $userData['output'][0]['email'];
            }else{
                $name = $userData['output'][0]['first_name'];
            }
        }
        return $name;
    } 
    
    /*to send invitation*/
    public function sendInvitation(Request $request){
        if(isset($_COOKIE['orchid_unumber']) && isset($_COOKIE['orchid_description'])){
            $formData = $request->all();
            $twitterData = array();
            $twitter = "TWITTER";
            $slackData = array();
            $slack = "EMAIL";
            $emailData1 = array();
            $email = "EMAIL";
  //          session_start();
  //            if(isset($_SESSION['invite_event_id'])){
  //                    $eventId = $_SESSION['invite_event_id'];
  //            }else{
  //                    $eventId = $_COOKIE['event_id'];
  //            }
            $userId = $_COOKIE['orchid_unumber'];
            $eventId = $formData['event_id'];
            $sendInviteMsg = array();
            if(isset($formData['screen_name'])){
                $twitterData = $formData['screen_name'];
            }
            if(isset ($formData['email'])){
                $slackData = $formData['email'];
            }
            if(isset($formData['invitee_email'])){
                $emails = substr($formData['invitee_email'], 1);
                $emailData1 = explode(",", $emails);
            }
            if(isset($formData['invitee_email2'])){
                $addPeopleToSendInvitation1 = [
                    "invitation_sent_to"=>null,
                    "invitation_sent_via"=>$email,
                    "invitee_profile"=>$formData['invitee_email2']
                ];
                $sendInviteMsg[0] = $addPeopleToSendInvitation1;
            }
            //Twitter data
             $j = count($sendInviteMsg);
            for($i=0; $i < count($twitterData); $i++){
                $addPeopleToSendInvitation2 = [
                    "invitation_sent_to"=>null,
                    "invitation_sent_via"=>$twitter,
                    "invitee_profile"=>$twitterData[$i]
                ];
                $sendInviteMsg[$j+$i] =  $addPeopleToSendInvitation2;
            }
            //Slack data
            $k = count($sendInviteMsg);
            for($i=0; $i < count($slackData); $i++){
                $addPeopleToSendInvitation3 = [
                    "invitation_sent_to"=>null,
                    "invitation_sent_via"=>$slack,
                    "invitee_profile"=>$slackData[$i]
                ];
                $sendInviteMsg[$k+$i] = $addPeopleToSendInvitation3;
            }
            //Array of email ddata
            $p = count($sendInviteMsg);
            for($i=0; $i<count($emailData1);  $i++){
                $addPeopleToSendInvitation4 = [
                    "invitation_sent_to"=>null,
                    "invitation_sent_via"=>$email,
                    "invitee_profile"=>$emailData1[$i]
                ];
                $sendInviteMsg[$p+$i] = $addPeopleToSendInvitation4;
            }
            //all invitee's information to send invitation
            $sendData = [
                "event_id"=>$eventId,
                "invitation_sent_by" => $userId,
                "invitee" => $sendInviteMsg
            ];
         //return json_encode($sendData);   
            $uri = '/inviteToEvent';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            return redirect()->to('/show-card');
        }else{
             return redirect()->to('/logout');
        }
    } 
    
    /*dispaly view event page*/
    public function displayViewEventPage(Request $request){
        if(isset($_COOKIE['orchid_unumber']) && isset($_COOKIE['orchid_description'])){
            $editeventid = $request['aev'];
            $role_name = base64_decode($request['eur']);
            session_start();
                $_SESSION['edit_event_id'] = $editeventid;
                $_SESSION['user_role_name'] = $role_name;
            //$eventid = $_COOKIE['event_id'];
            $userid = $_COOKIE['orchid_unumber'];
            $sendData = [
                'event_id' => $editeventid,
                'user_id' => $userid
            ];
            //events display
            $jsonResponseData = $this->editEventsInfo($sendData);
            $addevents = json_decode($jsonResponseData, true);
            /*to show user profile in profile page*/
            $userResponse = $this->showUserProfile($sendData);
            $showuserprofile = json_decode($userResponse, true);
            /*to show selected card in addmessage page*/
            $selectedCard = $this->showSelectedCard($sendData);
            $showselectedcard = json_decode($selectedCard, true);
            /*if($showselectedcard['status_code'] == 400){
                return redirect()->to('/write-msg');
            }*/
            if($addevents['status_code'] == 200){
                return view('pages/viewmessage')->with('userrole', $role_name)->with('selectedcard', $showselectedcard)->with('showprofile', $showuserprofile)->with('addevents', $addevents);
            }
        }else{
            return redirect()->to('/logout');
        }
    }
     /*for create message card*/
    public function createMessage(Request $request){
        if(isset($_COOKIE['orchid_unumber']) && isset($_COOKIE['orchid_description'])){
            $data = $request->all();
            session_start();
            $eventid               = $_SESSION['edit_event_id'];
            $ce_mapping_id         = $data['ce_mapping_id'];
            $userid                = $_COOKIE['orchid_unumber'];
            $add_message           = $data['addmessage'];
            $file                  = $request->file('file-upload');
            if(isset($data['signature_data'])){
                $scrible               = $data['signature_data'];
            }else{
                $scrible               = null;
            }
            if(isset($file)){
                $ext                   = $file->getClientOriginalName();
                $extension             = pathinfo($ext);
            }else{
                $extension = null;
            }
            $msg_file = "";
            if($file){
               $msg_file = base64_encode(file_get_contents($file));
            }
            $sendData = [
                'user_id'                   => $userid,
                'ce_mapping_id'             => $ce_mapping_id,
                'event_id'                  => $eventid,
                'message'                   => $add_message,
                'message_file'              => $msg_file,
                'file_extension'            => $extension['extension'],
                'scrible_file'              => $scrible
            ];
            $uri = '/createMessage';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            if($result['status_code'] == 200){ 
                if(($_SESSION['user_role_name'] == "SUPER ADMIN") || ($_SESSION['user_role_name'] == "ADMIN")){
                    return redirect()->to('/invite-friends?ifte='.$_SESSION['edit_event_id']);
                }elseif($_SESSION['user_role_name'] == "MEMBER"){
                    return redirect()->to('/show-card');
                }
            }else{
                return redirect()->to('/view-msg');
            }
        }else{
            return redirect()->to('/logout');
        }
    }   
    
    /* Display edit events page*/
    public function displayEditEventPage(){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            session_start();
                $eventid = $_SESSION['edit_event_id'];
            $user_id = $_COOKIE['orchid_unumber'];
            $sendData = [
                'user_id' => $user_id,
                'event_id' => $eventid
            ];
            //for significant events
            $jsonResponseData = $this->getEventsInfo($sendData);
            $result = json_decode($jsonResponseData, true);
            //for listing all cards
            $cardsResponse = $this->allCardsInfo($sendData);
            $cardsresult = json_decode($cardsResponse, true);
            //for cards category
            $cardsCategoryResponse = $this->cardsCategoryInfo($sendData);
            $cardscategory = json_decode($cardsCategoryResponse, true);
            //events display
            $jsonResponseData = $this->editEventsInfo($sendData);
            $addevents = json_decode($jsonResponseData, true);
            /*to show selected card in addmessage page*/
            $selectedCard = $this->showSelectedCard($sendData);
            $showselectedcard = json_decode($selectedCard, true);
            if($addevents['status_code'] == 200){
                return view('pages/editevent')->with('addevents', $addevents)->with('selectedcard', $showselectedcard)->with('significantevents', $result)->with('cardslist', $cardsresult)->with('cardscategory', $cardscategory);
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    /*for create event page*/
    public function updateEvent(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $data = $request->all();
            session_start();
               $eventid = $_SESSION['edit_event_id'];
            $eventnames       = $data['eventnames'];
            $eventtype        = $data['eventtype'];
            $eventdescription = $data['eventdescription'];
            $eventdate        = $data['eventdate'];
                $sec = strtotime($eventdate);
                $date = date("Y-m-d H:i", $sec); 
                $start_time = $date . ":00"; 
            $responsedate     = $data['responsedate'];
                $sec = strtotime($responsedate);
                $date = date("Y-m-d ", $sec); 
                $response_time = $date . "23:59:59"; 
            $createdby        = $_COOKIE['orchid_unumber'];
            $sendData = [
                'event_id'                   => $eventid,
                'event_name'                 => $eventnames,
                'event_type_id'              => $eventtype,
                'event_description'          => $eventdescription,
                'event_start_time'           => $start_time,
                'event_response_by_time'     => $response_time,
                'event_created_by'           => $createdby
            ];
            $uri = '/updateEvents';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            if(isset($data['card'])){$cardsid         = $data['card'];}
            if(isset($data['cards'])){$cardsid         = $data['cards'];}
            if(isset($cardsid)){
                $cards_value = explode("&&",$cardsid);
                $card_id  = $cards_value[0];
                $card_url = $cards_value[1];
                $cards_id              = $data['recipent_mail'];
                $add_message           = $data['addmessage'];
                $cards_id              = $card_id;
                $recipient_email       = $data['recipent_mail'];
                $file                  = $request->file('file-upload');
                if(isset($data['signature_data'])){
                    $scrible               = $data['signature_data'];
                }else{
                    $scrible               = null;
                }
                if(isset($file)){
                $ext                   = $file->getClientOriginalName();
                $extension             = pathinfo($ext);
                }else{
                    $extension = null;
                }
                $msg_file = "";
                if($file){
                   $msg_file = base64_encode(file_get_contents($file));
                }
                $cardData = [
                    'cards_id'                  => $cards_id,
                    'event_id'                  => $eventid,
                    'recipient_email'           => $recipient_email,
                    'send_card_date'            => $start_time,
                    'message'                   => $add_message,
                    'selected_by_user_id'       => $createdby,
                    'message_file'              => $msg_file,
                    'file_extension'            => $extension['extension'],
                    'scrible_file'              => $scrible
                ];
                $uri = '/selectCard';
                $apiObject = new ApiConsumptionClass();
                $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $cardData);
                $resultCard = json_decode($jsonResponseData, true);
            }
            if($result['status_code'] == 200){
                return redirect()->to('/invite-friends?ifte='.$_SESSION['edit_event_id']);
            }else{
                return Redirect::back();
            }
        }else{
            return redirect()->to('/logout');
        }
    }
  
    /*to dispaly created card page*/
    public function displayCreatedCardPage(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            session_start();
            if(isset($request['cei']) && isset($request['cur'])){
                $eventid               = base64_decode($request['cei']);
                $userrole              = base64_decode($request['cur']);
            }
            else if($_SESSION['edit_event_id']){
                $eventid               = $_SESSION['edit_event_id'];
            }else{
                $eventid = $_COOKIE['event_id'];
            }
            $userid = $_COOKIE['orchid_unumber'];
            $sendData = [
                'event_id' => $eventid,
                'user_id' => $userid
            ];
            //events display
            $jsonResponseData = $this->editEventsInfo($sendData);
            $addevents = json_decode($jsonResponseData, true);
            /*to show user profile in profile page*/
            $userResponse = $this->showUserProfile($sendData);
            $showuserprofile = json_decode($userResponse, true);
            /*to show selected card in addmessage page*/
            $selectedCard = $this->showSelectedCard($sendData);
            $showselectedcard = json_decode($selectedCard, true);
             if($showselectedcard['status_code'] == 200){
                return view('pages/showcreatedcard')->with('selectedcard', $showselectedcard)->with('showprofile', $showuserprofile)->with('addevents', $addevents);
            }else{
                return redirect()->to('/view-msg?aev='.$eventid.'&eur='.base64_encode($userrole));
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    
    /*for slack connection*/
    public function getSlackFriends($slackToken){
        $slack = new SlackClass();
        $response = $slack->getSlackFriendList($slackToken);
        return $response;
    }
    /*for twitter connection*/
    public function getTwitterFriendList($screen_name){
        $twitter = new TwitterClass();
        $response = $twitter->getTwitterFriends($screen_name);
        return $response;
    }
    
    public function getSocialMediaFriendList($user_id){
        $uri = '/showConnectedSocialMedia';
        $sendData = ["user_id" => $user_id];
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        $result = json_decode($jsonResponseData, true);
        $response = [];
        if($result['status_code'] == 200){
            $slackToken = "";
            $screen_name = "";
            foreach ($result['output'] as $user){
                if($user['provider'] == 'SLACK'){
                    $slackToken = $user['social_access_token'];
                }
                if($user['provider'] == 'TWITTER'){
                    $screen_name = $user['social_screen_name'];
                }
            }
            $twitterData = "";
            $slackData = "";
            if($slackToken){
                $slackList = $this->getSlackFriends($slackToken);
                $slackData = json_decode($slackList, true);
            }
            if($screen_name){
                $twitterList = $this->getTwitterFriendList($screen_name);
                $twitterData = json_decode($twitterList, true);
            }
            if($twitterData['users']){
                $twitter = $twitterData['users'];
                for($i=0 ; $i<count($twitter); $i++){
                    $response[$i] = $twitter[$i];
                }
            }
            if(isset($slackData['users'])){
                $i = count($response);
                $slack = $slackData['users'];
                for($j=0 ; $j<count($slack) ; $j++){
                    $response[$i+$j] = $slack[$j];
                }
            }
        }
        $friendList = ["users"=>$response];
        return $friendList;
    }
    
    
    /*to delete event in home page*/
    public function deleteEvent(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $userid           = $_COOKIE['orchid_unumber'];
            $del_eventid = $request['dei'];
            $sendData = [
                'user_id'    => $userid,
                'event_id'   => [$del_eventid]
            ];
            $uri = '/deleteMyEvent';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
                session_start();
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message'];
            if($result['status_code'] == 200){
                return redirect()->to('/up-events');
            }else{
                return redirect()->to('/up-events');
            }
        }else{
            return redirect()->to('/logout');
        }
    }
  
    
    /*to upload card in create event page*/
    public function uploadCard(Request $request){ 
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $uploaded = $request->file('fileName');
            $cards_category_id      = 13;
            $cards_name             = "My Card";
            $cards_description      = "My uploded card";
            $is_user_uploaded       = "Y";
            $userid                 = $_COOKIE['orchid_unumber'];
            $msg_file = "";
            if($uploaded){
               $msg_file = base64_encode(file_get_contents($uploaded));
            }
            $uploadCardData = [
                'cards_category_id'           => $cards_category_id,
                'cards_name'                  => $cards_name,
                'cards_description'           => $cards_description,
                'is_user_uploaded'            => $is_user_uploaded,
                'user_id_if_user_uploaded'    => $userid,
                'file'                        => $msg_file
            ];
            $uri = '/uploadCards';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $uploadCardData);
            $uploadedCard = json_decode($jsonResponseData, true);
            return $uploadedCard['status_code'];
        }else{
            return redirect()->to('/logout');
        }
    }
    
    
    
  
   /*extra*/
    /*for edit events page*/
    public function editEvents(Request $request){
        $data = $request->all();
        $eventid = $_COOKIE['event_id'];
        $userid = $_COOKIE['orchid_unumber'];
        $sendData = [
            'event_id' => $eventid,
            'user_id' => $userid
        ];
        if(isset($_COOKIE['orchid_description'])){
            //for significant events
            $jsonResponseData = $this->getEventsInfo($sendData);
            $result = json_decode($jsonResponseData, true);
            //for listing all cards
            $cardsResponse = $this->allCardsInfo($sendData);
            $cardsresult = json_decode($cardsResponse, true);
            //for cards category
            $cardsCategoryResponse = $this->cardsCategoryInfo($sendData);
            $cardscategory = json_decode($cardsCategoryResponse, true);
            //events display
            $jsonResponseData = $this->editEventsInfo($sendData);
            $addevents = json_decode($jsonResponseData, true);
            if($result['status_code'] == 200  || $eventresult['status_code'] == 200){
                return view('pages/editevents')->with('significantevents', $result)->with('cardslist', $cardsresult)->with('cardscategory', $cardscategory)->with('addevents', $addevents);
            }
        }else{
            return redirect()->to('/');
        }
    }
    /*extra*/
    
    /*guest view card*/
    /*to dispaly created card page*/
    public function guestShowCard(Request $request){
        if(isset($request['cei'])){
            $eventid               = base64_decode($request['cei']);
        }
        $sendData = [
            'event_id' => $eventid
        ];
        /*to show selected card in addmessage page*/
        $uri = '/showSelectedCard';
        $apiObject2 = new ApiConsumptionClass();
        $selectedCard = $apiObject2->postMethodApiConsumption($uri, $sendData);
        $showselectedcard = json_decode($selectedCard, true);
         if($showselectedcard['status_code'] == 200){
            return view('pages/showcardtoguest')->with('selectedcard', $showselectedcard);
        }
    }
    
    
}