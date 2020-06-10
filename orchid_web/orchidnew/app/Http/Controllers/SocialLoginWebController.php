<?php
namespace App\Http\Controllers;
 

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Classes\ApiConsumptionClass;
use Illuminate\Support\Facades\Redirect;
use App\Slack\SlackOauth;
use App\Twitter\TwitterOAuth;
/**
* Description of ApiConsumptionClass
*
* @author Ravasaheb
*/
class SocialLoginWebController extends Controller
{
    public function redirectToServiceProvider($provider){
       try{
           return \Socialite::driver($provider)->redirect();
       }catch(\GuzzleHttp\Exception\ConnectException $e){
           return "Please Check Your Internet Connection & Make Sure That You Have Connected To Internet";
       }
   }
  
   public function handleProviderServiceCallback($provider, Request $request){
       try{
           try{
               $userData = Socialite::driver($provider)->user();
               //print_r($userData); exit();
           } catch (\Laravel\Socialite\Two\InvalidStateException $e){
               return Redirect::back();
           }
           $profile_id = $userData->id;
           $name = $userData->name;
           $email = $userData->email;
           $profile_picture = $userData->avatar;
           $provider_token = $userData->token;
           /*Ravasaheb => 13/03/2019 */
           $screen_name = "";
           if($provider == "twitter"){
               $screen_name = $userData->nickname;
           }
           /* end */
           //return $screen_name; exit();
           if(isset($_COOKIE['orchid_unumber']) || isset($_COOKIE['orchid_description'])){
               $data = [
                        'user_id'=>$_COOKIE['orchid_unumber'],
                        'email'=>$email,
                        'profile_picture'=>$profile_picture,
                        'provider'=> strtoupper($provider),
                        'profile_id'=>$profile_id,
                        'social_screen_name' => $screen_name
                    ];
                $uri = '/addSocialMediaProfile';
                $apiObject = new ApiConsumptionClass();
                $jsonData = $apiObject->postMethodApiConsumptionWithToken($uri, $data);
                $result = json_decode($jsonData, true);
                session_start();
                $_SESSION['socialmsg'] = $result['message'];
               return redirect()->to('/connect-social');
           }else{
                if($provider == "instagram"){
                    /*dummy data*/
                    setcookie('orchid_description', "abc", time() + (86400 * 30), "/"); // 86400 = 1 day
                    setcookie('orchid_unumber', 20, time() + (86400 * 30), "/"); // 86400 = 1 day
                    /*end of dummy data*/
                    return redirect()->to('/up-events');
                }else{
                    $data = [
                        'first_name'=>$name,
                        'last_name'=>"",
                        'email'=>$email,
                        'profile_picture'=>$profile_picture,
                        'provider'=> strtoupper($provider),
                        'profile_id'=>$profile_id,
                        /*Ravasaheb => 13/03/2019 */
                        'social_screen_name' => $screen_name
                         /* end */
                    ];
                    $uri = '/socialLogin';
                    $apiObject = new ApiConsumptionClass();
                    $jsonData = $apiObject->postMethodApiConsumption($uri, $data);
                    $result = json_decode($jsonData, true);
                    if($result['status_code'] == 200){
                     setcookie('orchid_description', $result['token'], time() + (86400 * 30), "/"); // 86400 = 1 day
                     setcookie('orchid_unumber', $result['user_id'], time() + (86400 * 30), "/"); // 86400 = 1 day

                     return redirect()->to('/up-events');
                    }else{
                         $status_code = $result['status_code'];
                         return redirect()->to('/')->with($status_code);
                    }
               }
           }
       }catch(Exception $e){
           return "Error : ".$e->getMessage();
       }
   }
  
   public function redirectToSlackProvider(){
       $config = config('services.slack');
       return redirect("https://slack.com/oauth/authorize?scope=identity.basic identity.email identity.avatar identity.team&client_id=".$config['client_id']);
   }
  
    public function handleProviderSlackCallback(Request $request){
        try{
            $slackOauth = new SlackOauth();
            $jsonData = $slackOauth->getSlackUserInfo($request);
            $data = json_decode($jsonData, true);
 
        //print_r($jsonData); exit();
            //$access_token = $data['access_token'];
            $profile_id = $data['user']['id'];
            $name = $data['user']['name'];
            $email = $data['user']['email'];
            $profile_picture = $data['user']['image_48'];
/* Ravasaheb => 13/03/2019 */
            $sendData = [ 'name'=>$name, 'email'=>$email, 'profile_picture'=>$profile_picture, 'provider'=>'SLACK', 'profile_id'=>$profile_id ];
            setcookie('slackdata', json_encode($sendData), time() + 3600, "/"); // 1 hour
            $config = config('services.slack');
            return redirect("https://slack.com/oauth/authorize?scope=users:read users:read.email&client_id=".$config['client_id']."&redirect_uri=".$config['redirect_friend_list_uri']);
/* end 13/03/2019 */           
            /*$uri = '/socialLogin';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumption($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            if($result['status_code'] == 200){
                setcookie('orchid_description', $result['token'], time() + (86400 * 30), "/"); // 86400 = 1 day
                setcookie('orchid_unumber', $result['user_id'], time() + (86400 * 30), "/"); // 86400 = 1 day
                return redirect()->to('/up-events');
            }else{
                $status_code = $result['status_code'];
                return redirect()->to('/')->with($status_code);
            }*/
       }catch(\ErrorException $e){
           return Redirect::to('/');
       }
   }
  
   /* Ravasaheb => 13/03/2019 */
    public function connectSocialMedia($social){
        if($social == "slack"){
            $config = config('services.slack');
            return redirect("https://slack.com/oauth/authorize?scope=identity.basic identity.email identity.avatar identity.team&client_id=".$config['client_id']."&redirect_uri=".$config['redirect_connect_social_media']);
        }
    }
  
    public function connectSocialMediaCallback($social, Request $request){
        if($social == "slack"){
            $config = config('services.slack');
      
            $ch = curl_init("https://slack.com/api/oauth.access?client_id=".$config['client_id']."&client_secret=".$config['client_secret']."&code=".$request['code']."&redirect_uri=".$config['redirect_connect_social_media']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $jsonData = curl_exec($ch);
            curl_close($ch);
            $data = json_decode($jsonData, true);
        //print_r($jsonData);            exit();
           
            if($data['ok'] == true){
                $profile_id = $data['user']['id'];
                $name = $data['user']['name'];
                $email = $data['user']['email'];
                $profile_picture = $data['user']['image_48'];
                $sendData = [ 'name' => $name, 'email' => $email, 'profile_picture' => $profile_picture, 'profile_id' => $profile_id ];
                setcookie('slackdata', json_encode($sendData), time() + 3600, "/"); // 1 hour
                $config = config('services.slack');
                return redirect("https://slack.com/oauth/authorize?scope=users:read users:read.email&client_id=".$config['client_id']."&redirect_uri=".$config['redirect_friend_list_uri']);
            }else{
                return redirect()->to('/profile');
            }
        }elseif ($social == "twitter") {
            return redirect()->to("/login/twitter");
        }
    }
   
    public function connectSlackFriends(Request $request){
        if(isset($_COOKIE['slackdata'])){
            $config = config('services.slack');
            $ch = curl_init("https://slack.com/api/oauth.access?client_id=".$config['client_id']."&client_secret=".$config['client_secret']."&code=".$request['code']."&redirect_uri=".$config['redirect_friend_list_uri']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HEADER, 0);
            $jsonData = curl_exec($ch);
            curl_close($ch);
           
    //print_r($jsonData); exit();
            $data = json_decode($jsonData, true);
            if($data['ok'] == true){
                $slackdata = json_decode($_COOKIE['slackdata'], true);
                $access_token = $data['access_token'];
                //setcookie('access_token', $access_token, time() + (3600 * 24), "/"); // 1 hour
               
                $sendData = ["first_name" => $slackdata['name'], "last_name" => "", "email" => $slackdata['email'], "provider" => "SLACK", "profile_id" => $slackdata['profile_id'], 'profile_picture' => $slackdata['profile_picture'], "social_access_token" => $access_token ];
                $uri = '/socialLogin';
                $apiObject = new ApiConsumptionClass();
                $jsonResponseData = $apiObject->postMethodApiConsumption($uri, $sendData);
                $result = json_decode($jsonResponseData, true);
                if($result['status_code'] == 200){
                    setcookie('orchid_description', $result['token'], time() + (86400 * 30), "/"); // 86400 = 1 day
                    setcookie('orchid_unumber', $result['user_id'], time() + (86400 * 30), "/"); // 86400 = 1 day
                   
                    return redirect()->to('/up-events');
                }else{
                    $status_code = $result['status_code'];
                    return redirect()->to('/logout');
                }
               /* $savedData = $this->addSocialMedia($sendData);
                $jsonSavedData = json_decode($savedData, true);
                session_start();
                $_SESSION['social_media_status_code_'.$user_id] = $jsonSavedData['status_code'];
               $_SESSION['social_media_message_'.$user_id] = $jsonSavedData['message'];*/
                return redirect()->to('/profile');
            }else{
                return "else";
            }
        }else{
            return redirect()->to('/logout');
        }
    }
   
    public function addSocialMedia($sendData){
        $uri = '/addSocialMediaProfile';
        $apiObject = new ApiConsumptionClass();
        $jsonResponseData = $apiObject->postMethodApiConsumptionWithToken($uri, $sendData);
        $result = json_decode($jsonResponseData, true);
        return $result;
    }
    /*  end on 13/03/2019 */
}