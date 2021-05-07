<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//常用功能

class Common extends Fetch{
    
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('check_manager_logined');
        check_manager_logined();
    }
    
    
    //网站状态
    public function status(){
        check_manager_rights(__METHOD__);
        $data['server'] = $_SERVER;
        $this->load->view('manage/home_status',$data);
    }
    
}