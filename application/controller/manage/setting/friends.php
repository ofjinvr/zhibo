<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Friends extends Fetch{
    
    protected $table = 'td_friends';


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
    
    
    //栏目管理列表
    public function index(){
        check_manager_rights(__METHOD__);
        $cond = null;
        $city_id = trim($this->input->get('city_id',true));
        if(is_numeric($city_id)){
            $city_id = intval($city_id);
            $cond ="$this->table.city_id='$city_id'";
        }
        $this->load->library('paging',10,$this->public_model->get_count($this->table,$cond));
        $pageinfo = $this->paging->info();
        $cursor = $pageinfo['cursor'];
        $data['page'] = $this->paging->html();
        $data['list'] = $this->public_model->get("$this->table left join td_city on td_city.city_id=$this->table.city_id",'*',$cond,null,$cursor);
        $data['citys'] = $this->public_model->get('td_city');
        $this->load->view('manage/friends_list',$data);
    }
    
    
    
    //添加栏目
    public function add($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post= $this->input->post();
            if(empty($post['fname']) || empty($post['link'])){
                skip_false('名称和链接不能为空');
            }
            if(!preg_match("/https?:\/\//", $post['link'])){
                skip_false('链接格式有误,需要http://或https://开头');
            }
            $post['city_id'] = intval($post['city_id']);
            $post['page_type'] = intval($post['page_type']);
            $post['bind_id'] = intval($post['bind_id']);
            if($this->public_model->add($this->table,$post)===false){
                skip_false('系统繁忙,请稍后重试');
            }
            skip_true('友情链接已保存');
        }
        $data['citys'] = $this->public_model->get('td_city');
        $this->load->view('manage/friends_add',$data);
    }
    
    
    //编辑栏目
    public function edit($fid=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($fid) or !$this->public_model->in_table($this->table,'fid',$fid)){
            skip_false('友情链接不存在');
        }
        if($act==='action'){
            $post= $this->input->post();
            if(empty($post['fname']) || empty($post['link'])){
                skip_false('名称和链接不能为空');
            }
            if(!preg_match("/https?:\/\//", $post['link'])){
                skip_false('链接格式有误,需要http://或https://开头');
            }
            $post['city_id'] = intval($post['city_id']);
            $post['page_type'] = intval($post['page_type']);
            $post['bind_id'] = intval($post['bind_id']);
            if($this->public_model->edit($this->table,$post,"fid='$fid'")===false){
                skip_false('系统繁忙,请稍后重试');
            }
            skip_true('友情链接已保存');
        }
        $data['info'] = $this->public_model->one($this->table,'*',"fid=$fid");
        $data['citys'] = $this->public_model->get('td_city');
        $this->load->view('manage/friends_edit',$data);
    }
    
    
    //删除栏目
    public function drop($fid){
        check_manager_rights(__METHOD__);
        if(!is_natural($fid) or !$this->public_model->in_table($this->table,'fid',$fid)){
            skip_false('友情链接不存在');
        }
        $this->public_model->delete($this->table,"fid=$fid");
        skip_true('友情链接已删除');
    }
    
    
}