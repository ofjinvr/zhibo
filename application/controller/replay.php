<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//APP控制器 首页
class Replay extends Fetch{

    private $data;
    private $tb = 'trl_zhibo';
    private $pl = 'trl_zhibo_pinglun';

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('setting_model');
        $this->data['webinfo'] = $this->setting_model->seach(); //网站基础信息
        $this->data['nav'] = 'replay';
    }

    public function index(){
        $this->load->library('paging',10,$this->public_model->get_count($this->tb));
        $this->data['page'] = $this->paging->info();
        $now = time();
        $this->data['list'] = $this->public_model->get($this->tb,'*',"livetime+duration*60 < $now",'id desc',$this->data['page']['cursor']);
        $this->load->view('home/huifang_list',$this->data);
    }


    public function play($id = null){
        $id = abs(intval($id));
        if($id===0 or $this->public_model->get_count($this->tb,"id='$id'")==='0'){
            no_found();
        }
        $this->data['info'] = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->load->view('home/huifang_play',$this->data);
    }



}