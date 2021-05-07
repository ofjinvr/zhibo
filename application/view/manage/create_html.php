<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>网站静态化文件生成</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
</head>
<body>
    <h1 class="title">网站静态化文件生成</h1>
    <div class="center">
        <div class="top_button">
            <a href="javascript:history.back()">返回</a>
        </div>
        <form action="<?php echo site_url('manage/setting/seo/create_html/action');?>" method="post" target="exec_window">
        <table class='input'>
            <tr>
                <td class="key">更新内容</td>
                <td class="value">
                    <label><input type="radio" name="create" value="home" checked="checked"/>更新首页</label>
                    <label><input type="radio" name="create" value="category" />更新栏目</label>
                    <label><input type="radio" name="create" value="article" />更新文章</label>
                    <label><input type="radio" name="create" value="article_id" />指定文章ID</label>
                </td>
            </tr>
            <tr>
                <td class="key">指定ID</td>
                <td class="value">
                    <input type="text" class="text short" name="id" value="" checked="checked" placeholder="指定的ID值"/>
                </td>
            </tr>
            <tr>
                <td class="key"></td>
                <td class="value"><input  type="submit" class='button' value="提交"></td>
            </tr>
        </table>
            <iframe name="exec_window" style="width:100%; height:300px;"></iframe>
        </form>
    </div>
</body>
</html>