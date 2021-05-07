<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>权限组详情</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">权限组详情</h1>
    <div class="center">
        <div class="top_button"><a href="<?php echo site_url('manage/account/permission');?>"><返回列表</a></div>
        <table class="input">
                <tr>
                    <td class="key">权限组名称</td>
                    <td class="value"><?php echo $row['acc_name'];?></td>
                </tr>
                <tr>
                    <td class="key">权限详情</td>
                    <td class="value">
                        <textarea disabled><?php echo $row['rule'];?></textarea>
                    </td>
                </tr>
        </table>
        
    </div>
</body>
</html>