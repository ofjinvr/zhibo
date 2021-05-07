<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Api extends Fetch{
    
    private $member_phone = '18710953366';
    
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('string');
        $this->load->func('varcheck');
        $this->load->model('public_model');
    }


    public function pinglun(){
        $zid = (int)$this->input->post('zid');
        $score = (int)$this->input->post('score');
        $content = trim($this->input->post('content'));
        $ins = [
            'ip' => $this->getIp(),
            'zid' => $zid,
            'score' => $score,
            'content' => $content,
            'pubtime' => time()
        ];
        if(!$this->public_model->add('trl_zhibo_pinglun',$ins)){
            echo json_decode(['err'=>'1','msg'=>'系统繁忙']);
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


}