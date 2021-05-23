<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$info['title']?>-<?php echo $webinfo['title'];?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/zbhf_2.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
    <script src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php include 'header.php';?>
<section class="">
    <div class="sectionMain">
        <div class="mediaDetail">
            <h2>当前位置：<a href="<?=site_url('replay')?>">直播回放</a> >> <?=$info['title']?></h2>
            <div class="playDetail">
                <div class="playDetailL">
                    <img src="<?=base_url($info['imgurl'])?>" alt="<?=$info['title']?>">
                </div>
                <div class="playDetailR">
                    <h2><?=$info['title']?></h2>
                    <h3>直播简介:<?=mb_substr($info['destext'],0,60)?></h3>
                    <p>讲师：<?=$info['teacher'];?>
                        <span class="tIndent">直播时间：<?=date('Y-m-d H:i',$info['livetime']);?></span>
                        <br>
                        课程类型：<?=$info['typename']?>
                        <span class="tIndent">课程时长：<?=$info['duration']?>分钟</span>
                    </p>
                    <a href="<?=site_url('replay/play/'.$info['id'])?>" class="playB">观看回放</a>
                </div>
            </div>
            <div class="mediaDetailL">
                <h2>用户评论</h2>
                <form action="">
                    <textarea name="" id="plcontent" cols="30" rows="10" placeholder="请输入内容"></textarea>
                    <span style="vertical-align: middle">课程评价</span>
                    <div id="star">
                        <ul>
                            <li class="on"><a href="javascript:;">1</a></li>
                            <li class="on"><a href="javascript:;">2</a></li>
                            <li class="on"><a href="javascript:;">3</a></li>
                            <li class=""><a href="javascript:;">4</a></li>
                            <li class=""><a href="javascript:;">5</a></li>
                        </ul>
                    </div>
                    <a href="javascript:;" id="plsubmit" class="couseBut">提交</a>
                    <script>
                        $('#plsubmit').click(function(){
                            var score = $('#star').find('li.on').length;
                            var content = $('#plcontent').val();
                            $.post('<?=site_url('api/pinglun')?>',{'score':score,'content':content,'zid':<?=$info['id']?>},function(result){
                                alert(result.msg);
                            },'json');
                        })

                    </script>
                </form>
                <div style="clear: both;"></div>
                <div class="commentList">
                    <ul class="commentListUl">
                        <?php if(!empty($pinglun)): foreach($pinglun as $row):?>
                            <li>
                                <p class="commentListUser"><?=$row['ip']?>
                                    <span class="cousePUser" style="width:<?=$row['score']*23?>px;"></span>
                                    <span style="float: right"><?=date('Y/m/d H:i')?></span>
                                </p>
                                <p><?=$row['content']?></p>
                            </li>
                        <?php endforeach; else:?>
                            <li>暂无用户评论</li>
                        <?php endif;?>
                    </ul>
                </div>
            </div>
            <div class="mediaDetailR">
                <div class="videoDiv">
                    <div class="content">
                        <p class="mediaT"><span class="blue1"></span>相关课堂 <span></span> </p>
                        <div class="neiborder">
                            <div class="cRight">
                                <div class="videoList">
                                    <ul style="display: block;">
                                        <?php if(!empty($like)):?>
                                            <?php foreach($like as $row):?>
                                                <li>
                                                    <div class="img">
                                                        <a href="<?=site_url($row['mod'].'/detail/'.$row['id'])?>">
                                                            <img src="<?=base_url($row['imgurl'])?>" alt="">
                                                            <div class="img_mask"></div>
                                                            <div class="imgPlay" ></div>
                                                        </a>
                                                        <div class="playtime" >时长：<?=$row['duration']?>分钟</div>
                                                    </div>
                                                    <div class="videoDesc">
                                                        <div>
                                                            <div class="title">
                                                                <a href="<?=site_url('live/detail/'.$row['id'])?>" title="<?=$row['title']?>"><?=$row['title']?></a>
                                                            </div>
                                                            <div class="time">
                                                                <span><img src="<?=base_url('resource/home')?>/images/video-icon.png" width="16" height="16" class="video-icon"></span> <?=$row['pageview']?>
                                                            </div>
                                                            <div class="clear"></div>
                                                        </div>
                                                        <div class="desc">

                                                            <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:155px;">
                                                                讲师：<?=$row['teacher']?>
                                                            </div>
                                                            <div style="float:right;"> <?= date('Y-m-d',$row['livetime'])?></div>
                                                            <div class="clear"></div>

                                                        </div>
                                                    </div>
                                                </li>
                                            <?php endforeach;?>
                                        <?php else:?>
                                            暂无相关课程
                                        <?php endif;?>
                                        <div style="clear:both;"></div>
                                    </ul>
                                </div>

                            </div>
                            <div class="clear"></div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <?php include 'footer.php';?>
</section>
<script>
    function IsPC() {
        var userAgentInfo = navigator.userAgent;
        var Agents = ["Android", "iPhone",
            "SymbianOS", "Windows Phone",
            "iPad", "iPod"];
        var flag = true;
        for (var v = 0; v < Agents.length; v++) {
            if (userAgentInfo.indexOf(Agents[v]) > 0) {
                flag = false;
                break;
            }
        }
        return flag;
    }
    if(!IsPC()){
        $('.playB').attr('href','<?=site_url('replay/play/'.$info['id'])?>?ismob=1');
    }

    window.onload = function (){

        var oStar = document.getElementById("star");
        var aLi = oStar.getElementsByTagName("li");
        var oUl = oStar.getElementsByTagName("ul")[0];
        var oSpan = oStar.getElementsByTagName("span")[1];
        var oP = oStar.getElementsByTagName("p")[0];
        var i = iScore = iStar = 0;

        for (i = 1; i <= aLi.length; i++){
            aLi[i - 1].index = i;

            //鼠标移过显示分数
            aLi[i - 1].onmouseover = function (){
                fnPoint(this.index);
            };

            //鼠标离开后恢复上次评分
            aLi[i - 1].onmouseout = function (){
                fnPoint();
                //关闭浮动层
            };
            //点击后进行评分处理
            aLi[i - 1].onclick = function (){
                iStar = this.index;
            }
        }
        //评分处理
        function fnPoint(iArg){
            //分数赋值
            iScore = iArg || iStar;
            for (i = 0; i < aLi.length; i++) aLi[i].className = i < iScore ? "on" : "";
        }

    };
</script>
</body>
</html>