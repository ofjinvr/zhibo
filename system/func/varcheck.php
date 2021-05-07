<?php
/**
 * 验证函数
 * Date 2015/02/03 zhangzhi
 */


//判断是否为自然数
if(!function_exists('is_natural')){
    function is_natural($var){
        if(is_numeric($var) && $var > 0 && strpos((string)$var,'.')===false){
            return true;
        }
        return false;
    }
};

//判断是否为邮箱
if(!function_exists('is_email')){
    function is_email($var){
        if(preg_match('/\.{2,}/',$var)){
            return false;
        }
        if(preg_match('/^[\w]+@[\w\.]+$/i', $var)){
            return true;
        }else{
            return false;
        }
    }
}

//检测是否为电话号码(固定电话)
if(!function_exists('is_telphone')){
    function is_telphone($var){
        if(preg_match('/^[0-9\-]+$/',$var)){
            return true;
        }
        return false;
    }
}

//检测是否为手机号码(Only Chinese)
if(!function_exists('is_mobile')){
    function is_mobile($var){
        if(preg_match('/^1[3578][\d]{9}$/',$var)){
            return true;
        }
        return false;
    }
}