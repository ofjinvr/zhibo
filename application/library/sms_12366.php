<?php

class Sms_12366{
    
    private $app_code = 'xansrxt';
    private $api_url = 'http://117.34.72.35:80/sms/Sendu.do';
    
    public function __construct() {
    }
    
    
    public function sendSms($mobile,$content){
        $api_data = [
            'AppCode' => 'xansrxt',//$this->app_code,
            'MessageContent' => trim($content),
            'UserNumber' => $mobile,
            'SerialNumber' => '1',
            'Key' => '1'
        ];
        $curl = curl_init();
        $opts = array(
            CURLOPT_URL => $this->api_url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => http_build_query($api_data),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        );
        curl_setopt_array($curl, $opts);
        $trunsfer = parse_str(curl_exec($curl));
        if(isset($trunsfer['result']) and $trunsfer['result']==0){
            return true;
        }else{
            return false;
        }
    }
    
}