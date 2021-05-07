<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');
// +------------------------------------------------
// | Micro-Frame 1.0 Dev      
// +------------------------------------------------
// | Copyright (c) 2014 All rights reserved.        
// +------------------------------------------------
// | Author: XiaoZhi <travelphp@163.com>     
// +------------------------------------------------

// +-----------------------
// | 全局函数
// +-----------------------



/**
 * 文件载入
 * @param string $path 为一个相对路径,相对于网站根目录
 * @param string $file 载入的文件名
 * @param array $data 用于为该页面传值
 */
if(!function_exists('load')){
    function load($path, $file, $data=null){
        $path = rtrim(LOCAL_ROOT.$path,'/').'/';
        if(!strpos($file,'.')){
            $file = strtolower($file).'.php';
        }
        $filename = $path.$file;
        if(file_exists($filename)){
            if(is_array($data)){
                foreach ($data as $key => $value){
                    $$key = $value;
                }
            }
            unset($data);
            require $filename;
            return true;
        }else{
            $app_path = rtrim(LOCAL_APP.'controller','/\\');
            if($app_path === rtrim($path,'/\\')){
                no_found($file);
            }
            if(strpos($filename,LOCAL_APP.'controller')!==false){
                no_found();
            }
            trigger_error('无法载入文件 '.$filename,E_USER_ERROR);
        }
    }
}


//载入类文件,并且实例化该文件中的类
//返回一个实例化对象
if(!function_exists('load_class')){
    function load_class(){
        $args = func_get_args();
        $path = array_shift($args);
        $file = array_shift($args);
        $class_name = ucfirst($file);
        //载入文件
        $file_info_array = array('path'=>$path, 'file'=>$file);
        call_user_func_array('load', $file_info_array);
        //如果类存在并且可以直接实例化,则返回一个实例化后的对象
        if(class_exists($class_name) && in_array('__construct',get_class_methods($class_name)) ){
            //php反射 动态创建对象
            $object = new ReflectionClass($class_name);
            return $object->newInstanceArgs($args);
        }else{
            trigger_error('无法完成初始化 '.$class_name,E_USER_WARNING);
        }
    }
}


//显示404页面
if(!function_exists('no_found')){
    function no_found(){
        header("HTTP/1.1 404 Not Found");
        header("Status: 404 Not Found");
        $filename = LOCAL_APP.'message/404.php';
        if(file_exists($filename)){
            include $filename;
        }
        exit;
    }
}

//显示信息
if(!function_exists('show_msg')){
    function show_msg($title,$content){
        $filename = LOCAL_APP.'message/message.php';
        if(file_exists($filename)){
            include $filename;
        }
        exit;
    }
}

if(!function_exists('addslashes_deep')){
    function addslashes_deep($value){
        $value = is_array($value) ? array_map('addslashes_deep', $value) : addslashes($value);
        return $value;
    }
}

if(!function_exists('stripslashes_deep')){
    function stripslashes_deep($value){
        $value = is_array($value) ? array_map('stripslashes_deep', $value) : stripslashes($value);
        return $value;
    }
}

if(!function_exists('get_true_ip')){
    function get_true_ip(){
        $true_ip = '';
        if(!empty($_SERVER['HTTP_CLIENT_IP'])){
            $true_ip = $_SERVER['HTTP_CLIENT_IP'];
        }elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $true_ip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
        }elseif(!empty($_SERVER['REMOTE_ADDR'])){
            $true_ip = $_SERVER['REMOTE_ADDR'];
        }
        return $true_ip;
    }
}