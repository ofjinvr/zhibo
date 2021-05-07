<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 数据库返回数据处理
// +-----------------------
class Db_statement{
    static private $ins;
    
    //上次查询的PDO结果集
    public $pdo_statement;
    
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
     * 返回一条查询的结果集 - 对象
     */
    public function row(){
        return $this->pdo_statement->fetch(PDO::FETCH_OBJ);
    }
    
    
    /**
     * 返回一条查询的结果集 - 数组
     */
    public function row_array(){
        return $this->pdo_statement->fetch(PDO::FETCH_ASSOC);
    }
    
    
    /**
     * 返回查询的结果集 - 对象
     */
    public function all(){
        return $this->pdo_statement->fetchAll(PDO::FETCH_OBJ);
    }
    
    
    /**
     * 返回查询的结果集 - 数组
     */
    public function all_array(){
        return $this->pdo_statement->fetchAll(PDO::FETCH_ASSOC);
    }
}
