<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//APP控制器 首页
class Replay extends Fetch{

    private $data;
    private $tb = 'trl_zhibo';
    private $pl = 'trl_zhibo_pinglun';

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('setting_model');
        $this->data['webinfo'] = $this->setting_model->seach(); //网站基础信息
        $this->data['nav'] = 'replay';
        $this->load->func('filter');
        my_filter_get();
    }

    public function index(){
        $rolename = $this->input->get('rolename');
        $typename = $this->input->get('typename');
        $cityname = $this->input->get('cityname');
        $cond=['true'];
        if(!empty($rolename)){$cond[] = "rolename='$rolename'";}
        if(!empty($typename)){$cond[] = "typename='$typename'";}
        if(!empty($cityname)){$cond[] = "cityname='$cityname'";}
        $cond = implode(' and ',$cond);
        $this->load->library('paging',10,$this->public_model->get_count($this->tb,$cond));
        $this->data['page'] = $this->paging->info();
        $now = time();
        $this->data['list'] = $this->public_model->get($this->tb,'*',"livetime+duration*60 < $now and $cond",'id desc',$this->data['page']['cursor']);
        $this->load->view('home/huifang_list',$this->data);
    }


    public function detail($id = null){
        $id = abs(intval($id));
        if($id===0 or $this->public_model->get_count($this->tb,"id='$id'")==='0'){
            no_found();
        }
        $this->data['info'] = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->data['pinglun'] = $this->public_model->get($this->pl,'*',"zid='$id' and is_checked='1'");
        $this->data['like'] = $this->public_model->get($this->tb,'*',"id<>'$id' and typename='{$this->data['info']['typename']}'");
        foreach($this->data['like'] as $key => $row){
            if($row['livetime'] + 60 * $row['duration'] > time()){
                $this->data['like'][$key]['mod'] = 'live';
            }else{
                $this->data['like'][$key]['mod'] = 'replay';
            }
        }
        $this->load->view('home/huifang_detail',$this->data);
    }


    public function play($id = null){
        $id = abs(intval($id));
        if($id===0 or $this->public_model->get_count($this->tb,"id='$id'")==='0'){
            no_found();
        }
        $this->data['info'] = $this->public_model->one($this->tb,'*',"id='$id'");
        $this->data['msg_list'] = $this->public_model->get('trl_chat left join trl_member on trl_member.id=trl_chat.ident','trl_chat.*,nickname,mobile',"lid='$id' and is_checked>0");
        $this->public_model->math($this->tb,'pageview','1',"id='$id'");
        if(!empty($_GET['ismob']) and $_GET['ismob']==='1'){
            $this->load->view('home/huifang_mobile',$this->data);
        }else{
            $this->load->view('home/huifang_play',$this->data);
        }
    }



}