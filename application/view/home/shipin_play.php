<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$info['title']?></title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/zbym.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="http://cdn.aodianyun.com/lss/aodianplay/player.js"></script>
</head>
<body>
<div class="container">

    <div id="play_1" style="width: 100%; height: 100%; background: #000;"></div>
    <script type="text/javascript">
        var objectPlayer=new aodianPlayer({
            container:'play_1',//播放器容器ID，必要参数
            hlsUrl: '<?= $info['stream']?>',//控制台开通的APP hls地址，必要参数
            /* 以下为可选参数*/
            width: "100%",//播放器宽度，可用数字、百分比等
            height: "100%",//播放器高度，可用数字、百分比等
            autostart: true,//是否自动播放，默认为false
            controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
            //adveDeAddr: image,//封面图片链接
            //adveWidth: w,//封面图宽度
            //adveHeight: h,//封面图高度
            //adveReAddr: ''//封面图点击链接
        });
    </script>
</div>
</body>
</html>