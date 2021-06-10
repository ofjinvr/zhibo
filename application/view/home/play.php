<!doctype html>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?=$info['title']?></title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/zbym.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/play.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/clappr.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('resource')?>/js/jquery.js"></script>
</head>
<body>
<!--[if lt IE 9]>
<script >
    $(function(){
        $('body').css('font-size','18px')
            .html('您的浏览器版本过低，可能无法支持HTML5播放控件。请升级您的浏览器至IE9或更高。推荐使用：微软Edge浏览器、谷歌浏览器、火狐浏览器。 <br><a href="javascript:history.back()">返回上一页</a>');
    });
</script>
<![endif]-->
    <div class="container">
        <header>
            <div class="mainTop" style="margin-left: 40px;">
                <div class="bannerTop">
                    <div class="bannerText">
                        <a href="<?php echo site_url();?>">
                            <img src="<?php echo base_url('resource/home')?>/images/logo.png" alt="" style="float: left;margin-right: 30px"  style='height:80px'>
                        </a>
                    </div>
                </div>
            </div>
        </header>
        <div class="containerL">
            <div id="play" style="width: 100%; height: 100%; box-sizing: border-box; padding-bottom: 80px;"></div>
        </div>
        <div class="containerR">
            <div class='chatroom'>
                <div class='chatroom_head'>
                        <span class='hudong'>互动咨询</span>
                        <span class='descrip'>视频介绍</span>
                 </div>
                 <div class="chatroom_body">
                    <div  class='chatcontent'>
                        <div class='chatinner' id='chatinner'></div>
                    </div>
                 </div>
                 <div class='chatroom_right hide '>
                    <p>讲师 : <?=$info['teacher']?></p>
                    <p>课程简介 : <?=$info['destext']?></p>
                 </div>
                 <div class='keyin'>
                    <input type="hidden" id="lid" value="<?=$info['id']?>">
                    <input type="text"  placeholder="请输入您的问题" class='input'>
                    <button class='button'>发送</button>
                 </div>
            </div>
        </div>
    </div>
    <script>
        new Clappr.Player({
            source: "<?php if($nav==='live'){echo $info['stream_1'];} if($nav==='replay'){echo $info['stream_2'];}?>",
            parentId: "#play",
            poster: '<?=base_url('resource/home/images2/pptback.jpg')?>',
            muted:false,
            autoPlay:true,
            disableVideoTagContextMenu:true
        });
    </script>
    <script src="<?=base_url('resource/home/js2/chat.js')?>"></script>
</body>
</html>