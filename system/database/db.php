<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 数据库访问模块
// +-----------------------

class Db{
    //数据库实例化对象
    static private $ins;
    //数据库驱动
    private $db_drive;

    /**
     * 连接数据库驱动
     */
    private function __construct() {
        $drive_name = ucfirst(Config::DATABASE);
        load('system/database/drive',$drive_name);
        $this->db_drive = call_user_func(array($drive_name,'get_instance'));
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
     * 数据库驱动参数读取方法
     */
    public function __get($name) {
        return $this->db_drive->$name;
    }
    
    
    /**
     * 数据库驱动参数读取方法
     */
    public function __set($name,$value) {
        $this->db_drive->$name=$value;
    }
    
    
    /**
     * 数据库驱动方法调用
     */
    public function __call($method_name,$arguments) {
        return call_user_func_array(array($this->db_drive,$method_name),$arguments);
    }
    
}