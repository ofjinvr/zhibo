<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Slider extends Fetch{
    
    protected $table = 'td_slider';
    protected $tb_city = 'td_city';


    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('varcheck');
        $this->load->model('public_model');
        
        //检查是否登录
        $this->load->func('check_manager_logined');
        check_manager_logined();
    }
    
    
    public function index(){
        check_manager_rights(__METHOD__);
        $this->load->library('paging',8,$this->public_model->get_count($this->table));
        $pageinfo = $this->paging->info();
        $cursor = $pageinfo['cursor'];
        $data['page'] = $this->paging->html();
        $data['list'] = $this->public_model->get("$this->table left join $this->tb_city on $this->table.city_id=$this->tb_city.city_id",'*',null,'sorting desc',$cursor);
//        print_r($data);
        $this->load->view('manage/slider_list',$data);
    }
    
    
    
    //添加
    public function add($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post = array_map('trim',$this->input->post(null,true));
            
            if(empty($post['imgpath'])){
                skip_false('请选择图片');
            }
            if($this->public_model->add($this->table,$post)===false){
                skip_false('系统繁忙，请稍后重试');
            }else{
                skip_true('成功添加一个轮播图',site_url('manage/setting/slider'));
            }
        }
        $data['citys'] = $this->public_model->get($this->tb_city);
        $this->load->view('manage/slider_add',$data);
    }
    
    
    //编辑栏目
    public function edit($sid=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($sid) or !$this->public_model->in_table($this->table,'sid',$sid)){
            skip_false('轮播图不存在');
        }
        if($act==='action'){
            $post = array_map('trim',$this->input->post(null,true));
            if(empty($post['imgpath'])){
                skip_false('请选择图片');
            }
            if($this->public_model->edit($this->table,$post,"sid='$sid'")===false){
                skip_false('系统繁忙，请稍后重试');
            }else{
                skip_true('修改已保存',site_url('manage/setting/slider'));
            }
        }
        $data['info'] = $this->public_model->one($this->table,'*',"sid=$sid");
        $data['citys'] = $this->public_model->get($this->tb_city);
        $this->load->view('manage/slider_edit',$data);
    }
    
    
    //删除栏目
    public function drop($sid){
        check_manager_rights(__METHOD__);
        if(!is_natural($sid) or !$this->public_model->in_table($this->table,'sid',$sid)){
            skip_false('轮播图不存在');
        }
        $this->public_model->delete($this->table,"sid=$sid");
        skip_true('轮播图已删除');
    }
    
    
    //获取上传的图片
    public function ajax_slider_image(){
        $this->load->library('files');
        $files = $this->files->all_files('upload/slider',false,'jpg|png|gif');
        $files===false && $files = array();
        echo json_encode($files);
    }
    
    
}