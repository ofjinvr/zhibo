<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

/**
 * 公用的表模型,用于简单增删改查操作
 */

class Public_model extends Fetch{
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    
    /**
     * 增加一条数据
     * @param string $tablename 插入数据的表名称
     * @param array $data 插入表中的数据内容,需要一个关联数组
     */
    public function add($tablename,$data){
        if($this->db->insert($tablename,$data)===1){
            return $this->db->insert_id();
        }else{
            return false;
        }
    }
    
    
    /**
     * 修改一条数据
     * @param string $tablename 数据的表名称
     * @param array $data 修改表中的数据内容,需要一个关联数组
     * @param string $cond 修改条件表达式
     */
    public function edit($tablename,$data,$cond=null){
        if(is_null($cond)){return false;} //防止误操作,必有条件
        if($this->db->update($tablename,$data,$cond) !== false){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * 删除一条数据
     * @param string $tablename 数据的表名称
     * @param string $cond 删除的条件表达式
     */
    public function delete($tablename,$cond=null){
        if(is_null($cond)){return false;} //防止误操作,必有条件
        if($this->db->delete($tablename,$cond)>0){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * 简单查询多条数据
     * @param string $tablename 数据的表名称
     * @param string $column 要查询的字段名
     * @param string $cond 查询条件表达式
     * @param string $order 排序
     * @param string $limit 查询的数目和位置 默认10条
     */
    public function get($tablename,$column='*',$cond=null,$order=null,$limit=null){
        $query = $this->db->select($column)->from($tablename);
        
        if(!empty($cond)){
            $query->where($cond);
        }
        if(!empty($order)){
            $query->order($order);
        }
        if(!empty($limit)){
            $query->limit($limit);
        }
        return $query->query()->all_array();
    }
    
    
    /**
     * 简单查询一条数据
     * @param string $tablename 数据的表名称
     * @param string $column 要查询的字段名
     * @param string $cond 查询条件表达式
     */
    public function one($tablename,$column,$cond,$order=null){
        return $this->db->select($column)
                    ->from($tablename)
                    ->where($cond)
                    ->order($order)
                    ->query()
                    ->row_array();
    }
    
    
    /**
     * 查询表中一共有多少条数据
     */
    public function get_count($tablename,$cond=''){
        $sql = 'select count(*) as amount from '.$tablename;
        $sql.= !empty($cond) ? " where $cond" : '';
        return $this->db->query($sql)->row($sql)->amount;
    }
    
    
    /**
     * 查询某ID在某表中是否存在
     * @param string $tablename 
     */
    public function in_table($tablename,$key,$value){
        $num = $this->db->query("select count(*) as num from $tablename where $key='$value'")->row()->num;
        return $num>0 ? true : false;
    }
    
    
    /**
     * 自增等数学运算
     */
    public function math($tablename,$cloumn,$number=0,$cond=null){
        if(is_null($cond)){return false;} //防止误操作,必有条件
        if($this->db->exec("update $tablename set $cloumn = $cloumn + $number where $cond") !== false){
            return true;
        }else{
            return false;
        }
    }
    

}