<?php

class City_ip{
    
    public $ip;
    private $api;
    
    public function __construct() {
        $this->ip = get_true_ip();
        $this->api = "http://whois.pconline.com.cn/ip.jsp?ip=$this->ip";
    }
    
    
    
}