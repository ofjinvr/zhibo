<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Area_model extends Fetch{
    
    private $tb = 'td_area';
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    public function get_arealist($parent_id='0',$field='*'){
        $parent_id = intval($parent_id);
        $sql = "select $field from $this->tb where parentid='$parent_id' order by id";
        return $this->db->query($sql)->all_array();
    }
    
    
}