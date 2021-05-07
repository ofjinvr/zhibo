<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>账户管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">账户管理</h1>
    <div class="center">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>账户名</th>
                    <th>权限组</th>
                    <th>状态</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)):?>
                <?php foreach($list as $row):?>
                <tr>
                    <td class="t_center"><?php echo $row['id'];?></td>
                    <td><?php echo $row['merager_name'];?></td>
                    <td><?php echo $row['acc_name'];?></td>
                    <td class="t_center"><?php echo $row['status']==='1'?'正常':'停用';?></td>
                    <td class="t_center">
                        <a href="<?php echo site_url('manage/account/user/info').'/'.$row['id'];?>">查看详情</a>
                        | 
                        <a href="<?php echo site_url('manage/account/user/edit').'/'.$row['id'];?>">编辑</a>
                        | 
                        <a href="<?php echo site_url('manage/account/user/del').'/'.$row['id'];?>" onclick="return confirm('确定删除吗?');">删除</a>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                    <td class="t_center" colspan="5">暂无数据</td>
                </tr>
                <?php endif;?>
            </tbody>
        </table>
        <?php echo $page;?>
    </div>
</body>
</html>