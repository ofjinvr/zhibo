<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 主体文件
// +-----------------------

//全局函数
require LOCAL_SYSTEM.'core/common.php';

//载入配置文件并实例化一个对象
load('application/config','Config');

//设置运行环境模式
if(Config::APP_DEBUG === true){
    ini_set('display_errors', 'On');  
    error_reporting(E_ALL);
}else{
    error_reporting(0);
}

//设置PHP执行时间
set_time_limit(Config::PHP_TIME_OUT);

//设置时区
date_default_timezone_set(Config::TIMEZONE);

//核心模块 - 仅载入文件
load('system/core','Travel');       //底层资源模块映射表
load('system/core','Fetch');        //资源读取器
load('system/core','Loader');       //功能模块载入器

load('system/core','Safe');         //载入安全模块
load('system/core','Input');        //载入输入模块
load('system/core','Session');      //载入会话模块
load('system/core','Cookie');       //载入临时储存模块
//load('system/language','Language'); //载入语言包模块



/**
 * 载入语言包 (预留 以后开发)
 * $language = load_class('system/language','Simplified_chinese');
 */

/**
 * 此处进行路由器的解析,路由器会生成一个数组; 数组结构:
 * 第一个元素是访问的控制器类名;
 * 第二个参数是访问的控制器方法名;
 * 第三个开始,往后的所有元素将作为参数传入控制器的方法内;
 */
$router = load_class('system/core','Router');
//根据路由模式解析,获得控制器的名称,方法和参数数组
$mapping = $router->routing();

//访问的控制器的类名
$controller_name = array_shift($mapping);
//如果控制器名字是访问资源,表示真实地址无资源引发了重写,显示404;
if($controller_name==='resource' && !is_file(LOCAL_APP.'controller/resource.php')){
    no_found();
}
//访问的控制器方法名
$controller_method = array_shift($mapping);
//控制器的目录
$controller_dir = array_pop($mapping);
/**
 * 使用由路由器解析出的控制器名和方法名,载入APP层控制器并访问其方法
 * 所有的APP控制器都继承自一个Fetch的父类
 * Fetch类中有两个核心的属性:
 * -load:存放一个载入器对象,使用载入器可以载入框架中的model,database,library,func,view等模块中的类
 * -input:存放一个获取用户输入信息的对象,可以得到POST,GET,SESSION,COOKIE等由用户提交的信息
 */
$controller = load_class($controller_dir,$controller_name);

//检查控制器方法存在
if(method_exists($controller,$controller_method)){
    //反射判断方法是否公有
    $reflection_method = new ReflectionMethod($controller_name, $controller_method);
    if($reflection_method->isPublic()===false){
        no_found();
    }
}else if(!method_exists($controller,'__call')){
    no_found();
}

/**
 * 调用APP层控制器的方法开启访问页面
 */
call_user_func_array(array($controller,$controller_method),$mapping);

