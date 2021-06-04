<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//APP控制器 首页
class Teach extends Fetch{

    private $data;
    private $tb = 'trl_teach';

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('setting_model');
        $this->data['webinfo'] = $this->setting_model->seach(); //网站基础信息
        $this->data['nav'] = 'teach';
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
        $areaname = $this->input->get('areaname');
        $date = strtotime($this->input->get('date'));
        $date_end = $date + 3600*24;
        $cond=['true'];
        if(!empty($rolename)){$cond[] = "rolename='$rolename'";}
        if(!empty($typename)){$cond[] = "typename='$typename'";}
        if(!empty($cityname)){$cond[] = "cityname='$cityname'";}
        if(!empty($areaname)){$cond[] = "areaname='$areaname'";}
        if(!empty($date)){$cond[] = "teachtime>='$date' and teachtime<'$date_end'";}
        $cond = implode(' and ',$cond);
        $this->load->library('paging',20,$this->public_model->get_count($this->tb,$cond));
        $this->data['page'] = $this->paging->info();
        $this->data['list'] = $this->public_model->get($this->tb,'*',$cond,'abs(unix_timestamp(now())-`teachtime`) asc',$this->data['page']['cursor']);
        $this->data['arealist'] = $this->public_model->get('trl_area','*',"cityname='$cityname'");
//        print_r($this->data);
        $this->load->view('home/teach_list',$this->data);
    }



    public function detail($id = null){
        $id = abs(intval($id));
        if($id===0 or $this->public_model->get_count($this->tb,"id='$id'")==='0'){
            no_found();
        }
        $this->data['info'] = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->data['like'] = $this->public_model->get($this->tb,'*',"id<>'$id' and cityname='{$this->data['info']['cityname']}'");
//        print_r($this->data);
        $this->load->view('home/teach_detail',$this->data);
    }


}