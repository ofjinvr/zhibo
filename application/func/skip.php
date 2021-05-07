<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

//后台跳转信息函数

if(!function_exists('skip_true')){
    function skip_true($msg,$url=null){
        $skip = array(
            'skip_status' => 'true',
            'skip_message' => $msg,
            'skip_url' => $url ? $url : 'javascript:history.back();'
        );
        load('application/message','skip_msg',$skip);
        exit;
    }
}


if(!function_exists('skip_false')){
    function skip_false($msg,$url=null){
        $skip = array(
            'skip_status' => 'false',
            'skip_message' => $msg,
            'skip_url' => $url ? $url : 'javascript:history.back();'
        );
        load('application/message','skip_msg',$skip);
        exit;
    }
}
