<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>直播回放-<?php echo $webinfo['title'];?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/mStudy.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url('resource/home')?>/js/index.js"></script>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/videoDetail.js"></script>
</head>
<body>
<?php include 'header.php';?>
    <section>
        <div class="sectionMain">
            <div class="container">
                <div class="containerL">
                    <div class="zbhf1">
                        <h1><img src="<?php echo base_url('resource/home')?>/images/vi.png" alt="" style="width: 50px;height: 50px">直播回放</h1>
                        <?php include 'filter.php';?>
                        <div class="containerLBott">
                            <h1 class="containerLBottT">
                                <img src="<?php echo base_url('resource/home')?>/images/user.png" alt="" style="width: 50px;height: 50px">税务专家
                            </h1>
                            <ul>
                                <li>
                                    <div class="containerLBottI">
                                        <img src="<?php echo base_url('resource/home')?>/images/59f6d94d3a3c6.jpg" alt="">
                                    </div>
                                    <div class="containerLBottText">
                                        <p>讲师:万众岗老师</p>
                                        <p>分局：陕西省国家税务局渭南市分局</p>
                                        <p>访问次数：15698</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="containerR">
                    <!--视频-->
                    <ul class="containerRP">
                        <li>排序:</li>
                        <li class="active">默认</li>
                    </ul>
                    <div class="videoDiv">
                        <div class="content">
                            <div class="neiborder">
                                <div class="cRight">
                                    <div class="videoList">
                                        <ul>
                                            <?php if(!empty($list)):?>
                                            <?php foreach($list as $row):?>
                                            <li>
                                                <div class="img">
                                                    <img src="<?=base_url($row['imgurl']);?>">
                                                    <div class="img_mask" style="display: none;"></div>
                                                    <div class="imgPlay" style="display: none;">
                                                        <a href="<?=site_url('replay/play/'.$row['id'])?>"></a>
                                                    </div>
                                                    <div class="playtime" style="display: none;">时长：<?=$row['duration']?>分钟</div>
                                                </div>
                                                <div class="videoDesc">
                                                    <div>
                                                        <div class="title"><a href="<?=site_url('replay/play/'.$row['id'])?>" title="<?=$row['title']?>"><?=$row['title']?></a></div>
                                                        <div class="time"><span><img src="<?php echo base_url('resource/home')?>/images/video-icon.png" width="16" height="16" class="video-icon"></span> 753
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="desc">

                                                        <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:155px;">
                                                            讲师：<?=$row['teacher']?>
                                                        </div>
                                                        <div style="float:right;"><?=date('Y-m-d',$row['pubtime'])?></div>
                                                        <div class="clear"></div>

                                                    </div>
                                                </div>
                                            </li>
                                            <?php endforeach;?>
                                            <?php endif;?>
                                            <div style="clear:both;"></div>
                                        </ul>
                                    </div>

                                </div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    </div>
                    <?php include 'page.php'?>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </section>
    <script src="<?php echo base_url('resource/home')?>/js/modal.js"></script>
</body>
</html>