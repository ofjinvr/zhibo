<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>网站信息管理中心</title>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/style.css">
<script src="<?php echo base_url('resource/js');?>/jquery.js"></script>
<script src="<?php echo base_url('resource/admin/js');?>/insex.js"></script>
</head>
<body>
<div class="header">
    <div class="logo">
        <a title="Logo" href="<?php echo base_url('admin');?>">
            <img src="<?php echo base_url('resource/admin');?>/image/logo.jpg" width="155" height="46">
        </a>
    </div>
    <div class="title">网站信息管理中心</div>
    <div class="logout">
        <div class="username">用户名:<a href="javascript:void(0);"><?php echo $info['merager_name']?></a></div>
        <div class="slide_down">
            <div class="username">用户名:<a href="javascript:void(0);"><?php echo $info['merager_name']?></a></div>
            <ul>
                <li><a href="<?php echo site_url('manage/logout');?>">退出登录</a></li>
                <li><a href="<?php echo site_url('manage/account/security/pwd_modify');?>" target="main_iframe">修改密码</a></li>
            </ul>
        </div>
    </div>
    <div class="home"><a href="<?php echo base_url();?>" target="_blank">网站首页</a></div>
</div>