<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>登录日志</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">登录日志</h1>
    <div class="center">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>账户</th>
                    <th>登录IP</th>
                    <th>登录时间</th>
                    <th>状态</th>
                    <th>错误密码</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)):?>
                <?php foreach($list as $row):?>
                <tr>
                    <td class="t_center"><?php echo $row['id'];?></td>
                    <td><?php echo $row['merager_name'];?></td>
                    <td><?php echo $row['ip'];?></td>
                    <td class="t_center"><?php echo date('Y-m-d H:i:s',$row['login_time']);?></td>
                    <td class="t_center"><?php echo $row['status']==='1'?'登录成功':'登录失败';?></td>
                    <td><?php echo $row['error_pwd'];?></td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                    <td class="t_center" colspan="6">暂无数据</td>
                </tr>
                <?php endif;?>
            </tbody>
        </table>
        <?php echo $page;?>
    </div>
</body>
</html>