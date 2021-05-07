<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Network extends Fetch{
    
    protected $table = 'td_network';

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('varcheck');
        $this->load->model('public_model');
        $this->load->model('article_model');
        
        //检查是否登录
        $this->load->func('check_manager_logined');
        check_manager_logined();
    }
    
    
    public function index(){
        check_manager_rights(__METHOD__);
        $this->load->library('paging',10,$this->public_model->get_count($this->table));
        $pageinfo = $this->paging->info();
        $cursor = $pageinfo['cursor'];
        $data['page'] = $this->paging->html();
        $data['list'] = $this->public_model->get("$this->table left join td_city on td_city.city_id=$this->table.city_id",'*',null,'id desc',$cursor);
		$data['citylist'] = $this->public_model->get('td_city');
//		var_dump($data);
        $this->load->view('manage/network_list',$data);
    }

    
    public function add($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post = $this->input->post();
            $this->form_valid($post);					//去验证
            /*$qrcode = $this->image_upload();			//上传照片
            $post['qrcode'] = !empty($qrcode) ? $qrcode : 'resource/default_qrcode.png';*/			//二维码判断
            if($this->public_model->add($this->table,$post)===false){
                skip_true('系统繁忙,请稍后重试');
            }
            skip_true('网点已保存');
        }
		$data['citylist'] = $this->public_model->get('td_city');
		//print_r($data);
        $this->load->view('manage/network_add',$data);
    }
    
    
    public function edit($id=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($id) or !$this->public_model->in_table($this->table,'id',$id)){
            skip_false('服务网点不存在');
        }
        if($act==='action'){
            $post = $this->input->post();
            $this->form_valid($post);
            /*$qrcode = $this->image_upload();
            !empty($qrcode) && $post['qrcode']=$qrcode;*/
            if($this->public_model->edit($this->table,$post,"id=$id")===false){
                skip_true('系统繁忙,请稍后重试');
            }
            skip_true('服务网点已保存');
        }
		$data['citylist'] = $this->public_model->get("td_city");
        $data['info'] = $this->public_model->one("$this->table left join td_city on td_city.city_id=$this->table.city_id",'*',"id=$id");
		//print_r($data);
        $this->load->view('manage/network_edit',$data);
    }
    
    
    public function drop($id=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($id) or !$this->public_model->in_table($this->table,'id',$id)){
            skip_false('服务网点不存在');
        }
        $this->public_model->delete($this->table,"id=$id");
        skip_true('服务网点已删除');
    }
    
    
    //上传图片
    private function image_upload(){
        $this->load->library('upload',520000,'gif|jpg|png');
        $dirname = date('Ymd');
        if($this->upload->up($dirname)){
            $result = $this->upload->result();
            return $result['qrcode'];
        }
        $error = $this->upload->error();
        if($error[0]['code']!==4){
            skip_false($error[0]['msg']);
        }
    }
    
    
    //验证表单
    private function form_valid($post){
        $this->load->library('valid');
        $rule = array(
            'name,服务网点不能为空,required',
            'city_id,请选择服务城市,required'
           
        );
        $this->valid->set_rule_array($rule);
        if($this->valid->run($post)===false){
            $error = $this->valid->get_error();
            skip_false($error[0]['msg']);
        }
    }
}