<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Base extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('check_manager_logined');
        check_manager_logined();
        $this->load->model('setting_model');
    }
    
    
    //查看设置
    public function index($act=null){
        check_manager_rights(__METHOD__);
        //提交
        if($act==='action'){
            $data = $this->input->post(null,true);
            
            if($this->setting_model->edit($data) !== false){
                skip_true('已保存成功');
            }else{
                skip_false('保存失败,请稍后重试');
            }
            return;
        }
        
        //查询是否存在第一条信息 如果不存在则新建一条,如果存在则读取第一条信息
        if($this->setting_model->get_count()==='0'){
            $data = array(
                'title' => null,
                'keyword' => null,
                'description' => null,
                'tel' => null,
                'tel400' => null,
                'mobile' => null,
                'email' => null,
                'qq' => null,
                'address' => null
            );
            $this->setting_model->add($data);
        }else{
            $data = $this->setting_model->seach();
        }
        $this->load->view('manage/setting_index',$data);
    }
}