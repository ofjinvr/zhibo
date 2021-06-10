<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>请登录直播管理系统</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/style.css">
    <script src="<?php echo base_url('resource/js');?>/jquery.js"></script>
    <script type="text/javascript">
        $(function(){
            var url = $('#auth').attr('src');
            $('#auth').click(function(){
                $(this).attr('src',url+'?vrand='+Math.random()); 
            });
            $(window).load(function(){
                $('#auth').trigger('click');
            })
        });
    </script>
</head>
<body>
    <div class="login_bg">
        <h1>请登录直播管理系统</h1>
        <div class="login">
            <h2>请登陆 :)</h2>
            <form action="<?php echo site_url('manage/login/index/action');?>" method="post">
                <input type="hidden" name="_hash" value="<?=sha1(time()+mt_rand(100000,999999))?>">
                <ul>
                    <li class="username">
                        <input type="text" name="merager_name" placeholder="账户名称" value="<?php echo $login_manager_name; ?>">
                    </li>
                    <li class="password">
                        <input type="password" name="merager_pwd" placeholder="密码"  autocomplete="off">
                    </li>
                    <li class="vcode">
                        <input type="text" name="vcode"  placeholder="验证码">
                        <img src="<?php echo site_url('auth/index/100/32');?>" id="auth">
                    </li>
                    <li class="remember">
                        <label><input type="checkbox" name="remember" value="1">记住用户名</label>
                        <span>注意:勿在公共场所使用</span>
                    </li>
                    <li class="submit"><input type="submit" value="登录"></li>
                </ul>
            </form>
        </div>
        <div class="footer">
        COPYRIGHT © 2013-2017 陕西省国家税务局 ALL RIGHTS RESERVED
        </div>
    </div>
</body>
</html>