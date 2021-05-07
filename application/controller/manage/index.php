<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Index extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
    }
    
    public function index(){
        //检查是否登录
        $this->load->func('check_manager_logined');
        check_manager_logined();
        //载入菜单
        $this->load->config('config_menu');
        $data['menu'] = $this->config_menu->get();
        //获取登录用户名
        $this->load->model('manager_model');
        $manager['info'] = $this->manager_model->get_managers_baseinfo($this->session->get_userdata('login_manager_id'));
        $this->load->view('manage/header',$manager);
        $this->load->view('manage/left',$data);
        $this->load->view('manage/index');
    }
}