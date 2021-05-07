<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | Router 路由器类
// +-----------------------

class Router{
    //路由模式
    private $mode; 
    //接收的参数
    private $query;
    //兼容模式的参数使用字符串
    private $param;
    //安全模块是否开启
    private $safe_mode = null;
    
    public function __construct() {
        $mode = strtolower(Config::ROUTER_MODE);
        $param = strtolower(Config::ROUTER_TRADITION_PARAM);
        //检测路由模式有效性
        $title='路由器模式设置有误 :(';
        if($mode!=='pathinfo' and $mode!=='tradition'){
            $content = '请在配置文件中设置路由解析模式.<br>支持模式: pathinfo(默认模式),tradition';
            show_msg($title, $content);
        }
        if(!is_string($param) || is_numeric($param{0})){
            $content = '无法使用的兼容模式路由参数'.$param;
            show_msg($title, $content);
        }
        $this->mode = $mode;
        $this->param = $param;
        if(Config::ROUTER_SAFE !== false){
            $this->safe_mode = Safe::get_instance();
        }
    }
    
    //解析控制器映射
    public function routing(){
        $mode_method = $this->mode;
        
        return $this->$mode_method();
    }
    
    //pathinfo模式解析
    private function pathinfo(){
        //获取路径信息
        $selfpath = str_replace('index.php','',stristr(trim($_SERVER['PHP_SELF'],'/\\'),'index.php'));
//        var_dump($_SERVER['PHP_SELF']);
//        if(!empty($selfpath)){
//            $query = $selfpath;
//        }
//        //未重写的情况
//        else 
        if(!empty($_SERVER['PATH_INFO'])){
            $query = str_replace('\\','/',trim($_SERVER['PATH_INFO'],'/\\'));
        }
        //兼容NTS版PHP重写
        else if(!empty($_SERVER['REDIRECT_PATH_INFO'])){
            $query = str_replace('\\','/',trim($_SERVER['REDIRECT_PATH_INFO'],'/\\'));
        }
        //对IIS进行兼容 IIS Isapi_Rewrite
        else if(!empty($_SERVER['HTTP_X_REWRITE_URL'])){
            $rewrite_url = array_shift(explode('?',$_SERVER['HTTP_X_REWRITE_URL']));
            $query = str_replace('\\','/',trim($rewrite_url,'/\\'));
        }
        //对IIS进行兼容 IIS Mod-Rewrite
        else if(!empty($_SERVER['HTTP_X_ORIGINAL_URL'])){
            $rewrite_url = array_shift(explode('?',$_SERVER['HTTP_X_ORIGINAL_URL']));
            $query = str_replace('\\','/',trim($rewrite_url,'/\\'));
        }
        else{
            $query = '';
        }
        
        //去点号之后的扩展名
        if(($pix=strpos($query,'.')) !== false){
            $query = substr($query,0,$pix);
        }
        
        $this->query = $this->safe($query);
        //返回格式化路径
        return $this->query_handle($this->query);
    }
    
    
    //tradition模式解析
    private function tradition(){
        $query = '';
        if(!empty($_GET[$this->param])){
            $query = str_replace('\\','/',trim($_GET[$this->param],'/\\'));
        }
        unset($_GET[$this->param]);
        //判断是否使用安全模式解析
        $this->query = $this->safe($query);
        //返回格式化路径
        return $this->query_handle($this->query);
    }
    
    
    /**
     * 路径解析
     * @param string $string 待解析的字符串
     * @return string 解析后的访问字符串
     */
    private function query_handle($query){
        $controller_dir = 'application/controller';
        if(($pos=strpos($query,'&'))!==false){
            $query = substr($query,0,$pos);
        }
        $query = trim($query,'/');
        $query_handled = explode('/',$query);
        //检测是否为路径
        foreach($query_handled as $key => $value){
            if(!is_file($controller_dir.'/'.$value) && is_dir($controller_dir.'/'.$value)){
                $controller_dir = $controller_dir.'/'.$value;
                unset($query_handled[$key]);
            }else{
                break;
            }
        }
        //解析字符串为空
        if(empty($query_handled)){
            $query_handled = array('index','index');
        }
        //解析控制器不为空,但方法为空
        if(count($query_handled)===1){
            array_push($query_handled,'index');
        }
        //在最后一个元素添加路径信息
        array_push($query_handled,$controller_dir);
        return $query_handled;
    }
    
    
    /**
     * 安全模式处理
     * @param string $query 待处理的数据
     */
    private function safe($query){
        if($this->safe_mode !== null){
            return $this->safe_mode->clear_xss($query);
        }
        return $query;
    }
    
    
}
