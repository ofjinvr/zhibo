<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Live extends Fetch
{

    protected $tb = 'trl_zhibo';

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
        $this->load->view('manage/live_list',$data);
    }


    public function add($action=null){
        if($action==='submit'){
            $post = array_map('trim',$this->input->post());
            $post['pubtime'] = time();
            $post['livetime'] = strtotime($post['livetime']);
            $imgurl = $this->image_upload();
            $post['imgurl'] = !empty($imgurl) ? $imgurl : 'resource/nopic.jpg';
            if($this->public_model->add($this->tb,$post)===false){
                skip_false('系统繁忙，请稍后重试');
            }else{
                skip_true('发布成功',site_url('manage/applications/live'));
            }
        }
        $this->load->view('manage/live_add');
    }


    public function edit($id=null,$action=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('直播不存在或已删除');
        }
        if($action==='submit'){
            $post = array_map('trim',$this->input->post());
            $post['livetime'] = strtotime($post['livetime']);
            $imgurl = $this->image_upload();
            if(!empty($imgurl)){
                $post['imgurl'] = $imgurl;
            }
            if($this->public_model->edit($this->tb,$post,"id='$id'")===false){
                skip_false('系统繁忙，请稍后重试');
            }else{
                skip_true('编辑成功',site_url('manage/applications/live'));
            }
        }
        $data = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->load->view('manage/live_edit',$data);
    }


    public function remove($id=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('直播不存在或已删除');
        }
        if($this->public_model->delete($this->tb,"id='$id'")===false){
            skip_false('系统繁忙，请稍后重试');
        }
        skip_true('删除成功');
    }


    public function pl_list($id=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('直播不存在或已删除');
        }
        $this->load->library('paging',15,$this->public_model->get_count('trl_zhibo_pinglun',"zid='$id'"));
        $data['page'] = $this->paging->info();
        $data['list'] = $this->public_model->get('trl_zhibo_pinglun left join trl_member on trl_zhibo_pinglun.mid=trl_member.id','trl_zhibo_pinglun.*,mobile',"zid='$id'",'trl_zhibo_pinglun.id desc',$data['page']['cursor']);
        $this->load->view('manage/live_pl_list',$data);
    }


    public function pl_check($id=null){
        $id = abs(intval($id));
        $this->public_model->edit('trl_zhibo_pinglun',['is_checked'=>'1'],"id='$id'");
        skip_true('审核完成');
    }

    public function pl_remove($id=null){
        $id = abs(intval($id));
        $this->public_model->delete('trl_zhibo_pinglun',"id='$id'");
        skip_true('已删除');
    }


    public function msg_list($id=null){
        $id = abs(intval($id));
        if(!$this->public_model->get_count($this->tb,"id='$id'")){
            skip_false('直播不存在或已删除');
        }
        $this->load->library('paging',50,$this->public_model->get_count('trl_chat',"lid='$id'"));
        $data['page'] = $this->paging->info();
        $data['list'] = $this->public_model->get('trl_chat left join trl_member on trl_chat.ident=trl_member.id','trl_chat.*,mobile',"lid='$id'",'trl_chat.id desc',$data['page']['cursor']);
        $this->load->view('manage/live_ly_list',$data);
    }

    public function ly_check($id=null){
        $id = abs(intval($id));
        $this->public_model->edit('trl_chat',['is_checked'=>'1'],"id='$id'");
        skip_true('审核完成');
    }

    public function ly_remove($id=null){
        $id = abs(intval($id));
        $this->public_model->delete('trl_chat',"id='$id'");
        skip_true('已删除');
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