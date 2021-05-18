<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$info['title']?></title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/zbym.css">
    <style>
    .bannerTop{
        height:80px;
    }
    .bannerTop img{
      height:80px;
    }
    .chatroom{
    			width:100%;
    			height: 630px;
    		}
    		.chatroom_head{
    			height: 60px;
    		}
    		.chatroom_head span{
    			background:#2FA6E8;
    			display: inline-block;
    			width:49%;
    			height:60px;
    			box-sizing: border-box;
    			font-size: 18px;
    			color:#fff;
    			text-align: center;
    			line-height: 60px;
    			cursor:pointer;
    		}
    		.chatroom_head span:nth-od-type(1){
    			border-right:2px solid #fff;
    		}
    		.chatroom_body{
    			height: 538px;
    		}
    		.chatroom_right{
    			height:538px;
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
    			height:520px;
    			overflow-y: scroll;
    		}
    		.chatroom_right p{
    		    padding:5px;
    		}
    </style>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="http://cdn.aodianyun.com/lss/aodianplay/player.js"></script>
</head>
<body>
    <div class="container">
        <div class="containerL">
            <div class="topTitle">
                <header>
                    <div class="mainTop">
                        <div class="bannerTop">
                            <div class="bannerText">
                                <a href="<?php echo site_url();?>">
                                <img src="<?php echo base_url('resource/home')?>/images/logo.png" alt="" style="float: left;margin-right: 30px"  style='height:80px'>
                                </a>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <div id="play_1" style="width: 100%; height: 100%; box-sizing: border-box; background: #000; padding-bottom: 80px;""></div>
            <script type="text/javascript">
                var objectPlayer=new aodianPlayer({
                    container:'play_1',//播放器容器ID，必要参数
                    rtmpUrl: '<?=$info['stream_1']?>',//控制台开通的APP rtmp地址，必要参数
                    hlsUrl: '<?=$info['stream_2']?>',//控制台开通的APP hls地址，必要参数
                    /* 以下为可选参数*/
                    width: '100%',//播放器宽度，可用数字、百分比等
                    height: '100%',//播放器高度，可用数字、百分比等
                    autostart: true,//是否自动播放，默认为false
                    bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
                    maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
                    stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
                    controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
                    adveDeAddr: '<?php echo base_url('resource/home')?>/images2/pptback.jpg',//封面图片链接
                    //adveWidth: 320,//封面图宽度
                    //adveHeight: 240,//封面图高度
                    //adveReAddr: '',//封面图点击链接
                    //isclickplay: false,//是否单击播放，默认为false
                    isfullscreen: true//是否双击全屏，默认为true
                });
                /* rtmpUrl与hlsUrl同时存在时播放器优先加载rtmp*/
                /* 以下为Aodian Player支持的事件 */
                /* objectPlayer.startPlay();//播放 */
                /* objectPlayer.pausePlay();//暂停 */
                /* objectPlayer.stopPlay();//停止 hls不支持*/
                /* objectPlayer.closeConnect();//断开连接 */
                /* objectPlayer.setMute(true);//静音或恢复音量，参数为true|false */
                /* objectPlayer.setVolume(volume);//设置音量，参数为0-100数字 */
                /* objectPlayer.setFullScreenMode(1);//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。手机不支持 */
            </script>
        </div>
        <div class="containerR">
            <div class="containerR_media">
                <div id="play_2" style="height:320px; background: #000;"></div>
                <script type="text/javascript">
                    var objectPlayer=new aodianPlayer({
                        container:'play_2',//播放器容器ID，必要参数
                        rtmpUrl: '<?=$info['stream_3']?>',//控制台开通的APP rtmp地址，必要参数
                        hlsUrl: '<?=$info['stream_4']?>',//控制台开通的APP hls地址，必要参数
                        width: '100%',//播放器宽度，可用数字、百分比等
                        height: '100%',//播放器高度，可用数字、百分比等
                        autostart: true,//是否自动播放，默认为false
                        bufferlength: '1',//视频缓冲时间，默认为3秒。hls不支持！手机端不支持
                        maxbufferlength: '2',//最大视频缓冲时间，默认为2秒。hls不支持！手机端不支持
                        stretching: '1',//设置全屏模式,1代表按比例撑满至全屏,2代表铺满全屏,3代表视频原始大小,默认值为1。hls初始设置不支持，手机端不支持
                        controlbardisplay: 'enable',//是否显示控制栏，值为：disable、enable默认为disable。
                        //adveDeAddr: '',//封面图片链接
                        //adveWidth: 320,//封面图宽度
                        //adveHeight: 240,//封面图高度
                        //adveReAddr: '',//封面图点击链接
                        //isclickplay: false,//是否单击播放，默认为false
                        isfullscreen: true//是否双击全屏，默认为true
                    });
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
        </div>
    </div>
    <script src="<?=base_url('resource/home/js2/chat2.js')?>"></script>
</body>
</html>