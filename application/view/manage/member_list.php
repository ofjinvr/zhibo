<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>会员管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">会员管理</h1>
    <div class="center">
        <table>
            <thead>
                <tr>
                    <th>会员ID</th>
                    <th>会员手机</th>
                    <th>姓名</th>
                    <th>单位</th>
                    <th>状态</th>
                    <th>身份(回复特殊标志)</th>
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)):?>
                <?php foreach($list as $row):?>
                <tr>
                    <td class="t_center"><?php echo $row['id'];?></td>
                    <td><?php echo $row['mobile'];?></td>
                    <td><?php echo $row['member_name'];?></td>
                    <td><?php echo $row['company'];?></td>
                    <td><?php echo $row['disable']==='1'?'停用':'启用';?></td>
                    <td><?php echo $row['is_manage']==='1'?'官方人员':'普通用户';?></td>
                    <td class="t_center">
                        <a href="<?php echo site_url('manage/applications/member/disable').'/'.$row['id'];?>">停用</a>
                        |
                        <a href="<?php echo site_url('manage/applications/member/enable').'/'.$row['id'];?>" >启用</a>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                    <td class="t_center" colspan="100">暂无数据</td>
                </tr>
                <?php endif;?>
            </tbody>
        </table>
        <?php include 'page.php';?>
    </div>
</body>
</html>