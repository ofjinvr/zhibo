<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>备份管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">备份管理</h1>
    <div class="center">
        <table>
            <thead>
                <tr>
                    <th>文件名</th>
                    <th>操作(<a href="<?php echo site_url('manage/data/database/index/delete/'.base64_encode('clear'));?>" onclick="return confirm('确定清空备份吗?');">清空备份</a>)</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)):?>
                <?php foreach($list as $row):?>
                <tr>
                    <td><?php echo $row;?></td>
                    <td class="t_center">
                        <a href="<?php echo site_url('manage/data/database/index/download/'.base64_encode($row));?>">下载</a>
                        |
                        <a href="<?php echo site_url('manage/data/database/index/delete/'.base64_encode($row));?>" onclick="return confirm('确定删除吗?');">删除</a>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                    <td class="t_center" colspan="2">暂无备份文件</td>
                </tr>
                <?php endif;?>
            </tbody>
        </table>
        <?php echo $page;?>
    </div>
</body>
</html>