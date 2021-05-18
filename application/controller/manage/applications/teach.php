<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Teach extends Fetch
{

    protected $tb = 'trl_teach';
    protected $tb2 = 'trl_teach_signup';

    public function __construct()
    {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('varcheck');
        $this->load->func('string');
        $this->load->model('public_model');

        //检查是否登录
        $this->load->func('check_manager_logined');
        check_manager_logined();
    }


    public function index(){
        $this->load->library('paging',15,$this->public_model->get_count($this->tb));
        $data['page'] = $this->paging->info();
        $data['list'] = $this->public_model->get($this->tb,'*',null,'id desc',$data['page']['cursor']);
        $this->load->view('manage/teach_list',$data);
    }


    public function add($action=null){
        if($action==='submit'){
            $post = array_map('trim',$this->input->post());
            $post['pubtime'] = time();
            $post['teachtime'] = strtotime($post['teachtime']);
            $post['snumber'] = intval($post['snumber']);
            $post['pnumber'] = intval($post['pnumber']);
            $imgurl = $this->image_upload();
            $post['imgurl'] = !empty($imgurl) ? $imgurl : 'resource/nopic.jpg';
            if($this->public_model->add($this->tb,$post)===false){
                skip_false('系统繁忙，请稍后重试');
            }else{
                skip_true('发布成功',site_url('manage/applications/teach'));
            }
        }
        $data['city_list'] = $this->public_model->get('trl_city');
        $this->load->view('manage/teach_add',$data);
    }


    public function edit($id=null,$action=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('培训不存在或已删除');
        }
        if($action==='submit'){
            $post = array_map('trim',$this->input->post());
            $post['teachtime'] = strtotime($post['teachtime']);
            $post['snumber'] = intval($post['snumber']);
            $post['pnumber'] = intval($post['pnumber']);
            $imgurl = $this->image_upload();
            if(!empty($imgurl)){
                $post['imgurl'] = $imgurl;
            }
            if($this->public_model->edit($this->tb,$post,"id='$id'")===false){
                skip_false('系统繁忙，请稍后重试');
            }else{
                skip_true('编辑成功',site_url('manage/applications/teach'));
            }
        }
        $data = $this->public_model->one($this->tb,'*',"id='$id'");
        $data['city_list'] = $this->public_model->get('trl_city');
        $this->load->view('manage/teach_edit',$data);
    }


    public function remove($id=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('培训不存在或已删除');
        }
        if($this->public_model->delete($this->tb,"id='$id'")===false){
            skip_false('系统繁忙，请稍后重试');
        }
        skip_true('删除成功');
    }


    public function signup($tid=null){
        $this->load->library('paging',15,$this->public_model->get_count($this->tb2));
        $data['page'] = $this->paging->info();
        $data['list'] = $this->public_model->get($this->tb2,'*',null,'id desc',$data['page']['cursor']);
        $this->load->view('manage/teach_signup_list',$data);
    }


    //上传图片
    private function image_upload(){
        $this->load->library('upload',520000,'gif|jpg|png');
        $dirname = date('Ymd');
        if($this->upload->up($dirname)){
            $result = $this->upload->result();
            return $result['imgurl'];
        }
        $error = $this->upload->error();
        if($error[0]['code']!==4){
            skip_false($error[0]['msg']);
        }
    }
}