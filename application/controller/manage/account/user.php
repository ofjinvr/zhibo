<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class User extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('check_manager_logined');
        check_manager_logined();
        $this->load->model('manager_model');
        $this->load->config('config_access');
    }
    
    
    //查看管理员账户预览
    public function index(){
        check_manager_rights(__METHOD__);
        //载入数据分页类
        $this->load->library('paging',15,$this->manager_model->get_manages_count());
        $page_info = $this->paging->info();
        //根据分页信息查询数据
        $data['list'] = $this->manager_model->get_managers_limit($page_info['cursor']);
        $data['page'] = $this->paging->html();
        
        $this->load->view('manage/admin_list',$data);
    }
    
    
    //添加管理员账户
    public function add($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post = $this->input->post(null,true);
            $data = $post;
            $data['merager_name'] = trim($post['merager_name']);
            $data['status'] = 1;
            $this->load->library('valid');
            $this->valid->set_rule_array(
                array(
                    'rid,权限组类别参数不正确,required|natint',
                    'merager_name,用户名不为空,required',
                    'merager_name,用户名已存在,unique[trl_manage.merager_name]',
                    'merager_pwd,密码不能为空,required',
                    'remark,备注不能超过30个字符,max_length[30]'
                )
            );
            if($this->valid->run($data) === false){
                $error = $this->valid->get_error();
                skip_false($error[0]['msg']);
            }
            $data['merager_pwd'] = md5($post['merager_pwd']);
            if($this->manager_model->add_manager($data)===true){
                skip_true('增加成功', site_url('manage/account/user'));
            }else{
                skip_false('添加账户失败,请稍后重试');
            }
            return;
        }
        $data['rights'] = $this->manager_model->get_base_rights();
        if(empty($data['rights'])){
            skip_false('至少添加一个权限组',site_url('manage/account/user/add'));
        }
        $this->load->view('manage/admin_add',$data);
    }
    
    
    //编辑管理员账户
    public function edit($id=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_numeric($id) || $id<=0 && strpos($id,'.')!==false){
            skip_false('参数有误');
        }
        if($act=='action'){
            $data = $this->input->post(null,true);
            if(empty($data['merager_pwd'])){
                unset($data['merager_pwd']);
            }else{
                $data['merager_pwd'] = md5($data['merager_pwd']);
            }
            
            $this->load->library('valid');
            $this->valid->set_rule_array(
                array(
                    'rid,权限组类别参数不正确,required|natint',
                    'remark,备注不能超过30个字符,max_length[30]',
                    'status,账号状态有误,required|in[1-0]'
                )
            );
            if($this->valid->run($data) === false){
                $error = $this->valid->get_error();
                skip_false($error[0]['msg']);
            }
            if($this->manager_model->edit_manages($data,$id)===false){
                skip_false('修改失败,请稍后重试');
            }
            skip_true('修改成功',site_url('manage/account/user'));
            return;
        }
        $data['info'] = $this->manager_model->get_managers_baseinfo($id);
        $data['rights'] = $this->manager_model->get_base_rights();
        $this->load->view('manage/admin_edit',$data);
    }
    
    
    //删除管理员账户
    public function del($id=null){
        check_manager_rights(__METHOD__);
        if(!is_numeric($id) || $id<=0 && strpos($id,'.')!==false){
            skip_false('参数有误');
        }
        if($this->manager_model->del_manager($id)===0){
            skip_false('删除失败,请稍后重试!');
        }
        skip_true('删除成功',site_url('manage/account/user'));
    }
    
    
    //查看账户详情
    public function info($id=null){
        check_manager_rights(__METHOD__);
        if(!is_numeric($id) || $id<=0 && strpos($id,'.')!==false){
            skip_false('参数有误');
        }
        $data['info'] = $this->manager_model->get_managers_info($id);
        $this->load->view('manage/admin_info',$data);
    }
    
}

