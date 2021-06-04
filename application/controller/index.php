<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//APP控制器 首页
class Index extends Fetch{

    private $data;

    public function __construct() {
        parent::__construct();
        $this->load->func('url');
        $this->load->func('skip');
        $this->load->func('string');
        $this->load->model('public_model');
        $this->load->model('setting_model');
        $this->data['webinfo'] = $this->setting_model->seach(); //网站基础信息
        $this->data['nav'] = 'index';
        $this->load->func('filter');
        my_filter_get();
        $this->public_model->add('pview',['pvtime'=>time()]); 
        $this->data['webinfo']['pv_today'] = $this->public_model->get_count('pview','pvtime>='.strtotime(date('Y-m-d 0:0:0')));
        $this->data['webinfo']['pv_all'] = $this->public_model->get_count('pview');
    }

    public function index(){
        $this->data['live_list_ready'] = $this->public_model->get('trl_zhibo','*',"livetime>=".time(),'id desc','0,1');
        $this->data['live_list_replay'] = $this->public_model->get('trl_zhibo','*',"livetime+duration*60 < ".time(),'id desc','0,2');
        $this->data['video'] = $this->public_model->get('trl_video','*',null,'id desc','0,3');
        $this->data['article_list'] = $this->public_model->get('trl_article','*',null,'id desc','0,3');
        $this->data['teach'] =  $this->public_model->get('trl_teach','*',null,'id desc','0,5');
        $this->data['teacher'] =  $this->public_model->get('trl_teachers');
//        print_r($this->data);
        $this->load->view('home/index',$this->data);
    }


    //搜索 live article teach video
    public function search($type = 'live'){
        if($type!=='live' and $type!=='article' and $type!=='teach' and $type!=='video'){
            no_found();
        }

        $cond = [];
        if(!empty($this->input->get('typename'))){
            $cond[] = "typename='{$this->input->get('typename')}'";
        }
        if(!empty($this->input->get('rolename'))){
            $cond[] = "rolename='{$this->input->get('rolename')}'";
        }
        $cond_2 = '';
        if(!empty($this->input->get('kw'))){
            $cond_2 = [];
            $kwa = explode(' ', trim($this->input->get('kw')));
            foreach($kwa as $row){
                $cond_2[] = "title like '%$row%'";
            }
            $cond_2 = '('.implode(' or ',$cond_2).')';
            $cond[] = $cond_2;
        }
        $cond = implode(" and ",$cond);
        //搜索
        if($type === 'live'){
            $this->load->library('paging',20,$this->public_model->get_count('trl_zhibo',$cond));
            $this->data['page'] = $this->paging->info();
            $this->data['list'] = $this->public_model->get('trl_zhibo','id,title,pubtime',$cond,'id desc',$this->data['page']['cursor']);
            array_walk($this->data['list'],function(&$row){
                $row['url'] = site_url("live/detail/{$row['id']}");
            });
        }
        if($type === 'video'){
            $this->load->library('paging',20,$this->public_model->get_count('trl_video',$cond));
            $this->data['page'] = $this->paging->info();
            $this->data['list'] = $this->public_model->get('trl_video','id,title,pubtime',$cond,'id desc',$this->data['page']['cursor']);
            array_walk($this->data['list'],function(&$row){
                $row['url'] = site_url("video/play/{$row['id']}");
            });
        }
//        if($type === 'article'){
//            $this->load->library('paging',20,$this->public_model->get_count('trl_article',$cond_2));
////            $this->data['page'] = $this->paging->info();
//            $this->data['list'] = $this->public_model->get('trl_article','id,title,pubtime',$cond_2,'id desc',$this->data['page']['cursor']);
//            array_walk($this->data['list'],function(&$row){
//                $row['url'] = site_url("about/article/{$row['id']}");
//            });
//        }
        if($type === 'teach'){
            $this->load->library('paging',20,$this->public_model->get_count('trl_teach',$cond_2));
            $this->data['page'] = $this->paging->info();
            $this->data['list'] = $this->public_model->get('trl_teach','id,title,pubtime',$cond_2,'id desc',$this->data['page']['cursor']);
            array_walk($this->data['list'],function(&$row){
                $row['url'] = site_url("teach/detail/{$row['id']}");
            });
        }
        if(empty($_GET['kw'])){$_GET['kw'] = '';}else{$_GET['kw']=strip_tags($_GET['kw']);}
        if(empty($_GET['typename'])){$_GET['typename'] = '';}
        if(empty($_GET['rolename'])){$_GET['rolename'] = '';}
        $this->data['type'] = $type;
//        print_r($this->data);
        $this->load->view('home/search',$this->data);
    }


    public function logout(){
        $_SESSION['member'] = [];
        header('Location:'.site_url());
    }

}