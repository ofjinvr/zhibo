<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>关于学堂</title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/index.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <?php include 'header.php';?>
    <section>
        <div class="sectionMain" style="min-height: 400px;">
            <!--最下内容-->
            <div class="containerF">
                <!--左边tab切换-->

                <div class="containerFL">
                    <div id="cen_right_top">
                        <ul class="cen_right_top_nav">
                            <li><h3 class="active"> <p>建设背景</p></h3></li>
                            <li><h3 class=""> <p>功能亮点</p></h3></li>
                            <li><h3 class=""> <p>学堂大事</p></h3></li>
                            <li><h3 class=""> <p>发展成果</p></h3></li>
                        </ul>
                        <div style="display:block" class="div111">
                            <p style="margin-top: 20px;text-indent: 32px">
                                加强纳税人学堂建设是巩固党的群众路线教育实践活动的重要举措，是转变职能、改进作风的重要抓手，是建立优质便捷纳税服务体系的重要内容。陕西省国家税务局“纳税人学堂”以纳税人合理需求为导向，以普及税收知识、提高纳税人满意度和税法遵从度为目标，以免费授课、自愿参加、课程实用、教学相长为原则，旨在建立规范持久的税法宣传和纳税辅导机制，增强税法宣传的长效性、针对性和实用性，有效解决服务纳税人“最后一公里”问题。</p>
                            <p>纳税人学堂采用实体教学和网络教学相结合的方式，以纳税人关切为焦点，培训内容包括最新税收政策、新办税软件操作、常见问题等。企业负责人、财务人员、办税人员以及其他希望了解税收知识的人员可以根据个人需求在所属的县（区）纳税人实体学堂参加学习培训和互动交流，也可以通过陕西省国家税务局纳税人学堂网站、手机App以及微信公众号进入纳税人学堂进行在线学习交流。</p>
                            <p>愿我们的十分努力能为您带来一分获得！</p>
                        </div>
                        <div class="div111">
                            <p style="margin-top: 20px;text-indent: 32px">
                                功能亮点内容
                            </p>
                        </div>
                        <div class="div111">
                            <ul class="commentListUl1">
                                <?php if(!empty($list)):?>
                                <?php foreach($list as $row):?>
                                <li>
                                    <div class="commentListUl1F">
                                        <span><?=date('m/d',$row['pubtime'])?></span>
                                        <span><?=date('Y',$row['pubtime'])?></span>
                                    </div>
                                    <div class="commentListUl1T">
                                        <p><a href="<?=site_url('about/article/'.$row['id'])?>"><?=$row['title']?></a></p>
                                        <p><?=$row['summary']?></p>
                                    </div>
                                </li>
                                <?php endforeach;?>
                                <?php else:?>
                                <li>暂无数据</li>
                                <?php endif;?>
                            </ul>
                        </div>
                        <div class="div111">
                            <p style="margin-top: 20px;text-indent: 32px">
                                发展成果内容
                            </p>
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
    <script src="<?php echo base_url('resource/home')?>/js/script.js"></script>
</body>
</html>