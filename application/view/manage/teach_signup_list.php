<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>现场培训报名表</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">现场培训报名表</h1>
    <div class="center">
        <div class="top_button">
            <a href="javascript:history.back()">返回</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>姓名</th>
                    <th>手机号</th>
                    <th>地区</th>
                    <th>公司名称</th>
                    <th>单位性质</th>
                    <th>职务</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($list)):?>
                <?php foreach($list as $row):?>
                <tr>
                    <td class="t_center"><?php echo $row['id'];?></td>
                    <td class="t_center"><?php echo $row['member_name'];?></td>
                    <td class="t_center"><?php echo $row['mobile'];?></td>
                    <td class="t_center"><?php echo $row['city'];?> <?php echo $row['area'];?></td>
                    <td class="t_center"><?php echo $row['company_name'];?></td>
                    <td class="t_center"><?php echo $row['company_nature'];?></td>
                    <td class="t_center"><?php echo $row['job']?></td>
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