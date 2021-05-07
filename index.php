<?php


// +-----------------------
// | 入口文件
// +-----------------------

//环境检测
if(version_compare(PHP_VERSION,'5.5.0','<')) die('PHP version must >= 5.5.0; your version:'.PHP_VERSION);

// PV 版本
define('PT_VERSION','1.7.523');

//入口访问权限
define('ACCESS',true);

//配置系统路径  LOCAL系统文档路径 URL访问链接路径
defined('LOCAL_ROOT') or define('LOCAL_ROOT',rtrim(str_replace('\\','/',dirname(__FILE__)),'/').'/');             //系统根路径
defined('LOCAL_APP') or define('LOCAL_APP',LOCAL_ROOT.'application/');                                            //本地APP路径
defined('LOCAL_SYSTEM') or define('LOCAL_SYSTEM',LOCAL_ROOT.'system/');                                           //本地系统目录
$http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://'; 
defined('URL_ROOT') or define('URL_ROOT',$http_type.$_SERVER['HTTP_HOST'].'/');                            //URL根路径

//360安全插件
if(is_file('360safe/360webscan.php')){
    require_once('360safe/360webscan.php');
}

//载入初始化文件
require LOCAL_SYSTEM.'main.php';