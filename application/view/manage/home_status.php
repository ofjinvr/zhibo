<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>管理中心</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">服务器环境</h1>
    <div class="center">
        <table>
            <tbody>
                <?php foreach($server as $key => $value):?>
                <tr>
                    <td><?php echo $key;?></td>
                    <td><?php echo $value;?></td>
                </tr>
                <?php endforeach;?>
            </tbody>
        </table>
    </div>
</body>
</html>