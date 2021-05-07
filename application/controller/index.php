<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//APP控制器 首页
class Index extends Fetch{

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('setting_model');
        $this->data['webinfo'] = $this->setting_model->seach(); //网站基础信息
        $this->data['nav'] = 'index';
    }

    public function index(){
        $this->data['live_list_ready'] = $this->public_model->get('trl_zhibo','*',"livetime>=".time(),'id desc','0,3');
        $this->data['live_list_replay'] = $this->public_model->get('trl_zhibo','*',"livetime+duration*60 < ".time(),'id desc','0,3');
        $this->data['video'] = $this->public_model->get('trl_video','*',null,'id desc','0,3');
        $this->data['article_list'] = $this->public_model->get('trl_article','*',null,'id desc','0,3');
//        print_r($this->data);
        $this->load->view('home/index',$this->data);
    }
    

}