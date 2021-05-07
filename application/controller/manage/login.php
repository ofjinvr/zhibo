<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Login extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
    }
    
    public function index($act=null){
        if($act==='action'){
            $post = $this->input->post(null,true);
            $this->load->library('valid');
            $this->valid->set_rule_array(
                array(
                    'merager_name,用户名不为空,required',
                    'merager_pwd,密码不能为空,required',
                    'vcode,验证码不能为空,required'
                )
            );
            
            if($this->valid->run($post) === false){
                $error = $this->valid->get_error();
                skip_false($error[0]['msg']);
            }
            
            $merager_name = trim($post['merager_name']);
            $merager_pwd = md5($post['merager_pwd']);
            $vcode = trim($post['vcode']);
            $remember = !empty($post['remember']) ? 1 : 0;
            //验证码验证
            $auth = $this->session->get('vcode');
            if(strtolower($auth)!==strtolower($vcode)){
                $_SESSION['vcode'] = '';
                skip_false('验证码错误!',site_url('manage/login'));
            }
            $this->load->model('manager_model');
            if(($merager_id=$this->manager_model->login_check($merager_name,$merager_pwd))===false){
                //通过用户名查询id
                $nologin_id = $this->manager_model->get_manages_id($merager_name);
                if(is_numeric($nologin_id)){
                    //记录错误登录日志
                    $log = array(
                        'mid'=>$nologin_id,
                        'ip'=>$_SERVER['REMOTE_ADDR'],
                        'login_time' => time(),
                        'status' => '0',
                        'error_pwd' => $post['merager_pwd']
                    );
                    $this->manager_model->add_login_log($log);
                }
                skip_false('用户名或密码错误,请注意大小写!');
            }
            
            if($this->session->set_userdata('login_manager_id',$merager_id)===true){
                //如果选择记住用户名,记录COOKIE
                if($remember===1){
                    $this->cookie->set('login_manager_name',$merager_name,3600*24*3);
                }
                //记录错误登录日志
                $log = array(
                    'mid'=>$merager_id,
                    'ip'=>$_SERVER['REMOTE_ADDR'],
                    'login_time' => time(),
                    'status' => '1'
                );
                $this->manager_model->add_login_log($log);
                skip_true('登陆成功,将跳转到管理中心首页',  site_url('manage'));
            }
            return;
        }
        //如果已经登陆
        if($this->session->get_userdata('login_manager_id')){
            skip_true('您已经登陆,将跳转到管理中心首页',site_url('manage'));
        }
        $data['login_manager_name'] = $this->cookie->get('login_manager_name');
        $this->load->view('manage/login',$data);
    }
}
