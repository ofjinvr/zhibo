<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//APP控制器 首页
class Teacher extends Fetch{

    private $data;
    private $tb = 'trl_teachers';

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('setting_model');
        $this->data['webinfo'] = $this->setting_model->seach(); //网站基础信息
        $this->data['nav'] = 'teacher';
        $this->load->func('filter');
        my_filter_get();
        $this->data['company_list'] = [
            '陕西国税12366纳税服务中心','陕西东信税务师事务所','陕西国税货物和劳务税处','咸阳市长武县国家税务局'
        ];
        
        $this->public_model->add('pview',['pvtime'=>time()]);
        $this->data['webinfo']['pv_today'] = $this->public_model->get_count('pview','pvtime>='.strtotime(date('Y-m-d 0:0:0')));
        $this->data['webinfo']['pv_all'] = $this->public_model->get_count('pview');
    }

    public function index(){
        $company = $this->input->get('company');
        if(!empty($company)){
            $cond = "company='$company'";
        }else{
            $cond = null;
        }
        $this->load->library('paging',7,$this->public_model->get_count($this->tb,$cond));
        $this->data['page'] = $this->paging->info();
        $this->data['list'] = $this->public_model->get($this->tb,'*',$cond,'id desc',$this->data['page']['cursor']);
//        print_r($this->data);
        $this->load->view('home/teacher_list',$this->data);
    }



    public function detail($id = null){
        $id = abs(intval($id));
        if($id===0 or $this->public_model->get_count($this->tb,"id='$id'")==='0'){
            no_found();
        }
        $this->data['info'] = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->data['course'] = $this->public_model->get('trl_zhibo','*',"teacher='{$this->data['info']['teacher_name']}'");
        $rand = mt_rand(0,7);
        $this->data['more_list'] = $this->public_model->get($this->tb,'*',"id<>'$id'",'id asc','7,3');
//        print_r($this->data);
        $this->load->view('home/teacher_detail',$this->data);
    }


}