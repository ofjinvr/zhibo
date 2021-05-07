<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +----------------------------
// | 底层资源映射读取器
// +----------------------------

// 控制器非直接继承Travel资源类,使用读取器存在的意义:
// 1: 在初始化Travel之前,Travel::load属性为null值,固无法直接使用控制器的初始化完成实例化载入器
// 2: 限制了直接改写底层资源的情况,提升安全性;
// Fetch的作用即延迟载入操作,待Travel的初始化操作完毕,Travel对象已经生成,再执行控制器的初始化和载入操作
// 例如:
// 当控制器使用$this->load->config();
// 载入配置文件时,在Travel::_construct()执行时,Travel::load的(此时此刻)值为空,因此在控制器的__construct方法体中无法使用load载入器;
// 使用此读取器,在控制器实例化时,Travel::_construct()方法已经完成,固可以直接在控制器的_construct()方法体中使用载入器.

class Fetch{
    //资源映射的单例引用,APP层的控制器和模型可通过此属性共享Travel的单例功能模块
    private $travel; 
    //初始化读取器
    public function __construct() {
        $this->travel = Travel::get_instance();
    }
    
    /**
     * 将控制器或者模块中用于读取本对象的操作绑定到资源映射表中
     * @param string $name 属性名称
     * @return object
     */
    public function __get($name) {
        return $this->travel->$name;
    }
    
    
    /**
     * 通过单例模式获取读取器对象,可以返回资源映射的单一实例化对象
     * 在非继承Fetch环境中使用此方法可以得到一个实例化对象
     */
    static public function get_instance(){
        return Travel::get_instance();
    }
}