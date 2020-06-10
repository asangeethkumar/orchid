<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Twitter;

/**
 * Description of SettingHelper
 *
 * @author CEPL
 */
class SettingHelper {
   public function settings()
    {
        $config = config('services.twitter');
        $settings = [            
            'consumer_key' => $config['client_id'],
            'consumer_secret' => $config['client_secret'],
            'oauth_access_token' => $config['access_token'],
            'oauth_access_token_secret' => $config['access_secret'],
        ];
        return $settings;
    }
}
