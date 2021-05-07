<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>视频学习</title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/detail.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/spxx.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <script src="<?php echo base_url('resource/home')?>/js/index.js"></script>
</head>
<body>
<?php include 'header.php';?>
    <section>
    <div class="sectionMain">
        <div class="container">
            <div class="containerL">
                <h1><img src="<?php echo base_url('resource/home')?>/images/vi.png" alt="" style="viwidth: 50px;height: 50px">选择分类</h1>
                <?php include 'filter.php';?>
            </div>
            <div class="containerR">
                <ul>
                    <?php if(!empty($list)):?>
                    <?php foreach($list as $row):?>
                    <li>
                        <div>
                            <a href="<?=site_url('video/play/'.$row['id'])?>" target="_blank">
                                <img src="<?=base_url($row['imgurl'])?>" alt="">
                            </a>
                        </div>
                        <div>
                            <h3><a href="<?=site_url('video/play/'.$row['id'])?>"  target="_blank"><?=$row['title']?></a></h3>
                            <p class="zTime"><?=date('Y-m-d/H:i',$row['pubtime'])?></p>
                            <p><?=$row['destext'] ?></p>
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