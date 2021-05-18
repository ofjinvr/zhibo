<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>直播管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">直播管理</h1>
    <div class="center">
        <div class="top_button">
            <a href="<?php echo site_url('manage/applications/live/add');?>">发布直播</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>直播名称</th>
                    <th>开播时间</th>
                    <th>城市</th>
                    <th>类型</th>
                    <th>讲师</th>
                    <th>角色</th>
                    <th>持续时间</th>
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)):?>
                <?php foreach($list as $row):?>
                <tr>
                    <td class="t_center"><?php echo $row['id'];?></td>
                    <td class="t_center"><?php echo $row['title'];?></td>
                    <td class="t_center"><?php echo date('Y-m-d H:i:s',$row['livetime']);?></td>
                    <td class="t_center"><?php echo $row['cityname'];?></td>
                    <td class="t_center"><?php echo $row['typename'];?></td>
                    <td class="t_center"><?php echo $row['teacher'];?></td>
                    <td class="t_center"><?php echo $row['rolename'];?></td>
                    <td class="t_center"><?php echo $row['duration'];?>分钟</td>
                    <td class="t_center">
                        <a href="<?php echo site_url('manage/applications/live/msg_list/'.$row['id'])?>">留言</a> |
                        <a href="<?php echo site_url('manage/applications/live/pl_list/'.$row['id'])?>">评论</a> |
                        <a href="<?php echo site_url('manage/applications/live/edit/'.$row['id'])?>">编辑</a> |
                        <a href="<?php echo site_url('manage/applications/live/remove/'.$row['id'])?>" onclick="javascript:return confirm('确认要删除吗？')">删除</a>
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