<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$webinfo['title']?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/video.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/index.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
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
                            <a href="#"><img src="<?php echo base_url('resource/home')?>/banner/banner0.png"></a>
                            <a href="#"><img src="<?php echo base_url('resource/home')?>/banner/banner1.jpg"></a>
                            <a href="#"><img src="<?php echo base_url('resource/home')?>/banner/banner2.jpg"></a>
                        </div>
                        <div class="roll-news-index">
                            <ul>
                                <li class="roll-news-index-hover">1</li>
                                <li>2</li>
                                <li>3</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mainRight">
                    <div class="Trailer">
                        <p class="mediaT">直播预告 <span></span> <i></i>&nbsp;<a href="<?=site_url('live')?>">MORE</a></p>
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
                        <p class="mediaT">回放直播 <span></span> <i></i>&nbsp;<a href="<?=site_url('replay')?>">MORE</a></p>
                        <ul class="TrailerUl">
                            <?php if(!empty($live_list_replay)): foreach($live_list_replay as $row):?>
                            <li>
                                <p><a href="<?=site_url('replay/play/'.$row['id'])?>"><?=$row['title']?></a>
                                    <span><?=date('Y/m/d',$row['livetime'])?></span>
                                </p>
                            </li>
                            <?php endforeach; endif;?>
                        </ul>
                    </div>
                </div>
            </div>
            <!--培训列表-->
            <div class="TeachDiv">
                <div class="content">
                    <p class="mediaT">现场培训<span></span><i></i>&nbsp;<a href="javascript:;">MORE</a></p>
                    <table>
                        <tr>
                            <th width="30%">培训主题</th>
                            <th width="15%">主办单位</th>
                            <th width="15%">培训时间</th>
                            <th width="15%">剩余名额</th>
                            <th width="25%">操作</th>
                        </tr>
                        <?php if(!empty($teach)): foreach($teach as $row):?>
                            <tr>
                                <td title="<?=$row['title']?>"><?=mb_substr($row['title'],0,15)?>...</td>
                                <td title="<?=$row['sponsor']?>"><?=mb_substr($row['sponsor'],0,8)?>...</td>
                                <td><?=date('Y/m/d H:i',$row['teachtime'])?></td>
                                <td><?=$row['snumber']?></td>
                                <td id="handle">
                                    <a style="background-color: #EEE9E9;" href="<?=site_url('teach/detail/'.$row['id'])?>">详情</a>
                                    <a style="background-color: #FF9426;" href="javascript:;" data-tid="<?=$row['id']?>" class="baoming">报名</a>
                                </td>
                            </tr>
                        <?php endforeach; endif;?>
                    </table>
                </div>
            </div>
            <!--视频列表-->
            <div class="videoDiv">
                <div class="content">
                    <p class="mediaT">推荐课堂<span></span><i></i>&nbsp;<a href="javascript:;">MORE</a></p>
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
                                                <div style="float:left">制作单位：<?=$row['cityname']?></div>
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
            <img src="<?php echo base_url('resource/home')?>/images2/notice.png" alt="" style="max-width: 100%">

            <!--讲师介绍-->
            <p class="mediaT">名师风采<span></span><i></i>&nbsp;<a href="javascript:;">MORE</a></p>
            <div id="div1">
                <ul>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p1.png" alt=""/>
                        <p>讲师名称：<span>王晓梅</span></p>
                        <p>工作单位：<span>陕西东信税务师事务所</span></p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p2.png" alt=""/>
                        <p>讲师名称：<span>倪旻</span></p>
                        <p>工作单位：<span>陕西东信税务师事务所</span></p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p3.png" alt=""/>
                        <p>讲师名称：<span>杨楠</span></p>
                        <p>工作单位：<span>陕西国税12366纳税服务中心</span></p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p4.png" alt=""/>
                        <p>讲师名称：<span>王蕊</span></p>
                        <p>工作单位：<span>陕西东信税务师事务所</span></p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p5.png" alt=""/>
                        <p>讲师名称：<span>史蕊</span></p>
                        <p>工作单位：<span>陕西国税12366纳税服务中心</span></p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p6.png" alt=""/>
                        <p>讲师名称：<span>丁馨</span></p>
                        <p>工作职位：<span>陕西国税12366纳税服务中心</span></p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p7.png" alt=""/>
                        <p>讲师名称：<span>易娅岚</span></p>
                        <p>工作单位：<span>咸阳市长武县国家税务局</span></p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p8.png" alt=""/>
                        <p>讲师名称：<span>卢梦冰</span></p>
                        <p>工作单位：<span>陕西国税12366纳税服务中心</span></p>
                    </li>

                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p10.png" alt=""/>
                        <p>讲师名称：<span>马翌祯</span></p>
                        <p>工作单位：<span>省局货物和劳务税处</span></p>
                    </li>
                    <li>
                        <img src="<?php echo base_url('resource/home')?>/images2/p11.png" alt=""/>
                        <p>讲师名称：<span>姜蝉蝉</span></p>
                        <p>工作单位：<span>陕西国税12366纳税服务中心</span></p>
                    </li>

                </ul>
            </div>
            <!--最下内容
            <div class="containerF">
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
                <div class="containerFR">
                    <div>
                        <img src="<?php echo base_url('resource/home')?>/images/59f6d83a6f630.png" alt="">
                        <p>主办方：陕西省国家税务局</p>
                    </div>
                </div>
            </div>-->
        </div>
        <?php include 'footer.php';?>
    </section>

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
