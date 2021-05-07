<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Nav extends Fetch{
    
    protected $table = 'td_nav';

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
        $cond = null;
        $city_id = trim($this->input->get('city_id',true));
        if(is_numeric($city_id)){
            $city_id = intval($city_id);
            $cond ="$this->table.city_id='$city_id'";
        }
        $data['list'] = $this->public_model->get("$this->table left join td_city on td_city.city_id=$this->table.city_id",'*',$cond,"$this->table.city_id desc,weight desc");
		$data['citylist'] = $this->public_model->get('td_city');
//		print_r($data);
        $this->load->view('manage/nav_list',$data);
    }

    
    public function add($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post = $this->input->post();
            $this->form_valid($post);
            if($this->public_model->add($this->table,$post)===false){
                skip_true('系统繁忙,请稍后重试');
            }
            skip_true('导航已添加',site_url('manage/setting/nav'));
        }
		$data['citylist'] = $this->public_model->get('td_city');
        $this->load->view('manage/nav_add',$data);
    }
    
    
    public function edit($nav_id=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($nav_id) or !$this->public_model->in_table($this->table,'nav_id',$nav_id)){
            skip_false('导航不存在或已删除');
        }
        if($act==='action'){
            $post = $this->input->post();
            $this->form_valid($post);
            if($this->public_model->edit($this->table,$post,"nav_id=$nav_id")===false){
                skip_true('系统繁忙,请稍后重试');
            }
            skip_true('修改已保存',site_url('manage/setting/nav'));
        }
		$data['citylist'] = $this->public_model->get("td_city");
        $data['info'] = $this->public_model->one("$this->table left join td_city on td_city.city_id=$this->table.city_id",'*',"nav_id=$nav_id");
//		print_r($data);
        $this->load->view('manage/nav_edit',$data);
    }
    
    
    public function drop($nav_id=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($nav_id) or !$this->public_model->in_table($this->table,'nav_id',$nav_id)){
            skip_false('导航不存在或已删除');
        }
        $this->public_model->delete($this->table,"nav_id='$nav_id'");
        skip_true('导航已删除');
    }
    
    
    //验证表单
    private function form_valid($post){
        $this->load->library('valid');
        $rule = array(
            'nav_name,导航名称不能为空,required',
            'nav_href,链接地址不能为空,required',
            'city_id,城市参数有误,numeric'
        );
        $this->valid->set_rule_array($rule);
        if($this->valid->run($post)===false){
            $error = $this->valid->get_error();
            skip_false($error[0]['msg']);
        }
    }
}