<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Service_model extends Fetch{

    private $tb = 'td_service';
    private $tb_cate = 'td_service_cate';
    private $tb_type = 'td_service_type';
    private $tb_area = 'td_service_area';
    private $tb_apply = 'tb_service_apply';
    private $tb_faq = 'td_service_question';
    private $tb_assoc = 'td_service_assoc';
    private $tb_city = 'td_city';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('bosonnlp');
        $this->load->database();
    }
    
    
    // 获取服务列表
    public function getServiceList($field='*', $cond=null, $order='sid desc', $amount='15'){
        $data = array();
        $this->load->library('paging',$amount, $this->getServiceCount($cond));
        $data['page'] = $this->paging->info();
        $data['list'] = $this->db
            ->select($field)
            ->from($this->tb)
            ->join($this->tb_city,"$this->tb_city.city_id=$this->tb.city_id")
            ->join($this->tb_cate,"$this->tb_cate.scid=$this->tb.scid")
            ->where($cond)
            ->order($order)
            ->limit($data['page']['cursor'])
            ->query()
            ->all_array();
        foreach($data['list'] as $key => $row){
            $data['list'][$key]['types'] = array();
            $types = $this->db->select('type_name')
                ->from($this->tb_type)
                ->where("sid='{$row['sid']}'")
                ->query()
                ->all_array();
            foreach($types as $v){
                $data['list'][$key]['types'][] = $v['type_name'];
            }

        }
        return $data;
    }


    //查询服务数量
    public function getServiceCount($cond=null){
        $amount_all = $this->db
            ->select('COUNT(*) as amount_all')
            ->from($this->tb)
            ->where($cond)
            ->query()
            ->row()
            ->amount_all;
        return (int)$amount_all;
    }


    //获取服务详情
    public function getService($sid=null){
        if(!$this->isExists($sid)){
            throw new Exception('服务不存在');
        }
        $cond = "sid='$sid'";
        $data = $this->db->select("$this->tb.*,$this->tb_cate.scid,$this->tb_cate.pscid,$this->tb_cate.url_word,$this->tb_cate.cate_name,city_site,city_name")
            ->from($this->tb)
            ->where($cond)
            ->join($this->tb_cate,"$this->tb.scid=$this->tb_cate.scid",MYSQL::JOIN_LEFT)
            ->join($this->tb_city,"$this->tb.city_id=$this->tb_city.city_id",MYSQL::JOIN_LEFT)
            ->query()
            ->row_array();
        //服务可选类别
        $type = $this->db->select('type_name,type_price')->from($this->tb_type)->where($cond)->query()->all_array();
        $data['type'] = array();
        foreach($type as $key => $row){
            $data['type'][$key]['name'] = $row['type_name'];
            $data['type'][$key]['price'] = $row['type_price'];
        }
        //服务地区
        $area = $this->db->select('area_name')->from($this->tb_area)->where($cond)->query()->all_array();
        $data['area_name'] = array();
        foreach($area as $row){
            $data['area_name'][] = $row['area_name'];
        }
        //服务问题
        $question = $this->db->select('sqid,question,answer')->from($this->tb_faq)->where($cond)->limit('0,5')->query()->all_array();
        $data['question'] = array();
        foreach($question as $key => $row){
            $data['question'][$key]['q'] = $row['question'];
            $data['question'][$key]['a'] = $row['answer'];
            $data['question'][$key]['id'] = $row['sqid'];
        }
        //服务关联
        $assoc = $this->db->select('assoc_id')->from($this->tb_assoc)->where($cond)->query()->all_array();
        $data['assoc'] = array();
        foreach($assoc as $row){
            $data['assoc'][] = $row['assoc_id'];
        }
        return $data;
    }
    
    
    //发布服务
    public function addService($data){
        $this->checkForm($data);

        //图片上传
        $this->load->library('upload',512000,'gif|jpeg|jpg|png');
        $this->upload->up('service');
        $result = $this->upload->result();
        if(empty($data['s_pictrue'])){
            $data['s_pictrue'] = !empty($result['s_pictrue']) ? $result['s_pictrue'] : '';
        }
        if(empty($data['s_icon'])){
            $data['s_icon'] = !empty($result['s_icon']) ? $result['s_icon'] : '';
        }
        
        //自动获取第一张图片
        if(empty($data['s_pictrue'])){
            preg_match('/<img.+?src=(\\\'|\\\")?(?<src>.*?\.(jpg|png|gif))(\\1).*?>/i',$data['s_text'],$firstimg);
            $data['s_pictrue'] = !empty($firstimg['src']) ? str_replace(base_url(),'',$firstimg['src']) : 'resource/nopic.jpg';
        }
        
        //服务类型,类型价格处理
        $type = [];
        if(!empty($data['type_name']) and count($data['type_name'])===count($data['type_price'])){
            foreach($data['type_name'] as $key => $row){
                $type[$key]['name'] = $row;
                $type[$key]['price'] = $data['type_price'][$key];
            }
            unset($data['type_name']);
            unset($data['type_price']);
        }
        
        //服务网点处理
        $area_name = array();
        if(!empty($data['area_name']) and is_array($data['area_name'])){
            foreach($data['area_name'] as $row){
                $area_name[] = $row;
            }
        }
        unset($data['area_name']);
        //服务关联处理
        $assoc = array();
        if(!empty($data['assoc']) and is_array($data['assoc'])){
            foreach($data['assoc'] as $row){
                if(is_natural($row) && $this->isExists($row)){
                    $assoc[] = $row;
                }
            }
        }
        unset($data['assoc']);
        //关键词为空 自动提取
        if(empty($data['s_key'])){
            $keywords = $this->bosonnlp->get_keywords($data['s_name'],3);
            if(!empty($keywords) and is_array($keywords)){
                $s_key = [];
                foreach($keywords as $row){
                    $s_key[] = $row[1];
                }
                $data['s_key'] = implode(',',$s_key);
            }
        }

        //摘要自动提取
        if(empty($data['s_depict'])){
            $data['s_depict'] = str_replace('\n','',trim($this->bosonnlp->get_depict($data['s_text'],$data['s_name']),'"'));
        }

        //设置时间
        $data['pubdate'] = time();
        
        //开启事务插入
        $this->db->exec('begin');
        if($this->db->insert($this->tb,$data)===false){
            $this->db->exec('rollback');
            return false;
        }else{
            //附表插入
            $insert_id = $this->db->insert_id();
            //类型
            foreach($type as $row){
                if($this->db->insert($this->tb_type,array('sid' =>$insert_id,'type_name' => $row['name'],'type_price'=>$row['price']))===false){
                    $this->db->exec('rollback');
                    throw new Exception('系统繁忙,请稍后重试');
                }
            }
            //网点
            foreach($area_name as $row){
                if($this->db->insert($this->tb_area,array('sid' =>$insert_id,'area_name' => $row))===false){
                    $this->db->exec('rollback');
                    throw new Exception('系统繁忙,请稍后重试');
                }
            }
            //关联
            foreach($assoc as $row){
                if($this->db->insert($this->tb_assoc,array('sid' =>$insert_id,'assoc_id' => $row))===false){
                    $this->db->exec('rollback');
                    throw new Exception('系统繁忙,请稍后重试');
                }
            }
        }
        $this->db->exec('commit');
        return true;
    }


    //编辑服务
    public function editService($sid,$data){
        if(!$this->isExists($sid)){
            throw new Exception('服务不存在');
        }
        $this->checkForm($data);
        //图片上传
        $this->load->library('upload',512000,'gif|jpeg|jpg|png');
        $this->upload->up('service');
        $result = $this->upload->result();
        if(!empty($result['s_pictrue'])){
            $data['s_pictrue'] = $result['s_pictrue'];
        }
        if(!empty($result['s_icon'])){
            $data['s_icon'] = $result['s_icon'];
        }

        //服务类型,类型价格处理
        $type = [];
        if(!empty($data['type_name']) and count($data['type_name'])===count($data['type_price'])){
            foreach($data['type_name'] as $key => $row){
                $type[$key]['name'] = $row;
                $type[$key]['price'] = $data['type_price'][$key];
            }
            unset($data['type_name']);
            unset($data['type_price']);
        }
        
        //服务地区处理
        $area_name = array();
        if(!empty($data['area_name']) and is_array($data['area_name'])){
            foreach($data['area_name'] as $row){
                $area_name[] = $row;
            }
        }
        unset($data['area_name']);
        //服务关联处理
        $assoc = array();
        if(!empty($data['assoc']) and is_array($data['assoc'])){
            foreach($data['assoc'] as $row){
                if(is_natural($row) && $this->isExists($row)){
                    $assoc[] = $row;
                }
            }
        }
        unset($data['assoc']);

        //关键词为空 自动提取
        if(empty($data['s_key'])){
            $keywords = $this->bosonnlp->get_keywords($data['s_name'],3);
            if(!empty($keywords) and is_array($keywords)){
                $s_key = [];
                foreach($keywords as $row){
                    $s_key[] = $row[1];
                }
                $data['s_key'] = implode(',',$s_key);
            }
        }

        //摘要自动提取
        if(empty($data['s_depict'])){
            $data['s_depict'] = str_replace('\n','',trim($this->bosonnlp->get_depict($data['s_text'],$data['s_name']),'"'));
        }

        //开启事务修改
        $cond = "sid='$sid'";
        $this->db->exec('begin');
        if($this->db->update($this->tb,$data,$cond)===false){
            $this->db->exec('rollback');
            return false;
        }else{
            $this->db->delete($this->tb_type,$cond);
            $this->db->delete($this->tb_area,$cond);
            $this->db->delete($this->tb_faq,$cond);
            $this->db->delete($this->tb_assoc,$cond);
            //类型
            foreach($type as $row){
                if($this->db->insert($this->tb_type,array('sid'=>$sid,'type_name'=>$row['name'],'type_price'=>$row['price']))===false){
                    $this->db->exec('rollback');
                    throw new Exception('系统繁忙,请稍后重试');
                }
            }
            //网点
            foreach($area_name as $row){
                if($this->db->insert($this->tb_area,array('sid'=>$sid,'area_name'=>$row))===false){
                    $this->db->exec('rollback');
                    throw new Exception('系统繁忙,请稍后重试');
                }
            }
            //关联
            foreach($assoc as $row){
                if($this->db->insert($this->tb_assoc,array('sid' =>$sid,'assoc_id' => $row))===false){
                    $this->db->exec('rollback');
                    throw new Exception('系统繁忙,请稍后重试');
                }
            }
        }
        $this->db->exec('commit');
        return true;
    }


    public function delService($sid){
        if(!$this->isExists($sid)){
            throw new Exception('服务不存在');
        }
        $cond = "sid='$sid'";
        $this->db->delete($this->tb,$cond);
        $this->db->delete($this->tb_area,$cond);
        $this->db->delete($this->tb_type,$cond);
        $this->db->delete($this->tb_assoc,$cond);
        $this->db->delete($this->tb_faq,$cond);
        return true;
    }
    
    
    protected function checkForm($data){
        $this->load->library('valid');
        $this->valid->set_rule_array(array(
            's_name,请填写服务名称,required',
            's_price,服务价格有误,required|numeric|min[0]',
            'city_id,服务城市有误,required',
            'scid,请选择服务分类,required|natint',
            'hot,今日推荐参数有误,required|in[0-1]',
            'home,首页展示参数有误,required|in[0-1]',
            'weight,权重填写有误,numeric|min[0]'
        ));
        if(!$this->valid->run($data)){
            $errors = $this->valid->get_error();
            throw new Exception($errors[0]['msg']);
        }
    }

    //检测服务是否存在
    public function isExists($sid=null){
        $sql = "SELECT COUNT(*) AS count_number from $this->tb WHERE sid='$sid'";
        if(!is_natural($sid) or $this->db->query($sql)->row()->count_number==='0'){
            return false;
        }
        return true;
    }


    //检查服务分类是否存在
    public function isExistsCate($scid=null){
        $sql = "SELECT COUNT(*) AS count_number from $this->tb_cate WHERE scid='$scid'";
        if(!is_natural($scid) or $this->db->query($sql)->row()->count_number==='0'){
            return false;
        }
        return true;
    }
    
    //获取服务导航
    public function getServiceNav($city_id=0,$pscid=0){
        $data = $this->db->select('*')->from($this->tb_cate)->where("pscid='0'")->order('scid ASC')->query()->all_array();
        foreach($data as $key=>$row){
            $cond = "pscid='{$row['scid']}'";
            $data[$key]['children'] = $this->db->select('*')->from($this->tb_cate)->where($cond)->order('weight DESC')->query()->all_array();
        }
        return $data;
    }
    
    
}