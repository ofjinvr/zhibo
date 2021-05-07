<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//管理中心首页

class Index extends Fetch{
    
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('check_manager_logined');
        check_manager_logined();
        $this->load->model('manager_model');
    }
    
    
    public function index(){
        check_manager_rights(__METHOD__);
        $manager_id = $this->session->get_userdata('login_manager_id');
        $data['log'] = $this->manager_model->login_log_paging($manager_id,'3');
        
        //权限获取
        $this->load->config('config_access');
        
        $rights = $this->config_access->get_access();
        $data['manager_data'] = $this->manager_model->get_managers_info($this->session->get_userdata('login_manager_id'));
        
        $rule_array = explode(',',$data['manager_data']['rule']);
        foreach ($rule_array as $key => $rule){
            if($rule==='*'){
                $rule_array[$key] = '超级权限';
                break;
            }
            $rule_array[$key] = $rights[$rule];
        }
        $data['manager_data']['rule'] = implode(' | ', $rule_array);
        $this->load->view('manage/home_index',$data);
    }
    
}