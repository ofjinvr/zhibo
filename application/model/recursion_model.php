<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

/**
 * 递归查询模型
 * 地区等多级查询用
 */
class Recursion_model extends Fetch{
    
    private $table;
    private $idname;
    private $pidname;
    
    /**
     * 初始化
     * @param array $config
     *      $config[table] 表名
     *      $config[idname] ID列名称
     *      $config[pidname] 父ID列名称
     */
    public function __construct($config) {
        parent::__construct();
        $this->load->database();
        if(!is_array($config)
            or empty($config['table'])
            or empty($config['idname'])
            or empty($config['pidname']))
        {   
            trigger_error('Recursion_model初始化失败,配置格式有误',E_USER_ERROR);
            return null;
        }
        $table = $this->db->query("show tables like '{$config['table']}'")->all_array();
        if(empty($table)){
            trigger_error('Recursion_model初始化失败,找不到数据表'.$config['table'],E_USER_ERROR);
        }
        $desc = $this->db->query("desc `{$config['table']}`")->all_array();
        foreach($desc as $row){
            if(!empty($row['Field'])){
                $field[] = $row['Field'];
            }
        }
        if(!in_array($config['idname'],$field) or !in_array($config['pidname'],$field)){
            trigger_error('Recursion_model初始化失败,无法在数据库表中找到匹配字段',E_USER_ERROR);
            return null;
        }
        $this->table = $config['table'];
        $this->idname = $config['idname'];
        $this->pidname = $config['pidname'];
    } 
    
    
    /**
     * 查询某个元素的子元素
     */
    public function children($id=0,$order=null,$limit=null){
        $id = intval($id);
        return $this->db->select('*')
                ->from($this->table)
                ->where("$this->pidname='$id'")
                ->order($order)
                ->limit($limit)
                ->query()
                ->all_array();
    }
    
    
    /**
     * 查同级元素
     */
    public function siblings($id=0,$order=null,$limit=null){
        $id=intval($id);
        if($id>0){
            $pidname = $this->pidname;
            $pid = $this->db->select($pidname)
                    ->from($this->table)
                    ->where("$this->idname='$id'")
                    ->query()
                    ->row()
                    ->$pidname;
            return $this->db
                    ->from($this->table)
                    ->where("$this->pidname='$pid'")
                    ->order($order)
                    ->limit($limit)
                    ->query()
                    ->all_array();
        }else{
            return array();
        }
        
    }
    
    
    /**
     * 查询某个元素的所有后裔
     */
    public function descendant($id=0){
        $task = array(intval($id));
        $descendant = array();
        $key = null;
        do{
            $current_id = array_shift($task);
            //查询任务队列的第一个元素
            $children = $this->children($current_id);
            //查询位置索引
            foreach($descendant as $key=>$row){
                if($row[$this->idname]===$current_id){
                    break;
                }
            }
            foreach($children as $row){
                if(is_null($key)){
                    array_push($descendant, $row);
                }
                if(is_int($key)){
                    array_splice($descendant, $key+1, 0, array($row));
                }
//                array_push($descendant,$row);
                array_push($task, $row[$this->idname]);
            }
            
        }while(!empty($task));
        return $descendant;
    }
    
    
    /**
     * 查询某个元素到最上级的族谱树
     */
    public function tree($id=0){
        $tree = array();
        $id = intval($id);
        while($id!==0){
            $current = $this->get($id);
            array_unshift($tree, $current);
            $id = intval($current[$this->pidname]);
        }
        return $tree;
    }
    
    
    /**
     * 批量插入数据到某个父元素下
     * @param array $data
     * @param int $pid
     */
    public function multi_add($data,$pid=0){
        
    }
    
    
    /**
     * 删除某个ID以及他的所有后裔
     */
    public function multi_del($id=0){
        
    }
    
    
    public function get($id){
        $id = intval($id);
        return $this->db->select('*')
                ->from($this->table)
                ->where("$this->idname='$id'")
                ->query()
                ->row_array();
    }
    
    
    
    
}
