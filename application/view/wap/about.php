<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>关于学堂</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

    <meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
    <script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="js/organictabs.jquery.js"></script>
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/lrtk.css">
</head>
<body>
<script type="text/javascript">

    $(function() {

        // 调用插件

        $("#example-one").organicTabs();

        $("#example-two").organicTabs({

            "speed": 100,

        });

    });

</script>
<header>
    <div class="headerTop clearfix">
        <a href="http://xt.szgs.gov.cn/Wap/Index.html" class="back"></a>
        <div class="headerText">关于学堂</div>
    </div>
</header>
<div id="page-wrap">

    <!-- BEGIN Organic Tabs (Example One) -->

    <div id="example-one">

        <ul class="nav">

            <li class="nav-one"><a href="#featured" class="current">建设背景</a></li>

            <li class="nav-two"><a href="#core">功能亮点</a></li>

            <li class="nav-three"><a href="#jquerytuts">学堂大事</a></li>

            <li class="nav-four last"><a href="#classics">发展成果</a></li>

        </ul>

        <div class="list-wrap">

            <ul id="featured">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aspernatur aut blanditiis consectetur consequuntur doloremque ducimus eum expedita in ipsam iusto molestiae nobis numquam officia optio pariatur, quae quibusdam sed vel.</p>

            </ul>

            <ul id="core" class="hide">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus adipisci consequuntur cupiditate deserunt dicta dolore dolorum ducimus et hic iste libero magnam maxime minima modi nesciunt nihil quidem, repudiandae sunt!</p>

            </ul>

            <ul id="jquerytuts" class="hide">

                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Consequuntur exercitationem numquam recusandae velit voluptas? Ab autem dolores earum facere fugiat iusto laudantium maiores minus molestias rem rerum, similique tempora unde!</p>

            </ul>

            <ul id="classics" class="hide">
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Atque quaerat reprehenderit sed? A aspernatur assumenda at eveniet facilis harum illo iusto mollitia numquam odio optio quaerat, quia recusandae suscipit voluptates!</p>

            </ul>

        </div>

    </div>

    <!-- END Organic Tabs (Example One) -->
    <div class="publicFooter">
        国税首页 | 学堂首页 | 网站公告 | 关于学堂 <br>
        版权所有：陕西省国家税务局  备案号：陕ICP备 06000245号 <br>
        地址：西安市二环南路西段39号 <br>
        技术支持：西安网算数据科技有限公司
    </div>

</div>
</body>
</html>