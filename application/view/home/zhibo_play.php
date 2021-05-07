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
        <div class="containerL">
            <div class="topTitle">
                <header>
                    <div class="mainTop">
                        <div class="bannerTop">
                            <div class="bannerText">
                                <img src="<?php echo base_url('resource/home')?>/images/icon1.png" alt="" style="float: left;margin-right: 30px">
                                <p class="bannerTextT">陕西省国家税务局</p>
                                <p class="bannerTextI">Network Taxpayer School</p>
                            </div>
                        </div>
                    </div>
                </header>
            </div>
            <div id="play_1" style="width: 100%; height: 100%; box-sizing: border-box; background: #000; padding-bottom: 150px;""></div>
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
                    //adveDeAddr: '',//封面图片链接
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
                <div id="play_2" style="height: 380px; background: #000;"></div>
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
            <div id="cen_right_top">
                        <h3 class="active"><p>视频直播</p></h3>
                        <h3><p>视频回放</p></h3>
                </ul>
                <div style="display:block" class="div111">
                    <div class="zyla">
                        <p style="color:red; margin-left: 10px;margin-top: 10px">hello</p>
                    </div>
                    <div class="zylafs">
                        <p style="color:red; margin-left: 10px;margin-top: 10px">纳税人系统</p>
                        <input type="button" value="发送" >
                    </div>
                </div>
                <div class="div111">
                    <ul class="mainRightMediaList">
                        <li>回放</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url('resource/home')?>/js/script.js"></script>
</body>
</html>