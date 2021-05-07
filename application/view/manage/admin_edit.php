<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>编辑账户</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">编辑账户</h1>
    <div class="center">
        <div class="top_button"><a href="<?php echo site_url('manage/account/user');?>"><返回列表</a></div>
        <form action="<?php echo site_url('manage/account/user/edit/'.$info['id'].'/action');?>" method="post">
        <table class='input'>
            <tr>
                <td class="key">管理员账户</td>
                <td class="value">
                    <?php echo $info['merager_name'];?>
                </td>
            </tr>
            <tr>
                <td class="key">管理密码</td>
                <td class="value">
                    <input  type="password" name="merager_pwd" class='text'>
                    <span>不修改密码请留空</span>
                </td>
            </tr>
            <tr>
                <td class="key">备注信息</td>
                <td class="value">
                    <input  type="text" name="remark" class='text' value="<?php echo $info['remark'];?>">
                </td>
            </tr>
            <tr>
                <td class="key">账号状态</td>
                <td class="value">
                    <label>
                        <input type="radio" name="status" value="1" <?php if($info['status']==='1'){echo 'checked';}?>>正常
                    </label>
                    <label>
                        <input type="radio" name="status" value="0" <?php if($info['status']==='0'){echo 'checked';}?>>停用
                    </label>
                </td>
            </tr>
            <tr>
                <td class="key">所属权限组</td>
                <td class="value">
                    <select name="rid">
                        <?php foreach ($rights as $row):?>
                        <option value="<?php echo $row['id'];?>" <?php if($info['rid']===$row['id']){echo 'selected';}?>>
                            <?php echo $row['acc_name'];?>
                        </option>
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