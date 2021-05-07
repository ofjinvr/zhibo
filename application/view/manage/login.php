<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>请登录-淘丁财税网站管理系统</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/style.css">
    <script src="<?php echo base_url('resource/js');?>/jquery.js"></script>
    <script type="text/javascript">
        $(function(){
            var url = $('#auth').attr('src');
            $('#auth').click(function(){
                $(this).attr('src',url+'?vrand='+Math.random()); 
            });
        });
    </script>
</head>
<body>
    <div class="login_bg">
        <h1>淘丁财税网站管理系统</h1>
        <div class="login">
            <h2>请登陆 :)</h1>
            <form action="<?php echo site_url('manage/login/index/action');?>" method="post">
                <ul>
                    <li class="username">
                        <input type="text" name="merager_name" placeholder="账户名称" value="<?php echo $login_manager_name; ?>">
                    </li>
                    <li class="password">
                        <input type="password" name="merager_pwd" placeholder="密码">
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
        COPYRIGHT © 2013-2017 淘丁财税 ALL RIGHTS RESERVED，Powered by 淘丁财税有限公司
        </div>
    </div>
</body>
</html>