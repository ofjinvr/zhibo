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
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
    <style>
        .active a {
            color: white;
        }
        .videoList ul {
            display: block;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url('resource/home')?>/js/index.js"></script>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/videoDetail.js"></script>
</head>
<body>
<?php include 'header.php';?>
    <section>
        <div class="sectionMain" style="min-height: 800px;">
            <div class="container">
                <div class="containerL">
                    <div class="zbhf1">
<<<<<<< HEAD
                        <h1><img src="<?=base_url()?>resource/home/images/vi.png" alt="" style="width: 50px;height: 50px">选择分类</h1>
=======
                        <h1><img src="http://demo.cstaoding.com/resource/home/images/vi.png" alt="" style="width: 50px;height: 50px">选择分类</h1>
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
                        <?php include 'filter.php';?>

                        <!--
                        <div class="containerLBott">
                            <h1 class="containerLBottT">
                                <img src="<?php echo base_url('resource/home')?>/images/user.png" alt="" style="width: 50px;height: 50px">税务专家
                            </h1>
                            <ul>
                                <li>
                                    <p style="text-align: center;"></p>
                                    <p></p>
                                    <div class="containerLBottI">
                                        <img src="<?php echo base_url('resource/home')?>/images/m1.jpg" alt=""/>
                                    </div>
                                    <div class="containerLBottText">
                                        <p>讲师:丁馨</p>
                                        <p>单位：陕西国税12366纳税服务中心</p>
                                    </div>
                                </li>
                                <li>
                                    <p style="text-align: center;"></p>
                                    <p></p>
                                    <div class="containerLBottI">
                                        <img src="<?php echo base_url('resource/home')?>/images/m2.jpg" alt=""/>
                                    </div>
                                    <div class="containerLBottText">
                                        <p>讲师:姜蝉蝉</p>
                                        <p>单位：陕西国税12366纳税服务中心</p>
                                    </div>
                                </li>
                                <li>
                                    <p style="text-align: center;"></p>
                                    <p></p>
                                    <div class="containerLBottI">
                                        <img src="<?php echo base_url('resource/home')?>/images/m3.jpg" alt=""/>
                                    </div>
                                    <div class="containerLBottText">
                                        <p>讲师:卢梦冰</p>
                                        <p>单位：陕西国税12366纳税服务中心</p>
                                    </div>
                                </li>
                                <li>
                                    <p style="text-align: center;"></p>
                                    <p></p>
                                    <div class="containerLBottI">
                                        <img src="<?php echo base_url('resource/home')?>/images/m4.jpg" alt=""/>
                                    </div>
                                    <div class="containerLBottText">
                                        <p>讲师:马翌祯</p>
                                        <p>单位：省局货物和劳务税处</p>
                                    </div>
                                </li>
                                <li>
                                    <p style="text-align: center;"></p>
                                    <p></p>
                                    <div class="containerLBottI">
                                        <img src="<?php echo base_url('resource/home')?>/images/m5.jpg" alt=""/>
                                    </div>
                                    <div class="containerLBottText">
                                        <p>讲师:史蕊</p>
                                        <p>单位：陕西国税12366纳税服务中心</p>
                                    </div>
                                </li>
                                <li>
                                    <p style="text-align: center;"></p>
                                    <p></p>
                                    <div class="containerLBottI">
                                        <img src="<?php echo base_url('resource/home')?>/images/m6.jpg" alt=""/>
                                    </div>
                                    <div class="containerLBottText">
                                        <p>讲师:杨楠</p>
                                        <p>单位：陕西国税12366纳税服务中心</p>
                                    </div>
                                </li>
                                <li>
                                    <p style="text-align: center;"></p>
                                    <p></p>
                                    <div class="containerLBottI">
                                        <img src="<?php echo base_url('resource/home')?>/images/m7.jpg" alt=""/>
                                    </div>
                                    <div class="containerLBottText">
                                        <p>讲师:易娅岚</p>
                                        <p>单位：咸阳市长武县国家税务局</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        -->

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
                                            <li style="">
                                                <div class="img">
                                                    <img src="<?=base_url($row['imgurl']);?>">
                                                    <div class="img_mask" style="display: none;"></div>
                                                    <div class="imgPlay" style="display: none;">
                                                        <a href="<?=site_url('replay/detail/'.$row['id'])?>"></a>
                                                    </div>
                                                    <div class="playtime" style="display: none;">时长：<?=$row['duration']?>分钟</div>
                                                </div>
                                                <div class="videoDesc">
                                                    <div>
                                                        <div class="title"><a href="<?=site_url('replay/detail/'.$row['id'])?>" title="<?=$row['title']?>"><?=$row['title']?></a></div>
                                                        <div class="time"><span><img src="<?php echo base_url('resource/home')?>/images/video-icon.png" width="16" height="16" class="video-icon"></span> <?=$row['pageview']?>
                                                        </div>
                                                        <div class="clear"></div>
                                                    </div>
                                                    <div class="desc">

                                                        <div style="white-space:nowrap;overflow:hidden;text-overflow:ellipsis;max-width:155px;">
                                                            讲师：<?=$row['teacher']?>
                                                        </div>
                                                        <div style="float:right;"><?=date('Y-m-d',$row['livetime'])?></div>
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
        <?php include 'footer.php';?>
    </section>
</body>
</html>