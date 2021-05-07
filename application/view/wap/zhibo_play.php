<!DOCTYPE html>
<!-- saved from url=(0078)http://xtzb.szgs.gov.cn/webcast/site/vod/play-d03a225e69dd4af5903cf2c801dcec60 -->
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="width=device-width,minimum-scale=1.0,maximum-scale=1.0,user-scalable=no,minimal-ui">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="format-detection" content="telephone=no">
    <title>视频直播</title>
    <link rel="stylesheet" type="text/css" href="css/global.css">
    <link rel="stylesheet" type="text/css" id="cssfile" href="css/live_black.css">

    <!--<link rel="stylesheet" type="text/css" id="whitecss" href="http://static.gensee.com/webcast/static/mobile2015/css/live_black.css?201709v47"/>-->
    <!--@4.7 白天样式css-->
    <link rel="stylesheet" type="text/css" href="css/jquery-ui.custom.css">
    <!--<script src="http://192.168.0.41/debuggap.js?192.168.0.41:8082" type="text/javascript"></script>-->
    <script src="js/jquery-2.1.4.min.js"></script>
    <script src="js/jquery.plug.js"></script>
    <script src="js/jquery-ui.min.js"></script>
    <script src="js/jquery.ui.touch-punch.min.js"></script>
    <script src="js/zepto-docs.js"></script>
    <script src="js/json2.js"></script>
    <script src="js/scheduler2.js"></script>
    <script src="js/utils.js"></script>
    <script src="js/text-limit.js"></script>
    <script src="js/mobiplayer.common.js"></script>
    <script src="js/fabric.min.js"></script>
    <script src="js/zh_CN.js"></script>
    <script src="js/iphone-vod.js"></script>
    <script src="js/smartphone-vod-all.js"></script>
    <script src="js/smartphone-vod.record.js"></script>
    <script src="js/smartphone-vod.synchat.js"></script>
    <!--<script src="http://static.gensee.com/webcast/static/mobile2015/js/smartphone-vod.doc.js"></script>
    <script src="http://static.gensee.com/webcast/static/mobile2015/js/smartphone-vod.chat.js"></script>
    <script src="http://static.gensee.com/webcast/static/mobile2015/js/smartphone-vod.qa.js"></script>
    <script src="http://static.gensee.com/webcast/static/mobile2015/js/smartphone-vod.vote.js"></script>
    <script src="http://static.gensee.com/webcast/static/mobile2015/js/smartphone-vod.card.js"></script>
    <script src="http://static.gensee.com/webcast/static/mobile2015/js/smartphone-vod.lottery.js"></script>-->


    <script type="text/javascript" src="js/sendlicense.js"></script>
    <script type="text/javascript" src="js/xmlapi.js"></script>
    <script type="text/javascript" src="js/parser.js"></script>
    <script type="text/javascript" src="js/send_xml.js"></script>
    <script type="text/javascript" src="js/message_deal.js"></script>
    <script type="text/javascript" src="js/qaapi.js"></script>
    <script type="text/javascript" src="js/tools.js"></script>
    <script type="text/javascript" src="js/chatAndMsg.js"></script>
    <script type="text/javascript">
        var xmlUrl = 'http://cache.gensee.com/gsgetrecord/record9.gensee.net/gsrecord/24922/sbr/2017_11_16/0043ca469f5d45a18a6ede4138dc62e6_1510815792/record197.xml';


        xmlUrl = xmlUrl.replace("https://", "http://");

        var root = xmlUrl.substring(0, xmlUrl.lastIndexOf("/") + 1);
        var siteId = '24922';
        var userId = '9923342819';
        var confId = 'd03a225e69dd4af5903cf2c801dcec60';
        var hostId = '';
        var userName = 'M_76718513';
        var playerVideo = "视频";
        var playerDocument = "文档"
        var playerInfo = "系统消息";
        var emailInfo = "Email未输入或格式不正确，请修改后发送！";
        var lastedImgUrl = "http://static.gensee.com/webcast/static/zh_CN/images/ipad/images/completed.jpg";
        var firstImgUrl = "http://static.gensee.com/webcast/static/zh_CN/images/ipad/images/pptbg.GIF";
        var war_context_path = "/webcast";
        var videoMain = "true" == "true";
        var tid = "868fef9205f64eb6a00a8b9fb766c165";
        var shareUrl = "false" == "true";
        var tkExtend = "";
        var chatMsg = null;
        console.log("[war_context_path]" + war_context_path);
        var visitScheme = "http://";
        var xmlapiContextPath = "/xmlapi";
        if ("/clientapi" != "") {
            xmlapiContextPath = "/clientapi";
        }

        function init(fun, initObj, param) {
            var start = xmlUrl.indexOf("/", "http://".length + 1);
            var server = xmlUrl.substring(0, start);
            var relativeUrl = xmlUrl.substring(start);
            console.log("[init]The relativeUrl " + relativeUrl)
            var iframeSrc = xmlUrl;
            chatMsg = new ChatMsg(xmlapiContextPath + "/apichannel", siteId, userId, confId)
            messageXml(iframeSrc, function (xml, params) {
                console.log("[common-ipad messageXml]The lincese is start.")
                if (!xml.playing) {
                    console.log("[play-ipad-video][record.xml] don't hava video");
                    var msg = "点播件正在转换中，请在等待一段时间后再尝试。";
                    msg = encodeURIComponent(msg);
                    var hrefUrl = "http://static.gensee.com/webcast/static/zh_CN/ipad-error.html?msg=" + msg;

                    document.location.href = hrefUrl;
                }
                if (initObj.licenseSwitch == null || initObj.licenseSwitch == undefined || typeof(initObj.licenseSwitch) == 'undefined') {
                    initObj.licenseSwitch = function () {

                    }
                }
                var service_license_info = "alb9proxy.gensee.com" + "/albcmd/license";
                var service_license_bak_info = "" + "/albcmd/license";


                service_license_bak_info = service_license_info;

                console.log("[service_license_info]:" + service_license_info + ";" + service_license_bak_info);
                var notEnoughLicense = '\u5F53\u524D\u53C2\u52A0\u76F4\u64AD\u4EBA\u6570\u8F83\u591A\uFF0C\u8BF7\u60A8\u7A0D\u540E\u518D\u8BD5\u3002';
                if ($.trim(notEnoughLicense) == "") {
                    notEnoughLicense = '很遗憾，人数已满，您无法加入。请联系活动主办方。';
                }

                sendLicense({
                    service: service_license_info,
                    siteId: siteId,
                    userId: userId,
                    confId: confId,
                    hostId: hostId,
                    tkId: "868fef9205f64eb6a00a8b9fb766c165",
                    totalTime: xml.duration,
                    username: userName,
                    onlylogin: "0",
                    intervalTime: 15000,
                    alreadyLogin: "已有用户使用当前账号观看本内容。请在结束先前播放后重试。",
                    notEnoughLicense: notEnoughLicense,
                    notApplicationLicense: "很遗憾，不能申请到服务，您无法加入。请联系活动主办方。",
                    popcorn: document.getElementById(initObj.videoId),
                    href: "http://static.gensee.com/webcast/static/zh_CN/ipad-error.html?msg=",
                    imgObj: $("#" + initObj.imageId),
                    code: "",
                    sessionCall: function (xmlData, paramsData) {
                        sessionCall(fun, xmlData, paramsData)
                    },
                    sessionCallXml: xml,
                    sessionCallParams: params,
                    albBackService: service_license_bak_info,
                    licenseSwitch: initObj.licenseSwitch,
                    tkExtend: tkExtend
                });


            }, param)

        }

        function sessionCall(fun, recordObj, paramsData) {
            if ($.trim(recordObj.livetextfile) == "") {
                fun.call(this, recordObj, paramsData);
            } else {
                var random = Math.random();
                if (recordObj.livetextfile.indexOf("?") > 0) {
                    random = "&" + random;
                } else {
                    random = "?" + random;
                }
                $.ajax({
                        url: root + recordObj.livetextfile + random,
                        dateType: 'xml',
                        success: function (xml) {
                            var rootNode = xml.documentElement;
                            var LiveTextItems = rootNode.getElementsByTagName("LiveTextItem");
                            recordObj.livetextArray = new Array();
                            var startTime = recordObj.startTime;
                            var time = (Date.parse(startTime.replace(/-/g, "/") + " UTC-00000"));
                            if (!(time > 0)) {
                                time = 0;
                            }
                            for (var i = 0; i < LiveTextItems.length; i++) {
                                var liveTextItem = LiveTextItems[i];
                                var liveTextObj = {}
                                liveTextObj.time = getXmlNodeAttr(liveTextItem, "timestamp");
                                liveTextObj.time = liveTextObj.time - 0 + time
                                liveTextObj.lang = getXmlNodeAttr(liveTextItem, "lang");
                                liveTextObj.content = $.trim(liveTextItem.textContent);
                                recordObj.livetextArray.push(liveTextObj);
                            }
                            fun.call(this, recordObj, paramsData);
                        },
                        error: function (data) {
                            console.log("[sessionCall]to get live textfile is error. the status:" + data)
                            fun.call(this, recordObj, paramsData);
                        }
                    }
                )
            }
        }

        function sendMessage(content, email, successFun) {
            var sendXml = '<?xml version="1.0" encoding="UTF-8"?>';
            sendXml = sendXml + '<qaSubmit><siteId>' + siteId + '</siteId>';
            sendXml = sendXml + '<confId>' + confId + '</confId>';
            sendXml = sendXml + '<userId>' + userId + '</userId>';
            sendXml = sendXml + '<isLive>false</isLive>';
            sendXml = sendXml + '<userName><![CDATA[' + userName + ']]></userName>';
            sendXml = sendXml + '<question><![CDATA[' + content + ']]></question><filter>false</filter>';
            sendXml = sendXml + '<email><![CDATA[' + email + ']]></email></qaSubmit>';
            var xml = getQaAndMsg(xmlapiContextPath + "/apichannel", sendXml, function (xml) {
                successFun.call(this, xml)
            });
        }

        function sendVoteSurvey(commandObj, successFun) {
            var rootType = commandObj.name
            var rootName = "voteSubmit";
            var bool = rootType == "vote";
            if (!bool) {
                rootName = "surveySubmit"
            }
            var xml = createXml({
                nodeName: rootName,
                attrArray: [{name: "tid", value: tid}, {name: "siteid", value: siteId}, {
                    name: "userid",
                    value: userId
                }, {name: "username", value: userName}, {name: "confid", value: confId}, {name: "live", value: "false"}]
            }, "UTF-8");
            var commandNode = createNode({nodeName: "command", attrArray: [{name: "id", value: commandObj.id}]});
            var questionArray = commandObj.questions;
            for (var j = 0; j < questionArray.length; j++) {
                var questionObj = questionArray[j];
                var questionNode = createNode({nodeName: "question", attrArray: [{name: "id", value: questionObj.id}]});
                if (questionObj.type == "text") {
                    if (bool) {
                        if ($.trim(questionObj.answer) != "") {
                            var itemNode = createNode({
                                nodeName: "item",
                                value: questionObj.answer,
                                attrArray: [{name: "idx", value: 0}]
                            });
                            questionNode = addNode(questionNode, itemNode);
                        }
                    } else {
                        var itemNode = createNode({nodeName: "item", value: questionObj.answer});
                        questionNode = addNode(questionNode, itemNode);
                    }
                } else {
                    if ($.trim(questionObj.answer) != "") {
                        var items = questionObj.answer.split(",");
                        for (var k = 0; k < items.length; k++) {
                            var resultItem = items[k] - 1;
                            var itemNode = createNode({
                                nodeName: "item",
                                attrArray: [{name: "idx", value: resultItem}]
                            });
                            questionNode = addNode(questionNode, itemNode);
                        }
                    }
                }
                commandNode = addNode(commandNode, questionNode);
            }
            xml = addNode(xml, commandNode);
            console.log("[createWebXml]The content:" + xml);
            if (successFun == null || successFun == undefined || typeof(successFun) == "undefined" || typeof(successFun) != "function") {
                successFun = function () {

                }
            }
            var xml = getQaAndMsg(xmlapiContextPath + "/apichannel", xml, function (xml) {
                successFun.call(this, xml)
            });
        }

        function getResource(resourceName, callFun) {
            if (chatMsg != null) {
                if (resourceName == "qa") {
                    chatMsg.qaDeal(parseQaXml, function (data) {
                        callFun({more: data.more, list: data.qaArray});
                    });
                } else if (resourceName == "chat") {
                    chatMsg.chatDeal(parseChatXml, function (data) {
                        callFun(data);
                    });
                } else if (resourceName == "msg") {
                    chatMsg.msgDeal(parserMsgXml, function (data) {
                        callFun(data);
                    });
                }
            }
        }
    </script>

    <script src="js/console.js"></script>
    <script type="text/javascript">
        var tmpBlackWhite = "black";
        var videoWidthHeight = "16:9";//@4.7 4:3
        var staticPrefix = "http://static.gensee.com/webcast";
        if ("" == "false") {
            window.location = "http://static.gensee.com/webcast/static/zh_CN/ipad-error.html?msg=" + encodeURIComponent('iPhone直播未启用！');
        }
        var appDownload = false;
        var customerBtnEnabled = false;

        function onPlayerReady() {
            init(loadPlayerData, {
                imageId: "hiddenImg",
                videoId: ("2" == "3") ? "gs-audio" : "gs-video",
                qaFunction: function (data) {
                    console.log(data);
                    //chatArray:[{time:time,sender:sender,receiver:receiver,content:content}]
                    if (data.chatArray) {
                        for (var i in data.chatArray) {
                            var chat = data.chatArray[i];
                            loadChat({
                                type: "public",
                                talkerId: "",
                                talkerName: chat.sender,
                                msg: chat.content,
                                richtext: chat.richtext,
                                time: chat.time
                            });
                        }
                    }
                    //qaArray
                    if (data.qaArray) {
                        loadHisQa(data);
                    }
                }, licenseSwitch: function () {
                }
            });

            getResource("qa", function (data) {
                loadHisQa(data);
            });

        }

        function submitVoteAndSurvey(data) {
            var d = data[0];
            console.log("提交答案");
            console.log(d);
            var result = {id: d.id, name: d.name, questions: d.questions};
            sendVoteSurvey(result);
        }

        var Setting = {loopPlay: "false"};
        var xmlUrl = 'http://cache.gensee.com/gsgetrecord/record9.gensee.net/gsrecord/24922/sbr/2017_11_16/0043ca469f5d45a18a6ede4138dc62e6_1510815792/record197.xml';
        var resPath = xmlUrl.substring(0, xmlUrl.lastIndexOf("/") + 1);

        function loadPlayerData(data) {
            console.log("[receive all data]:", data);
            var audioSrc = "";
            var videoSrc = "";
            if (resPath.indexOf("http://") == 0 && data.isSessionDataUrlInfo) {
                var newResPath = resPath.substring("http://".length);
                var paramStartIndex = newResPath.indexOf("?");
                var portStartIndex = newResPath.indexOf(":80/");
                if (paramStartIndex > 0) {
                    if (paramStartIndex > portStartIndex && portStartIndex > 0) {
                        newResPath = newResPath.substring(0, portStartIndex) + newResPath.substring(portStartIndex + ":80".length);
                    }
                } else if (portStartIndex > 0) {
                    newResPath = newResPath.substring(0, portStartIndex) + newResPath.substring(portStartIndex + ":80".length);
                }
                if (isValid(data.hlsaudioonly)) {//hlsaudioonly
                    audioSrc = data.sessionDataUrlInfo + newResPath + data.hlsaudioonly;
                }
                videoSrc = data.sessionDataUrlInfo + newResPath + data.hls;
            } else {
                if (isValid(data.hlsaudioonly)) {//hlsaudioonly
                    audioSrc = resPath + data.hlsaudioonly;
                }
                videoSrc = resPath + data.hls;
            }
            if ("2" == "3") {//1 视频文档，2 视频为主 3文档音频
                $("#gs-audio").attr("src", audioSrc);
                Media.initCtrlbar({duration: data.duration});
            } else {
                $("#gs-video").attr("src", videoSrc);
                Media.duration = data.duration;
            }
// 			$("#gs-video").attr("src", "http://192.168.0.172:8080/webcast/static/test/last-time-race-start.mp4");
// 			$("#gs-audio").attr("src", "http://192.168.0.172:8080/webcast/static/test/last-time-race-start.mp4");
            console.log("data.isSessionDataUrlInfo:" + data.isSessionDataUrlInfo + ";" + data.sessionDataUrlInfo);
            loadPpts(resPath, data);
            if ('false' != 'true') {
                console.log(data);
                loadVotes(data);
                loadCards(data);
            }
            if (data.jscontent != "") {
                try {
                    var jshtml = resPath + data.jscontent;
                    $.ajax({
                        type: 'GET',
                        url: jshtml,
                        dataType: 'json',
                        timeout: 15000,
                        success: function (data) {
                            console.log(jshtml);
                            pptGetRecord(data);
                            chatGetSyn(data);
                        },
                        error: function (xhr, type) {
                            //alert('Ajax error!')
                            console.log(jshtml + "加载失败");
                        }
                    });
                } catch (e) {
                    console.log(e);
                }
            } else {
                getResource("chat", function (data) {
                    loadChats(data);
                });
            }
            //抽奖

            /*if(data.lotteryArray){
                for(var i in data.lotteryArray){
                    loadLottery(data.lotteryArray[i], 0);
                }
            }*/
        }

        var mobileModel = "2";

        function modifyUI(v1, v2) {
            switch (v1) {
                case 1:
                    //$("#qa-tab").addClass("onetab");
                    $(".onchat").remove();
                    $(".chat-container").remove();
                    break;
                case 10:
                    //$("#chat-tab").addClass("onetab");
                    $(".onqa").remove();
                    $(".qa-container").remove();
                    break;
                case 11:
                    if (v2 == 10) {
                    } else {
                    }
                    break;
                default:
                    ;
            }
            if ($('.tabs li').length == 1) {
                $('.tabs li a').css({'text-align': 'left', 'padding-left': '20px'});
            }
        }

        var tabDefaultIndex = 0;
        var medialineMode = "false";
        $(function () {
            if (mobileModel == "1" || mobileModel == "2") {//1 视频文档，3  音频文档 2 纯视频
                Media.init("videoFirst");
            } else if (mobileModel == "3") {
                Media.init("docFirst");
                //}else if(mobileModel == "2"){
                //Media.init("videoOnly");
            }
        });

        function isValid(obj) {
            if (typeof(obj) == 'undefined' || obj == null) {
                return false;
            } else if (typeof(obj) == 'string') {
                if (obj.trim() == "" || obj == "null") {
                    return false;
                }
            }
            return true;
        }


        var loopPlay = 'false';
        var skipVoteAndSurvey = 'false';
    </script>
</head>
<body>
<div style="width:0; height:0; overflow:hidden;">

    <!--<img src="./外贸综合服务企业代办退税新政策解读及操作实务_files/share.jpg">-->


    <!--<img src="./外贸综合服务企业代办退税新政策解读及操作实务_files/icon.png">-->
    <!--<img src="./外贸综合服务企业代办退税新政策解读及操作实务_files/icon_black.png">-->
    <!--<img src="./外贸综合服务企业代办退税新政策解读及操作实务_files/triangle_img.png">-->
    <!--<img id="pointEx" src="./外贸综合服务企业代办退税新政策解读及操作实务_files/pointEx.png">-->
    <!--<img id="pointEx2" src="./外贸综合服务企业代办退税新政策解读及操作实务_files/point.png">-->
</div>
<!--<img id="hiddenImg" style="display:none" src="./外贸综合服务企业代办退税新政策解读及操作实务_files/license">-->
<div class="toolset fastclick">
</div>
<div id="webPlayer" class="web" style="width: 100%; height: 100%;">
    <div class="enter_page fastclick" style="display:none;">
        <form method="post" id="login_form" name="login_form" onsubmit="return false;">
            <span class="friendly_reminder">给自己取个名字，让大家认识你</span>
            <div class="input_item">
                <input name="l_nickname" type="text" class="input_txt" id="l_nickname" value="">
            </div>
            <button class="submit_btn_s" type="submit">立即观看</button>
        </form>
    </div>
    <!-- 视频区域 -->
    <div id="topHalf" style="height: 210px;">

        <div id="playercontainer"></div>
        <script type="text/javascript" src="../player/cyberplayer.js"></script>
        <script type="text/javascript">

            /* ----------------直播demo--------------------- */

            //    var player = cyberplayer("playercontainer").setup({
            //        width: 680,
            //        height: 448,
            //        file: "rtmp://fupin110.com/pa_test/20171121", // <—flv直播地址
            //        autostart: true,
            //        stretching: "uniform",
            //        volume: 100,
            //        controls: true,
            //        isLive: true, // 标明是否是直播
            //        ak: "25a51bf25b09491ca1b0e6da296c9ba5" // 公有云平台注册即可获得accessKey
            //    });


            /* ----------------直播回放demo--------------------- */
            var player = cyberplayer("playercontainer").setup({
                width: "100%", // 宽度，也可以支持百分比(不过父元素宽度要有)
                height: "100%", // 高度，也可以支持百分比
                title: "基本功能", // 标题
                file: "http://hj6phddw2dzk7jwafw2.exp.bcevod.com/mda-hkwf96qdbri48jdf/mda-hkwf96qdbri48jdf.mp4", // 播放地址
                image: "http://hj6phddw2dzk7jwafw2.exp.bcevod.com/mda-hkwf96qdbri48jdf/mda-hkwf96qdbri48jdf.jpg", // 预览图
                autostart: false, // 是否自动播放
                stretching: "uniform", // 拉伸设置
                repeat: false, // 是否重复播放
                volume: 100, // 音量
                controls: true, // controlbar是否显示
                starttime: 0, // 视频开始播放时间，如果不设置，则可以从上次播放时间点续播
                primary: "html5", // 首先使用html5还是flash播放，默认：html5
                logo: { // logo设置
                    linktarget: "_blank",
                    margin: 8,
                    hide: false,
                    position: "top-right", // 位置
                    file: "./img/logo.png" // 图片地址
                },
                ak: "25a51bf25b09491ca1b0e6da296c9ba5" // 公有云平台注册即可获得accessKey
            });
        </script>

    </div>
    <div class="status_bar toolbar toolbar-show border-box">
        <p class="hui">回放</p>
        <div class="status_bar_r">
            <a href="javascript:void(0)" id="tool_a" class="tool_a"><i></i></a>
        </div>
    </div>
    <div class="tool_box" id="tool_box" style="top: 240px; display: none;">
        <ul class="display-box">
            <li class="flex audio" id="audio_a">
                <a href="javascript:void(0)"><i></i><span>纯音频</span></a>
            </li>
            <li class="flex css" id="change_css"><a href="javascript:void(0)" class="change_css"><i></i><span>白天</span></a>
            </li>
        </ul>
    </div>
    <!-- 聊天问答区域 -->
    <div id="chatQaBox" class="section-bottom" style="height: 427px;">
        <div class="tabs border-box">
            <ul class="display-box fastclick">
                <li id="doc-tab" class=" flex ondoc on">
                    <a>
                        <span>互动咨询</span>
                    </a>
                </li>
                <li class="flex onchapter">
                    <a>
                        <span>视频介绍</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="tempWrap" style="overflow:hidden; position:relative;">
            <div class="slider-container" style="width: 1500px; position: relative; overflow: hidden; padding: 0px; margin: 0px; transition-duration: 0ms; transform: translate(0px, 0px) translateZ(0px);">


                <div class="section-top slider-box" style="display: table-cell; vertical-align: top; width: 375px; height: 390px;">
                    <!--<div id="doc-box" class="document-container" style="height: 390px; line-height: 390px; width: 100%; overflow: hidden;">-->
                            <!--111-->
                    <!--</div>-->
                    <p>问: Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid, architecto debitis facere!</p>
                    <p class="redText">
                        答：Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                    </p>
                    <!--<div class="tiwen">-->
                        <!--<textarea name="" id="" cols="30" rows="10"></textarea>-->
                        <!--<input type="button" value="提交">-->
                    <!--</div>-->
                    <div id="doc-box" class="document-container tiwen" style="height: 390px; line-height: 390px; width: 100%; overflow: hidden;">
                        123
                            <textarea name="" id="" cols="30" rows="10"></textarea>
                            <input type="button" value="提交">
                    </div>
                </div>

                <div class="chapter-container slider-box" style="display: table-cell; vertical-align: top; width: 375px;">
                    <div class="chapter_empty" id="chapter_empty" style="display: none;">
                        <i></i>
                        <p>没有章节哦~</p>
                    </div>
                    <div class="chapter-hd display-box">
                        <div class="sn">序号</div>
                        <div class="title flex">标题</div>
                        <div class="time">时间</div>
                    </div>
                    <div class="chapter-list-container allow-roll">
                        <ul id="chapter-box" class="chapter-list">
                            <li class="display-box" data-startime="0.01" endtime="315.404">
                                <div class="sn"><em class="sn-circle">1</em></div>
                                <div class="title flex">1 - 外贸综合服务企业代办退税 政策解读及实际操作</div>
                                <div class="time">00:00</div>
                            </li>
                            <li class="display-box" data-startime="315.404" endtime="316.886">
                                <div class="sn"><em class="sn-circle">2</em></div>
                                <div class="title flex">2 - 主 要 内 容</div>
                                <div class="time">05:15</div>
                            </li>
                            <li class="display-box" data-startime="316.886" endtime="322.456">
                                <div class="sn"><em class="sn-circle">3</em></div>
                                <div class="title flex">3 - 一、政策出台背景</div>
                                <div class="time">05:16</div>
                            </li>
                            <li class="display-box" data-startime="322.456" endtime="327.744">
                                <div class="sn"><em class="sn-circle">4</em></div>
                                <div class="title flex">4 - 2014年13号公告起源</div>
                                <div class="time">05:22</div>
                            </li>
                            <li class="display-box" data-startime="327.744" endtime="382.422">
                                <div class="sn"><em class="sn-circle">5</em></div>
                                <div class="title flex">5 - 13号公告主要内容</div>
                                <div class="time">05:27</div>
                            </li>
                            <li class="display-box" data-startime="382.422" endtime="466.756">
                                <div class="sn"><em class="sn-circle">6</em></div>
                                <div class="title flex">6 - 三年来，13号公告为外综服的发展注入了强大动力</div>
                                <div class="time">06:22</div>
                            </li>
                            <li class="display-box" data-startime="466.756" endtime="584.958">
                                <div class="sn"><em class="sn-circle">7</em></div>
                                <div class="title flex">7 - 但，另一方面……</div>
                                <div class="time">07:46</div>
                            </li>
                            <li class="display-box" data-startime="584.958" endtime="680.244">
                                <div class="sn"><em class="sn-circle">8</em></div>
                                <div class="title flex">8 - 35号公告出台的重要意义</div>
                                <div class="time">09:44</div>
                            </li>
                            <li class="display-box" data-startime="680.244" endtime="745.686">
                                <div class="sn"><em class="sn-circle">9</em></div>
                                <div class="title flex">9 - 35号公告出台的重要意义</div>
                                <div class="time">11:20</div>
                            </li>
                            <li class="display-box" data-startime="745.686" endtime="841.128">
                                <div class="sn"><em class="sn-circle">10</em></div>
                                <div class="title flex">10</div>
                                <div class="time">12:25</div>
                            </li>
                            <li class="display-box" data-startime="841.128" endtime="1148.231">
                                <div class="sn"><em class="sn-circle">11</em></div>
                                <div class="title flex">11</div>
                                <div class="time">14:01</div>
                            </li>
                            <li class="display-box" data-startime="1148.231" endtime="1194.002">
                                <div class="sn"><em class="sn-circle">12</em></div>
                                <div class="title flex">12</div>
                                <div class="time">19:08</div>
                            </li>
                            <li class="display-box" data-startime="1194.002" endtime="1340.050">
                                <div class="sn"><em class="sn-circle">13</em></div>
                                <div class="title flex">13 - 二、35号公告细解</div>
                                <div class="time">19:54</div>
                            </li>
                            <li class="display-box" data-startime="1340.050" endtime="1542.898">
                                <div class="sn"><em class="sn-circle">14</em></div>
                                <div class="title flex">14</div>
                                <div class="time">22:20</div>
                            </li>
                            <li class="display-box" data-startime="1542.898" endtime="1738.149">
                                <div class="sn"><em class="sn-circle">15</em></div>
                                <div class="title flex">15</div>
                                <div class="time">25:42</div>
                            </li>
                            <li class="display-box" data-startime="1738.149" endtime="1839.082">
                                <div class="sn"><em class="sn-circle">16</em></div>
                                <div class="title flex">16</div>
                                <div class="time">28:58</div>
                            </li>
                            <li class="display-box" data-startime="1839.082" endtime="1991.011">
                                <div class="sn"><em class="sn-circle">17</em></div>
                                <div class="title flex">17</div>
                                <div class="time">30:39</div>
                            </li>
                            <li class="display-box" data-startime="1991.011" endtime="2366.256">
                                <div class="sn"><em class="sn-circle">18</em></div>
                                <div class="title flex">18</div>
                                <div class="time">33:11</div>
                            </li>
                            <li class="display-box" data-startime="2366.256" endtime="2595.779">
                                <div class="sn"><em class="sn-circle">19</em></div>
                                <div class="title flex">19</div>
                                <div class="time">39:26</div>
                            </li>
                            <li class="display-box" data-startime="2595.779" endtime="2664.529">
                                <div class="sn"><em class="sn-circle">20</em></div>
                                <div class="title flex">1</div>
                                <div class="time">43:15</div>
                            </li>
                            <li class="display-box" data-startime="2664.529" endtime="2674.015">
                                <div class="sn"><em class="sn-circle">21</em></div>
                                <div class="title flex">19</div>
                                <div class="time">44:24</div>
                            </li>
                            <li class="display-box" data-startime="2674.015" endtime="2818.472">
                                <div class="sn"><em class="sn-circle">22</em></div>
                                <div class="title flex">20</div>
                                <div class="time">44:34</div>
                            </li>
                            <li class="display-box" data-startime="2818.472" endtime="2980.369">
                                <div class="sn"><em class="sn-circle">23</em></div>
                                <div class="title flex">21</div>
                                <div class="time">46:58</div>
                            </li>
                            <li class="display-box" data-startime="2980.369" endtime="3227.288">
                                <div class="sn"><em class="sn-circle">24</em></div>
                                <div class="title flex">22</div>
                                <div class="time">49:40</div>
                            </li>
                            <li class="display-box" data-startime="3227.288" endtime="3401.588">
                                <div class="sn"><em class="sn-circle">25</em></div>
                                <div class="title flex">23</div>
                                <div class="time">53:47</div>
                            </li>
                            <li class="display-box" data-startime="3401.588" endtime="3462.319">
                                <div class="sn"><em class="sn-circle">26</em></div>
                                <div class="title flex">24</div>
                                <div class="time">56:41</div>
                            </li>
                            <li class="display-box" data-startime="3462.319" endtime="3536.482">
                                <div class="sn"><em class="sn-circle">27</em></div>
                                <div class="title flex">25</div>
                                <div class="time">57:42</div>
                            </li>
                            <li class="display-box" data-startime="3536.482" endtime="3699.940">
                                <div class="sn"><em class="sn-circle">28</em></div>
                                <div class="title flex">26</div>
                                <div class="time">58:56</div>
                            </li>
                            <li class="display-box" data-startime="3699.940" endtime="3831.027">
                                <div class="sn"><em class="sn-circle">29</em></div>
                                <div class="title flex">27</div>
                                <div class="time">01:01:39</div>
                            </li>
                            <li class="display-box" data-startime="3831.027" endtime="4067.556">
                                <div class="sn"><em class="sn-circle">30</em></div>
                                <div class="title flex">28 - 三、代办退税操作流程及注意事项</div>
                                <div class="time">01:03:51</div>
                            </li>
                            <li class="display-box" data-startime="4067.556" endtime="4187.568">
                                <div class="sn"><em class="sn-circle">31</em></div>
                                <div class="title flex">29</div>
                                <div class="time">01:07:47</div>
                            </li>
                            <li class="display-box" data-startime="4187.568" endtime="4438.152">
                                <div class="sn"><em class="sn-circle">32</em></div>
                                <div class="title flex">30</div>
                                <div class="time">01:09:47</div>
                            </li>
                            <li class="display-box" data-startime="4438.152" endtime="4535.871">
                                <div class="sn"><em class="sn-circle">33</em></div>
                                <div class="title flex">31</div>
                                <div class="time">01:13:58</div>
                            </li>
                            <li class="display-box" data-startime="4535.871" endtime="4667.489">
                                <div class="sn"><em class="sn-circle">34</em></div>
                                <div class="title flex">32</div>
                                <div class="time">01:15:35</div>
                            </li>
                            <li class="display-box" data-startime="4667.489" endtime="4798.124">
                                <div class="sn"><em class="sn-circle">35</em></div>
                                <div class="title flex">33</div>
                                <div class="time">01:17:47</div>
                            </li>
                            <li class="display-box" data-startime="4798.124" endtime="4933.627">
                                <div class="sn"><em class="sn-circle">36</em></div>
                                <div class="title flex">34</div>
                                <div class="time">01:19:58</div>
                            </li>
                            <li class="display-box" data-startime="4933.627" endtime="5078.957">
                                <div class="sn"><em class="sn-circle">37</em></div>
                                <div class="title flex">35</div>
                                <div class="time">01:22:13</div>
                            </li>
                            <li class="display-box" data-startime="5078.957" endtime="5293.131">
                                <div class="sn"><em class="sn-circle">38</em></div>
                                <div class="title flex">36</div>
                                <div class="time">01:24:38</div>
                            </li>
                            <li class="display-box" data-startime="5293.131" endtime="5387.855">
                                <div class="sn"><em class="sn-circle">39</em></div>
                                <div class="title flex">37</div>
                                <div class="time">01:28:13</div>
                            </li>
                            <li class="display-box" data-startime="5387.855" endtime="5509.380">
                                <div class="sn"><em class="sn-circle">40</em></div>
                                <div class="title flex">38 - 参考：代办退税内部风险管控制度模型</div>
                                <div class="time">01:29:47</div>
                            </li>
                            <li class="display-box" data-startime="5509.380" endtime="5575.462">
                                <div class="sn"><em class="sn-circle">41</em></div>
                                <div class="title flex">39 - 组织架构及职责分工</div>
                                <div class="time">01:31:49</div>
                            </li>
                            <li class="display-box" data-startime="5575.462" endtime="5688.640">
                                <div class="sn"><em class="sn-circle">42</em></div>
                                <div class="title flex">40</div>
                                <div class="time">01:32:55</div>
                            </li>
                            <li class="display-box" data-startime="5688.640" endtime="5711.526">
                                <div class="sn"><em class="sn-circle">43</em></div>
                                <div class="title flex">41 - 参考：风险管控信息系统功能介绍</div>
                                <div class="time">01:34:48</div>
                            </li>
                            <li class="display-box" data-startime="5711.526" endtime="5751.197">
                                <div class="sn"><em class="sn-circle">44</em></div>
                                <div class="title flex">42</div>
                                <div class="time">01:35:11</div>
                            </li>
                            <li class="display-box" data-startime="5751.197" endtime="5817.661">
                                <div class="sn"><em class="sn-circle">45</em></div>
                                <div class="title flex">43</div>
                                <div class="time">01:35:51</div>
                            </li>
                            <li class="display-box" data-startime="5817.661" endtime="5931.339">
                                <div class="sn"><em class="sn-circle">46</em></div>
                                <div class="title flex">44</div>
                                <div class="time">01:36:57</div>
                            </li>
                            <li class="display-box" data-startime="5931.339" endtime="5987.468">
                                <div class="sn"><em class="sn-circle">47</em></div>
                                <div class="title flex">45</div>
                                <div class="time">01:38:51</div>
                            </li>
                            <li class="display-box" data-startime="5987.468" endtime="6020.790">
                                <div class="sn"><em class="sn-circle">48</em></div>
                                <div class="title flex">46</div>
                                <div class="time">01:39:47</div>
                            </li>
                            <li class="display-box" data-startime="6020.790" endtime="6087.402">
                                <div class="sn"><em class="sn-circle">49</em></div>
                                <div class="title flex">45</div>
                                <div class="time">01:40:20</div>
                            </li>
                            <li class="display-box" data-startime="6087.402" endtime="6088.354">
                                <div class="sn"><em class="sn-circle">50</em></div>
                                <div class="title flex">46</div>
                                <div class="time">01:41:27</div>
                            </li>
                            <li class="display-box" data-startime="6088.354" endtime="6161.440">
                                <div class="sn"><em class="sn-circle">51</em></div>
                                <div class="title flex">47</div>
                                <div class="time">01:41:28</div>
                            </li>
                            <li class="display-box" data-startime="6161.440" endtime="6311.981">
                                <div class="sn"><em class="sn-circle">52</em></div>
                                <div class="title flex">48</div>
                                <div class="time">01:42:41</div>
                            </li>
                            <li class="display-box" data-startime="6311.981" endtime="6382.977">
                                <div class="sn"><em class="sn-circle">53</em></div>
                                <div class="title flex">49</div>
                                <div class="time">01:45:11</div>
                            </li>
                            <li class="display-box" data-startime="6382.977" endtime="7062.018">
                                <div class="sn"><em class="sn-circle">54</em></div>
                                <div class="title flex">50 - &amp; ANSWER</div>
                                <div class="time">01:46:22</div>
                            </li>
                        </ul>
                    </div>
                </div>
             </div>
    </div>
</div>


</div></div>
</div>
<!-- 聊天问答区域 END-->

<div id="freeVotePopup" class="survey fastclick">
    <div class="survey_head display-box">
        <div class="title_set flex">
            <h4 class="border-box" id="curent-vote-title"></h4>
            <em></em>
        </div>
        <div class="survey_head_r">
            <a class="survey_more"><i></i><span class="vote-tips"></span></a>
            <div class="linellae"></div>
            <a class="survey_close"><i></i></a>
        </div>
    </div>
    <div class="survey_list allow-roll" id="vote-select">
        <ul>
        </ul>
    </div>
    <!-- 强制 -->
    <div id="vote-list">

    </div>

</div>
<!-- 强制问卷答案 -->
<div class="survey_stat fastclick" id="survey_stat">
    <div class="survey_head display-box">
        <div class="title_set flex">
            <h4 class="border-box" id="survey_stat_title"></h4>
        </div>
        <div class="survey_head_r">
            <a class="survey_more"><i></i><span id="survey_stat_more"></span></a>
            <div class="linellae"></div>
            <a class="survey_close"><i></i></a>
        </div>
    </div>
    <div class="survey_list" id="survey_list">
        <ul>
        </ul>
    </div>
    <div id="voteresult_list">

    </div>
</div>
<!-- 抽奖 -->
<div id="lottery-dialog" class="draw_set">
    <div class="draw_on">
        <div class="call_the_roll display-box">
            <span class="flex">抽奖咯</span>
            <a>
                <i></i>
            </a>
        </div>
        <div class="draw_set_b">
            <div class="draw_set_t">
                <span></span>
            </div>
            <div class="draw_bg"></div>
        </div>
    </div>
    <div class="draw_result">
        <div class="call_the_roll display-box">
            <span class="flex">中奖名单</span>
            <a class="fastclick">
                <i></i>
            </a>
        </div>
        <div class="draw_result_list allow-roll">
            <ul>
            </ul>
        </div>
    </div>
    <div class="draw_over">
        <div class="call_the_roll display-box">
            <span class="flex"></span>
            <a class="fastclick">
                <i></i>
            </a>
        </div>
        <p>
            哎哟，本次抽奖被中止
        </p>
    </div>
</div>
<!--答题卡-->
<div class="broadside" id="card_small">
    <i></i>
    <span>答题卡</span>
</div>
<div class="answer_sheet" id="card_box">
</div>
<div id="coverLayer" class="coverLayer"></div>
</div>
<div id="audio_area">

</div>

</body>
</html>