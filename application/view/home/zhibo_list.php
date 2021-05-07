<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>直播教室-<?php echo $webinfo['title'];?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/detail.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="https://at.alicdn.com/t/font_234130_nem7eskcrkpdgqfr.css">
    <script src="<?php echo base_url('resource/home')?>/js/index.js"></script>
</head>
<body>
<?php include 'header.php';?>
    <section>
        <div class="sectionMain">
            <?php if(!empty($top)):?>
            <div class="mediaDetail">
                <div class="playDetail">
                    <div class="playDetailL">
                        <a href="<?=site_url('live/detail/'.$top['id'])?>">
                            <img src="<?=base_url($top['imgurl'])?>" alt="<?=$top['title']?>">
                        </a>
                    </div>
                    <div class="playDetailR">
                        <h2>[正在直播]<a href="<?=site_url('live/detail/'.$top['id'])?>"><?=$top['title']?></a></h2>
                        <h3>直播简介:<?=mb_substr($top['destext'],0,60)?></h3>
                        <p>讲师：<?=$top['teacher'];?>
                            <span class="tIndent">直播时间：<?=date('Y-m-d H:i',$top['livetime']);?></span>
                            <br>
                            课程类型：<?=$top['typename']?>
                            <span class="tIndent">课程时长：<?=$top['duration']?>分钟</span>
                        </p>
                        <a href="<?=site_url('live/play/'.$top['id'])?>" class="playB">观看直播</a>
                    </div>
                </div>
            </div>
            <?php else:?>
            <div class="mediaDetail">
                <div class="playDetail">
                    <div class="playDetailL">
                        <img src="<?=base_url('resource/home/images/nolive.png')?>" alt="">
                    </div>
                    <div class="playDetailR">
                        <h2>直播尚未开始</h2>
                        <h3>您可先浏览直播预告或查阅<a href="#">直播回放</a></h3>
                    </div>
                </div>
            </div>
            <?php endif;?>
            <div class="container">
                <div class="containerL">
                    <h1><img src="<?=base_url('resource/home')?>/images/ca.png" alt="" style="width: 50px;height: 50px">直播预告</h1>
                    <div id='schedule-box' class="boxshaw">
                        a
                    </div>
                    <h1><img src="<?=base_url('resource/home')?>/images/me.png" alt="" style="width: 50px;height: 50px">选择分类</h1>
                    <?php include 'filter.php';?>
                </div>
                <div class="containerR">
                    <ul>
                        <?php if(!empty($list)): foreach($list as $row):?>
                        <li>
                            <div>
                                <a href="<?=site_url('live/detail/'.$row['id'])?>">
                                    <img src="<?=base_url($row['imgurl'])?>" alt="">
                                </a>
                            </div>
                            <div>
                                <h3>[直播预告]<a href="<?=site_url('live/detail/'.$row['id'])?>"><?=$row['title']?></a></h3>
                                <p class="zTime">
                                    <strong>开播时间：</strong><?=date('Y-m-d H:i',$row['livetime'])?>
                                    <strong>时长：</strong><?=$row['duration']?>分钟
                                </p>
                                <p><?=mb_substr($row['destext'],0,50)?></p>
                            </div>
                        </li>
                        <?php endforeach; else:?>
                        <li>提示：暂时没有已发布的直播预告，敬请期待</li>
                        <?php endif;?>
                        <div class="clear"></div>
                    </ul>
                    <?php include 'page.php'?>
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
            </div>
        </div>
        <?php include 'footer.php';?>
    </section>
    <script src="<?php echo base_url('resource/home')?>/js/schedule.js"></script>
    <script>
        var mySchedule = new Schedule({
            el: '#schedule-box',
            clickCb: function(y, m, d) {
                alert(y+'-'+m+'-'+d)
            }
        });
    </script>
    <script src="<?php echo base_url('resource/home')?>/js/modal.js"></script>
</body>

</html>