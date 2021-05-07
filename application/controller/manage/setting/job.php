<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Job extends Fetch{
    
    protected $table = 'td_job';


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
        $this->load->library('paging',10,$this->public_model->get_count($this->table));
        $pageinfo = $this->paging->info();
        $cursor = $pageinfo['cursor'];
        $data['page'] = $this->paging->html();
        $data['list'] = $this->public_model->get($this->table,'*',null,'reltime desc',$cursor);
        $this->load->view('manage/job_list',$data);
    }
    
    
    
    //添加
    public function add($act=null){
        check_manager_rights(__METHOD__);
        if($act==='action'){
            $jobname = trim($this->input->post('jobname',true));
            $content = $this->input->post('content',true);
            if(!$this->public_model->add($this->table,array('jobname'=>$jobname,'content'=>$content))){
                skip_false('系统繁忙,请稍后重试');
            }
            skip_true('成功发布一个职位',site_url('manage/setting/job'));
        }
        $this->load->view('manage/job_add');
    }
    
    
    //编辑栏目
    public function edit($jid=null,$act=null){
        check_manager_rights(__METHOD__);
        if(!is_natural($jid) or !$this->public_model->in_table($this->table,'jid',$jid)){
            skip_false('职位不存在');
        }
        if($act==='action'){
            $jobname = trim($this->input->post('jobname',true));
            $content = $this->input->post('content',true);
            if(!$this->public_model->edit($this->table,array('jobname'=>$jobname,'content'=>$content),"jid=$jid")){
                skip_false('系统繁忙,请稍后重试');
            }
            skip_true('职位信息已保存',site_url('manage/setting/job'));
        }
        $data['info'] = $this->public_model->one($this->table,'*',"jid=$jid");
        $this->load->view('manage/job_edit',$data);
    }
    
    
    //删除栏目
    public function drop($jid){
        check_manager_rights(__METHOD__);
        if(!is_natural($jid) or !$this->public_model->in_table($this->table,'jid',$jid)){
            skip_false('职位不存在');
        }
        $this->public_model->delete($this->table,"jid=$jid");
        skip_true('职位已删除');
    }
    
    
}