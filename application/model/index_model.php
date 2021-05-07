<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


class Index_model extends Fetch{
    
    protected $catable = 'td_category';
    protected $artable = 'td_article';
    protected $logtable = 'td_pushurl_log';


    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    public function get_pushurl_list($push_var){
        
        switch($push_var){
                case '1':
                    $catelist = $this->db->query("select cid from $this->catable where cid not in(select typeid from $this->logtable where ptype='c')")->all_array();
                    $arclist = $this->db->query("select aid,cid from $this->artable where aid not in(select typeid from $this->logtable where ptype='a')")->all_array();
                    $list = array_merge($catelist,$arclist);
                    break;
                case '2':
                    $list = $arclist = $this->db->query("select aid,cid from $this->artable where reltime>now()-3600*24")->all_array();
                    break;
                default :
                    $catelist = $this->db->query("select cid from $this->catable")->all_array();
                    $arclist = $this->db->query("select aid,cid from $this->artable")->all_array();
                    $fixedlist = array('','index/about','index/join','xinhu/nzjh','xinhu/dljz','xinhu/zcgs','xinhu/dbzz','xinhu/hd','xinhu/szhy');
                    $list = array_merge($catelist,$arclist,$fixedlist);
            }
            return $list;
            
    }
    
   

}