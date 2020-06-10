<?php
 

/*
* To change this license header, choose License Headers in Project Properties.
* To change this template file, choose Tools | Templates
* and open the template in the editor.
*/
 

namespace App\Classes;
 

/**
* Description of SlackClass
*
* @author Ravasaheb
*/
class SlackClass {
   
    public function getSlackFriendList($access_token){
       
            $i = 0;
            $k = 0;
            $cursor = "";
            $url = "";
            $uri = "https://slack.com/api/users.list?limit=200";
            $users = array();
            do{
                if($k==0){
                    $url = $uri."&token=".$access_token;
                }elseif ($k > 0) {
                    $url = $uri."&cursor=".$cursor."&token=".$access_token;
                }
                //$postdata = json_encode($data);
                //return $postdata;
                $ch=curl_init($url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/x-www-form-urlencoded'));
                curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
                $result = curl_exec($ch);
                curl_close($ch);
                $data = json_decode($result, true);
            //print_r($result); exit();
                if($data['ok'] == true){
                    $user = $data['members'];
                    for($j=0; $j< count($user); $j++){
                        if($k == 0){
                            $k++;
                        }else{
                            $id = $user[$j]['id'];
                            $name = $user[$j]['real_name'];
                            $screen_name = "";
                            $profile_image_url = $user[$j]['profile']['image_48'];
                            $email = $user[$j]['profile']['email'];
                            $userdata = array("id"=>$id, "name"=>$name, "screen_name"=>$screen_name, 'email'=>$email, "provider"=>"SLACK", "profile_image_url"=>$profile_image_url);
                            $users[$i] = $userdata;
                            $i = $i+1;
                        }
                    }
                    $cursor = $data['response_metadata']['next_cursor'];
                }
            }while($cursor != "");
            $userList = array("users"=>$users);
            //print_r($users); exit();
            $response = json_encode($userList);
            return $response;
    }
}