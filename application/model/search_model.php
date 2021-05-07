<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');
//SQL_CALC_FOUND_ROWS
class Search_model extends Fetch{

    private $tb = 'td_service';
    private $tb2 = 'td_article';
    private $tb_city = 'td_city';
    
    public function __construct() {
        parent::__construct();
        $this->load->library('bosonnlp');
        $this->load->database();
    }
    
    
    public function search($kw,$type,$city_id){
        try {
            $splitter = $this->bosonnlp->splitter($kw)[0]->word;
        } catch (Exception $exc) {
            $splitter = array($kw);
        }
//        print_r($splitter);
        $cond= [];
        //做一个简单的排序权重
        $diff= [];
        if($type==='1'){
            foreach($splitter as $row){
                $cond[] = "s_name like '%$row%'";
                $diff[] = "SIGN(LOCATE('$row',s_name))";
            }
            $sql_count = "select COUNT(*) AS nums from $this->tb where city_id='$city_id' and (".implode(' or ', $cond).')';
            $this->load->library('paging',20,$this->db->query($sql_count)->row()->nums);
            $data['page'] = $this->paging->info();
            $sql = "select sid,s_name,s_price,s_depict,pageview,s_pictrue,(".implode('+',$diff).") as rn from $this->tb where city_id='$city_id' and (".implode(' or ', $cond).") order by rn desc,pageview desc limit {$data['page']['cursor']}";
//            echo $sql;
            $data['list'] = $this->db->query($sql)->all_array();
            foreach($data['list'] as $key => $row){
                foreach($splitter as $kw){
                    $row['s_name'] = str_replace($kw, "<font color='red'>$kw</font>", $row['s_name']);
                }
                $data['list'][$key]['s_name_html'] = $row['s_name'];
            }
        }
        
        if($type==='2'){
            foreach($splitter as $row){
                $cond[] = "title like '%$row%'";
                $diff[] = "SIGN(LOCATE('$row',title))";
            }
            $sql_count = "select COUNT(*) AS nums from $this->tb2 where city_id='$city_id' and (".implode(' or ', $cond).')';
            $this->load->library('paging',20,$this->db->query($sql_count)->row()->nums);
            $data['page'] = $this->paging->info();
            $sql = "select aid,$this->tb2.cid,cname,url_word,title,$this->tb2.meta_keywords,summary,browse_number,picture,reltime,(".implode('+',$diff).") as rn from $this->tb2 left join td_category on td_category.cid=$this->tb2.cid where city_id='$city_id' and (".implode(' or ', $cond).") order by rn desc limit {$data['page']['cursor']}";
//            echo $sql;
            $data['list'] = $this->db->query($sql)->all_array();
            foreach($data['list'] as $key => $row){
                foreach($splitter as $kw){
                    $row['title'] = str_replace($kw, "<font color='red'>$kw</font>", $row['title']);
                }
                $data['list'][$key]['title_html'] = $row['title'];
            }
//            print_r($data);
        }
        return $data;
    }
    
}