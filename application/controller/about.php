<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//APP控制器 首页
class About extends Fetch
{

    private $data;
    private $tb = 'trl_article';

    public function __construct()
    {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('setting_model');
        $this->data['webinfo'] = $this->setting_model->seach(); //网站基础信息
        $this->data['nav'] = 'about';
    }

    public function index()
    {
        $this->data['list'] = $this->public_model->get($this->tb,'*',null,'id desc','0,3');
        $this->load->view('home/about', $this->data);
    }

    public function article($id=null){
        $id = abs(intval($id));
        if($id===0 or $this->public_model->get_count($this->tb,"id='$id'")==='0'){
            no_found();
        }
        $this->data['info'] = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->load->view('home/article',$this->data);

    }


}