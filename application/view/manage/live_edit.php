<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>发布直播</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/jedate');?>/jedate.css">
    <script src="<?php echo base_url('resource/js/jquery.js');?>"></script>
    <script src="<?php echo base_url('resource/jedate/jquery.jedate.min.js');?>"></script>
</head>
<body>
<h1 class="title">发布直播</h1>
<div class="center">
    <div class="top_button">
        <a href="javascript:history.back()">返回</a>
    </div>
    <form action="<?php echo site_url('manage/applications/live/edit/'.$id.'/submit');?>" method="post" enctype="multipart/form-data">
        <table class='input'>
            <tr>
                <td class="key">直播标题</td>
                <td class="value">
                    <input type="text" name="title" class='text' value="<?php echo $title;?>">
                </td>
            </tr>
            <tr>
                <td class="key">开播时间</td>
                <td class="value">
                    <input type="text" name="livetime" class='text' id="jedate" readonly  value="<?php echo date('Y-m-d H:i:s',$livetime);?>">
                    <script>
                        $(function(){
                            $("#jedate").jeDate({
                                format:"YYYY-MM-DD hh:mm:ss",
                                isTime:true
                            })
                        });
                    </script>
                </td>
            </tr>
            <tr>
                <td class="key">课程时长</td>
                <td class="value">
                    <input type="text" name="duration" class='text short' value="<?php echo $duration;?>"> 分钟
                </td>
            </tr>
            <tr>
                <td class="key">讲师</td>
                <td class="value">
                    <input type="text" name="teacher" class='text short' value="<?php echo $teacher;?>">
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
                <td class="key">直播M3U8播放源</td>
                <td class="value">
                    <input type="text" name="stream_1" class='text' value="<?php echo $stream_1;?>">
                </td>
            </tr>
            <tr>
                <td class="key">回放M3U8播放源</td>
                <td class="value">
                    <input type="text" name="stream_2" class='text' value="<?php echo $stream_2;?>">
                </td>
            </tr>
            <tr>
                <td class="key">直播简介</td>
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