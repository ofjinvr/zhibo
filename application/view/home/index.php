<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$webinfo['title']?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/modal.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/video.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/index.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url('resource/home')?>/js/index.js"></script>
    <!--<script type="text/javascript" src="js/videoDetail.js"></script>-->
</head>
<body>
<?php include 'header.php';?>
    <section>
        <div class="sectionMain">
            <div class="mainTop">
                <div class="mainLeft">
                    <div class="roll-news-keleyi-com">
                        <div class="roll-news-image">
                            <img src="<?php echo base_url('resource/home')?>/images/59f6d83a6f630.png">
                        </div>
                        <div class="roll-news-index">
                            <ul>
                                <li class="roll-news-index-hover">1</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mainRight">
                    <div class="Trailer">
                        <p class="mediaT">直播预告 <span></span> <i></i><a href="<?=site_url('live')?>">MORE</a></p>
                        <div class="">
                            <?php if(!empty($live_list_ready[0])):?>
                            <div class="TrailerL">
                                <a href="<?=site_url('live/detail/'.$live_list_ready[0]['id'])?>">
                                    <img src="<?php echo base_url($live_list_ready[0]['imgurl'])?>" alt="">
                                    <div class="img_mask"></div>
                                    <div class="imgPlay"></div>
                                </a>
                            </div>
                            <div class="TrailerR">
                                <p class="TrailerRT"><?=$live_list_ready[0]['title']?></p>
                                <p><?=mb_substr($live_list_ready[0]['destext'],0,15)?>...</p>
                                <p class="TrailerRS"><?=date('Y-m-d/H:i',$live_list_ready[0]['livetime'])?>
                                    <span>
                                        <a href="<?=site_url('live/detail/'.$live_list_ready[0]['id'])?>">查看详情</a>
                                    </span>
                                </p>
                            </div>
                            <?php endif;?>
                            <div class="clear"></div>
                        </div>
                        <p class="mediaT">回放直播 <span></span> <i></i><a href="<?=site_url('replay')?>">MORE</a></p>
                        <ul class="TrailerUl">
                            <?php if(!empty($live_list_replay)): foreach($live_list_replay as $row):?>
                            <li>
                                <p class="TrailerUlP1">
                                    <a href=""></a>
                                    <span>2017-9-12</span>
                                </p>
                                <p><a href="<?=site_url('replay/play/'.$row['id'])?>"><?=$row['title']?></a></p>
                            </li>
                            <?php endforeach; endif;?>
                        </ul>
                    </div>
                </div>
            </div>
            <!--视频列表-->
            <div class="videoDiv">
                <div class="content">
                    <p class="mediaT">推荐课堂 <span></span> <i></i></p>
                    <div class="neiborder">
                        <div class="cRight">
                            <div class="videoList">
                                <ul>
                                    <?php foreach($video as $row):?>
                                    <li>
                                        <div class="img">
                                            <a href="<?=site_url('video/play/'.$row['id'])?>" target="_blank">
                                                <img src="<?=base_url($row['imgurl'])?>">
                                            <div class="img_mask"></div>
                                            <div class="imgPlay" > </div>
                                            </a>
                                        </div>
                                        <div class="videoDesc">
                                            <div>
                                                <div class="title">
                                                    <a href="<?=site_url('video/play/'.$row['id'])?>" target="_blank"><?=$row['title']?></a>
                                                </div>
                                                <div class="time"><span>
                                                <img src="<?php echo base_url('resource/home')?>/images/video-icon.png" width="16" height="16" class="video-icon"></span> <?=$row['pageview']?>
                                                </div>
                                                <div class="clear"></div>
                                            </div>
                                            <div class="desc">
                                                <div style="float:right;"><?=date('Y-m-d',$row['pubtime'])?></div>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                    </li>
                                    <?php endforeach;?>
                                    <div style="clear:both;"></div>
                                </ul>
                            </div>

                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
            <!--单图片-->
            <img src="images/sy1.jpg" alt="" style="max-width: 100%">

            <!--讲师介绍-->
            <p class="mediaT">名师风采 <span></span> <i></i></p>
            <div id="div1">
                <ul>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images/m1.jpg" alt=""/>
                        <p style="text-align: center;">丁馨</p>
                        <p>陕西国税12366纳税服务中心</p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images/m2.jpg" alt=""/>
                        <p style="text-align: center;">姜蝉蝉</p>
                        <p>陕西国税12366纳税服务中心</p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images/m3.jpg" alt=""/>
                        <p style="text-align: center;">卢梦冰</p>
                        <p>陕西国税12366纳税服务中心</p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images/m4.jpg" alt=""/>
                        <p style="text-align: center;">马翌祯</p>
                        <p>省局货物和劳务税处</p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images/m5.jpg" alt=""/>
                        <p style="text-align: center;">史蕊</p>
                        <p>陕西国税12366纳税服务中心</p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images/m6.jpg" alt=""/>
                        <p style="text-align: center;">杨楠</p>
                        <p>陕西国税12366纳税服务中心</p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images/m7.jpg" alt=""/>
                        <p style="text-align: center;">易娅岚</p>
                        <p>咸阳市长武县国家税务局</p>
                    </li>
                </ul>
            </div>
            <!--最下内容-->
            <div class="containerF">
                <!--左边tab切换-->

                <div class="containerFL">
                    <div id="cen_right_top">
                        <ul class="cen_right_top_nav">
                            <li>
                                <h3 class="active">
                                    <p>视频直播</p>
                                </h3>
                            </li>
                            <li>
                                <h3>
                                    <p>视频回放</p>
                                </h3>
                            </li>
                            <li>
                                <h3>
                                    <p>办税导航</p>
                                </h3>
                            </li>
                        </ul>
                        <div style="display:block" class="div111">
                                <ul class="commentListUl1">
                                    <?php if(!empty($live_list_ready)): foreach($live_list_ready as $row):?>
                                    <li>
                                        <div class="commentListUl1F">
                                            <span><?=date('m/d',$row['livetime'])?></span>
                                            <span><?=date('Y',$row['livetime'])?></span>
                                        </div>
                                        <div class="commentListUl1T">
                                            <p><a href="<?=site_url('live/detail/'.$row['id'])?>"><?=$row['title']?></a></p>
                                            <p> <?= mb_substr($row['destext'],0,70)?>... </p>
                                        </div>
                                    </li>
                                    <?php endforeach; endif;?>
                                </ul>
                        </div>
                        <div class="div111">
                            <ul class="commentListUl1">
                                <?php if(!empty($live_list_replay)): foreach($live_list_replay as $row):?>
                                    <li>
                                        <div class="commentListUl1F">
                                            <span><?=date('m/d',$row['livetime'])?></span>
                                            <span><?=date('Y',$row['livetime'])?></span>
                                        </div>
                                        <div class="commentListUl1T">
                                            <p><a href="<?=site_url('replay/play/'.$row['id'])?>"><?=$row['title']?></a></p>
                                            <p> <?= mb_substr($row['destext'],0,70)?>... </p>
                                        </div>
                                    </li>
                                <?php endforeach; endif;?>
                            </ul>
                        </div>
                        <div class="div111">
                            <ul class="commentListUl1">
                                <?php if(!empty($article_list)): foreach($article_list as $row):?>
                                    <li>
                                        <div class="commentListUl1F">
                                            <span><?=date('m/d',$row['pubtime'])?></span>
                                            <span><?=date('Y',$row['pubtime'])?></span>
                                        </div>
                                        <div class="commentListUl1T">
                                            <p><a href="<?=site_url('about/article/'.$row['id'])?>"><?=$row['title']?></a></p>
                                            <p> <?= mb_substr($row['summary'],0,70)?>... </p>
                                        </div>
                                    </li>
                                <?php endforeach; endif;?>
                            </ul>
                        </div>
                    </div>
                </div>
                <!--右边显示-->
                <div class="containerFR">
                    <div>
                        <img src="<?php echo base_url('resource/home')?>/images/59f6d83a6f630.png" alt="">
                        <p>主办方：陕西省国家税务局</p>
                    </div>
                </div>
            </div>
        </div>
        <?php include 'footer.php';?>
    </section>
    <!--foot-->
    <div class="modal">
        <div class="accModal">
            <h3>用户登陆 <span class="tRight">×</span></h3>
            <form action="">
                <ul class="formUl">
                    <li>用户名：</li>
                    <li>密码：</li>
                </ul>
                <ul class="formUl">
                    <li><input type="text" placeholder="请输入姓名"></li>
                    <li><input type="text" placeholder="请输入企业名称"></li>
                    <li><input type="checkbox"><span style="color: black;font-size: 14px">自动登陆</span></li>
                </ul>
                <div class="clear"></div>
                <input type="button" class="accButton" value="登陆">
            </form>
        </div>
        <div class="regModal">
            <h3>用户登陆 <span class="tRight">×</span></h3>
            <form action="">
                <ul class="formUl">
                    <li>姓名：</li>
                    <li>企业名称：</li>
                    <li>密码：</li>
                    <li>确认密码：</li>
                    <li>手机号码：</li>
                </ul>
                <ul class="formUl">
                    <li><input type="text" placeholder="请输入姓名"></li>
                    <li><input type="text" placeholder="请输入企业名称"></li>
                    <li><input type="text" placeholder="输入密码"></li>
                    <li><input type="text" placeholder="确认密码"></li>
                    <li><input type="text" placeholder="请输入手机号码"></li>
                    <li><input type="text" placeholder="请输入验证码" class="yzm"><input type="button" value="获取验证码" class="hqyzm"></li>
                </ul>
                <input type="button" class="accButton" value="登陆">
            </form>
        </div>
    </div>
    <script src="<?php echo base_url('resource/home')?>/js/modal.js"></script>
    <script>
        <!--跑马灯-->
        var oUl=document.getElementById('div1').children[0];
        var lis=oUl.getElementsByTagName('li');
        oUl.innerHTML+=oUl.innerHTML;
        oUl.style.width=lis.length*(lis[0].offsetLeft+lis[0].offsetWidth)+'px';
        var left=null;
        function move() {
            left-=1;
            if(left<-oUl.offsetWidth/2){
                left=0;
            }
            oUl.style.left=left+'px'
        }
        var timer=setInterval(move,10);

        $('#div1>ul').on('mouseover',function () {
            clearInterval(timer)
        })

        $('#div1>ul').on('mouseout',function () {
            timer=setInterval(move,10);
        })
        
    </script>
    <script>
        <!--tab切换-->
        var oTab=document.getElementById("cen_right_top");
        var aH3=oTab.getElementsByTagName("h3");
        var aDiv=oTab.getElementsByClassName("div111");
        console.log(aDiv);
        for(var i=0;i<aH3.length;i++)
        {
            aH3[i].index=i;
            aH3[i].onmouseover=function()
            {
                for(var i=0;i<aH3.length;i++)
                {
                    aH3[i].className="";
                    aDiv[i].style.display="none";
                }
                this.className="active";
                aDiv[this.index].style.display="block";
            }
        }
    </script>
</body>
</html>