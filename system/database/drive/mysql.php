<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | MYSQL数据库驱动
// +-----------------------

class Mysql{
    //数据库实例化对象
    static private $ins;
    //PDO对象
    private $pdo;
    //数据库查询结果集封装对象
    private $db_statement;
    //连接类型
    const JOIN_LEFT=1;
    const JOIN_INNER=2;
    const JOIN_OUTER=3;
    
    //数据库查询属性
    public $select;
    public $from;
    public $join = array();
    public $where;
    public $group;
    public $order;
    public $limit;
    
    /**
     * 链接数据库,生成一个PDO对象
     */
    private function __construct() {
        //尝试链接数据库
        try {
            if(!$this->pdo instanceof PDO){
                //读取配置文件设置,连接数据库
                $dsn = Config::DATABASE.':host='.Config::DB_HOST.';port='.Config::DB_PROT.';dbname='.Config::DB_NAME;
                $options = array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                );
                $this->pdo  = new PDO($dsn, Config::DB_UNAME, Config::DB_PWD, $options);
            }
        } catch (PDOException $exc) {
            $title = '数据库链接失败';
            $content = '错误: '.$exc->getMessage().'<br>路径: '.$exc->getFile();
            show_msg($title, $content);
        }
        //如果数据库链接成功则实例化一个数据库查询数据处理类
        load('system/database','db_statement');
        $this->db_statement = Db_statement::get_instance();
        //设置字符集
        $this->pdo->prepare('set names utf8')->execute();
    }
    
    
    /**
     * 实例化本类返回本类的实例化对象
     * @return ins
     */
    static function get_instance(){
        if(!self::$ins instanceof self){
            self::$ins = new self;
        }
        return self::$ins;
    }
    
    
    /**
     * 基本查询方法
     */
    public function query($sql = null){
        //如果没有参数SQL,则按照链式语法解析
        if(is_null($sql)){
            if(empty($this->from)){
                return false;
            }
            if(empty($this->select)){
                $this->select = '*';
            }
            $sql = 'select '.$this->select;
            $sql.= ' from '.$this->from;
            if(!empty($this->join)){
                foreach ($this->join as $value){
                    $sql.= ' '.$value;
                }
            }
            if(!empty($this->where)){
                $sql.=' where '.$this->where;
            }
            if(!empty($this->group)){
                $sql.=' group by '.$this->group;
            }
            if(!empty($this->order)){
                $sql.=' order by '.$this->order;
            }
            if(!empty($this->limit)){
                $sql.=' limit '.$this->limit;
            }
            $this->select=$this->from=$this->where=$this->order=$this->group=$this->order=$this->limit=null;
            $this->join = array();
        }
        try {
            $this->db_statement->pdo_statement = $this->pdo->query($sql);
        } catch (Exception $exc) {
            $title = 'SQL语句查询失败';
            if(Config::APP_DEBUG===true){
                $content = '信息: '.$exc->getMessage().'<br>文件: '.$exc->getFile().' 行数:'.$exc->getLine().'<br>语句: '.$sql;
            }else{
                $content = '信息:SQL语句查询失败,请联系管理员';
            }
            show_msg($title, $content);
        }
        
        return $this->db_statement;
    }
    
    
    /**
     * 获得最后一个插入的id
     */
    public function insert_id($column_name=null){
        return $this->pdo->lastInsertId($column_name);
    }
    
    
    /**
     * 执行一个SQL语句,返回影响的行数
     */
    public function exec($sql){
        try {
            return $this->pdo->exec($sql);
        } catch (Exception $exc) {
            $title = 'SQL语句执行失败';
            $content = '信息: '.$exc->getMessage().'<br>文件: '.$exc->getFile().' 行数:'.$exc->getLine().'<br>语句: '.$sql;
            show_msg($title, $content);
        }
    }
    
    
    /**
     * 设置select属性值,一般为查询的字段名称
     */
    public function select($select='*'){
        $this->select = $select;
        return $this;
    }
    
    
    /**
     * 设置from属性值
     * @param string $from 一般为查询的表名,可用逗号分割
     */
    public function from($from){
        $this->from = $from;
        return $this;
    }
    
    
    /**
     * 设置join属性值
     * @param mix $join 链接的表名和条件表达式
     * @param mix $on 连接的表名 on 条件
     * @param mix $type 可选-链接的方式 默认左链接
     */
    public function join($join,$on,$type=self::JOIN_LEFT){
        switch ($type){
            case self::JOIN_LEFT:
                $join_type='left join';
                break;
            case self::JOIN_INNER:
                $join_type='inner join';
                break;
            default :
                $join_type='outer join';
        }
        array_push($this->join, $join_type.' '.$join.' on '.$on);
        return $this;
    }
    
    
    /**
     * 设置where属性值
     * @param string $where 一般为查询的条件表达式,可用逗号分割
     */
    public function where($where){
        $this->where = $where;
        return $this;
    }
    
    
     /**
     * 设置group属性值
     * @param string $group 一般为按照该字段分组
     */
    public function group($group){
        $this->group = $group;
        return $this;
    }
    
    
    /**
     * 设置order属性值
     * @param string $order 一般为查询排序的字段
     */
    public function order($order){
        $this->order = $order;
        return $this;
    }
    
    
    /**
     * 设置limit属性值
     * @param string $limit 一般为查询排序的字段
     */
    public function limit($limit){
        $this->limit = $limit;
        return $this;
    }
    
    /**
     * 插入一条数据
     * @param string $table 插入的表名
     * @param array $data 插入的数据
     * @return int 影响的行数
     */
    public function insert($table,$data){
        if(!is_array($data) || empty($data)){
            return false;
        }
        $columns='';
        $values='\'';
        foreach($data as $key => $value){
            $columns .= $key.',';
            $values .= $value.'\',\'';
        }
        $columns = rtrim($columns,',');
        $values = substr($values,0,strrpos($values,','));
        $sql = 'insert into '.$table.'('.$columns.') values('.$values.')';
        try {
            return $this->exec($sql);
        } catch (PDOException $exc) {
            $title = '数据插入失败';
            $content = '信息: '.$exc->getMessage().'<br>文件: '.$exc->getFile().' 行数:'.$exc->getLine().'<br>语句: '.$sql;
            show_msg($title, $content);
        }
    }
    
    
    /**
     * 更改一条数据
     * @param string $table 更改的表名
     * @param array $data 更新的数据
     * @param string $where 条件表达式
     */
    public function update($table,$data,$where='1'){
        if(!is_array($data) || empty($data)){
            return false;
        }
        $sql = 'update '.$table.' set ';
        foreach($data as $key => $value){
            $sql .= $key.'=\''.$value.'\',';
        }
        $sql = rtrim($sql,',');
        $sql .= ' where '.$where;
        try {
            return $this->exec($sql);
        } catch (PDOException $exc) {
            $title = '数据更改失败';
            $content = '信息: '.$exc->getMessage().'<br>文件: '.$exc->getFile().' 行数:'.$exc->getLine().'<br>语句: '.$sql;
            show_msg($title, $content);
        }
    }
    
    
    /**
     * 删除数据
     * @param string $table 更改的表名
     * @param string $where 条件表达式
     */
    public function delete($table,$where='1'){
        $sql = 'delete from '.$table.' where '.$where;
        try {
            return $this->exec($sql);
        } catch (PDOException $exc) {
            $title = '数据删除失败';
            $content = '信息: '.$exc->getMessage().'<br>文件: '.$exc->getFile().' 行数:'.$exc->getLine().'<br>语句: '.$sql;
            show_msg($title, $content);
        }
    }
    
    
}