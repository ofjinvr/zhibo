drop table if exists trl_manage;
create table trl_manage(
    id int unsigned auto_increment,
    rid int unsigned comment '权限组id',
    merager_name varchar(30) comment '管理员账户名',
    merager_pwd char(32) comment '管理员密码MD5',
    status tinyint comment '管理员账户状态 1-正常 0-停用',
    remark varchar(30) comment '备注信息',
    primary key(id),
    key(rid)
)engine myisam charset utf8;


drop table if exists trl_rights;
create table trl_rights(
    id int unsigned auto_increment,
    acc_name varchar(20) comment '权限组名称',
    rule text comment '每组权限之间使用逗号分隔,控制器和方法之间用点号分隔 例如:home.index,setting.*',
    primary key(id)
)engine myisam charset utf8;


insert into trl_rights(id,acc_name,rule) values('1','超级权限组','*');
insert into trl_manage(id,rid,merager_name,merager_pwd,status,remark) values('1','1','admin','e10adc3949ba59abbe56e057f20f883e','1','超级管理员');


drop table if exists trl_setting;
create table trl_setting(
    id int unsigned auto_increment,
    title varchar(255) comment '网站标题',
    keyword varchar(255) comment '网站关键字',
    description varchar(255) comment '网站描述',
    tel varchar(20) comment '电话号码',
    tel400 varchar(20) comment '400电话号码',
    mobile varchar(20) comment '移动电话',
    email varchar(100) comment '邮箱',
    qq varchar(20) comment 'QQ号码',
    address varchar(200) comment '地址',
    brief text comment '公司简介',
    hrtel varchar(200) comment 'HR电话',
    hremail varchar(200) comment 'HR邮箱',
    primary key(id)
)engine myisam charset utf8;


drop table if exists trl_login_log;
create table trl_login_log(
    id int unsigned auto_increment,
    mid int unsigned comment '管理员ID',
    ip varchar(15) comment '登录IP',
    login_time int unsigned comment '登录时间',
    status tinyint unsigned comment '登录状态 1-成功 2-失败',
    error_pwd varchar(30) comment '登录失败的错误密码',
    primary key(id),
    key(mid)
)engine myisam charset utf8;


drop table if exists trl_zhibo;
create table trl_zhibo(
    id int unsigned auto_increment,
    title varchar(255) not null default '' comment '直播标题',
    destext varchar(255) not null default '' comment '描述',
    imgurl varchar(255) not null default '' comment '图片地址',
    teacher varchar(255) not null default '' comment '讲师名称',
    typename varchar(255) not null default '' comment '类型',
    cityname varchar(255) not null default '' comment '市区',
    rolename varchar(255) not null default '' comment '角色',
    livetime int not null default 0 comment '开播时间',
    duration smallint not null default 0 comment '持续时长（分）',
    stream_1 varchar(255) not null default '' comment '视频流地址1',
    stream_2 varchar(255) not null default '' comment '视频流地址2',
    stream_3 varchar(255) not null default '' comment '视频流地址3',
    pubtime int not null default 0 comment '发布时间',
    pageview int not null default 0 comment '浏览量',
    primary key(id),
    index(livetime)
)engine myisam charset utf8;

drop table if exists trl_zhibo_pinglun;
create table trl_zhibo_pinglun(
    id int unsigned auto_increment,
    zid int not null default '' comment '直播ID',
    content varchar(500) not null default '' comment '评论内容',
    score tinyint not null default 0 comment '评分',
    primary key(id)
)engine myisam charset utf8;

drop table if exists trl_video;
create table trl_video(
    id int unsigned auto_increment,
    title varchar(255) not null default '' comment '视频标题',
    destext varchar(255) not null default '' comment '描述',
    imgurl varchar(255) not null default '' comment '图片地址',
    typename varchar(255) not null default '' comment '类型',
    cityname varchar(255) not null default '' comment '市区',
    rolename varchar(255) not null default '' comment '角色',
    stream varchar(255) not null default '' comment '视频地址',
    pubtime int not null default 0 comment '发布时间',
    pageview int not null default 0 comment '浏览量',
    primary key(id)
)engine myisam charset utf8;

