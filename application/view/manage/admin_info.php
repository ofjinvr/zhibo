<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>管理账户详情</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">管理账户详情</h1>
    <div class="center">
        <div class="top_button"><a href="<?php echo site_url('manage/account/user');?>"><返回列表</a></div>
        <table class="input">
                <tr>
                    <td class="key">账户名称</td>
                    <td class="value"><?php echo $info['merager_name'];?></td>
                </tr>
                <tr>
                    <td class="key">账户状态</td>
                    <td class="value"><?php echo $info['status']==='1'?'正常':'停用';?></td>
                </tr>
                <tr>
                    <td class="key">所属权限组</td>
                    <td class="value"><?php echo $info['acc_name'];?></td>
                </tr>
                <tr>
                    <td class="key">拥有权限</td>
                    <td class="value">
                        <textarea disabled><?php echo $info['rule'];?></textarea>
                    </td>
                </tr>
                <tr>
                    <td class="key">账户备注</td>
                    <td class="value"><?php echo $info['remark'];?></td>
                </tr>                
        </table>
        
    </div>
</body>
</html>