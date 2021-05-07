<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>文章编辑</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <script src="<?php echo base_url('resource/js/jquery.js');?>"></script>
    <script src="<?php echo base_url('plugin/ueditor/ueditor.config.js');?>"></script>
    <script src="<?php echo base_url('plugin/ueditor/ueditor.all.min.js');?>"></script>
</head>
<body>
<h1 class="title">文章编辑</h1>
<div class="center">
    <div class="top_button">
        <a href="javascript:history.back()">返回</a>
    </div>
    <form action="<?php echo site_url('manage/applications/article/edit/'.$id.'/submit');?>" method="post" enctype="multipart/form-data">
        <table class='input'>
            <tr>
                <td class="key">文章标题</td>
                <td class="value">
                    <input type="text" name="title" class='text' value="<?php echo $title;?>">
                </td>
            </tr>
            <tr>
                <td class="key">文章摘要</td>
                <td class="value">
                    <textarea name="summary"><?php echo $summary;?></textarea>
                </td>
            </tr>
            <tr>
                <td class="key">文章正文</td>
                <td class="value">
                    <textarea name="content" id="content"><?php echo $content;?></textarea>
                </td>
            </tr>
            <tr>
                <td class="key"></td>
                <td class="value"><input  type="submit" class='button' value="提交"></td>
            </tr>
        </table>
    </form>
</div>
<script>
    $(function(){
        var ue = UE.getEditor('content');
    })
</script>
</body>
</html>