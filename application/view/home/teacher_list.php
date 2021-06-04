<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>名师风采-<?php echo $webinfo['title'];?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?=base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?=base_url('resource/home')?>/css/common.css">
     <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
    <link rel="stylesheet" href="<?=base_url('resource/home')?>/css/detail.css">
    <link rel="stylesheet" href="<?=base_url('resource/home')?>/teachers/css/goodTeacher.css">
     <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php include 'header.php';?>
<div class="section">
    <div class="sectionMain_box">
        <div class="section_left">
            <div class="section_top">
                <img src="<?=base_url('resource/home')?>/teachers/images/mingshi.png" alt="">
                <span style="font-size:18px;">选择分类</span>
            </div>
            <div class="category category3 category_3">
                <ul>
                    <h3>按单位</h3>
                    <li <?php if(empty($_GET['company'])){echo 'class="active"';}?>><a href="<?=site_url('teacher')?>">全部</a></li>
                    <?php if(!empty($company_list)): foreach($company_list as $row):?>
                    <li <?php if(!empty($_GET['company']) and $_GET['company']===$row){echo 'class="active"';}?>>
                        <a href="<?=site_url('teacher?company='.$row)?>")><?=$row?></a>
                    </li>
                    <?php endforeach; endif;?>
                </ul>
            </div>
        </div>
        <div class="section_right">
            <div class="item_box">
                <?php foreach($list as $row):?>
                    <div class="item_list">
                        <div class="item_img"><a href="<?=site_url('teacher/detail/'.$row['id'])?>"><img src="<?=base_url($row['photo'])?>" alt=""></a></div>
                        <div class="item_content">
                            <h3><a href="<?=site_url('teacher/detail/'.$row['id'])?>"><?=$row['teacher_name']?></a></h3>
                            <h4><?=$row['company']?></h4>
                            <p><?=mb_substr($row['content'],0,35)?><?php if(mb_strlen($row['content'])>35){echo '...';}?></p>
                        </div>
                        <a href="<?=site_url('teacher/detail/'.$row['id'])?>">
                            <div class="item_btn" style="color:#fff">详情</div>
                        </a>
                    </div>
                <?php endforeach;?>
            </div>
            <?php include 'page.php'?>
        </div>
    </div>
    <?php include 'footer.php'?>
</div>

</body>
</html>