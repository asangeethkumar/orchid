<?php
namespace App\Classes;

use Response;
/**
* Description of ApiConsumptionClass
*
* @author CEPL
*/
class ApiConsumptionClass {
   
   public function getMethodApiConsumption($url, $data){
       
   }
   
   public function postMethodApiConsumption($uri, $data){
       $configValue = config('services.api_base_url');
       $url = $configValue['api_url'].$uri;
       $postdata = json_encode($data);
       $ch=curl_init($url);
       curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
       curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
       curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
       $result = curl_exec($ch);
       curl_close($ch);
       return $result;
   }
   public function postMethodApiConsumptionWithToken($uri, $data){
        $configValue = config('services.api_base_url');
        $url = $configValue['api_url'].$uri;
        $postdata = json_encode($data);
        $authorization = "";
        if(isset($_COOKIE['orchid_description'])){
            $access_token = $_COOKIE['orchid_description'];
            $authorization = "Authorization: Bearer ".$access_token;
        }
        $ch=curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json', $authorization));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
        $result = curl_exec($ch);
        curl_close($ch);
        return $result;
    }
}