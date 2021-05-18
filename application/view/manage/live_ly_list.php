<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>互动留言管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
<h1 class="title">互动留言管理</h1>
<div class="center">
    <div class="top_button">
        <a href="javascript:history.back()">返回</a>
    </div>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>评论人</th>
            <th>IP</th>
            <th>内容</th>
            <th>时间</th>
            <th>状态</th>
            <th>管理操作</th>
        </tr>
        </thead>
        <tbody>
        <?php if(!empty($list)):?>
            <?php foreach($list as $row):?>
                <tr>
                    <td class="t_center"><?php echo $row['id'];?></td>
                    <td class="t_center"><?php echo $row['mobile'];?></td>
                    <td class="t_center"><?php echo $row['ip'];?></td>
                    <td class="t_center"><?php echo $row['message'];?></td>
                    <td class="t_center"><?php echo date('Y-m-d H:i:s',$row['pubtime']);?></td>
                    <td class="t_center"><?php echo $row['is_checked'] ? '已审核' : '未审核';?></td>
                    <td class="t_center">
                        <a href="<?php echo site_url('manage/applications/live/ly_check/'.$row['id'])?>">通过审核</a> |
                        <a href="<?php echo site_url('manage/applications/live/ly_remove/'.$row['id'])?>">删除</a>
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