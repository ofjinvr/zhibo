<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>备份数据库</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">数据库还原</h1>
    <div class="center">
        <form action="<?php echo site_url('manage/data/database/restore');?>" method="post">
        <table class='input'>
            <tr>
                <td class="key">使用须知</td>
                <td class="value">
                    <ul>
                        <li>1: 暂只支持表以及数据的备份(视图,事务,储存过程等功能待完善)</li>
                        <li>2: 本功能仅作为便于管理的备份工具而免费使用</li>
                        <li>3: 使用本功能引发的所有后果作者不承担任何责任,如需要数据保障请使用专业软件</li>
                        <li>4: 本功能一切解释权归作者所有</li>
                        <li>5: 使用本功能视为同意以上所有条款</li>
                    </ul>
                </td>
            </tr>
            <tr>
                <td class="key">选择备份文件</td>
                <td class="value">
                    <select name="bakfile">
                        <option value="">请选择备份文件</option>
                        <?php foreach($baklist as $row):?>
                        <option value="<?php echo base64_encode(basename($row));?>">
                            <?php echo substr($row,0,strpos($row,'-'));?>
                        </option>
                        <?php endforeach;?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">还原数据库</td>
                <td class="value"><input  type="submit" name="submit" class='button' value="开始还原"></td>
            </tr>
        </table>
        </form>
    </div>
</body>
</html>