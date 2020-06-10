<?php
namespace App\Slack;
use Illuminate\Http\Request;

class SlackOauth{
  
  public function getSlackUserInfo(Request $request){
      $config = config('services.slack');
      
      $ch = curl_init("https://slack.com/api/oauth.access?client_id=".$config['client_id']."&client_secret=".$config['client_secret']."&code=".$request['code']);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_HEADER, 0);
      $jsonData = curl_exec($ch);
      curl_close($ch);
      
      return $jsonData;
  }
}