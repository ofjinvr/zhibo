<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//检测后台管理人员是否已经登录
function check_manager_logined(){
    $fetch = Fetch::get_instance();
    if($fetch->session->isset_userdata('login_manager_id')){
        $login_manager_id = $fetch->session->get_userdata('login_manager_id');
        if(is_numeric($login_manager_id) && $login_manager_id>0 && strpos($login_manager_id,'.')===false){
            return true;
        }
    }
    //没有登录则跳转
    header('Location:'.site_url('manage/login'));
    exit;
}


//检测后台管理人员是否已经登录
function check_manager_rights($permission){
    $fetch = Fetch::get_instance();
    $fetch->load->model('manager_model');
    $fetch->load->func('skip');
    $fetch->load->func('url');
    $mid = $fetch->session->get_userdata('login_manager_id');
    if(empty($mid)){
        //没有登录则跳转
        header('Location:'.site_url('manage/login'));
        exit;
    }
    
    //获得管理账户详细信息
    $manager_info = $fetch->manager_model->get_managers_info($mid);
    if($manager_info['rule']==='*'){
        return true;
    }
    
    //权限字符串
    $trace = debug_backtrace();
//    print_r($trace);
    $dirname = basename(dirname($trace[0]['file']));
    
    $allow_access = explode(',',$manager_info['rule']);
    if(!in_array($dirname.'/'.strtolower($permission),$allow_access)){
        skip_false('你没有访问此栏目权限');
    }
    
}