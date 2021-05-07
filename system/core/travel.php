<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 底层资源映射表
// +-----------------------

class Travel{
    
    static private $ins;
    public $load;
    
    protected function __construct() {
        //加载功能模块
        $this->load = Loader::get_instance();
        $this->input = Input::get_instance();
        $this->session = Session::get_instance();
        $this->cookie = Cookie::get_instance();
        //Loader载入器属性中存在一个travel实例化对象,用来引用(对象传递方式为引用传值)本资源映射的实例化对象
        $this->load->travel($this);
    }
    
    //单例-资源初始化
    static public function get_instance(){
        if(!self::$ins instanceof self){
            self::$ins =  new self;
        }
        return self::$ins;
    }
    
}