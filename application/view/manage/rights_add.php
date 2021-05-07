<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>新建权限组</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <script src="<?php echo base_url('resource/js');?>/jquery.js"></script>
    <script type="text/javascript">
    $(function(){
        var checkboxs = $('input[type=checkbox]:not(#all)'),
            status= null;
        $("#all").change(function(){
            status = $(this).is(':checked');
            checkboxs.attr('disabled',status);
            
        });
    })
    </script>
</head>
<body>
    <h1 class="title">新建权限组</h1>
    <div class="center">
        <form action="<?php echo site_url('manage/account/permission/add/action');?>" method="post">
        <table class='input'>
            <tr>
                <td class="key">权限组名称</td>
                <td class="value"><input  type="text" name="acc_name" class='text'></td>
            </tr>
            <tr>
                <td class="key">选择权限</td>
                <td class="value">
                    <p><label><input  type="checkbox" class='checkbox' id="all" name="rule[]" value="*">所有权限</label></p>
                    <?php foreach($rights as $key=>$value):?>
                    <label><input type="checkbox" class='checkbox' name="rule[]" value="<?php echo $key;?>"><?php echo $value;?></label>
                    <?php endforeach; ?>
                </td>
            </tr>
            <tr>
                <td class="key"></td>
                <td class="value"><input  type="submit" class='button' value="提交"></td>
            </tr>
        </table>
        </form>
    </div>
</body>
</html>