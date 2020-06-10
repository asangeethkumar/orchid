<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\ApiConsumptionClass;
class LoginWebController extends Controller
{
    public function index(Request $request){
        session_start();
        if(isset($_COOKIE['orchid_description'])){ 
            return redirect()->to('/up-events');
        }else{
            if(isset($_SESSION['status_code']) && isset($_SESSION['message'])){ 
                if($request){
                    $_SESSION['login_eventid'] = base64_decode($request['l']);
                    $_SESSION['eventsend_user'] = base64_decode($request['e']);
                    return view('loginpage')->with("message", $_SESSION['message'])->with("status", $_SESSION['status_code']);
                }else{
                    return view('loginpage')->with("message", $_SESSION['message'])->with("status", $_SESSION['status_code']);
                }
            } else{ 
                if($request){
                    $_SESSION['login_eventid'] = base64_decode($request['l']);
                    $_SESSION['eventsend_user'] = base64_decode($request['e']);
                    return view('loginpage')->with('status', "");
                }else{
                    return view('loginpage')->with('status', "");
                }
            }
        }
    }
    public function loginOrRegister(Request $request){
            $data = $request->all();
            $email = $data['email'];
            $password = $data['password'];
            $sendData = [
                'email'=>$email,
                'password'=>$password
            ];
            $uri = '/login';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumption($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
                session_start();
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message'];
                
            if($result['status_code'] == 200){
                $_SESSION["email"] = $email;
                setcookie('orchid_description', $result['token'], time() + (86400 * 30), "/"); // 86400 = 1 day
                setcookie('orchid_unumber', $result['user_id'], time() + (86400 * 30), "/");
                
                $_SESSION['card_id'] = "";
                $_SESSION['card_url'] = "";
                //Auth::loginUsingId($result['user_id']);
                return redirect()->to('/up-events');
            }elseif($result['status_code'] == 206){
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $password;
                return redirect()->to('/confirm-password');
            }else{
                return redirect()->to('/');
            }
    }
    
    public function registerUser(Request $request){
            $data = $request->all();
            $email = $data['email'];
            $password = $data['password'];
            $sendData = [
                'email'=>$email,
                'password'=>$password
            ];
            $uri = '/registerUser';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumption($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            session_start();
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message'];
            if($result['status_code'] == 200){
                $_SESSION["email"] = $email;
                setcookie('orchid_description', $result['token'], time() + (86400 * 30), "/"); // 86400 = 1 day
                setcookie('orchid_unumber', $result['user_id'], time() + (86400 * 30), "/");
                
                $_SESSION['card_id'] = "";
                $_SESSION['card_url'] = "";
                return redirect()->to('/up-events');
            }else{
                return redirect()->to('/');
            }
    }
    
    
    public function displayForgetPassword(){
        session_start();
        if(isset($_SESSION['status_code']) && isset($_SESSION['message'])){      
            return view('forgetpassword')->with("message", $_SESSION['message'])->with("status", $_SESSION['status_code']);
        } else{           
            return view('forgetpassword')->with('status', "");
        }
    }
    
    public function sendOtp(Request $request){
        $data = $request->all();
        $email = $data['email'];
        /*sravanthi*/
        session_start();
        $otp_mail = $_SESSION["otp_email"] = $email;
        /*sravanthi*/
        $sendData = [
                'email'=>$email
            ];
            $uri = '/sendOTP';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumption($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            if($result['status_code'] == 200){
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message'];
                return redirect()->to('/new-password');
            }else{
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message']['email'][0];
                return redirect()->to('/forget-password');
            }
    }
    /*sravanthi*/
    
    public function displayNewPassword(){
        session_start();
        if(isset($_SESSION['status_code']) && isset($_SESSION['message'])){      
            return view('newpasswordlogin')->with("message", $_SESSION['message'])->with("status", $_SESSION['status_code']);
        } else{           
            return view('newpasswordlogin')->with('status', "");
        }
    }
    
    public function resendOtp(Request $request){
        $data = $request->all();
        session_start();
        $email = $_SESSION["otp_email"];
        $sendData = [
                'email'=>$email
            ];
            $uri = '/reSendOTP';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumption($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
            if($result['status_code'] == 200){
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message'];
                return redirect()->to('/new-password');
            }else{
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message']['email'][0];
                return redirect()->to('/forget-password');
            }
    }
    
    
    public function verifyOtp(Request $request){
        $data = $request->all();
        $otp = (int)$data['otp'];
        session_start();
        $email = $_SESSION["otp_email"];
        $password = $data['password'];
        
        $sendData = [
                'email'=>$email,
                'otp'=>$otp,
                'password'=>$password
            ];
            $uri = '/verifyOTP';
            $apiObject = new ApiConsumptionClass();
            $jsonResponseData = $apiObject->postMethodApiConsumption($uri, $sendData);
            $result = json_decode($jsonResponseData, true);
                $_SESSION['status_code'] = $result['status_code'];
                $_SESSION['message'] = $result['message'];
            if($result['status_code'] == 200){
                return redirect()->to('/');
            }else{
                return redirect()->to('/new-password');
            }
    }
    
    public function displayConfirmPasswordPage(){
        session_start();
        $email = $_SESSION["email"];
        $password = $_SESSION["password"];
        $sendData = [
                'email'=>$email,
                'password'=>$password
            ]; 
        if(isset($_SESSION['status_code']) && isset($_SESSION['message'])){      
            return view('confirmpassword')->with('confirm_values', $sendData)->with("message", $_SESSION['message'])->with("status", $_SESSION['status_code']);
        } else{           
            return view('confirmpassword')->with('confirm_values', $sendData)->with('status', "");
        }
    }
    
    public function logout(){
        if(isset($_COOKIE['orchid_description'])){ 
            setcookie('orchid_description', '', 1);
            setcookie('orchid_unumber', '', 1);
            session_start();
            session_destroy();
        }
        return redirect()->to('/');
    }
    /*sravanthi*/
}
