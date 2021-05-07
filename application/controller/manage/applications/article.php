<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Article extends Fetch{

    protected $tb = 'trl_article';
    
    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('varcheck');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('article_model');
        
        //检查是否登录
        $this->load->func('check_manager_logined');
        check_manager_logined();
    }
    
    
    //文章列表
    public function index(){
        $this->load->library('paging',15,$this->public_model->get_count($this->tb));
        $data['page'] = $this->paging->info();
        $data['list'] = $this->public_model->get($this->tb,'*',null,'id desc',$data['page']['cursor']);
        $this->load->view('manage/article_list',$data);
    }



    public function add($action=null){
        if($action==='submit'){
            $post = array_map('trim',$this->input->post());
            $post['pubtime'] = time();
            if($this->public_model->add($this->tb,$post)===false){
                skip_false('系统繁忙，请稍后重试');
            }else{
                skip_true('发布成功',site_url('manage/applications/article'));
            }
        }
        $this->load->view('manage/article_add');
    }


    public function edit($id=null,$action=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('文章不存在或已删除');
        }
        if($action==='submit'){
            $post = array_map('trim',$this->input->post());
            if($this->public_model->edit($this->tb,$post,"id='$id'")===false){
                skip_false('系统繁忙，请稍后重试');
            }else{
                skip_true('编辑成功',site_url('manage/applications/article'));
            }
        }
        $data = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->load->view('manage/article_edit',$data);
    }


    public function remove($id=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('文章不存在或已删除');
        }
        if($this->public_model->delete($this->tb,"id='$id'")===false){
            skip_false('系统繁忙，请稍后重试');
        }
        skip_true('删除成功');
    }
}