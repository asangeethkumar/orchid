<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ApiConsumptionClass;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{ 
    /*to show user profile in profile page*/
    public function showUserProfile($sendData){
        $uri = '/showUserProfile';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }   
    /*for primarydetails in profile page*/
    public function primaryDetailsPage(){
        if((isset($_COOKIE['orchid_description'])) && isset($_COOKIE['orchid_unumber'])){
            $user_id = $_COOKIE['orchid_unumber'];
            $userData = [
                'user_id' => $user_id
            ];
            /*to show user profile in profile page*/
            $userResponse = $this->showUserProfile($userData);
            $showuserprofile = json_decode($userResponse, true);
            if($showuserprofile['status_code'] == 200){
                session_start();
                if(isset($_SESSION['userupdate_status_code']) && isset($_SESSION['userupdate_message'])){
                    return view('pages/primarydetails')->with('showprofile', $showuserprofile)
                        ->with('status_code', $_SESSION['userupdate_status_code'])->with('message', $_SESSION['userupdate_message']);
                }else{
                    return view('pages/primarydetails')->with('showprofile', $showuserprofile)->with('status_code', "");
                } 
            }else{
              return Redirect::back();
           }
        }else{
            return redirect()->to('/logout');
        }
    }
    /*for update profile page*/
    public function updateProfile(Request $request){
    if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
        $data = $request->all();
        $userid       = $_COOKIE['orchid_unumber'];
        $name         = $data['eventnames'];
        $phone_number = $data['phonenumber'];
        $dob          = $data['dob'];
            $sec = strtotime($dob);
            $date = date("Y-m-d H:i", $sec); 
            $start_time = $date . ":00"; 
        $file     = $request->file('profile-upload');
            $profile_pic = "";
            if($file){
                $profile_pic = base64_encode(file_get_contents($file));
            }
        $sendData = [
            'user_id'                 => $userid,
            'first_name'              => $name,
            'phone_number'            => $phone_number,
            'dob'                     => $start_time,
            'profile_picture'         => $profile_pic
        ];
            $uri = '/updateUserProfile';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            
            if($result['output'][0]['first_name'] != null){
                    $user_name = $result['output'][0]['first_name'];
                }else{
                    $user_name = $result['output'][0]['email'];
                }
            
            //session
            session_start();
            $_SESSION['userupdate_status_code'] = $result['status_code'];
            $_SESSION['userupdate_message'] = $result['message'];
            if($result['status_code'] == 200){
                $_SESSION['user_profile_pic'] = $result['output'][0]['profile_picture'];
                $_SESSION['user_profile_name'] = $user_name;
                //setcookie('user_profile_pic', $result['output'][0]['profile_picture'] ,time() + (86400 * 30), "/");
                //setcookie('user_profile_name', $user_name ,time() + (86400 * 30), "/");
                return redirect()->to('/profile');
            }else{
                return redirect()->to('/profile');
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    
    
    
    /*for socialconnect in profile page*/
    public function displayConnectSocialMediaPage(){
       if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
           session_start();
            if(isset($_SESSION['socialmsg'])){
                $socialmsg = $_SESSION['socialmsg'];
            }
           $user_id = $_COOKIE['orchid_unumber'];
           $sendData = [ 'user_id' => $user_id ];
           $uri = '/showConnectedSocialMedia';
           $apiObject = new ApiConsumptionClass();
           $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
           $result = json_decode($jsonResponseData, true);
           if($result['status_code'] == 200){
               if(isset($_SESSION['socialmsg'])){
                    return view('pages/connectsocial')->with("socialMsg", $socialmsg)->with("connectedSocialMedia", $result)->with("status_code", $result['status_code']);
               } else{
                    return view('pages/connectsocial')->with("connectedSocialMedia", $result)->with("status_code", $result['status_code'])->with('status', "");
               }
           }elseif($result['status_code'] == 400){
               if(isset($_SESSION['socialmsg'])){
                    return view('pages/connectsocial')->with("socialMsg", $socialmsg)->with("status_code", $result['status_code']);
               } else{
                    return view('pages/connectsocial')->with("status_code", $result['status_code'])->with('status', "");
               }
           }else{
              return Redirect::back();
           }
       }else{
           return redirect()->to('/logout');
       }
    }
    
    
    /*for significant eventtypes in profile page*/
    public function significantEventsInfo($sendData){
        $uri = '/listSignificantEventTypes';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*for relation in significant events in profile page*/
    public function userRelationInfo($sendData){
        $uri = '/listUserRelationships';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*for listing significant events in profile page*/
    public function listSignificantEvents($sendData){
        $uri = '/listSignificantEvents';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        return $jsonResponseData;
    }
    /*for significant in profile page*/
    public function significantEventPage(){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $user_id = $_COOKIE['orchid_unumber'];
            $sendData = [
                'creator_user_id' => $user_id
            ];
            /*for significant eventtypes in profile page*/
            $jsonResponseData = $this->significantEventsInfo($sendData);
            $result = json_decode($jsonResponseData, true);
            /*for relation in significant events in profile page*/
            $jsonResponse = $this->userRelationInfo($sendData);
            $userrelation = json_decode($jsonResponse, true);
            /*for listing significant events in profile page*/
            $signfResponse = $this->listSignificantEvents($sendData);
            $listsignifevents = json_decode($signfResponse, true);
            if($result['status_code'] == 200){
                session_start();
                if(isset($_SESSION['signf_status_code']) && isset($_SESSION['signf_message'])){
                    if(isset($_SESSION['show_signif_event'])){
                        $show_signif_event = json_decode($_SESSION['show_signif_event'], true);
                        return view('pages/significantevent')->with('showsignifevents', $show_signif_event)->with('significantevents', $result)->with('listsignifevents', $listsignifevents)->with('userrelation', $userrelation)
                            ->with('status_code', $_SESSION['signf_status_code'])->with('message', $_SESSION['signf_message']);
                    }else{
                        return view('pages/significantevent')->with('showsignifevents', "")->with('showsignifevents', "")->with('significantevents', $result)->with('listsignifevents', $listsignifevents)->with('userrelation', $userrelation)
                            ->with('status_code', $_SESSION['signf_status_code'])->with('message', $_SESSION['signf_message']);
                    }
                }elseif(isset($_SESSION['update_signf_status_code']) && isset($_SESSION['update_signf_message'])){
                    if(isset($_SESSION['show_signif_event'])){
                        $show_signif_event = json_decode($_SESSION['show_signif_event'], true);
                        return view('pages/significantevent')->with('showsignifevents', $show_signif_event)->with('significantevents', $result)->with('listsignifevents', $listsignifevents)->with('userrelation', $userrelation)
                            ->with('status_code', $_SESSION['update_signf_status_code'])->with('message', $_SESSION['update_signf_message']);
                    }else{
                        return view('pages/significantevent')->with('showsignifevents', "")->with('showsignifevents', "")->with('significantevents', $result)->with('listsignifevents', $listsignifevents)->with('userrelation', $userrelation)
                            ->with('status_code', $_SESSION['update_signf_status_code'])->with('message', $_SESSION['update_signf_message']);
                    }
                }elseif(isset($_SESSION['del_signf_status_code']) && isset($_SESSION['del_signf_message'])){
                    if(isset($_SESSION['show_signif_event'])){
                        $show_signif_event = json_decode($_SESSION['show_signif_event'], true);
                        return view('pages/significantevent')->with('showsignifevents', $show_signif_event)->with('significantevents', $result)->with('listsignifevents', $listsignifevents)->with('userrelation', $userrelation)
                            ->with('status_code', $_SESSION['del_signf_status_code'])->with('message', $_SESSION['del_signf_message']);
                    }else{
                        return view('pages/significantevent')->with('showsignifevents', "")->with('showsignifevents', "")->with('significantevents', $result)->with('listsignifevents', $listsignifevents)->with('userrelation', $userrelation)
                            ->with('status_code', $_SESSION['del_signf_status_code'])->with('message', $_SESSION['del_signf_message']);
                    }
                }else{
                    if(isset($_SESSION['show_signif_event'])){
                        $show_signif_event = json_decode($_SESSION['show_signif_event'], true);
                        return view('pages/significantevent')->with('showsignifevents', $show_signif_event)->with('significantevents', $result)->with('listsignifevents', $listsignifevents)->with('userrelation', $userrelation)->with('status_code', "");
                    }else{
                        return view('pages/significantevent')->with('showsignifevents', "")->with('significantevents', $result)->with('listsignifevents', $listsignifevents)->with('userrelation', $userrelation)->with('status_code', "");
                    }    
                }    
            }else{
                return Redirect::back();
            }
        }else{
           return redirect()->to('/logout');
       }
    }
    /*to add significant event in profile page*/
    public function addSignificantEvent(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $data = $request->all();
            $userid           = $_COOKIE['orchid_unumber'];
            $name             = $data['signf_name'];
            $event_type_id    = $data['eventtype'];
            $relation         = $data['relation'];
            $event_user_id    = null;
            $signf_date       = $data['datesignfevent'];
                $sec = strtotime($signf_date);
                $date = date("Y-m-d H:i", $sec); 
            $signf_frequency  = 'YEARLY';
            $sendData = [
                'creator_user_id'    => $userid,
                'name'               => $name,
                'se_type_id'         => $event_type_id,
                'event_user_id'      => $event_user_id,
                'se_relationship_id' => $relation,
                'se_date'            => $date,
                'se_frequency'       => $signf_frequency
            ];
            $uri = '/createSignificantEvent';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            $result = json_decode($jsonResponseData, true); 
            //session
            session_start();
            $_SESSION['signf_status_code'] = $result['status_code'];
            $_SESSION['signf_message'] = $result['message'];
            if($result['status_code'] == 200){
                return redirect()->to('/significant-event');
            }else{
                return redirect()->to('/significant-event');
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    /*to show significant event in profile page*/
    public function showSignificantEvent(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $userid           = $_COOKIE['orchid_unumber'];
            $show_signf_eventid = $request['sei'];
            session_start();
                $_SESSION['show_signf_eventid'] = $show_signf_eventid;
            $sendData = [
                'creator_user_id'    => $userid,
                's_events_id'        => $show_signf_eventid
            ];
            $uri = '/showSignificantEvent';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
                $_SESSION['show_signif_event'] = $jsonResponseData;
                return redirect()->to('/significant-event');
        }else{
            return redirect()->to('/logout');
        }
    }
    /*to add significant event in profile page*/
    public function updateSignificantEvent(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $s_events_id = $request['usei'];
            $data = $request->all();
            $userid           = $_COOKIE['orchid_unumber'];
            $name             = $data['signf_name'];
            $event_type_id    = $data['eventtype'];
            $relation         = $data['relation'];
            $event_user_id    = null;
            $signf_date       = $data['datesignfevent'];
                $sec = strtotime($signf_date);
                $date = date("Y-m-d H:i", $sec); 
            $signf_frequency  = 'YEARLY';
            $sendData = [
                'creator_user_id'    => $userid,
                's_events_id'        => $s_events_id,
                'name'               => $name,
                'se_type_id'         => $event_type_id,
                'event_user_id'      => $event_user_id,
                'se_relationship_id' => $relation,
                'se_date'            => $date,
                'se_frequency'       => $signf_frequency
            ];
            $uri = '/updateSignificantEvent';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            //session
            session_start();
            $_SESSION['update_signf_status_code'] = $result['status_code'];
            $_SESSION['update_signf_message'] = $result['message'];
            if($result['status_code'] == 200){
                return redirect()->to('/significant-event');
            }else{
                return redirect()->to('/significant-event');
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    /*to delete significant event in profile page*/
    public function deleteSignificantEvent(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $userid           = $_COOKIE['orchid_unumber'];
            $del_signf_eventid = $request['dsei'];
            $sendData = [
                'creator_user_id'    => $userid,
                's_events_id'        => [$del_signf_eventid]
            ];
            $uri = '/deleteSignificantEvents';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            //session
            session_start();
            $_SESSION['del_signf_status_code'] = $result['status_code'];
            $_SESSION['del_signf_message'] = $result['message'];
            if($result['status_code'] == 200){
                return redirect()->to('/significant-event');
            }else{
                return redirect()->to('/significant-event');
            }
        }else{
            return redirect()->to('/logout');
        }
    }
    
    
    
    /*for changepassword in profile page*/
    public function changePasswordPage(){
        if(isset($_COOKIE['orchid_description'])){
            session_start();
                if(isset($_SESSION['password_status_code']) && isset($_SESSION['passowrd_message'])){
                    return view('pages/changepassword')->with('status_code', $_SESSION['password_status_code'])->with('message', $_SESSION['passowrd_message']);
                }else{
                    return view('pages/changepassword')->with('status_code', "");
                }
        }else{
            return redirect()->to('/logout');
        }
    }
    /*for change password in profile page*/
    public function createNewPassword(Request $request){
        if(isset($_COOKIE['orchid_description']) && isset($_COOKIE['orchid_unumber'])){
            $data = $request->all();
            $userid                         = $_COOKIE['orchid_unumber'];
            $old_password                   = $data['old_password'];
            $new_password                   = $data['new_password'];
            $sendData = [
                'user_id'                   => $userid,
                'old_password'              => $old_password,
                'new_password'              => $new_password
            ];
            $uri = '/changePassword';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumption($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            //session
            session_start();
            $_SESSION['password_status_code'] = $result['status_code'];
            $_SESSION['passowrd_message'] = $result['message'];
            if($result['status_code'] == 200){
                return redirect()->to('/change_password');
            }else{              
                return redirect()->to('/change_password');
            }
        }else{
            return redirect()->to('/logout');
        }
    }    
}