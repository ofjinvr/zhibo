<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>管理中心</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">管理中心</h1>
    <h2 class="index user"><a href="<?php echo site_url('manage/account/security/pwd_modify');?>">修改密码</a>账号信息</h2>
    <div class="holder">
        <ul>
            <li>我的账号: <span><?php echo $manager_data['merager_name'];?></span></li>
            <li>所属权限组: <span><?php echo $manager_data['acc_name'];?></span></li>
            <li>我的权限: <span><?php echo $manager_data['rule'];?></span></li>
        </ul>
    </div>
    <h2 class="index status">
        <a href="<?php echo site_url('manage/home/common/status');?>">环境详情</a>网站状态
    </h2>
    <div class="holder">
        <ul>
            <li>网站域名: <span><?php echo $_SERVER['HTTP_HOST'];?></span></li>
            <li>开发者模式: <span><?php if(Config::APP_DEBUG){echo '已开启 (正式上线应该关闭)';}else{echo '已关闭';}?></span></li>
            <li>网站路由模式: <span><?php echo Config::ROUTER_MODE;?></span></li>
        </ul>
    </div>
    <h2 class="index log"><a href="<?php echo site_url('manage/account/security/log');?>">详细日志</a>登录日志</h2>
    <div class="holder">
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
                <?php if(!empty($log)):?>
                <?php foreach($log as $row):?>
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
    </div>
</body>
</html>