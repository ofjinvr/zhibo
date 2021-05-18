<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>现场培训管理</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">现场培训管理</h1>
    <div class="center">
        <div class="top_button">
            <a href="<?php echo site_url('manage/applications/teach/add');?>">发布现场培训</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>标题</th>
                    <th>培训时间</th>
                    <th>地址</th>
                    <th>讲师</th>
                    <th>计划人数</th>
                    <th>剩余名额</th>
                    <th>主办单位</th>
                    <th>管理操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)):?>
                <?php foreach($list as $row):?>
                <tr>
                    <td class="t_center"><?php echo $row['id'];?></td>
                    <td class="t_center"><?php echo $row['title'];?></td>
                    <td class="t_center"><?php echo date('Y-m-d H:i:s',$row['teachtime']);?></td>
                    <td class="t_center"><?php echo $row['address'];?></td>
                    <td class="t_center"><?php echo $row['teacher'];?></td>
                    <td class="t_center"><?php echo $row['pnumber'];?></td>
                    <td class="t_center"><?php echo $row['snumber'];?></td>
                    <td class="t_center"><?php echo $row['sponsor']?></td>
                    <td class="t_center">
                        <a href="<?php echo site_url('manage/applications/teach/signup/'.$row['id'])?>">报名名单</a> |
                        <a href="<?php echo site_url('manage/applications/teach/edit/'.$row['id'])?>">编辑</a> |
                        <a href="<?php echo site_url('manage/applications/teach/remove/'.$row['id'])?>" onclick="javascript:return confirm('确认要删除吗？')">删除</a>
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