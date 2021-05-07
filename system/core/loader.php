<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 类库载入器
// +-----------------------

class Loader{
    
    //本类对象
    static private $ins;
    //存放资源映射表的引用
    private $travel;
    
    //path目录
    private $config_path = 'application/config';
    private $model_path = 'application/model';
    private $view_path = 'application/view';
    private $app_func_path = 'application/func';
    private $sys_func_path = 'system/func';
    private $app_library_path = 'application/library';
    private $sys_library_path = 'system/library';
    private $db_path = 'system/database';
    
    /**
     * 核心方法:将资源映射的引用绑定到载入器属性$travel上,使得载入器可以往资源映射表中添加功能模块
     * @param object $travel Travel资源映射表的实例引用
     */
    public function travel($travel){
        $this->travel = $travel;
    }
    
    
    /**
     * 载入模型
     * @param string $exp 扩展路径/模型名称
     */
    public function model($exp){
        $param_arr = func_get_args();
        $exp = array_shift($param_arr);
        $call = $this->path_leave($this->model_path, $exp);
        
        //给引用它的APP控制器加上属性,属性值是载入的该模型的一个实例化对象
        if(!is_file($call['dir'].'/'.$call['name'].'.php')){
            trigger_error('没有找到Model库中的文件'.$exp,E_USER_WARNING);
            return false;
        }
        $this->travel->{$call['name']} = call_user_func_array(array($this,'insert_mode'), array_merge($call,$param_arr));
        return true;
    }
    
    
    /**
     * 载入视图
     * @param string $name 文件名称
     * @param string $exp 文件路径
     * @param array $data View层接收的数据
     * @param bool $ret 如果传入TRUE则返回解析后的静态HTML
     * 
     */
    public function view($exp,$data=null,$ret=false){
        $_POST = array_map('stripslashes_deep', $_POST);
        $_GET = array_map('stripslashes_deep', $_GET);
        $_COOKIE = array_map('stripslashes_deep', $_COOKIE);
        $_REQUEST = array_map('stripslashes_deep', $_REQUEST);
        $call = $this->path_leave($this->view_path, $exp);
        load($call['dir'],$call['name'],$data);
        //返回静态HTML
        if($ret===true){
            $html = ob_get_contents();
            ob_end_clean();
            return $html;
        }
    }
    
    
    /**
     * 载入数据库
     * @param string $name 类名称
     */
    public function database(){
        if(!class_exists('Db')){
            load($this->db_path,'db');
        }
        $this->travel->db = Db::get_instance();
    }
    
    
    /**
     * 载入系统类库
     * 注意:文件名称的"ex_"前缀有特殊含义,仅仅在app层进行引入
     * @param string $name 类名称,如果APP层有同名类,则覆盖系统类
     * @param1,@param2,@param3... 可以传递多个参数,对载入的库文件初始化函数传参
     */
    public function library(){
        $param_arr = func_get_args();
        $exp = array_shift($param_arr);
        
        $app_call = $this->path_leave($this->app_library_path, $exp);
        $sys_call = $this->path_leave($this->sys_library_path, $exp);
        $app_file = $app_call['dir'].'/'.$app_call['name'].'.php';
        $sys_file = $sys_call['dir'].'/'.$sys_call['name'].'.php';

        if(is_file($app_file)){
            //如果文件名前三个字符为"ex_",则表示在system/library上进行扩展
            if(substr($app_call['name'],0,3)==='ex_'){
                load($sys_call['dir'],substr($sys_call['name'],3));
            }
            $this->travel->{$app_call['name']} = call_user_func_array(array($this,'insert_mode'), array_merge($app_call,$param_arr));
            return true;
        }else if(is_file($sys_file)){
            $this->travel->{$sys_call['name']} = call_user_func_array(array($this,'insert_mode'), array_merge($sys_call,$param_arr));
            return true;
        }else{
            trigger_error('没有找到Library库中的文件'.$exp,E_USER_WARNING);
            return false;
        }
        
    }
    
    
    /**
     * 载入功能函数
     * @param string $name 类名称 如果APP层有同名类,则覆盖系统类
     */
    public function func($exp){
        $app_call = $this->path_leave($this->app_func_path, $exp);
        $sys_call = $this->path_leave($this->sys_func_path, $exp);
        $app_file = $app_call['dir'].'/'.$app_call['name'].'.php';
        $sys_file = $sys_call['dir'].'/'.$sys_call['name'].'.php';
        
        if(is_file($app_file)){
            load($app_call['dir'],$app_call['name']);
            return true;
        }else if(is_file($sys_file)){
            load($sys_call['dir'],$sys_call['name']);
            return true;
        }else{
            trigger_error('没有找到Func库中的文件'.$exp,E_USER_WARNING);
            return false;
        }
        
    }
    
    
    /**
     * 载入配置文件
     * @param string $name 类名称 如果APP层有同名类,则覆盖系统类
     */
    public function config($exp){
        $call = $this->path_leave($this->config_path, $exp);
        $this->travel->{$call['name']} = $this->insert_mode($call['dir'],$call['name']);
    }

    
    /**
     * 载入类并生成实例化对象返回
     */
    private function insert_mode(){
        $param_arr = func_get_args();
        $path = $param_arr[0];
        $name = $param_arr[1];
        $class_name = ucfirst($name);
        if(!class_exists($class_name)){
            return call_user_func_array('load_class',$param_arr);
        }else{
            unset($param_arr[0]);
            unset($param_arr[1]);
            if(empty($param_arr)){
                return new $class_name;
            }else{
                $ref = new ReflectionClass($class_name);
                return $ref->newInstanceArgs($param_arr);
            }
        }
    }
    
    
    /**
     * 载入多级路径解析
     * @param string $path 某个默认的路径
     * @param string $exp 功能类名称
     */
    private function path_leave($path,$exp){
        $exp = trim(str_replace('\\','/',$exp),'/');
        if(strpos($exp,'/')!==false){
            $path_arr = explode('/',$exp);
            $name = array_pop($path_arr);
            $dir = $path.'/'.implode('/',$path_arr);
        }else{
            $name = $exp;
            $dir = $path;
        }
        return array('dir'=>$dir,'name'=>$name);
    }
    
    
    /**
     * 获取载入模块对象
     */
    static public function get_instance(){
        if(!self::$ins instanceof self){
            self::$ins = new self;
        }
        return self::$ins;
    }
    
}

