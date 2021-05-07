<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Auth extends Fetch{
    public function __construct() {
        parent::__construct();
    }
    
    //验证码页
    public function index($width=null,$height=null){
        //加载验证码类
        if(!is_numeric($width) or !is_numeric($height)){
            no_found();
        }
        $this->load->library('vcode');
        $this->vcode->vcode($width,$height);
    }
}