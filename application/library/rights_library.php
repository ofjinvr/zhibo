<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//管理员权限管理类

class Rights_library{
    
    public function __construct() {
        ;
    }
    
    /**
     * 动态解析模块菜单为权限列表
     * @param type $rights_array
     */
    public function rights_trans($rights_array){
        $rights = array();
        foreach($rights_array as $model_key => $model){
            if(empty($model)){
                continue;
            }
            foreach($model as $value){
                if(empty($value) || !isset($value['list'])){
                    continue;
                }
                foreach($value['list'] as $k => $v){
                    $rights[$model_key.'.'.$k] = $v;
                }
                
            }
        }
        return $rights;
    }
    
    
}
