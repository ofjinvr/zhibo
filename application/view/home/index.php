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
<<<<<<< HEAD
    <script type="text/javascript" src="<?php echo base_url('resource')?>/js/jquery.js"></script>
=======
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
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
<<<<<<< HEAD
                            <a href="/replay/play/9"><img src="<?php echo base_url('resource/home')?>/banner/banner0.png"></a>
                            <a href="/replay/play/9"><img src="<?php echo base_url('resource/home')?>/banner/banner1.jpg"></a>
=======
                            <a href="http://demo.cstaoding.com/replay/play/9"><img src="<?php echo base_url('resource/home')?>/banner/banner0.png"></a>
                            <a href="http://demo.cstaoding.com/replay/play/9"><img src="<?php echo base_url('resource/home')?>/banner/banner1.jpg"></a>
                            <a href="http://demo.cstaoding.com/replay/play/9"><img src="<?php echo base_url('resource/home')?>/banner/banner2.jpg"></a>
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
                        </div>
                        <div class="roll-news-index">
                            <ul>
                                <li class="roll-news-index-hover">1</li>
                                <li>2</li>
<<<<<<< HEAD
=======
                                <li>3</li>
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="mainRight">
                    <div class="Trailer">
                        <p class="mediaT">直播预告 <span></span> <i></i>&nbsp;<a href="<?=site_url('live')?>">更多</a></p>
                        <div class="">
                            <?php if(!empty($live_list_ready)): foreach($live_list_ready as $row):?>
                                <div class="TrailerL">
                                    <a href="<?=site_url('live/detail/'.$row['id'])?>">
                                        <img src="<?php echo base_url($row['imgurl'])?>" alt="">
                                        <div class="img_mask"></div>
                                        <div class="imgPlay"></div>
                                    </a>
                                </div>
                                <div class="TrailerR">
                                    <p class="TrailerRT"><?=$row['title']?></p>
                                    <p><?=mb_substr($row['destext'],0,15)?>...</p>
                                    <p class="TrailerRS"><?=date('Y-m-d/H:i',$row['livetime'])?>
                                        <span>
                                        <a href="<?=site_url('live/detail/'.$row['id'])?>">查看详情</a>
                                    </span>
                                    </p>
                                </div>
                                <div class="clear"></div>
                                
                            <?php endforeach; else:?>
                                <div class="TrailerL">
                                        <img src="<?php echo base_url('resource/home/images/nolive.png')?>" alt="">
                                    </a>
                                </div>
                                <div class="TrailerR">
                                    <p class="TrailerRT" style="margin-top: 20px">暂无直播 敬请期待</p>
                                </div>
                                <div class="clear"></div>
                                <?php endif;?>
                        </div>
                        <p class="mediaT">回放直播 <span></span> <i></i>&nbsp;<a href="<?=site_url('replay')?>">更多</a></p>
                        <ul class="TrailerUl">
                            <?php if(!empty($live_list_replay)): foreach($live_list_replay as $row):?>
                                <div class="TrailerL">
                                    <a href="<?=site_url('replay/detail/'.$row['id'])?>">
                                        <img src="<?php echo base_url($row['imgurl'])?>" alt="">
                                        <div class="img_mask"></div>
                                        <div class="imgPlay"></div>
                                    </a>
                                </div>
                                <div class="TrailerR">
                                    <p class="TrailerRT"><?=mb_substr($row['title'],0,12)?></p>
                                    <p><?=mb_substr($row['destext'],0,14)?>...</p>
                                    <p class="TrailerRS"><?=date('Y-m-d/H:i',$row['livetime'])?>
                                        <span>
                                        <a href="<?=site_url('replay/detail/'.$row['id'])?>">查看详情</a>
                                    </span>
                                    </p>
                                </div>
                                <div class="clear"></div>
                            <?php endforeach; endif;?>
                        </ul>
                    </div>
                </div>
            </div>
                   <!--视频列表-->
                        <div class="videoDiv">
                            <div class="content">
                                <p class="mediaT">推荐课堂<span></span><i></i>&nbsp;<a href="<?=site_url('video')?>">更多</a></p>
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
            <!--培训列表-->
            <div class="TeachDiv" style="margin-bottom:22px;">
                <div class="content">
                    <p class="mediaT">现场培训<span></span><i></i>&nbsp;<a href="<?=site_url('teach')?>">更多</a></p>
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

            <!--单图片-->
            <img src="<?php echo base_url('resource/home')?>/images2/notice.png" alt="" style="max-width: 100%">

            <!--讲师介绍-->
            <p class="mediaT">名师风采<span></span><i></i>&nbsp;<a href="<?=site_url('teacher')?>">更多</a></p>
            <div id="div1">
                <ul>
                    <?php if(!empty($teacher)): foreach($teacher as $row):?>
                    <li><a href="<?=site_url('teacher/detail/'.$row['id'])?>">
                        <img src="<?php echo base_url($row['photo'])?>" alt=""/>
                        <p>讲师姓名：<span><?=$row['teacher_name']?></span></p>
                        <p>工作单位：<span><?=$row['company']?></span></p>
                        </a>
                    </li>
                    <?php endforeach; endif;?>
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
       $(function() {
       // 如果不支持placeholder，用jQuery来完成
       if(!isSupportPlaceholder()) {
       // 遍历所有input对象, 除了密码框
       $('input').not("input[type='password']").each(
       function() {
       var self = $(this);
       var val = self.attr("placeholder");
       input(self, val);
       }
       );

       /**//* 对password框的特殊处理
       * 1.创建一个text框
       * 2.获取焦点和失去焦点的时候切换
       */
       $('input[type="password"]').each(
       function() {
       var pwdField    = $(this);
       var pwdVal      = pwdField.attr('placeholder');
       var pwdId       = pwdField.attr('id');
       // 重命名该input的id为原id后跟1
       pwdField.after('<input id="' + pwdId +'1" type="text" value='+pwdVal+' autocomplete="off" />');
       var pwdPlaceholder = $('#' + pwdId + '1');
       pwdPlaceholder.show();
       pwdField.hide();

       pwdPlaceholder.focus(function(){
       pwdPlaceholder.hide();
       pwdField.show();
       pwdField.focus();
       });

       pwdField.blur(function(){
       if(pwdField.val() == '') {
       pwdPlaceholder.show();
       pwdField.hide();
       }
       });
       }
       );
       }
       });

       // 判断浏览器是否支持placeholder属性
       function isSupportPlaceholder() {
       var input = document.createElement('input');
       return 'placeholder' in input;
       }

       // jQuery替换placeholder的处理
       function input(obj, val) {
       var $input = obj;
       var val = val;
       $input.attr({value:val});
       $input.focus(function() {
       if ($input.val() == val) {
       $(this).attr({value:""});
       }
       }).blur(function() {
       if ($input.val() == "") {
       $(this).attr({value:val});
       }
       });
       }

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
</body>
</html>
