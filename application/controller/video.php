<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//APP控制器 首页
class Video extends Fetch{

    private $data;
    private $tb = 'trl_video';

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('setting_model');
        $this->data['webinfo'] = $this->setting_model->seach(); //网站基础信息
        $this->data['nav'] = 'video';
        $this->load->func('filter');
        my_filter_get();
        
        $this->public_model->add('pview',['pvtime'=>time()]);
        $this->data['webinfo']['pv_today'] = $this->public_model->get_count('pview','pvtime>='.strtotime(date('Y-m-d 0:0:0')));
        $this->data['webinfo']['pv_all'] = $this->public_model->get_count('pview');
    }

    public function index(){
        $rolename = $this->input->get('rolename');
        $typename = $this->input->get('typename');
        $cityname = $this->input->get('cityname');
        $cond=['true'];
        if(!empty($rolename)){$cond[] = "rolename='$rolename'";}
        if(!empty($typename)){$cond[] = "typename='$typename'";}
        if(!empty($cityname)){$cond[] = "cityname='$cityname'";}
        $cond = implode(' and ',$cond);
        $this->load->library('paging',7,$this->public_model->get_count($this->tb,$cond));
        $this->data['page'] = $this->paging->info();
        $this->data['list'] = $this->public_model->get($this->tb,'*',$cond,'id desc',$this->data['page']['cursor']);
        $this->load->view('home/shipin_list',$this->data);
    }


    public function play($id =null){
        $id = abs(intval($id));
        if($id===0 or $this->public_model->get_count($this->tb,"id='$id'")==='0'){
            no_found();
        }
        $this->data['info'] = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->public_model->math($this->tb,'pageview','1',"id='$id'");
        $this->load->view('home/shipin_play',$this->data);
    }


}