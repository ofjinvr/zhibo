<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//账户安全中心

class Security extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('check_manager_logined');
        check_manager_logined();
        $this->load->model('manager_model');
        $this->load->config('config_access');
    }
    
    
    //修改密码
    public function pwd_modify($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post = $this->input->post(null,true);
            //格式验证
            $this->load->library('valid');
            $this->valid->set_rule_array(
                array(
                    'old_password,请输入原密码,required',
                    'new_password,请输入新密码,required',
                    'confirm,两次密码不一致,equal[new_password]'
                )
            );
            if($this->valid->run($post) === false){
                $error = $this->valid->get_error();
                skip_false($error[0]['msg']);
            }
            $id = $this->session->get_userdata('login_manager_id');
            $pwd = md5($post['new_password']);
            //验证原密码是否正确
            $managee_info = $this->manager_model->get_managers_baseinfo($id);
            if(md5($post['old_password'])!==$managee_info['merager_pwd']){
                skip_false('原密码错误,请重新输入');
            }
            if($this->manager_model->change_password($id,$pwd)!==false){
                skip_true('密码修改成功');
            }else{
                skip_false('密码修改失败,请稍后重试');
            }
            return;
        }
        $this->load->view('manage/change_password');
    }
    
    
    //登录日志
    public function log(){
        check_manager_rights(__METHOD__);
        //载入数据分页类
        $this->load->library('paging',15,$this->manager_model->log_count());
        $page_info = $this->paging->info();
        //根据分页信息查询数据
        $data['list'] = $this->manager_model->login_log_paging($page_info['cursor']);
        $data['page'] = $this->paging->html();
        $this->load->view('manage/login_log',$data);
    }
    
}

