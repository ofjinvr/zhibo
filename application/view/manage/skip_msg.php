<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>提示信息</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <script src="<?php echo base_url('resource/js');?>/jquery.js"></script>
</head>
<body>
    <h1 class="title">提示信息</h1>
    <div class="holder">
        <div class="skip <?php echo $skip_status;?>"><span><?php echo $skip_message;?></span></div>
        <div class="count_down"><span id="count_times">3</span>秒后自动跳转,<a href="<?php echo $skip_url;?>" id="skip_url">手动跳转</a></div>
    </div>
    <script type="text/javascript">
    $(function(){
        var timeout = 3;
        var timer = setInterval(function(){
            timeout--;
            if(timeout<=0){
                window.location.href =  $('#skip_url').attr('href');
                clearInterval(timer);
            }
            $('#count_times').text(timeout);
        },1000);
    });
    </script>
</body>
</html>