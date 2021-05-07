<?php
/**
 * 得到基础url访问地址
 */
if(!function_exists('base_url')){
    function base_url($path=''){
        return URL_ROOT.$path;
    }
}

/**
 * 根据访问模式,得到url访问地址
 * 当路由模式为pathinfo时,实际上与base_url相同
 */
if(!function_exists('site_url')){
    function site_url($path=''){
        if(strtoupper(Config::ROUTER_MODE) === 'PATHINFO'){
            return Config::PSEUDO_STATIC===true ?  URL_ROOT.$path : URL_ROOT.'index.php/'.$path;
        }
        if(strtoupper(Config::ROUTER_MODE) === 'TRADITION'){
            return URL_ROOT.'?'.Config::ROUTER_TRADITION_PARAM.'='.$path;
        }
        return false;
    }
}

/**
 * 整理路径,可以将路径中重复的'/'和'\'替换为一个'/'
 * @return string 整理后的路径
 */
if(!function_exists('crepeat')){
    function crepeat($path){
        $path = trim($path);
        //如果格式公正直接返回
        if(strpos($path,'\\')!==false){
            $path = str_replace('\\','/',$path);
        }
        if(strpos($path,'//')===false){
            return $path;
        }
        while(strpos($path,'//')!==false){
            $path = str_replace('//','/',$path);
        }
        return $path;
    }
}