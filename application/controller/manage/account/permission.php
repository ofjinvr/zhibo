<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Permission extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('check_manager_logined');
        check_manager_logined();
        $this->load->model('manager_model');
        $this->load->config('config_access');
        $this->rights = $this->config_access->get_access();
    }
    
    
    //权限组预览
    public function index(){
        check_manager_rights(__METHOD__);
        //载入数据分页类
        $this->load->library('paging',15,$this->manager_model->get_rights_count());
        $page_info = $this->paging->info();
        //根据分页信息查询数据
        $data['list'] = $this->manager_model->get_rights_limit($page_info['limit']);
        $data['page'] = $this->paging->html();
        $this->load->view('manage/rights_list',$data);
        
    }
    
    
    //添加权限组
    public function add($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post = $this->input->post(null,true);
            $this->load->library('valid');
            $this->valid->set_rule('acc_name,权限名称不能为空,required');
            $this->valid->set_rule('rule,请选择权限规则,required');
            if($this->valid->run($post) === false){
                $error = $this->valid->get_error();
                skip_false($error[0]['msg']);
            }
            $data['acc_name'] = trim($post['acc_name']);
            $data['rule'] = implode(',',$post['rule']);
            if($this->manager_model->add_rights($data) === true){
                skip_true('成功添加一个权限组', site_url('manage/account/permission'));
            }else{
                skip_false('添加权限组失败,请稍后重试');
            }
            return;
        }
        $data['rights'] = $this->rights;
        $this->load->view('manage/rights_add',$data);
        
    }
    
    
    //查看权限组详情
    public function info($id=null){
        check_manager_rights(__METHOD__);
        if(!is_numeric($id) || $id<=0 && strpos($id,'.')!==false){
            skip_false('参数有误');
        }
        $data['row'] = $this->manager_model->get_rights_one($id);
        $this->load->view('manage/rights_info',$data);
    }
    
    
    //修改权限组
    public function edit($id=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_numeric($id) || $id<=0 && strpos($id,'.')!==false){
            skip_false('参数有误');
        }
        //如果提交的话
        if($act==='action'){
            $post = $this->input->post(null,true);
            $this->load->library('valid');
            $this->valid->set_rule('acc_name,权限名称不能为空,required');
            $this->valid->set_rule('rule,请选择权限规则,required');
            if($this->valid->run($post) === false){
                $error = $this->valid->get_error();
                skip_false($error[0]['msg']);
            }
            $data['acc_name'] = $post['acc_name'];
            $data['rule'] = implode(',',$post['rule']);
            if($this->manager_model->edit_rights($data,$id)===false){
                skip_false('修改失败,请稍后重试');
            }
            skip_true('修改成功',site_url('manage/account/permission'));
            return;
        }
        $data['rights'] = $this->rights;
        $data['info'] = $this->manager_model->get_rights_one($id);
        $data['info']['rule'] = explode(',',$data['info']['rule']);
        if(in_array('*',$data['info']['rule'])){
            $data['info']['rule'] = array('*');
        }
        $this->load->view('manage/rights_edit',$data);
        
    }
    
    
    //删除权限组
    public function del($id=null){
        check_manager_rights(__METHOD__);
        if(!is_numeric($id) || $id<=0 && strpos($id,'.')!==false){
            skip_false('参数有误');
        }
        //验证是否能够安全的删除该条规则(无管理员使用该规则)
        if(($result=$this->manager_model->rule_merages_count($id))>0){
            skip_false("有{$result}个账户为该权限组成员,无法删除!");
        }
        if($this->manager_model->del_rights($id)===0){
            skip_false('删除失败,请稍后重试!');
        }
        skip_true('删除成功',site_url('manage/account/permission'));
    }
    
}

