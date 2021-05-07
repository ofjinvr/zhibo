<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>发布视频</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <script src="<?php echo base_url('resource/js/jquery.js');?>"></script>
</head>
<body>
    <h1 class="title">发布视频</h1>
    <div class="center">
        <div class="top_button">
            <a href="javascript:history.back()">返回</a>
        </div>
        <form action="<?php echo site_url('manage/applications/video/add/submit');?>" method="post" enctype="multipart/form-data">
        <table class='input'>
            <tr>
                <td class="key">视频标题</td>
                <td class="value">
                    <input type="text" name="title" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key">类型</td>
                <td class="value">
                    <select name="typename">
                        <option value="财税政策">财税政策</option>
                        <option value="办税指南">办税指南</option>
                        <option value="软件操作">软件操作</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">城市</td>
                <td class="value">
                    <select name="cityname">
                        <option value="西安">西安</option>
                        <option value="咸阳">咸阳</option>
                        <option value="安康">安康</option>
                        <option value="延安">延安</option>
                        <option value="汉中">汉中</option>
                        <option value="渭南">渭南</option>
                        <option value="榆林">榆林</option>
                        <option value="商洛">商洛</option>
                        <option value="宝鸡">宝鸡</option>
                        <option value="铜川">铜川</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">角色</td>
                <td class="value">
                    <select name="rolename">
                        <option value="个体">个体</option>
                        <option value="企业">企业</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">封面图片</td>
                <td class="value">
                    <input type="file" name="imgurl">
                    <span class="tips">接受500KB以下JPG,PNG,GIF图片;</span>
                </td>
            </tr>
            <tr>
                <td class="key">视频源</td>
                <td class="value">
                    <input type="text" name="stream" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key">视频简介</td>
                <td class="value">
                    <textarea name="destext"></textarea>
                </td>
            </tr>
            <tr>
                <td class="key"></td>
                <td class="value"><input type="submit" class='button' value="提交"></td>
            </tr>
        </table>
        </form>
    </div>
</body>
</html>