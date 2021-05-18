<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');


// +-----------------------
// | Config 配置文件
// +-----------------------

class Config{
    
    // 配置是否开启调试模式 部署阶段设为false
    const APP_DEBUG = true;
    
    // 程序执行的最大时间
    const PHP_TIME_OUT = 30;
    
    // 配置系统时区设置
    const TIMEZONE = 'PRC';
    
    // 设置路由解析模式
    // tradition: 兼容模式,用参数方式访问 访问方式:URL/index.php?r=/controller/method
    // pathinfo: 用于没有开启重写的服务器环境; 访问方式:URL/index.php/controller/method (默认模式)
    const ROUTER_MODE = 'pathinfo';
    //是否开启伪静态
    const PSEUDO_STATIC = true;
    //使用路由XSS安全过滤
    const ROUTER_SAFE = true;
    //路由兼容模式GET参数key
    const ROUTER_TRADITION_PARAM = 'r';
    
    /**
     * 数据库访问设置
     * DATABASE: 使用的数据库 目前仅支持mysql
     * 
     * DB_HOST : 数据库访问地址
     * DB_PORT : 数据库访问端口号
     * DB_UNAME: 数据库访问用户名
     * DB_PWD  : 数据库访问密码
     * DB_NAME : 使用库名
     */
    const DATABASE = 'mysql';
    const DB_HOST  = 'mysql.rdsm4mera4ukti9.rds.bj.baidubce.com';
    const DB_PROT  = '3306';
    const DB_UNAME = 'zhibo';
    const DB_PWD   = 'taoding12345';
    const DB_NAME  = 'zhibo';
    // PDO参数设置 以下选项仅PDO链接方式有效
    
    /**
     * 选择要使用的语言包
     * 语言包文件位于system/language下,你还可以扩展自己的语言包
     */
    const LANGAGE_PACK = 'simplified_chinese';
    
}
