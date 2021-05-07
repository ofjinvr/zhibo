<?php if(!defined('ACCESS') || ACCESS !== true) exit('No Access!');

/**
 * 后台权限列表配置文件
 */
class Config_Access{
    
    //权限数组
    private $access;
    
    public function __construct() {
        $this->access = array(
            'home/index::index' => '管理中心首页',
            'home/common::status' => '服务器环境',
            'account/user::index'=>'账户总览',
            'account/user::add' => '添加管理员',
            'account/user::edit' => '编辑管理员账户',
            'account/user::del' => '删除管理员账户',
            'account/user::info' => '查看账户详情',
            'account/permission::index' => '权限组总览',
            'account/permission::add' => '添加权限组',
            'account/permission::edit' => '修改权限组',
            'account/permission::del' => '删除权限组',
            'account/permission::info' => '查看权限组详情',
            'account/security::pwd_modify' => '修改账户密码',
            'account/security::log' => '查看登录日志',
            'data/database::index' => '数据库备份管理',
            'data/database::backup' => '数据库备份',
            'data/database::restore' => '数据库还原',
            'data/explorer::upload_files' => '资源文件上传',
            'data/explorer::uploaded_files' => '资源管理器浏览',
            'data/explorer::delete_uploaded_file' => '删除资源文件',
            
            'setting/base::index' => '网站资料设置',
            'setting/base::about' => '公司介绍',
            'setting/base::about' => '联系我们',
            'setting/base::collaborate' => '共同合作',
            'setting/base::matter' => '常见问题',
            'setting/base::server' => '售后服务',

            'setting/slider::index' => '轮播图管理',
            'setting/slider::add' => '轮播图添加',
            'setting/slider::edit' => '轮播图编辑',
            'setting/slider::drop' => '轮播图删除',
            
            'setting/network::index' => '服务网点管理',
            'setting/network::add' => '服务网点添加',
            'setting/network::edit' => '服务网点编辑',
            'setting/network::drop' => '服务网点删除',
            
            'setting/nav::index' => '导航管理',
            'setting/nav::add' => '导航添加',
            'setting/nav::edit' => '导航编辑',
            'setting/nav::drop' => '导航删除',
            
            'setting/job::index' => '职位招聘管理',
            'setting/job::add' => '职位招聘添加',
            'setting/job::edit' => '职位招聘编辑',
            'setting/job::drop' => '职位招聘删除',
            
            'setting/friends::index' => '友情链接管理',
            'setting/friends::add' => '添加友情连接',
            'setting/friends::drop' => '删除友情连接',
            'setting/friends::edit' => '编辑友情连接',
            
            'setting/seo::sitemap' => 'Ssitemap生成',
            'setting/seo::push_url' => 'URL主动推送',
            'setting/seo::thirdjs' => '第三方JS管理',
            'setting/seo::add_thirdjs' => '第三方JS添加',
            'setting/seo::edit_thirdjs' => '第三方JS编辑',
            'setting/seo::del_thirdjs' => '第三方JS编辑',
            
            'applications/city::index' => '城市管理',
            'applications/city::add' => '城市添加',
            'applications/city::del' => '城市删除',
            'applications/city::edit' => '城市编辑',
            'applications/city::action' => '城市提交',

            'applications/article::index' => '文章管理',
            'applications/article::add' => '文章发布',
            'applications/article::drop' => '文章删除',
            'applications/article::edit' => '文章编辑',
            'applications/article::copy' => '文章拷贝',
            'applications/artpub::editor' => '编辑管理',
            'applications/artpub::editor_add' => '编辑添加',
            'applications/artpub::editor_edit' => '重置编辑密码',
            'applications/artpub::apply' => '审核文章管理',
            'applications/artpub::apply_edit' => '审核文章详情',
            'applications/artpub::dropart' => '审核文章删除',
            'applications/artpub::dropart' => '审核文章删除',
            'applications/artpub::statistics' => '兼职报表统计',

            'applications/category::index' => '栏目管理',
            'applications/category::add' => '栏目发布',
            'applications/category::drop' => '栏目删除',
            'applications/category::edit' => '栏目编辑',
            
            'applications/service_cate::index' => '服务分类管理',
            'applications/service_cate::add' => '服务分类添加',
            'applications/service_cate::del' => '服务分类删除',
            'applications/service_cate::edit' => '服务分类编辑',
            'applications/service_cate::action' => '服务分类提交',
            
            'applications/service::index' => '服务管理',
            'applications/service::add' => '服务添加',
            'applications/service::del' => '服务删除',
            'applications/service::edit' => '服务编辑',
            'applications/service::copy' => '服务拷贝',
            'applications/service::action' => '服务提交',
            
            'applications/cwiki::index' => '百科栏目列表',
            'applications/cwiki::add' => '百科栏目添加',
            'applications/cwiki::drop' => '百科栏目删除',
            'applications/cwiki::edit' => '百科栏目编辑',
            'applications/cwiki::tdk' => '百科栏目TDK',
            
            'applications/wiki::index' => '百科列表',
            'applications/wiki::add' => '百科添加',
            'applications/wiki::drop' => '百科删除',
            'applications/wiki::edit' => '百科编辑',
            'applications/wiki::copy' => '百科拷贝',
            
            'applications/faq::index' => '服务问答列表',
            'applications/faq::add' => '服务问答添加',
            'applications/faq::del' => '服务问答删除',
            'applications/faq::edit' => '服务问答编辑',
            'applications/faq::action' => '服务问答提交',
             
            'applications/msg::service' => '服务需求查看',
            'applications/msg::index' => '电话回访查看'
            
//            公司吧已关闭功能
//            'applications/company::sale' => '公司转让列表',
//            'applications/company::add' => '发布转让表单',
//            'applications/company::edit' => '编辑转让表单',
//            'applications/company::delete' => '删除转让信息',
//            'applications/company::sale_action' => '提交转让信息',
//            'applications/company::buy' => '公司求购列表',
//            'applications/company::add2' => '发布求购表单',
//            'applications/company::edit2' => '编辑求购信息',
//            'applications/company::delete2' => '删除求购信息',
//            'applications/company::buy_action' => '提交求购信息',
//            'applications/company::intention' => '查看意向列表',
//            'applications/company::cancel' => '注销意向查询',
//            'applications/company::export_to_excel' =>'导出到Excel',
//            'applications/company::intention_list' => '最新意向信息'
        );
    }
    
    /**
     * @return array 后台权限列表
     */
    public function get_access(){
        return $this->access;
    }
    
}
