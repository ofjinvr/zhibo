<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');



// +-----------------------
// | CONFIG FOR TEMPLATE ENGINE
// +-----------------------

class Config_Engine{
    
    //权限数组
    private $opts;
    
    /**
     * 配置列表
     * template_dir 模板目录
     * compile_dir 编译文件目录
     * cache_dir 缓存目录
     * lifetime 缓存周期
     * tplext 模板扩展名
     */
    public function __construct() {
        $this->opts = array(
            'tpl_dir' => 'application/view',
            'comp_dir' => 'application/compiled',
            'cache_dir' => 'application/cache',
            'tplext' => 'tpl',
            'lifetime'=>0
            //预留,暂未开发 'is_cache' => false
        );
    }
    
    /**
     * @return array 后台权限列表
     */
    public function get_config(){
        return $this->opts;
    }
    
}