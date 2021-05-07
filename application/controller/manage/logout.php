<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Logout extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
    }
    
    //退出登录
    public function index(){
        if($this->session->destroy()){
            skip_true('已经安全退出',site_url('manage'));
        }
        session_unset();
        header('Location:'.site_url('manage'));
    }
}