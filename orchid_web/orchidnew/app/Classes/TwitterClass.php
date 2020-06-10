<?php
 

namespace App\Classes;
 

use App\Twitter\SettingHelper;
use App\Twitter\TwitterAPIExchange;
/**
* Description of TwitterClass
*
* @author Ravasaheb
*/
class TwitterClass {
    public function getFollowingList($screen_name){
        $settingTwitter = new SettingHelper();
        $settings = $settingTwitter->settings();
        $cursor = -1;
        $requestMethod = 'GET';
        $url = "https://api.twitter.com/1.1/friends/list.json";
        $i = 0;
        $users = array();
        do{
            try{
                $getfield = '?cursor='.$cursor.'&screen_name='.$screen_name.'&count=200&skip_status=true&include_user_entities=false';
                $twitter = new TwitterAPIExchange($settings);
                $result = $twitter->setGetfield($getfield)
                                    ->buildOauth($url, $requestMethod)
                                    ->performRequest();
                $data = json_decode($result, true);
                $user = $data['users'];
            }catch(\ErrorException $e){
                $cursor = 0;
            }
            for ($j =0; $j<count($user);$j++){
                $id = $user[$j]['id'];
                $name = $user[$j]['name'];
                $screen_name = $user[$j]['screen_name'];
                $email = "";
                $profile_image_url = $user[$j]['profile_image_url'];
                $userdata = array("id"=>$id, "name"=>$name, "screen_name"=>$screen_name, 'provider'=>'TWITTER', 'email'=>$email, "profile_image_url"=>$profile_image_url);
                $users[$i] = $userdata;
                $i = $i+1;
            }
            $cursor = $data['next_cursor'];
        }while($cursor != 0);
        //$userList = array("users"=>$users);
        //print_r($users); exit();
        //$response = json_encode($userList);
        return $users;
    }
   
    public function getFollowersList($screen_name){
        $settingTwitter = new SettingHelper();
        $settings = $settingTwitter->settings();
        $cursor = -1;
        $requestMethod = 'GET';
        $url = "https://api.twitter.com/1.1/followers/list.json";
        $i = 0;
        $users = array();
        do{
            $getfield = '?cursor='.$cursor.'&screen_name='.$screen_name.'&count=200&skip_status=true&include_user_entities=false';
            $twitter = new TwitterAPIExchange($settings);
            $result = $twitter->setGetfield($getfield)
                                ->buildOauth($url, $requestMethod)
                                ->performRequest();
            $data = json_decode($result, true);
            try{
                $user = $data['users'];
                for ($j =0; $j<count($user);$j++){
                    $id = $user[$j]['id'];
                    $name = $user[$j]['name'];
                    $screen_name = $user[$j]['screen_name'];
                    $email = "";
                    $profile_image_url = $user[$j]['profile_image_url'];
                    $userdata = array("id"=>$id, "name"=>$name, "screen_name"=>$screen_name, 'provider'=>'TWITTER', 'email'=>$email, "profile_image_url"=>$profile_image_url);
                    $users[$i] = $userdata;
                    $i = $i+1;
                }
                $cursor = $data['next_cursor'];
            }catch(\ErrorException $e){
                $cursor = 0;
            }
        }while($cursor != 0);
        //$userList = array("users"=>array());
        //print_r($users); exit();
        //$response = json_encode($userList);
        return $users;
    }
    
    public function getTwitterFriends($screen_name){
        $response = array();
        $followingList = $this->getFollowingList($screen_name);
        $followersList = $this->getFollowersList($screen_name);
        for($i=0; $i<count($followersList); $i++){
            $response[$i] = $followersList[$i];            
        }
        $j = count($response);
        for($i=0; $i<count($followingList); $i++){
            if(in_array($followingList[$i], $response)){
            }else{
                $response[$j+$i] = $followingList[$i];
            }
        }
        $result = json_encode(array("users"=>$response));
        return $result;
    }
}