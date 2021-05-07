<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | COOKIE操作类
// +-----------------------

class Cookie{
    private static $ins;
    private $safe;
    
    private function __construct(){
        $this->safe = Safe::get_instance();
    }
    
    
    /**
     * 设置一个COOKIE
     */
    public function set($name,$value,$time,$path='/',$domain=null,$secure=null){
        if(empty($name) || !is_numeric($time)){
            return false;
        }
        setcookie($name,$value,time()+$time,$path,$domain,$secure);
    }
    
    /**
     * 读取COOKIE
     */
    public function get($var=null,$safe=false){
        if(empty($_COOKIE[$var])){
            return null;
        }
        if(is_null($var)){
            if($safe===true){
                return $this->safe->clear_xss_array($_COOKIE);
            }
            return $_COOKIE;
        }
        if(!empty($var) && !empty($_COOKIE[$var])){
            if($safe===true){
                return $this->safe->clear_xss($_COOKIE[$var]);
            }
            return $_COOKIE[$var];
        }
    }
    
    /**
     * 清除一个COOKIE
     */
    public function clear($name){
        setcookie($name,null,0);
    }
    
    
    
    static public function get_instance(){
        if(!self::$ins instanceof self){
            self::$ins = new self();
        }
        return self::$ins;
    }
}