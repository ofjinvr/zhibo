<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>修改密码</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">修改密码</h1>
    <div class="center">
        <form action="<?php echo site_url('manage/account/security/pwd_modify/action');?>" method="post">
        <table class='input'>
            <tr>
                <td class="key">原密码</td>
                <td class="value">
                    <input type="password" name="old_password" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key">新密码</td>
                <td class="value">
                    <input  type="password" name="new_password" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key">确认新密码</td>
                <td class="value">
                    <input  type="password" name="confirm" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key"></td>
                <td class="value"><input  type="submit" class='button' value="提交"></td>
            </tr>
        </table>
        </form>
    </div>
</body>
</html>