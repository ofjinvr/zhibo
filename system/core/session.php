<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | SESSION操作类
// +-----------------------

class Session{
    
    static private $ins;
    
    private function __construct() {
        //开启会话
        if(!isset($_SESSION)){
            ini_set('session.gc_maxlifetime', 28800);
            ini_set('cookie_lifetime', 28800);
            session_start();
        }
    }
    
    /**
     * 设置SESSION的值
     * 可接收参数:数组,字符串lifetime
     */
    public function set_userdata(){
        $args = func_get_args();
        if(is_array($args[0])){
            foreach ($args[0] as $key => $value){
                $_SESSION['userdata'][$key] = $value;
            }
            return true;
        }
        if(!empty($args[0]) && is_string($args[0]) && isset($args[1])){
            $_SESSION['userdata'][$args[0]] = $args[1];
            return true;
        }
        return false;
    }
    
    
    /**
     * 获取SESSION中用户设置的的值
     */
    public function get_userdata($var=null){
        if(isset($_SESSION['userdata'][$var])){
            return $_SESSION['userdata'][$var];
        }else{
            return null;
        }
    }
    
    
    /**
     * 获取SESSION的值
     */
    public function get($var=null){
        if(isset($_SESSION[$var])){
            return $_SESSION[$var];
        }else{
            return null;
        }
    }
    
    /**
     * 判断是否定义了SESSION的属性
     */
    public function isset_userdata($var){
        if(!empty($_SESSION['userdata'][$var])){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * 获取SESSION_ID
     */
    public function id(){
        return session_id();
    }
    
    
    //销毁一个SESSION会话
    public function destroy(){
        if(session_destroy()){
            return true;
        }else{
            return false;
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