<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | 模板标签类
// +-----------------------

// 注意:
// 并不推荐使用本类,因为他是低效的;
// 本类仅用于与无法阅读php标签前端程序员合作时使用
// 无特殊需求推荐使用PHP原生标签, 灵活并且高效

class Engine{
    
    const L = '{';
    const R = '}';
    const RETURN_PATH = 1;
    const RETURN_CONT = 2;
    
    //配置属性
    protected $tpl_dir;            //模板目录
    protected $comp_dir;           //编译目录
    protected $cache_dir;          //缓存目录
    protected $tplext;             //模板文件扩展名
    protected $lifetime;           //编译间隔时间
    
    //运行时创建属性
    protected $appends = array();   //为框架添加的变量
    protected $tpl_file_path;      //当前操作的模板路径
    protected $comp_file_path;     //当前操作的编译文件路径
    protected $tpl_content;        //编译前的内容
    protected $comp_content;       //编译后的内容
    protected $global_vars;       //尽可能的解析出的所有可以安全替换的标记 (包括get,post,cookie等超全局数组)
    protected $nocomp_block;      //不进行编译的代码块存放数组
    
    
    //正则匹配表达式
    protected $preg_vars;          //变量匹配
    protected $preg_cond;          //条件匹配
    protected $preg_foreach;       //循环匹配
    protected $preg_nocomp;        //不进行编译的代码块匹配
    
    
    /**
     * 初始化配置
     * @param Array $opts 配置参数数组
     * @throws Exception
     */
    public function __construct($opts=null) {
        //初始化参数
        $this->tpl_dir = isset($opts['tpl_dir']) ? trim($opts['tpl_dir'],'/\\') : 'application/view';
        $this->comp_dir = isset($opts['comp_dir']) ? trim($opts['comp_dir'],'/\\') : 'application/compiled';
        $this->cache_dir = isset($opts['cache_dir']) ? trim($opts['cache_dir'],'/\\') : 'application/cache';
        $this->tplext = isset($opts['tplext']) ? trim($opts['tplext'],'.') : 'tpl';
        $this->lifetime = isset($opts['lifetime']) ? trim($opts['lifetime'],'/\\') : 7200;
        
        //初始化正则匹配表达式
        $this->preg_vars = '/\\'.self::L.'([A-Za-z_][\w]*\([^\\'.self::R.']*?)?(\$[A-Za-z_][\w|\.]*)([^\\'.self::R.']*?\))?\\'.self::R.'/m';
        $this->preg_cond = '/\\'.self::L.'if.+?\\'.self::L.'\/if\\'.self::R.'/is';
        $this->preg_foreach = '/\\'.self::L.'foreach[\s]+(\$[A-Za-z_][\w|\.]+)[\s]+as[\s]+(\$[A-Za-z_][\w]+)[\s]*(\=\>[\s]*(\$[\w]+))?[\s]*\\'.self::R.'(.*?)\\'.self::L.'\/foreach\\'.self::R.'/is';
        $this->preg_nocomp = '/\\'.self::L.'nocomp\\'.self::R.'(.*?)\\'.self::L.'\/nocomp\\'.self::R.'/is';
        
        //添加超全局编译变量,将超全局变量放在global_vars属性
        $this->get_global_vars(
            array(
                '_GET'     =>  $_GET,
                '_POST'    =>  $_POST,
                '_SESSION' =>  $_SESSION,
                '_COOKIE'  =>  $_COOKIE,
                '_SERVER'  =>  $_SERVER
            )
        );
    }
    
    
    /**
     * 为模板加载数据
     * @param array|string $append 接收到字符串,为模板变量名称;数组则为模板批量添加变量
     * @param mixed $data 模板变量的值 
     */
    public function append($append,$data=null){
        if(empty($append)){
            throw new Exception('模板数据添加失败');
        }
        if(is_array($append)){
            foreach ($append as $key => $value){
                $this->appends[$key] = $value;
            }
        }
        if(is_string($append)){
            $this->appends[$append] = $data;
        }
    }
    
    
    /**
     * 根据模板文件生成PHP动态文件
     * @param string $tplname 模板文件名(无需扩展名)
     * @param int $behavior 编译后的返回数据的选择,默认载入编译的文件
     * @return bool
     */
    public function display($tplname, $behavior=null){
        
        //检查模板文件名格式
        $tplname = trim($tplname,'/\\');
        if(empty($tplname) || !is_string($tplname)){
            throw new Exception('模板文件有误,无法解析');
        }
        //加载模板文件,加载了模板文件的路径和文件内容存在属性中
        if($this->load_tpl($tplname)===false){
            throw new Exception('无法载入模板文件,文件不存在或没有读取权限');
        }
        
        //先确定编译后的文件路径
        $this->comp_file_path = $this->comp_dir.'/'.$tplname.'.php';
        //生成文件目录
        if(!is_dir(dirname($this->comp_file_path))){
            mkdir(dirname($this->comp_file_path),0777,true);
        }
        
        //对比编译的缓存文件是否未过期
        if($this->is_compile()===true){
            //获得数据内容,进行标签替换解析(缓存开启时,生成缓存内容)
            if($this->compile()!==false){
                file_put_contents($this->comp_file_path,$this->comp_content);
            }
        }
        
        if($behavior==self::RETURN_PATH){
            return $this->comp_file_path;
        }elseif($behavior==self::RETURN_CONT){
            return $this->comp_content;
        }else{
            $this->load_compiled($this->comp_file_path);
        }
    }
    
    
    /**
     * 返回是否拥有未过期的有效缓存
     * @return bool true-需要编译/false-不需要编译
     */
    protected function is_compile(){
        if(is_file($this->comp_file_path) && (time()-filemtime($this->comp_file_path) < $this->lifetime || filemtime($this->comp_file_path) > filemtime($this->tpl_file_path))
        ){  
            return false;
        }
        return true;
    }
    
    
    /**
     * 加载模板文件 并获取内容
     * @param string $tplname 模板文件名(无需扩展名)
     * @return string|bool
     */
    protected function load_tpl($tplname){
        $this->tpl_file_path = $this->tpl_dir.'/'.$tplname.'.'.$this->tplext;
        if(is_readable($this->tpl_file_path)){
            $this->tpl_content = file_get_contents($this->tpl_file_path);
            return true;
        }
        return false;
    }
    
    
    /**
     * 载入编译后的文件
     * @param string $path 编译文件的路径
     */
    protected function load_compiled($path){
        foreach ($this->appends as $key => $value){
            $$key = $value;
        }
        include $path;
    }
        
    
    /**
     * 编译方法主体
     */
    protected function compile(){
        //先匹配不进行编译的代码块
        $this->tpl_content = preg_replace_callback($this->preg_nocomp,array($this,'find_nocomp_block'),$this->tpl_content);
        //编译循环结构
        $this->tpl_content = $this->compile_foreach($this->tpl_content);
        //编译条件控制结构
        $this->tpl_content = $this->compile_cond($this->tpl_content);
        //编译标准变量
        $this->comp_content = $this->compile_vars($this->tpl_content);
        //将不编译的代码块放回原位
        if(is_array($this->nocomp_block) && !empty($this->nocomp_block)){
            foreach($this->nocomp_block as $key => $value){
                 $this->comp_content = str_replace($key,$value,  $this->comp_content);
            }
        }
        
        if(!empty($this->comp_content)){
            return true;
        }else{
            return false;
        }
    }
    
    
    /**
     * 查找不编译的代码块,进行记录并写入sha1标记
     * @param array $nc 匹配到的不编译代码块
     * @return string $key;
     */
    protected function find_nocomp_block($nc){
        //生成一个块指纹
        $block = $nc[1];
        $key = '<!--tplnc:'.sha1($block).';-->';
        $this->nocomp_block[$key] = $block;

        return $key;
    }
    
    
    /**
     * @param string $runtime_content 编译标准变量前的tpl文档
     * @return string 编译标准变量后的tpl文档
     */
    protected function compile_vars($runtime_content){
        return preg_replace($this->preg_vars,'<?php echo \\1\\2\\3;?>', $runtime_content);
    }
    
    
    /**
     * @param string $runtime_content 编译foreach循环结构前的tpl文档
     * @return string 编译foreach循环结构后的tpl文档
     */
    protected function compile_foreach($runtime_content){
        $foreach_ary = array();
        preg_match_all($this->preg_foreach, $runtime_content,$foreach_ary,PREG_SET_ORDER);
        foreach($foreach_ary as $sign){
            $sign = array_map('trim', $sign);
            $fe_body =  $sign[5];
            $fe_ary = $this->ary_tpl2php($sign[1]);
            if(!empty($sign[4])){
                $fe_key = $sign[2];
                $fe_val = $sign[4];
                $fe_php = '<?php foreach('.$fe_ary.' as '.$fe_key.'=>'.$fe_val."):?>\r\n";
                $fe_body = preg_replace('/\\'.self::L.'([A-Za-z_][\w]*\([^\\'.self::R.']*?)?\\'.$fe_key.'([^\\'.self::R.']*?\))?\\'.self::R.'/m','<?php echo \\1'.$fe_key.'\\2;?>',$fe_body);
            }else{
                $fe_val = $sign[2];
                $fe_php = '<?php foreach('.$fe_ary.' as '.$fe_val."):?>\r\n";
            }
            $fe_body = preg_replace('/\\'.self::L.'([A-Za-z_][\w]*\([^\\'.self::R.']*?)?(\\'.$fe_val.'(\.[A-Za-z_]|[\w])*)([^\\'.self::R.']*?\))?\\'.self::R.'/m',"<?php echo \\1\\2\\4;?>",$fe_body);
            $fe_body = preg_replace_callback('/\$[A-Za-z_][\w]*\.[\w]+/m',array($this,'ary_tpl2php'),$fe_body);
            $fe_php .= $fe_body."\r\n<?php endforeach;?>";
            $runtime_content = str_replace($sign[0],$fe_php,$runtime_content);
        }
        return $runtime_content;
    }
    
    
    /**
     * @param string $runtime_content 编译条件结构控制前的tpl文档
     * @return string 编译条件结构控制后的tpl文档
     */
    protected function compile_cond($runtime_content){
        $cond_ary = array();
        preg_match_all($this->preg_cond, $runtime_content,$cond_ary,PREG_SET_ORDER);
        
        foreach($cond_ary as $value){
            $part = $value[0];
            //查找代码片段中的数组标签字符并且替换
            $part = preg_replace_callback('/\$[A-Za-z_][\w]*\.[\w]+/m',array($this,'ary_tpl2php'), $part);
            $part = preg_replace('/\{if[\s]+([\S].*?)\}/im',"<?php if(\\1):?>", $part);
            $part = preg_replace('/\{else[\s]?if[\s]+([\S].*?)\}/im',"<?php elseif(\\1):?>", $part);
            $part = str_replace('{else}',"<?php else:?>", $part);
            $part = str_replace('{/if}','<?php endif;?>', $part);
            $runtime_content = $runtime_content = str_replace($value[0],$part, $runtime_content);
        }
        return $runtime_content;
    }
    
    
    /**
     * 尽可能的(递归调用)解析出所有安全替换变量表,将模板可能出现的变量标记生成一个数组置于safe_global_vars属性中
     * @params array $assign 数据数组
     */
    protected function get_global_vars($appends,$leave=null){
        foreach($appends as $key => $value){
            $key = trim($leave.'.'.$key,'.');
            if(is_array($value)){
                $this->global_vars[self::L.'$'.$key.self::R] = $this->get_global_vars($value,$key);
            }
            //如果没有缓存,则解析数组语法
            $tag = $this->ary_tpl2php($key);
            $this->global_vars[self::L.'$'.$key.self::R] = '<?php echo $'.$tag.';?>';
        }
    }
    
    
    /**
     * 数组模板标签语法至PHP语法
     * @param mixed $tag 模板标签数组语法
     * @return string PHP语法数组
     */
    protected function ary_tpl2php($tag){
        //特殊情况:如果传进来的是数组,参数表示在本类的条件正则替换中查找的字符数组
        if(is_array($tag) && !empty($tag[0])){
            $tag = $tag[0];
        }
        $tag = trim($tag);
        $ary = explode('.',$tag);
        if(count($ary)>1){
            $ary_string = $ary[0].'[\'';
            foreach($ary as $k => $v){
                if($k===0){continue;}
                $ary_string .= $v.'\'][\'';
            }
            $ary_string = substr($ary_string,0,strlen($ary_string)-2);
        }
        if(count($ary) === 1){
            $ary_string = $ary[0];
        }
        
        return $ary_string;
    }
    
}