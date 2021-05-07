<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>公司介绍</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <script src="<?php echo base_url('resource/js/jquery.js');?>"></script>
    <script src="<?php echo base_url('plugin/ueditor/ueditor.config.js');?>"></script>
    <script src="<?php echo base_url('plugin/ueditor/ueditor.all.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('resource/jedate/');?>jedate.min.js"></script>
    <style>
        
    </style>
</head>
<body>
    <h1 class="title">文章发布</h1>
    <div class="center">
        <div class="top_button">
            <a href="javascript:history.back()">返回</a>
        </div>
        <form action="<?php echo site_url('manage/setting/base/about/action');?>" method="post" enctype="multipart/form-data">
        <table class='input'>  
            <tr>
                <td class="key">公司介绍</td>
                <td class="value">
                    <textarea name="brief" id="content"><?php echo $brief; ?></textarea>
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
        $('select[name=cid]').change(function(){
            var catename = $(this).find('option:selected').text();
            if(catename.indexOf('活动')!==-1){
                $('tr.hd').show();
            }else{
                $('tr.hd').hide();
            }
        })
        jeDate({
		dateCell:"#setTime",//isinitVal:true,
		format:"YYYY-MM-DD hh:mm:ss",
		isTime:true, //isClear:false,
		minDate:"<?php echo date('Y-m-d H:i:s');?>",
		maxDate:"2099-12-31 00:00:00"
	})
    })
    </script>
</body>
</html>