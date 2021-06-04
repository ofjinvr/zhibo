<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?=$info['teacher_name']?>-名师风采-<?php echo $webinfo['title'];?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?=base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?=base_url('resource/home')?>/css/common.css">
   <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
    <link rel="stylesheet" href="<?=base_url('resource/home')?>/css/detail.css">
    <link rel="stylesheet" href="<?=base_url('resource/home')?>/teachers/css/zixun.css">
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php include 'header.php';?>
<div class="section">
    <div class="zixun_box">
        <div class="zi_section_1">
            <h2 style=" margin-bottom: 20px;">当前位置：<a href="<?=site_url('teacher')?>">名师风采</a> >> <?=$info['teacher_name']?></h2>
            <div class="zi_section_img">
                <img src="<?=base_url($info['photo'])?>" alt="">
            </div>
            <div class="zi_section_text">
                <div class="item_content">
                    <h3><?=$info['teacher_name']?></h3>
                    <h4><?=$info['company']?></h4>
                    <p><?=$info['content']?></p>
                    <p>课程数量:<?=count($course)?></p>
                </div>
            </div>
        </div>
        <div class="zi_section_2">
            <div class="section_2_left">
                <ul id="btn_menu">
                    <li class="active">相关课程</li>
                    <li>业务咨询</li>
                </ul>

                <div class="qq_box item_text">
                    <div style="padding:30px;">
                        <?php if($info['company']==='陕西东信税务师事务所'):?>
                        <p>座机:<?=$info['phone_1'];?></p>
                        <p>手机:<?=$info['phone_2'];?></p>
                        <img src="<?=base_url('resource/home')?>/images2/qrcode.jpg" alt="" width="400">
                        <?php else:?>
                        <p>服务电话：12366</p>
                        <img src="<?=base_url('resource/home')?>/images2/qrcode_12366.jpg" alt="">
                        <?php endif;?>
                        <h3>扫一扫加微信</h3>
                    </div>
                </div>
                <div class="book_ss ">
                    <?php if(!empty($course)): foreach($course as $row):?>
                    <?php if($row['livetime']+$row['duration']*60 > time()){$type='live';}else{$type='replay';}?>
                        <div class="right_box">
                            <a href="<?=site_url("$type/detail/{$row['id']}")?>">
                                <img src="<?=base_url($row['imgurl'])?>" alt="">
                            </a>
                            <p><a href="<?=site_url("$type/detail/{$row['id']}")?>">小微企业税收优惠政策</a><span><?=$row['pageview']?></span> <img src="<?=base_url('resource/home')?>/teachers/images/play.png" alt=""></p>
                            <p class="small">
                                <a>讲师：<?=$row['teacher']?></a><span><?=date('Y-m-d',$row['livetime'])?></span>
                            </p>
                        </div>
                    <?php endforeach; else:?>
                        <p style="margin: 20px; text-align: center;">暂无相关课程</p>
                    <?php endif;?>
                </div>
            </div>
            <div class="section_2_right">
                <h3><i></i>更多名师<a></a></h3>
                <?php foreach($more_list as $row):?>
                <div class="right_box">
                    <a href="<?=site_url('teacher/detail/'.$row['id'])?>"><img src="<?=base_url($row['photo'])?>" alt=""></a>
                    <p><a href="<?=site_url('teacher/detail/'.$row['id'])?>"><?=$row['teacher_name']?></a>  <span><?=$row['company']?></span></p>
                    <p class="small" title="<?=$row['content']?>"><?=mb_substr($row['content'],0,45)?><?php if($row['content']>45){echo '...';}?></p>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </div>
    <?php include 'footer.php'?>
</div>
<script>
    $("#btn_menu").on('click',function(e){
        $('#btn_menu li').removeClass('active');

        e.target.className='active';
        if(e.target.innerHTML=='业务咨询'){
            $('.book_ss').css('display','none')
            $('.qq_box').css('display','block')

        }
        if(e.target.innerHTML=='相关课程'){
            $('.book_ss').css('display','block')
            $('.qq_box').css('display','none')

        }
    })
</script>

</body>
</html>