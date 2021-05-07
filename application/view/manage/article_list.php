<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>文章管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">文章管理</h1>
    <div class="center">
        <div class="top_button">
            <a href="<?php echo site_url('manage/applications/article/add');?>">发布文章</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>文章ID</th>
                    <th>文章名称</th>
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)):?>
                <?php foreach($list as $row):?>
                <tr>
                    <td class="t_center"><?php echo $row['id'];?></td>
                    <td><?php echo $row['title'];?></td>
                    <td class="t_center">
                        <a href="<?php echo site_url('manage/applications/article/edit').'/'.$row['id'];?>">编辑</a>
                        |
                        <a href="<?php echo site_url('manage/applications/article/remove').'/'.$row['id'];?>" onclick="return confirm('确定删除吗?');">删除</a>
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