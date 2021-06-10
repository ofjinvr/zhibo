<?php
/**
 * Created by PhpStorm.
 * User: 49143
 * Date: 2017/12/14
 * Time: 17:47
 */



class BaiduTxt{


    private $ak = 'Vgok1syUeMBO1UVDbXbkD2GR';
    private $sk = 'ghOMhSVLMcNcthTyhUxLBO6SSk7GwAhL';
    private $token_cache_path = './plugin/baidutxt/token';
    private $access_token;
    private $session_key;
    private $scope;
    private $refresh_token;
    private $session_secret;
    private $expires_in;

    public function __construct()
    {
        $token = unserialize(file_get_contents($this->token_cache_path));
        if(empty($token) or !is_object($token) or $token->put_time+$token->expires_in<=time()){
            $url = 'https://aip.baidubce.com/oauth/2.0/token';
            $post_data['grant_type'] = 'client_credentials';
            $post_data['client_id'] = $this->ak;
            $post_data['client_secret'] = $this->sk;
            $token = json_decode($this->request_post($url, http_build_query($post_data)));
            $token->put_time = time();
            file_put_contents($this->token_cache_path,serialize($token));
        }
        $this->access_token = $token->access_token;
        $this->session_key = $token->session_key;
        $this->scope = $token->scope;
        $this->refresh_token = $token->refresh_token;
        $this->session_secret = $token->session_secret;
        $this->expires_in = $token->expires_in;
    }


    public function check($text){
        $api = 'https://aip.baidubce.com/rest/2.0/antispam/v1/spam?access_token='.$this->access_token;
        $data = [
            'command_no' => '500071',
            'content' => substr($text,0,20000)
        ];
        $res = json_decode($this->request_post($api,http_build_query($data)),true);
        if($res['errno']===0 and $res['result']['spam']>0){
            return false;
        }
        return true;
    }



    private function request_post($url = '',$param='') {
        if (empty($url) || empty($param)) {
            return false;
        }
        $postUrl = $url;
        $curlPost = $param;
        $curl = curl_init();//初始化curl
        curl_setopt($curl, CURLOPT_URL,$postUrl);//抓取指定网页
        curl_setopt($curl, CURLOPT_HEADER, 0);//设置header
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($curl, CURLOPT_POST, 1);//post提交方式
        curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
        $data = curl_exec($curl);//运行curl
        curl_close($curl);
        return $data;
    }

}