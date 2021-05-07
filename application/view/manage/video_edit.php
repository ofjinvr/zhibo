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
    <form action="<?php echo site_url('manage/applications/video/edit/'.$id.'/submit');?>" method="post" enctype="multipart/form-data">
        <table class='input'>
            <tr>
                <td class="key">视频标题</td>
                <td class="value">
                    <input type="text" name="title" class='text' value="<?php echo $title;?>">
                </td>
            </tr>
            <tr>
                <td class="key">类型</td>
                <td class="value">
                    <select name="typename">
                        <option value="财税政策" <?php if($typename==='财税政策') echo 'selected';?>>财税政策</option>
                        <option value="办税指南" <?php if($typename==='办税指南') echo 'selected';?>>办税指南</option>
                        <option value="软件操作" <?php if($typename==='软件操作') echo 'selected';?>>软件操作</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">城市</td>
                <td class="value">
                    <select name="cityname">
                        <option value="西安" <?php if($cityname==='西安') echo 'selected';?>>西安</option>
                        <option value="咸阳" <?php if($cityname==='咸阳') echo 'selected';?>>咸阳</option>
                        <option value="安康" <?php if($cityname==='安康') echo 'selected';?>>安康</option>
                        <option value="延安" <?php if($cityname==='延安') echo 'selected';?>>延安</option>
                        <option value="汉中" <?php if($cityname==='汉中') echo 'selected';?>>汉中</option>
                        <option value="渭南" <?php if($cityname==='渭南') echo 'selected';?>>渭南</option>
                        <option value="榆林" <?php if($cityname==='榆林') echo 'selected';?>>榆林</option>
                        <option value="商洛" <?php if($cityname==='商洛') echo 'selected';?>>商洛</option>
                        <option value="宝鸡" <?php if($cityname==='宝鸡') echo 'selected';?>>宝鸡</option>
                        <option value="铜川" <?php if($cityname==='铜川') echo 'selected';?>>铜川</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">角色</td>
                <td class="value">
                    <select name="rolename">
                        <option value="个体" <?php if($rolename==='个体') echo 'selected';?>>个体</option>
                        <option value="企业" <?php if($rolename==='企业') echo 'selected';?>>企业</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="key">封面图片</td>
                <td class="value">
                    <?php if(!empty($imgurl)):?>
                        <p><img src="<?php echo base_url($imgurl);?>" alt="" height="100"></p>
                    <?php endif;?>
                    <input type="file" name="imgurl">
                    <span class="tips">接受500KB以下JPG,PNG,GIF图片;</span>
                </td>
            </tr>
            <tr>
                <td class="key">视频源</td>
                <td class="value">
                    <input type="text" name="stream" class='text' value="<?php echo $stream;?>">
                </td>
            </tr>
            <tr>
                <td class="key">视频简介</td>
                <td class="value">
                    <textarea name="destext"><?php echo $destext;?></textarea>
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