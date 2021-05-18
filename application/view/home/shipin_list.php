<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>视频学习-<?=$webinfo['title']?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/detail.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/spxx.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
    <style>
        .containerR ul li {
            height: 156px;
        }
        #studyBox {
            display: inline-block;
            width: 100%;
            height: 100%;
        }
        #studyBox img {
            width: 256px;
            height: 157px;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url('resource/home')?>/js/index.js"></script>
</head>
<body>
<?php include 'header.php';?>
    <section>
    <div class="sectionMain">
        <div class="container">
            <div class="containerL">
                <h1><img src="<?php echo base_url('resource/home')?>/images/me.png" alt="" style="viwidth: 50px;height: 50px">选择分类</h1>
                <?php include 'filter.php';?>
                <div class="category category3">
                    <ul>
                        <h3>按单位</h3>
                        <li class="<?php if(empty($_GET['cityname'])){echo 'active';}?>"><a href="?<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">全部</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='省直属分局'){echo 'active';}?>"><a href="?cityname=省直属分局<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">省直属分局</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='西安国税'){echo 'active';}?>"><a href="?cityname=西安国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>"></a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='宝鸡国税'){echo 'active';}?>"><a href="?cityname=宝鸡国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">宝鸡国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='咸阳国税'){echo 'active';}?>"><a href="?cityname=咸阳国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">咸阳国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='铜川国税'){echo 'active';}?>"><a href="?cityname=铜川国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">铜川国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='渭南国税'){echo 'active';}?>"><a href="?cityname=渭南国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">渭南国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='安康国税'){echo 'active';}?>"><a href="?cityname=安康国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">安康国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='商洛国税'){echo 'active';}?>"><a href="?cityname=商洛国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">商洛国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='韩城国税'){echo 'active';}?>"><a href="?cityname=韩城国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">韩城国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='杨凌国税'){echo 'active';}?>"><a href="?cityname=杨凌国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">杨凌国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='西咸新区国税'){echo 'active';}?>"><a href="?cityname=西咸新区国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">西咸新区国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='延安国税'){echo 'active';}?>"><a href="?cityname=延安国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">延安国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='汉中国税'){echo 'active';}?>"><a href="?cityname=汉中国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">汉中国税</a></li>
                        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='榆林国税'){echo 'active';}?>"><a href="?cityname=榆林国税<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">榆林国税</a></li>
                    </ul>
                </div>
            </div>
            <div class="containerR">
                <ul>
                    <?php if(!empty($list)):?>
                    <?php foreach($list as $row):?>
                    <li>
                        <div id="studyBox" style=" width: 256px; height: 100%">
                            <a href="<?=site_url('video/play/'.$row['id'])?>" target="_blank">
                                <img src="<?=base_url($row['imgurl'])?>" alt="">
                            </a>
                        </div>
                        <div style="width: 300px">
                            <h3><a href="<?=site_url('video/play/'.$row['id'])?>"  target="_blank"><?=$row['title']?></a></h3>
                            <p class="zTime">制作单位:<?=$row['cityname']?><br>发布日期：<?=date('Y-m-d/H:i',$row['pubtime'])?> </p>
                            <p><?=mb_substr($row['destext'],0,40)?></p>
                        </div>
                    </li>
                    <?php endforeach;?>
                    <?php endif;?>
                    <div class="clear"></div>
                </ul>
                <?php include "page.php";?>
                <div class="clear"></div>
            </div>
            <div class="clear"></div>
        </div>
    </div>
        <?php include 'footer.php';?>
</section>
</body>
</html>