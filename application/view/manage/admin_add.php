<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>添加管理员</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">添加管理员</h1>
    <div class="center">
        <form action="<?php echo site_url('manage/account/user/add/action');?>" method="post">
        <table class='input'>
            <tr>
                <td class="key">管理员账户</td>
                <td class="value">
                    <input type="text" name="merager_name" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key">管理密码</td>
                <td class="value">
                    <input  type="password" name="merager_pwd" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key">备注信息</td>
                <td class="value">
                    <input  type="text" name="remark" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key">所属权限组</td>
                <td class="value">
                    <select name="rid">
                        <?php foreach ($rights as $row):?>
                        <option value="<?php echo $row['id'];?>"><?php echo $row['acc_name'];?></option>
                        <?php endforeach;?>
                    </select>
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