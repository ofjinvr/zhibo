<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');
// +------------------------------------------------
// | Travel - 1.1 2014.11.25                           
// +------------------------------------------------
// | Copyright (c) 2014 All rights reserved.        
// +------------------------------------------------
// | Author: XiaoZhi <travelphp@163.com>
// +------------------------------------------------

// +-----------------------
// | HTTP请求类
// +-----------------------
class Request{

    protected $curl;
    //当前执行的临时URL和数据
    protected $tempurl;
    protected $tempdata;
    //请求参数列表
    protected $user_opts;
            
    
    public function __construct() {
        if(function_exists('curl_init')){
            $this->curl = curl_init();    
        }else{
            trigger_error('环境不支持CURL',E_USER_WARNING);
        }
    }
    
    
    /**
     * 发送请求
     * @param string $method 请求方式
     * @param string $url 请求地址
     * @param mix $data 发送的数据,使用POST方式时,可以前加'@+文件路径'上传文件
     * @return 响应的数据,如果失败返回false
     */
    public function send($method,$url,$data=null){
        if(empty($url) || !is_string($url)){
            trigger_error('错误的请求地址',E_USER_WARNING);
            return false;
        }
        $this->tempurl = $url;
        if(!is_null($data) && is_array($data)){
            $this->tempdata = http_build_query($data);
        }
        if(!is_null($data) && is_string($data)){
            $this->tempdata = $data;
        }
        switch (strtolower($method)){
            case 'get':
                $result = $this->get();
                break;
            case 'post':
                $result = $this->post();
                break;
            default:
                trigger_error('未知的请求类型',E_USER_WARNING);
                return false;
                break;
        }
        return $result;
    }
    
    
    /**
     * 设置CURLOPT参数
     * @param array $opts CURLOPT参数
     * @return boolean 
     */
    public function set_user_opts($opts){
        if(is_array($opts)){
            $this->user_opts = $opts;
            return true;
        }
        return false;
    }
    
    
    /**
     * 检查URL是否有效
     * @param string $url 要检查的URL地址
     * @return bool 是否有效
     */
    public function checkurl($url){
        //设置请求基本参数
        $opts = array(
            CURLOPT_URL => $url,
            CURLOPT_NOBODY => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_CONNECTTIMEOUT => 3
        );
        curl_setopt_array($this->curl,$opts);
        $result = curl_exec($this->curl);
        //如果请求结果有响应,再检查是否为状态200成功响应
        if($result!==false){
            $status_code = curl_getinfo($this->curl,CURLINFO_HTTP_CODE);
            if($status_code===200){
                return true;
            }
        }
        return false;
    }
    
    
    /**
     * 发送GET请求
     * @param $user_opts 用户扩展的CURL参数数组
     */
    protected function get(){
        //设置发送GET请求基本参数
        $opts = array(
            CURLOPT_URL => $this->tempurl.'?'.$this->tempdata,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        );
        //合并用户扩展参数
        if(is_array($this->user_opts) && !empty($this->user_opts)){
            $opts = $opts+$this->user_opts;
        }
        curl_setopt_array($this->curl,$opts);
        return curl_exec($this->curl);
    }
    
    
    /**
     * 发送POST请求
     */
    protected function post(){
        //设置发送POST请求的
        $opts = array(
            CURLOPT_URL => $this->tempurl,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $this->tempdata,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_SSL_VERIFYPEER => false
        );
        //合并用户扩展参数
        if(is_array($this->user_opts) && !empty($this->user_opts)){
            $opts = $opts+$this->user_opts;
        }
        curl_setopt_array($this->curl,$opts);
        return curl_exec($this->curl);
    }

}