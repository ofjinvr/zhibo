<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>发布现场培训</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/jedate');?>/jedate.css">
    <script src="<?php echo base_url('resource/js/jquery.js');?>"></script>
    <script src="<?php echo base_url('resource/jedate/jquery.jedate.min.js');?>"></script>
</head>
<body>
    <h1 class="title">发布现场培训</h1>
    <div class="center">
        <div class="top_button">
            <a href="javascript:history.back()">返回</a>
        </div>
        <form action="<?php echo site_url('manage/applications/teach/add/submit');?>" method="post" enctype="multipart/form-data">
        <table class='input'>
            <tr>
                <td class="key">培训标题</td>
                <td class="value">
                    <input type="text" name="title" class='text'>
                </td>
            </tr>
            <tr>
                <td class="key">培训时间</td>
                <td class="value">
                    <input type="text" name="teachtime" class='text' id="jedate" readonly>
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
                <td class="key">地址</td>
                <td class="value">
                    <input type="text" name="address" class='text'>
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
                <td class="key">讲师</td>
                <td class="value">
                    <input type="text" name="teacher" class='text short'>
                </td>
            </tr>
            <tr>
                <td class="key">主办单位</td>
                <td class="value">
                    <input type="text" name="sponsor" class='text short'>
                </td>
            </tr>
            <tr>
                <td class="key">计划人数</td>
                <td class="value">
                    <input type="number" name="pnumber" class='text short' value="0">
                </td>
            </tr>
            <tr>
                <td class="key">剩余名额</td>
                <td class="value">
                    <input type="number" name="snumber" class='text short' value="0">
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
                    <select name="cityname" id="city_selector">
                        <option value="">请选择</option>
                        <?php foreach ($city_list as $row):?>
                            <option value="<?=$row['city_name']?>"><?=$row['city_name']?></option>
                        <?php endforeach;?>
                    </select>
                    <select name="areaname" id="area_selector">
                        <option value="">请选择</option>
                    </select>
                    <script>
                        $(function(){
                            $('#city_selector').change(function(){
                                $.get('<?=site_url('api/getCityArea/')?>?cityname='+$('#city_selector>option:selected').val(),function(result){
                                    var opt = '<option value="">请选择</option>';
                                    $(result).each(function(k,v){
                                        opt += '<option value="'+v.area_name+'">'+v.area_name+'</option>';
                                    })
                                    $('#area_selector').html(opt);
                                },'json');
                            });
                        });
                    </script>
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
                <td class="key">简介概述</td>
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