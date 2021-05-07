<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


class Article_model extends Fetch{
    
    protected $catable = 'td_category';
    protected $artable = 'td_article';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    
    public function get_article_list($cursor,$cid=null,$city_id=null){
        $cid = intval($cid);
        $city_id = intval($city_id);
        if($cid>0){
            $cond = "$this->artable.cid='$cid' and CURRENT_TIMESTAMP>efftime";
        }else{
            $cond = 'CURRENT_TIMESTAMP>efftime';
        }
        if(is_numeric($city_id)){
            $city_id = intval($city_id);
            $cond .= " and $this->artable.city_id='$city_id'";
        }
        $sql = "select $this->artable.*,$this->catable.cname,$this->catable.url_word,td_city.city_name "
                . "from $this->artable "
                . "left join $this->catable on $this->artable.cid = $this->catable.cid "
                . "left join td_city on td_city.city_id=$this->artable.city_id "
                . "where $cond order by ishot desc,reltime desc limit $cursor";
        return $this->db->query($sql)->all_array();
    }
    
    
    //根据条件查询文章列表
    public function get_article_list_fixed($cond,$cursor,$city_id=null){
        $cond = trim($cond);
        if(!empty($cond)){
            $cond = "$cond and CURRENT_TIMESTAMP>efftime";
        }else{
            $cond = 'CURRENT_TIMESTAMP>efftime';
        }
        if(is_numeric($city_id)){
            $city_id = intval($city_id);
            $cond .= " and $this->artable.city_id='$city_id'";
        }
        $sql = "select $this->artable.*,$this->catable.cname,$this->catable.url_word,city_name,city_site "
                . "from $this->artable "
                . "left join $this->catable on $this->artable.cid = $this->catable.cid "
                . "left join td_city on td_city.city_id=$this->artable.city_id "
                . "where $cond order by reltime desc limit $cursor";
        return $this->db->query($sql)->all_array();
    }
    

    public function get_article($aid){
        $aid=intval($aid);
        $cond = "$this->artable.aid='$aid'' and CURRENT_TIMESTAMP>efftime";
        return $this->db->select("$this->artable.*,$this->catable.cname,url_word")
            ->from($this->artable)
            ->join($this->catable,"$this->catable.cid=$this->artable.cid")
            ->where("aid='$aid'")
            ->query()->row_array();
    }


    public function get_prev_article($aid,$cid,$city_id){
        $aid=intval($aid);
        for($i=$aid-1;$i>0;$i--){
            $cond = "aid='$i' and $this->artable.cid='$cid' and city_id='$city_id' and CURRENT_TIMESTAMP>efftime";
            $num = $this->db->query("select COUNT(*) AS num from $this->artable where $cond")->row()->num;
            if($num>0){
                break;
            }
        }
        return $this->db->select('aid,title,url_word')
                ->from($this->artable)
                ->join($this->catable,"$this->artable.cid=$this->catable.cid")
                ->where($cond)
                ->query()
                ->row_array();
    }


    //最热
    public function top($city_id=null){
        $cond = !empty($city_id) ? "istop='1' and city_id='$city_id'" : "istop='1'";
        return $this->db->select("aid,$this->artable.cid,title,url_word")
            ->from($this->artable)
            ->join($this->catable, "$this->artable.cid=$this->catable.cid")
            ->where($cond)
            ->order("browse_number desc")
            ->limit('0,6')
            ->query()
            ->all_array();
    }


    //右侧最新
    public function newest($city_id=null){
        $cond = !is_null($city_id) ? "city_id='$city_id'" : null;
        $data = $this->db->select("aid,$this->artable.cid,url_word,title,UNIX_TIMESTAMP(reltime) as reltime")
            ->from($this->artable)
            ->join($this->catable, "$this->artable.cid=$this->catable.cid")
            ->where($cond)
            ->order("aid desc")
            ->limit('0,5')
            ->query()
            ->all_array();

        foreach($data as $key => $row){
            $t = time();
            $diff = $t-$row['reltime'];
            if($diff<0){
                $data[$key]['reltime'] = '穿越了';
                continue;
            }
            if($diff<60){
                $data[$key]['reltime'] = '刚刚';
                continue;
            }
            if($diff<3600){
                $data[$key]['reltime'] = intval($diff/60).'分钟前';
                continue;
            }
            if($diff<(3600*24)){
                $data[$key]['reltime'] = intval($diff/3600).'小时前';
                continue;
            }
            if($diff<(3600*24*365)){
                $data[$key]['reltime'] = intval($diff/3600/24).'天前';
                continue;
            }
            $data[$key]['reltime'] = intval($diff/3600/24/365).'年前';
        }
        return $data;
    }
    
    
}