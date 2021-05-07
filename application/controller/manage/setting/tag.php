<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Tag extends Fetch{
    
    protected $tb = 'td_words';

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('varcheck');
        $this->load->model('public_model');
        
        //检查是否登录
        $this->load->func('check_manager_logined');
        check_manager_logined();
        //城市列表
        $this->city = $this->public_model->get('td_city');
        array_unshift($this->city,['city_id'=>'0','city_name'=>'全国','city_site'=>'www.taoding.cn']);
    }
    
    
    public function index(){
        check_manager_rights(__METHOD__);
        $cond = ['1'];
        $kw = trim($this->input->get('kw',true));
        if(!empty($kw)){
            $cond[] = is_natural($kw) ? "$this->tb.id='$kw'" : "$this->tb.word like '%$kw%'";
        }
        $city_id = trim($this->input->get('city_id',true));
        if(is_numeric($city_id)){
            $city_id = intval($city_id);
            $cond[] ="$this->tb.city_id='$city_id'";
        }
        $cond = implode(' and ',$cond); 
        $this->load->library('paging',15,$this->public_model->get_count($this->tb,$cond));
        $pageinfo = $this->paging->info();
        $cursor = $pageinfo['cursor'];
        $data['page'] = $pageinfo;
        $data['list'] = $this->public_model->get("$this->tb left join td_city on td_city.city_id=$this->tb.city_id","$this->tb.*,city_name",$cond,"$this->tb.id desc", $cursor);
        $data['citys'] = $this->public_model->get('td_city');
//		print_r($data);
        $this->load->view('manage/tag_list',$data);
    }

    
    public function add($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $post = $this->input->post();
            if(empty($post['word'])){
                skip_false('标签名称必须填写');
            }
            if(!empty($post['link']) and substr($post['link'],0,7)!=='http://'){
                skip_false('链接地址格式有误');
            }
            $post['city_id'] = intval($post['city_id']);
            if($this->public_model->add($this->tb,$post)===false){
                skip_true('系统繁忙,请稍后重试');
            }
            skip_true('TAG已添加');
        }
		$data['citys'] = $this->public_model->get('td_city');
        $this->load->view('manage/tag_add',$data);
    }
    
    
    public function edit($id=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($id) or !$this->public_model->in_table($this->tb,'id',$id)){
            skip_false('TAG不存在或已删除');
        }
        if($act==='action'){
            $post = $this->input->post();
            if(empty($post['word'])){
                skip_false('标签名称必须填写');
            }
            if(!empty($post['link']) and substr($post['link'],0,7)!=='http://'){
                skip_false('链接地址格式有误');
            }
            $post['city_id'] = intval($post['city_id']);
            if($this->public_model->edit($this->tb,$post,"id='$id'")===false){
                skip_true('系统繁忙,请稍后重试');
            }
            skip_true('修改已保存');
        }
		$data['citys'] = $this->public_model->get('td_city');
        $data['info'] = $this->public_model->one("$this->tb left join td_city on td_city.city_id=$this->tb.city_id",'*',"id='$id'");
//		print_r($data);
        $this->load->view('manage/tag_edit',$data);
    }
    
    
    public function drop($id=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($id) or !$this->public_model->in_table($this->tb,'id',$id)){
            skip_false('TAG不存在或已删除');
        }
        $this->public_model->delete($this->tb,"id='$id'");
        skip_true('TAG已删除');
    }
    
    
    //从文章中提取
    public function tag_update($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            set_time_limit(0);
            $this->load->database();
            $this->db->exec('truncate `td_words`');
            foreach($this->city as $city){
                $city_id = intval($city['city_id']);
                $fetch = array_column($this->public_model->get($this->atb,'meta_keywords',"city_id='$city_id'"),'meta_keywords');
                $akw = [];
                foreach($fetch as $row){
                    $exp = explode(',',$row);
                    $akw = array_merge($akw,$exp);
                }
                $akw = array_unique($akw);
                foreach($akw as $wd){
                    $wd = trim($wd);
                    if(empty($wd)){
                        continue;
                    }
                    $this->public_model->add('td_words',['word'=>$wd,'city_id'=>$city_id]);
                }
            }
            skip_true('关键词库已更新');
        }
        $this->load->view('manage/tag_update');
    }
}