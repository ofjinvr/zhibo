<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');



// +-----------------------
// | Email 配置文件
// +-----------------------

class Config_Smtp{
    
    //权限数组
    private $opts;
    
    /**
     * 配置列表
     * stmp:STMP服务器的地址
     * port:STMP服务器使用的端口号
     * username:登陆STMP所使用的邮箱账号
     * password:登陆STMP的账号密码
     * sender:发送邮箱的地址
     * sendname:发信系统的名称
     * socket_timeout:链接超时时间
     * charset:字符编码 默认UTF-8
     */
    public function __construct() {
        $this->opts = array(
            'smtp' => 'smtp.aliyun.com',
            'port' => '25',
            'username'=>'zhangzhi@taoding.cn',
            'password' => 'zx19900109',
            'sender' => 'zhangzhi@taoding.cn',
            'sendname' => '淘丁通知系统邮件',
            'socket_timeout' => 5,
            'charset' => 'UTF-8'
        );
    }
    
    /**
     * @return array 后台权限列表
     */
    public function get_config(){
        return $this->opts;
    }
    
}