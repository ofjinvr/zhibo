<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>现场培训-<?=$webinfo['title']?></title>
    <meta name="keywords" content="<?php echo $webinfo['keyword'];?>"/>
    <meta name="description" content="<?php echo $webinfo['description'];?>"/>
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/common.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/reset.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/detail.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/index.css">
<<<<<<< HEAD
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/calendar.css">
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">

=======
    <link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css2/common2.css">
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
    <style>
        
        select {
            width: 145px;
            margin-left:20px;
        }
        .categoryTitle {
            margin: 20px 0;
        }
        .category3 h3 {
            display: inline-block;
<<<<<<< HEAD
            *zoom:1;
              *display: inline;
=======
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('resource/home')?>/js/jquery-3.2.1.min.js"></script>
    <link rel="stylesheet" href="https://at.alicdn.com/t/font_234130_nem7eskcrkpdgqfr.css">
    <script src="<?php echo base_url('resource/home')?>/js/index.js"></script>
<<<<<<< HEAD
    <script src="<?php echo base_url('resource/home')?>/js2/calendar.js"></script>
    <script src="<?php echo base_url('resource/home')?>/js2/calendar-zh.js"></script>
    <script src="<?php echo base_url('resource/home')?>/js2/calendar-setup.js"></script>
=======
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
</head>
<body>
<?php include 'header.php';?>
<section>
    <div class="sectionMain" style="min-height: 800px;">
                    <div class="container">
                        <div class="containerL">
                            <h1><img src="<?=base_url('resource/home')?>/images/ca.png" alt="" style="width: 50px;height: 50px">培训安排</h1>
<<<<<<< HEAD
                            <div id="date_box">
                                <input type="text" id="EntTime" name="EntTime" onclick="return showCalendar('EntTime', 'y-mm-dd');" style="visibility: hidden"/>
                            </div>
=======
                            <div id='schedule-box' class="boxshaw"></div>
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
                            <h1><img src="<?=base_url('resource/home')?>/images/me.png" alt="" style="width: 50px;height: 50px">选择类型</h1>
                            <?php include 'filter2.php';?>
                        </div>
                        <div class="containerR">
                            <table>
                                <tr>
                                    <th width="35%">培训主题</th>
                                    <th width="15%">主办单位</th>
                                    <th width="15%">培训时间</th>
                                    <th width="10%">剩余名额</th>
                                    <th width="20%">操作</th>
                                </tr>
                                <?php if(!empty($list)): foreach($list as $row):?>
                                    <tr>
                                        <td title="<?=$row['title']?>"><a href="<?=site_url('teach/detail/'.$row['id'])?>"><?=mb_substr($row['title'],0,11)?>...</a></td>
                                        <td title="<?=$row['sponsor']?>"><?=mb_substr($row['sponsor'],0,5)?>...</td>
                                        <td title="<?=date('Y/m/d H:i',$row['teachtime'])?>"><?=date('m/d H:i',$row['teachtime'])?></td>
                                        <td><?=$row['snumber']?></td>
                                        <td id="handle">
                                            <a style="background-color: #EEE9E9;" href="<?=site_url('teach/detail/'.$row['id'])?>">详情</a>
                                            <a style="background-color: #FF9426;" href="#"  data-tid="<?=$row['id']?>" class="baoming">报名</a>
                                        </td>
                                    </tr>
                                <?php endforeach; else:?>
                                <tr>
                                    <td colspan="100">暂无数据</td>
                                </tr>
                                <?php endif;?>
                            </table>
                            <?php include 'page.php'?>
                            <div class="clear"></div>
                        </div>
                        <div class="clear"></div>
                    </div>
    </div>
    <?php include 'footer.php';?>
<<<<<<< HEAD
    <script src="<?php echo base_url('resource/home')?>/js/schedule.js"></script>
    <script>

        window.onload=function(){
                showCalendar('EntTime','y-mm-dd');
            }
    </script>
</section>
<script src="<?php echo base_url('resource/home')?>/js/script.js"></script>

=======
</section>
<script src="<?php echo base_url('resource/home')?>/js/script.js"></script>
<script src="<?php echo base_url('resource/home')?>/js/schedule.js"></script>
<script>
var mySchedule = new Schedule({
    el: '#schedule-box',
    clickCb: function(y, m, d) {
        window.location.href = '?date='+y+'-'+m+'-'+d;
    }
});
</script>
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
</body>
</html>