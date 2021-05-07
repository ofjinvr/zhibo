<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

/**
 * 后台菜单配置文件
 * 注意list中的key键应该是唯一的,他是该栏目的访问地址
 */
class Config_menu{
    
    private $conf_menu;
    
    
    //主页模块菜单
    private $conf_menu_home = array(
        array(
            'title' => '常用功能',
            'list'=>array(
                'index'=>'管理中心首页',
                'common/status' => '服务器环境'
            )
        )
    );

    //应用菜单
    private $conf_menu_applications = array(
        array(
            'title' => '多媒体管理',
            'list'=>array(
                'live/add' => '发布直播',
                'live/index' => '直播管理',
                'video/add' => '发布学习视频',
                'video/index' => '学习视频管理'
            )
        ),
        array(
            'title' => '文章公告',
            'list'=>array(
                'article/add' => '文章发布',
                'article/index' => '文章列表'
            )
        )
        
    );

    //管理员用户权限
    private $conf_menu_user = array(
        array(
            'title' => '账户管理',
            'list'=>array(
                'user/add' => '添加管理员',
                'user/index' => '账户管理'
            )
        ),
        array(
            'title' => '权限组管理',
            'list'=>array(
                'permission/add' => '建立权限组',
                'permission/index' => '管理权限组'
            )
        ),
        array(
            'title' => '安全中心',
            'list'=>array(
                'security/pwd_modify' => '修改密码',
                'security/log' => '登录日志'
            )
        )
    );
    //设置菜单
    private $conf_menu_setting = array(
        array(
            'title' => '设置',
            'list'=>array(
                'base/index'=>'基本设置'
            )
        )
    );
    //后台管理菜单
    private $conf_menu_manage = array(
        array(
            'title' => '数据管理',
            'list'=>array(
                'database/index' => '备份管理',
                'database/backup' => '数据库备份',
                'database/restore' => '数据库还原'
            )
        ),
        array(
            'title' => '资源管理器',
            'list'=>array(
                'explorer/upload_files' => '资源上传',
                'explorer/uploaded_files' => '浏览文件'
            )
        )
    );
    
    public function __construct(){
        //后台管理菜单 - 主菜单
        $this->conf_menu = array(
            'home'=>$this->conf_menu_home,
            'applications'=>$this->conf_menu_applications,
            'account'=>$this->conf_menu_user,
            'setting'=>$this->conf_menu_setting,
            'data'=>$this->conf_menu_manage
        );
    }
    
    public function get(){
        return $this->conf_menu;
    }
}
