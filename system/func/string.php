<?php

//字符串截取(unicode多语言兼容)
if(!function_exists('multi_substr')){
    function multi_substr($string,$start=0,$length=null){
        //mb函数库
        if(is_callable('mb_substr')){
            return mb_substr($string, $start, $length, 'utf-8');
        }
        //mb函数库未开启
        $byte = strlen($string);
        $temp = '';$result = '';
        for($i=0;$i<$byte;$i++){
            $bin = decbin(ord($string{$i}));
            //不足8位补0
            if(strlen($bin)<8){
                $bin = str_repeat('0',8-strlen($bin)).$bin;
            }
            if(substr($bin,0,2)!=='10'){
                $bin = ','.$bin;
            }
            $temp .= $bin.' ';
        }
        $temp = explode(',',trim($temp,', '));
        $temp = array_slice($temp,$start,$length);
        foreach ($temp as $row){
            $binarr = explode(' ',trim($row));
            $binarr = array_map('chr',array_map('bindec',$binarr));
            $char = implode('', $binarr);
            $result .= $char;
        }
        return $result;
    }
}


//字符数量(unicode多语言兼容)
if(!function_exists('multi_strlen')){
    function multi_strlen($string){
        //mb函数库
        if(is_callable('mb_strlen')){
            return mb_strlen($string,'utf-8');
        }
        //mb函数库未开启
        $byte = strlen($string);
        $count = 0;
        for($i=0;$i<$byte;$i++){
            $bin = decbin(ord($string{$i}));
            //不足8位补0
            if(strlen($bin)<8){
                $bin = str_repeat('0',8-strlen($bin)).$bin;
            }
            if(substr($bin,0,2)!=='10'){
                $count++;
            }
        }
        return $count;
    }
}


if(!function_exists('short_title')){
    function short_title($title,$max_length,$ext_string='...'){
        if(multi_strlen($title) > $max_length){
            $title = multi_substr($title,0, intval($max_length)).$ext_string;
        }
        return $title;
    }
}