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
                <td class="key">所属制作单位</td>
                <td class="value">
                    <select name="cityname">
                        <option value="省直属分局" <?php if($cityname==='省直属分局') echo 'selected';?>>省直属分局</option>
                        <option value="西安国税" <?php if($cityname==='西安国税') echo 'selected';?>>西安国税</option>
                        <option value="宝鸡国税" <?php if($cityname==='宝鸡国税') echo 'selected';?>>宝鸡国税</option>
                        <option value="咸阳国税" <?php if($cityname==='咸阳国税') echo 'selected';?>>咸阳国税</option>
                        <option value="安康国税" <?php if($cityname==='安康国税') echo 'selected';?>>安康国税</option>
                        <option value="延安国税" <?php if($cityname==='延安国税') echo 'selected';?>>延安国税</option>
                        <option value="汉中国税" <?php if($cityname==='汉中国税') echo 'selected';?>>汉中国税</option>
                        <option value="渭南国税" <?php if($cityname==='渭南国税') echo 'selected';?>>渭南国税</option>
                        <option value="榆林国税" <?php if($cityname==='榆林国税') echo 'selected';?>>榆林国税</option>
                        <option value="商洛国税" <?php if($cityname==='商洛国税') echo 'selected';?>>商洛国税</option>
                        <option value="铜川国税" <?php if($cityname==='铜川国税') echo 'selected';?>>铜川国税</option>
                        <option value="韩城国税" <?php if($cityname==='韩城国税') echo 'selected';?>>韩城国税</option>
                        <option value="西咸新区国税" <?php if($cityname==='西咸新区国税') echo 'selected';?>>西咸新区国税</option>
                        <option value="杨凌国税" <?php if($cityname==='杨凌国税') echo 'selected';?>>杨凌国税</option>
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