<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$info['title']?></title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/zbym.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/clappr@latest/dist/clappr.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <style>
        .bannerTop{
            height:80px;
        }
        .bannerTop img{
            height:80px;
        }
        .chatroom{
            width:100%;
            height: 100%;
        }
        .chatroom_head{
            height: 60px;
            overflow: hidden;
        }
        .chatroom_head span{
            background:#2FA6E8;
            float:left;
            width:50%;
            height:60px;
            box-sizing: border-box;
            font-size: 18px;
            color:#fff;
            text-align: center;
            line-height: 60px;
            cursor:pointer;
        }

        .chatroom_head span:nth-of-type(1){
            border-right:2px solid #fff;
        }
        .chatroom_body{
            height: 70%;
        } 
        .chatroom_right{
            height:80%;
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
            margin-bottom: 0;
            margin-top: 10px;
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
            height:34px;
            width: 18%;
            background:#007FDC;
            border:0;
            cursor:pointer;
            color:#fff;
            text-align:center;
            line-height:34px;
        }
        .hide{
            display: none;
        }
        .chatcontent{
            height:100%;
            overflow-y: scroll;
        }
        .chatroom_right p{
            padding:5px;
        }
    </style>
</head>
<body>
<!--[if lt IE 9]> ??????????????????????????????????????????????????????????????????????????? <![endif]-->
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
            <div id="play_1" style="width: 100%; height: 100%; box-sizing: border-box; padding-bottom: 80px;"></div>
            <script>
            new Clappr.Player({
                source: "<?=$info['stream_1']?>",
                parentId: "#play_1",
                poster: '<?=base_url('resource/home/images2/pptback.jpg')?>',
                muted:false,
                autoPlay:true,
                disableVideoTagContextMenu:true
            });
            </script>
        </div>
        <div class="containerR">
            <div class='chatroom'>
            		<div class='chatroom_head'>
            				<span class='hudong'>????????????</span>
            				<span class='descrip'>????????????</span>
            		 </div>
            		 <div class="chatroom_body">
            			<div  class='chatcontent'>
            				<div class='chatinner' id='chatinner'>
                                <?php foreach($msg_list as $row):?>
                                <ul><li class="info"><?=substr_replace($row['mobile'],'****',4,4)?> &nbsp;<?=date('Y-m-d H:i:s',$row['pubtime'])?></li><li class="question"><?=$row['message']?></li></ul>
                                <?php endforeach;?>
            				</div>
            			</div>
            		 </div>
            		 <div class='chatroom_right hide '>
            			<p>?????? : <?=$info['teacher']?></p>
            			<p>???????????? : <?=$info['destext']?></p>
            		 </div>
            		 <div class='keyin'> 
                                <input type="hidden" id="lid" value="<?=$info['id']?>">
                                <input type="text"  placeholder="?????????????????????" class='input'>
                                <button class='button'>??????</button>
            		 </div>
            	</div>
        </div>
    </div>
    <script src="<?=base_url('resource/home/js2/chat2.js')?>"></script>
    <script>
        $('#play_1>div').css({
            width : '100%',
            height: '100%'
        });
    </script>
</body>
</html>