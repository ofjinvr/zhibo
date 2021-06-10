<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 用户输入操作类
// +-----------------------

class Input{
    
    static private $ins;
    private $safe;
    
    private function __construct() {
        //关闭魔术引号功能,在5.3以下环境兼容
        if (get_magic_quotes_gpc()) {
            $_POST = array_map('stripslashes_deep', $_POST);
            $_GET = array_map('stripslashes_deep', $_GET);
            $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
            $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
        }

        $_POST = array_map('addslashes_deep', $_POST);
        $_GET = array_map('addslashes_deep', $_GET);
        $_COOKIE = array_map('addslashes_deep', $_COOKIE);
        $_REQUEST = array_map('addslashes_deep', $_REQUEST);
        //加载安全模块
        $this->safe = Safe::get_instance();
    }
    
    
    /**
     * 获取GET提交的的数据
     * @param string $property GET提交数据数组中的某一项
     * @param bool $safe 是否使用XSS安全过滤
     */
    public function get($property = null,$safe = false){
        $get = $safe === true ? $this->safe->clear_xss_array($_GET) : $_GET;
        if(!empty($property)){
            return !isset($get[$property]) ? null : $get[$property];
        }else{
            return $get;
        }
    }
    
    
    /**
     * 获取POST提交的的数据
     * @param string $property POST提交数据数组中的某一项
     * @param bool $safe 是否使用XSS安全过滤
     */
    public function post($property = null,$safe = false){
        $post = $safe === true ? $this->safe->clear_xss_array($_POST) : $_POST;
        if(!empty($property)){
            return !isset($post[$property]) ? null : $post[$property];
        }else{
            return $post;
        }
    }
    
    
    /**
     * 获取本类对象
     */
    static public function get_instance(){
        if(!self::$ins instanceof self){
            self::$ins = new self();
        }
        return self::$ins;
    }

}