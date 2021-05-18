<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Member extends Fetch{

    protected $tb = 'trl_member';

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('varcheck');
        $this->load->func('string');
        $this->load->model('public_model');
        //检查是否登录
        $this->load->func('check_manager_logined');
        check_manager_logined();
    }

    public function index(){
        $this->load->library('paging',15,$this->public_model->get_count($this->tb));
        $data['page'] = $this->paging->info();
        $data['list'] = $this->public_model->get($this->tb,'*',null,'id desc',$data['page']['cursor']);
        $this->load->view('manage/member_list',$data);
    }


    public function disable($id=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('用户不存在或已删除');
        }
        if($this->public_model->edit($this->tb,['disable'=>'1'],"id='$id'")===false){
            skip_false('系统繁忙，请稍后重试');
        }
        skip_true('已停用');
    }


    public function enable($id=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('用户不存在或已删除');
        }
        if($this->public_model->edit($this->tb,['disable'=>'0'],"id='$id'")===false){
            skip_false('系统繁忙，请稍后重试');
        }
        skip_true('已启用');
    }
}