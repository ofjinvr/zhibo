<!DOCTYPE html>
<html lang="zh-cn">
<head>
    <meta charset="UTF-8">

    <title><?=$info['title']?></title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title></title>
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <meta http-equiv="X-UA-Compatible" content="IE=Edge，chrome=1">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/zbym.css">

    <style>

    .chatroom{
        width:100%;
        height: calc(100% - 310px);
        position:relative;
    }
    .chatroom_head{
        height: 40px;
    }
    .chatroom_head span{
        background:#2FA6E8;
        display: inline-block;
         width:calc((100% - 1px)/2);
        height:40px;
        box-sizing: border-box;
        font-size: 12px;
        color:#fff;
        text-align: center;
        line-height: 40px;
        cursor:pointer;
    }
    .chatroom_head span:nth-of-type(1){
        float:left;
        border-left:1px solid #ccc;
    }
    .chatroom_head span:nth-of-type(2){
        float:right;
    }
    .chatroom_body{
        height: calc(100% - 80px);
    }
    .chatroom_right{
        height:320px;
    }
    .chatroom_body ul{
        list-style: none;
        padding:0 10px;
    }
    .fixedtop{
        padding-left: 10px;
        color:#ef600f;
    }
    ul .info{
        color:blue;
    }
    ul .info.self{
        color:green;
    }
    ul .info.teacher{
        color:#ef600f;
    }
    .question{
        word-break:break-all;
    }
    .keyin{
        height:30px;
        position:absolute;
        bottom:10px;
        width:100%;
    }
    .keyin  input{
        height:30px;
        width:80%;
        margin-top:2px;
        padding-left:10px;
        box-sizing: border-box;
        border:1px solid #ccc;
    }
    .keyin  button{
        float:right;
        height:30px;
        width: 18%;
        background:#007FDC;
        border:0;
        cursor:pointer;
        color:#fff;
        text-align:center;
        line-height:30px;
        margin-top: 1px;
    }
    .hide{
        display: none;
    }
    .chatcontent{
        height:100%;
        overflow-y: scroll;
    }
    .video{
        height: 270px;
        background-color: #006AB8;
        position: relative;
    }
    .containerR_media {
        position: absolute;
        width: 60px;
        height: 60px;
        top: 5px;
        right: 0;
    }
    .containerR_media video {
        height: 60px;
    }
    .bannerTop{
        height:40px;
    }
    .bannerTop img{
        height:40px;
    }
    </style>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
</head>
<body>
    <header>
        <div class="mainTop">
            <div class="bannerTop">
                <div class="bannerText">
                    <a href="<?php echo site_url();?>">
                    <img src="<?php echo base_url('resource/home')?>/images/logo.png" alt="">
                    </a>
                </div>
            </div>
        </div>
    </header>
    <div class='video'>
        <div id="play_1" style="box-sizing: border-box; "></div>
        <script>
            new Clappr.Player({
                source: "<?=$info['stream_2']?>",
                parentId: "#play_1",
                autoPlay:true,
                disableVideoTagContextMenu:true
            });
            $('#play_1>div').css({
                width:'100%',
                height:'270px'
            })
        </script>
    </div>
    <div class='chatroom'>
        <div class='chatroom_head'>
            <span class='hudong'>互动咨询</span>
            <span class='descrip'>视频介绍</span>
        </div>
        <div class="chatroom_body">
            <!-- 	<p class="fixedtop"> 系统提示: 欢迎某某某某进入直播教室</p> -->
            <div  class='chatcontent'>
                <div class='chatinner' id='chatinner'>
                    <?php foreach($msg_list as $row):?>
                        <ul><li class="info"><?=substr_replace($row['mobile'],'****',4,4)?> &nbsp;<?=date('Y-m-d H:i:s',$row['pubtime'])?></li><li class="question"><?=$row['message']?></li></ul>
                    <?php endforeach;?>
                </div>
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
    <script src="<?=base_url('resource/home/js2/chat2.js')?>"></script>
    </body>
</html>
