<?php
//用户唯一key
//www : c30cb0f0a8af7ee85973e29b88b58ff1
//xa  : 817f660443c44757f44e4675d5ad7aaf
//cs  : d1d41551c3db6613d22de2e1ffc5f72f
//wh  : 91cee5bceca3bedc4671aa89cdadbad6
//zz  : a05ffcaab19ab459b7a0b64186750d0f
switch($_SERVER['HTTP_HOST']){
    case 'xa.taoding.cn': define('WEBSCAN_U_KEY', '817f660443c44757f44e4675d5ad7aaf'); break;
    case 'zz.taoding.cn': define('WEBSCAN_U_KEY', 'a05ffcaab19ab459b7a0b64186750d0f'); break;
    case 'wh.taoding.cn': define('WEBSCAN_U_KEY', '91cee5bceca3bedc4671aa89cdadbad6'); break;
    case 'cs.taoding.cn': define('WEBSCAN_U_KEY', 'd1d41551c3db6613d22de2e1ffc5f72f'); break;
    default : define('WEBSCAN_U_KEY', 'c30cb0f0a8af7ee85973e29b88b58ff1'); break;
}
//数据回调统计地址
define('WEBSCAN_API_LOG', 'http://safe.webscan.360.cn/papi/log/?key='.WEBSCAN_U_KEY);
//版本更新地址
define('WEBSCAN_UPDATE_FILE','http://safe.webscan.360.cn/papi/update/?key='.WEBSCAN_U_KEY);
//拦截开关(1为开启，0关闭)
$webscan_switch=1;
//提交方式拦截(1开启拦截,0关闭拦截,post,get,cookie,referre选择需要拦截的方式)
$webscan_post=1;
$webscan_get=1;
$webscan_cookie=1;
$webscan_referre=1;
//后台白名单,后台操作将不会拦截,添加"|"隔开白名单目录下面默认是网址带 admin  /dede/ 放行
$webscan_white_directory='manage'; 
//url白名单,可以自定义添加url白名单,默认是对phpcms的后台url放行
//写法：比如phpcms 后台操作url index.php?m=admin php168的文章提交链接post.php?job=postnew&step=post ,dedecms 空间设置edit_space_info.php
$webscan_white_url = array('index.php' => 'm=admin','post.php' => 'job=postnew&step=post','edit_space_info.php'=>'');
?>