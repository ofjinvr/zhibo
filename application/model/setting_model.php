<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

class Setting_model extends Fetch{
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    //查询是否存在设置
    public function get_count(){
        $sql = 'select count(*) as num from trl_setting';
        return $this->db->query($sql)->row()->num;
    }
    
    
    //新插入一条设置
    public function add($data){
        return $this->db->insert('trl_setting',$data);        
    }
    
    //查询出所有的设置选项
    public function seach(){
        return $this->db->query('select * from trl_setting')->row_array();
    }
    
    //更改设置
    public function edit($data){
        return $this->db->update('trl_setting',$data);
    }
}
