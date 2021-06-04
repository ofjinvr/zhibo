<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>关于学堂</title>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/index.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php include 'header.php';?>
<section>
    <div class="sectionMain teachMain" style="min-height: 800px;">
        <h2 style=" margin-bottom: 20px;">当前位置：<a href="<?=site_url('teach')?>">现场培训</a> >> <?=$info['title']?></h2>
        <div class="teachDetail">
            <div class="teachDetailL">
                <img src="<?=base_url($info['imgurl'])?>" alt="<?=$info['title']?>" width="100%" height="100%">
            </div>
            <div class="teachDetailR" style="width: auto; line-height: 1.5em;">
                <h2><?=$info['title']?></h2>
                <p>主办单位:<?=$info['sponsor']?></p>
                <p>联系人:<?=$info['teacher']?></p>
                <p>联系电话:<?=$info['telphone']?></p>
                <p>培训时间:<?=date('Y-m-d H:i',$info['teachtime'])?></p>
                <p>培训地址:<?=$info['address']?></p>
                <p style="margin-top:10px">计划人数:<?=$info['pnumber']?> 剩余名额:<?=$info['snumber']?></p>
                <a href="#" data-tid="<?=$info['id']?>" class="baoming">我要报名</a>
             </div>
         </div>

        <div class="teachDeS">
            <h2>课程描述</h2>
            <span class="line"></span>
            <p><?=$info['destext']?></p>
        </div>

        <div class="teachAbout">
            <h2>相关培训</h2>
            <span class="line"></span>
            <ul>
                <?php if(!empty($like)):?>
                <?php foreach($like as $row):?>
                <li><a href="<?=site_url('teach/detail/'.$row['id'])?>" title="<?=$row['title']?>"><?=mb_substr($row['title'],0,16)?>...</a></li>
                <?php endforeach;?>
                <?php else:?>
                <li>暂无数据</li>
                <?php endif;?>
            </ul>
        </div>
    </div>
    <?php include 'footer.php';?>
</section>

<script src="<?php echo base_url('resource/home')?>/js/script.js"></script>
</body>
</html>