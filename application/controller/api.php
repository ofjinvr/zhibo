<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Api extends Fetch{
    
    private $member_phone = '18710953366';
    
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('string');
        $this->load->func('varcheck');
        $this->load->model('public_model');
        header('Access-Control-Allow-Origin:*');
        header("Access-Control-Allow-Credentials: true");
    }


    public function pinglun(){
        if(empty($_SESSION['member']['id'])){
            exit(json_encode(['error'=>'4','info'=>'您需要先登录才能留言']));
        }
        $zid = (int)$this->input->post('zid');
        $score = (int)$this->input->post('score');
        $content = trim($this->input->post('content'));
        if($content===''){
            echo json_encode(['err'=>'1','msg'=>'请填写评论内容']);
            exit;
        }
        $ins = [
            'ip' => $this->getIp(),
            'zid' => $zid,
            'mid' => $_SESSION['member']['id'],
            'score' => $score,
            'content' => $content,
            'pubtime' => time()
        ];
        if(!$this->public_model->add('trl_zhibo_pinglun',$ins)){
            echo json_encode(['err'=>'1','msg'=>'系统繁忙']);
        }else{
            echo json_encode(['err'=>'0','msg'=>'评论成功']);
        }
    }


    private function getIP() {
        if (getenv('HTTP_CLIENT_IP')) {
            $ip = getenv('HTTP_CLIENT_IP');
        }
        elseif (getenv('HTTP_X_FORWARDED_FOR')) {
            $ip = getenv('HTTP_X_FORWARDED_FOR');
        }
        elseif (getenv('HTTP_X_FORWARDED')) {
            $ip = getenv('HTTP_X_FORWARDED');
        }
        elseif (getenv('HTTP_FORWARDED_FOR')) {
            $ip = getenv('HTTP_FORWARDED_FOR');

        }
        elseif (getenv('HTTP_FORWARDED')) {
            $ip = getenv('HTTP_FORWARDED');
        }
        else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }

    //获取聊天室聊天记录
    public function getChatMsg(){
        exit;
        $lid = intval($this->input->post('lid'));
        if(empty($lid) or !$this->public_model->get_count('trl_zhibo',"id='$lid'")){
            exit(json_encode(['error'=>'1','info'=>'直播ID不存在']));
        }
        $last_get_time = !empty($_SESSION['last_get_time'][$lid]) ? intval($_SESSION['last_get_time'][$lid]) : time();
        $session_id = session_id();
        $list = $this->public_model->get('trl_chat','*',"lid='$lid' and pubtime>'$last_get_time'",'pubtime asc,id asc');
        if(!empty($list)){
            array_walk($list,function(&$row){
                $ip_arr = explode('.',$row['ip']);
                $ip_arr[2] = $ip_arr[3] = '*';
                $row['ip'] = implode('.',$ip_arr);
            });
            $_SESSION['last_get_time'][$lid] = time();
        }
        exit(json_encode($list));
    }


    //写入聊天室记录
    public function putChatMsg(){
        if(empty($_SESSION['member']['id'])){
            exit(json_encode(['error'=>'4','info'=>'您需要先登录才能留言']));
        }
        $lid = intval($this->input->post('lid'));
        if(empty($lid) or !$this->public_model->get_count('trl_zhibo',"id='$lid'")){
            exit(json_encode(['error'=>'1','info'=>'直播ID不存在']));
        }
        $msg = strip_tags($this->input->post('msg'));
        if(empty($msg)){
            exit(json_encode(['error'=>'2','info'=>'请输入内容']));
        }
        $ins = [
            'session_id' => session_id(),
            'ip' => $this->getIP(),
            'ident' => $_SESSION['member']['id'],
            'pubtime' => time(),
            'message' => $msg,
            'lid' => $lid
        ];

        if($this->public_model->add('trl_chat',$ins)===false){
            exit(json_encode(['error'=>'3','info'=>'系统繁忙，请稍后重试']));
        }
        exit(json_encode(['error'=>'0','info'=>'发送成功']));
    }


    public function getCityArea(){
        $cityname = $this->input->get('cityname');
        $list = $this->public_model->get('trl_area','*',"cityname='$cityname'");
        exit(json_encode($list));
    }


    public function baoming(){
        if(empty($_SESSION['member']['id'])){
            exit('您需要先登录才能报名');
        }
        $post = array_map('trim',$this->input->post());
        $post['mobile'] = $_SESSION['member']['mobile'];
        if(empty($post['tid'])){
            exit('参数有误');
        }
        if(empty($post['member_name'])){
            exit('请填写姓名');
        }
        if(empty($post['mobile']) or strlen($post['mobile'])!==11 or !is_natural($post['mobile'])){
            exit('手机号码有误');
        }
        if(empty($post['company_nature'])){
            exit('请选择单位性质');
        }
        $this->public_model->add('trl_teach_signup',$post);
        exit('报名成功');
    }

    //登录接口
    public function login(){
        $moblie = trim($this->input->post('mobile'));
        $pwd = $this->input->post('pwd');
        if(!is_mobile($moblie)){
            exit(json_encode(['err'=>'1','msg'=>'手机号码有误']));
        }
        if(empty($pwd)){
            exit(json_encode(['err'=>'1','msg'=>'请输入密码']));
        }
        $pwd = md5($pwd);
        if($this->public_model->get_count('trl_member',"mobile='$moblie' and pwd='$pwd'")<=0){
            exit(json_encode(['err'=>'1','msg'=>'用户名或密码有误']));
        }
        $_SESSION['member'] = $member = $this->public_model->one('trl_member','id,mobile,nickname',"mobile='$moblie' and pwd='$pwd' and disable='0'");
        exit(json_encode(['err'=>'0','msg'=>'登录成功','member'=>$member]));
    }


    public function reg(){
        $mobile = trim($this->input->post('mobile'));
        $pwd = $this->input->post('pwd');
        $pwd2 =  $this->input->post('pwd2');
        $sms_code = $this->input->post('sms_code');
        $nickname = $this->input->post('nickname');
        if(!is_mobile($mobile)){
            exit(json_encode(['err'=>'1','msg'=>'手机号码有误']));
        }
        if($pwd!==$pwd2){
            exit(json_encode(['err'=>'1','msg'=>'两次密码不一致']));
        }
        if(empty($_SESSION['sms_code']) or $_SESSION['sms_code']!==$sms_code){
            exit(json_encode(['err'=>'1','msg'=>'手机验证码有误']));
        }
        if($this->public_model->get_count('trl_memebr',"mobile='$mobile'")>0){
            exit(json_encode(['err'=>'1','msg'=>'用户已经存在']));
        }
        if(($new_id = $this->public_model->add('trl_member',['mobile'=>$mobile ,'pwd'=>md5($pwd),'nickname'=>$nickname]))===false){
            exit(json_encode(['err'=>'1','msg'=>'系统繁忙']));
        }
        $_SESSION['member'] = [
            'id' => $new_id,
            'mobile' => $mobile,
            'nickname' => $nickname
        ];
        exit(json_encode(['err'=>'0','msg'=>'注册成功']));
    }


    public function sms(){
        $moblie = trim($this->input->post('mobile'));
        if(!is_mobile($moblie)){
            exit(json_encode(['err'=>'1','msg'=>'手机号码有误']));
        }
        if(!empty($_SESSION['last_sms_time']) and time()-$_SESSION['last_sms_time']<60){
            exit(json_encode(['err'=>'1','msg'=>'请等待60秒']));
        }
        $sms_code = (string)mt_rand(100000,999999);
        $_SESSION['sms_code'] =$sms_code;
        $this->load->library('sms');
        $this->sms->mt($moblie,"您的验证码为：$sms_code");
        $_SESSION['last_sms_time'] = time();
        exit(json_encode(array(['err'=>'0','msg'=>'发送成功'])));
    }




}