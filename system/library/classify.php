<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

// +-----------------------
// | 栏目无限极分类 
// +-----------------------

class Classify{
    
    protected $id;
    protected $pid;
    protected $data;
    protected $result;
    
    /**
     * 初始化
     * @param string $id  自身id的数组字段名
     * @param string $pid 父级的id的数组字段名
     */
    public function __construct($id='id',$pid='pid') {
        $this->id  = $id;
        $this->pid = $pid;
        $this->data = array();
        $this->result = array();
    }
    
    
    /**
     * @param array $data 数据
     */
    public function setdata($data){
        if(!is_array($data)){
            throw new Exception('Classify数据需要一个数组');
        }
        foreach($data as $row){
            if(!is_array($row) or !isset($row[$this->id]) or !isset($row[$this->pid])){
                throw new Exception('Classify数据内容有误');
            }
        }
        $this->data = $data;
    }
    
    
    
    /**
     * 查找某个ID的子集
     * @param int $id id值
     */
    public function subsets($id=0){
        $id = abs(intval($id));
        foreach($this->data as $row){
            if($row[$this->pid] == $id){
                $this->result[] = $row;
                $this->subsets($row[$this->id]);
            }
        }
        return $this->result;
    }
    
    
    /**
     * 查找某个ID的子元素
     * @param int $id id值
     */
    public function sons($id=0){
        $id = abs(intval($id));
        foreach($this->data as $row){
            if($row[$this->pid] == $id){
                $this->result[] = $row;
            }
        }
        return $this->result;
    }
    
    
    /**
     * 查询根级到某ID的线路节点
     * @param int $id id值
     */
    public function nodes($id=0){
        $id = abs(intval($id));
        foreach($this->data as $key => $row){
            if($row[$this->id]==$id){
                $this->result[] = $row;
                $this->result = $this->nodes($row[$this->pid]);
            }
        }
        return $this->result;
    }
    
    
    /**
     * 查询某个ID的父级
     * @param int $id id值
     */
    public function parent_node($id=0){
        $id = abs(intval($id));
        foreach($this->data as $row){
            if($row[$this->id]==$id){
                $pid = $row[$this->pid];
                break;
            }
        }
        if(!empty($pid)){
            foreach($this->data as $row){
                if($row[$this->id]===$pid){
                    return $row;
                }
            }
        }   
    }
    
}