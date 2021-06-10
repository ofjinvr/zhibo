<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>搜索</title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/detail.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/index.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
    <style>
        .in a {
            color: white;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
    <?php include 'header.php';?>
    <section>

        <div class="sectionMain" style="min-height: 800px;">
            <div class="container_box">
                    <div class="keyword" style="font-size:16px; margin-left:30px;">
                        关键词：<?=$_GET['kw'];?>
                    </div>
                    <div class="section_box">

                        <div class="choose_one">
                            <div class="choose_one_name">按内容</div>
                            <div class="choose_one_tabBox">
                                <span class="fate <?php if(!empty($type) and $type==='live') echo 'in';?>"><a href="<?=site_url('index/search/live')?>?kw=<?=$_GET['kw']?>">直播</a></span>
                                <span class="fate <?php if($type==='video') echo 'in';?>"><a href="<?=site_url('index/search/video')?>?kw=<?=$_GET['kw']?>">视频</a></span>
                                <span class="fate <?php if($type==='teach') echo 'in';?>"><a href="<?=site_url('index/search/teach')?>?kw=<?=$_GET['kw']?>">现场培训</a></span>
                            </div>
                        </div>
                        <div class="choose_two">
                            <div class="choose_one_name">按分类</div>
                            <div class="choose_one_tabBox">
                                <span class="fate <?php if(empty($_GET['typename'])) echo 'in';?>"><a href="?kw=<?=$_GET['kw']?>&typename=&rolename=<?=$_GET['rolename']?>">全部</a></span>
                                <span class="fate <?php if(!empty($_GET['typename'])&&$_GET['typename']=='财税政策') echo 'in';?>"><a href="?kw=<?=$_GET['kw']?>&typename=财税政策&rolename=<?=$_GET['rolename']?>">财税政策</a></span>
                                <span class="fate <?php if(!empty($_GET['typename'])&&$_GET['typename']=='办税指南') echo 'in';?>"><a href="?kw=<?=$_GET['kw']?>&typename=办税指南&rolename=<?=$_GET['rolename']?>">办税指南</a></span>
                                <span class="fate <?php if(!empty($_GET['typename'])&&$_GET['typename']=='软件操作') echo 'in';?>"><a href="?kw=<?=$_GET['kw']?>&typename=软件操作&rolename=<?=$_GET['rolename']?>">软件操作</a></span>
                            </div>
                        </div>
                        <div class="choose_two">
                            <div class="choose_one_name">按角色</div>
                            <div class="choose_one_tabBox">
                                <span class="fate <?php if(empty($_GET['rolename'])) echo 'in';?>"><a href="?kw=<?=$_GET['kw']?>&typename=<?=$_GET['typename']?>&rolename=">全部</a></span>
                                <span class="fate <?php if(!empty($_GET['rolename'])&&$_GET['rolename']=='个体') echo 'in';?>"><a href="?kw=<?=$_GET['kw']?>&typename=<?=$_GET['typename']?>&rolename=个体">个体</a></span>
                                <span class="fate <?php if(!empty($_GET['rolename'])&&$_GET['rolename']=='企业') echo 'in';?>"><a href="?kw=<?=$_GET['kw']?>&typename=<?=$_GET['typename']?>&rolename=企业">企业</a></span>
                            </div>
                        </div>

                        <div class="section_title">
                            <span>标题</span>
                            <span>日期</span>
                        </div>
                        <div class="section_list" style="height: auto;">
                            <ul>
                                <?php if(!empty($list)): foreach($list as $row):?>
                                <li><span><a href="<?=$row['url']?>"><?=$row['title']?></a></span><span><?=date('Y/m/d',$row['pubtime'])?></span></li>
                                <?php endforeach; else:?>
                                <li>暂无数据</li>
                                <?php endif;?>
                            </ul>
                        </div>
                        <?php include 'page.php'?>
                    </div>
                </div>
        </div>
        <?php include 'footer.php';?>
    </section>
    <script src="<?php echo base_url('resource/home')?>/js/script.js"></script>
</body>
</html>