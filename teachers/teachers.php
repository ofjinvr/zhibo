<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/resource/home/css/common.css">
    <link rel="stylesheet" href="/resource/home/css/reset.css">
    <link rel="stylesheet" href="css/zixun.css">
    <script src="jquery-1.11.3.js"></script>
    <style>
        body: alpha(opacity=100 finishopacity=50 style=1 startx=0, starty=0, finishx=0, finishy=150) progid:DXImageTransform.Microsoft.gradient(startcolorstr=rgb(0,109,172), endcolorstr=rgb(174,206,235), gradientType=0);
        -ms-filter: alpha(opacity=100 finishopacity=50 style=1 startx=0, starty=0, finishx=0, finishy=150) progid:DXImageTransform.Microsoft.gradient(startcolorstr=rgb(0,109,172), endcolorstr=rgb(174,206,235), gradientType=0);
        /* background: -webkit-gradient(linear, 0 0, 0 bottom, from(rgb(0,109,172)), to(rgb(174,206,235))); */
        background: -webkit-gradient(linear, 0% 0%, 0% 100%,from(#85b9e7),to(#006ab8));
        background: -moz-linear-gradient(top, #85b9e7,#006ab8);
        background: -o-linear-gradient( top,#85b9e7,#006ab8);
        /* background: #599FD8; */
    </style>
</head>
<body>
<header>
    <div class="mainTop">
        <div class="bannerTop">
            <div class="bannerText mediate">
                <img src="http://demo.cstaoding.com/resource/home/images2/logo3.png" alt="" style="float: left; width: 600px;  max-height: 129px">
            </div>
            <div class="bannerSearch" style="float: right">
                <p style="display:inline-block;vertical-align:bottom">
                    <input type="text" class="bannerSearchInput" placeholder="请输入查询信息">
                    <span class="zoom" id="searchBtn"></span>
                    <script>
                        $(function(){
                            var doSearch = function(){
                                var kw = $('input.bannerSearchInput').val();
                                window.location.href = 'http://demo.cstaoding.com/index/search/live?kw='+kw;
                            }
                            $('#searchBtn').click(doSearch);
                            $('input.bannerSearchInput').keyup(function(e){
                                if(e.which == 13){
                                    doSearch();
                                }
                            })
                        })
                    </script>
                    <button class="searchButton" id="loginShow">登陆</button>
                    <button class="searchButton" id="regShow">注册</button>
                </p>
            </div>
        </div>
        <div class="navDiv">
            <ul class="navTop">
                <li class="active">
                    <a href="http://demo.cstaoding.com/">首页</a>
                </li>
                <li >
                    <a href="http://demo.cstaoding.com/live">直播教室</a>
                </li>
                <li >
                    <a href="http://demo.cstaoding.com/replay">直播回放</a>
                </li>
                <li >
                    <a href="http://demo.cstaoding.com/video">视频学习</a>
                </li>
                <li >
                    <a href="http://demo.cstaoding.com/teach">现场培训</a>
                </li>
                <li >
                    <a href="http://demo.cstaoding.com/about">关于学堂</a>
                </li>
            </ul>
        </div>
    </div>
</header>

<div class="zixun_box">
    <div class="zi_section_1">
        <div class="zi_section_img">
            <img src="/teachers/images/teacher_1.png" alt="">
        </div>
        <div class="zi_section_text">
            <div class="item_content">
                <h3>欧阳柳青</h3>
                <h4>陕西国税局</h4>
                <p>陕西国税12366纳税服务中心渠道管理组副 组长，擅长发票相关业务。</p>
                <div class="stats">
                    <span>视频数量 <i>20</i> </span>
                    <span>点击总量 <i>20</i> </span>
                </div>
            </div>
        </div>
    </div>
    <div clsas="zi_section_2">
        <div class="section_2_left">
            <ul id="btn_menu">
                <li class="active">相关课程</li>
                <li>业务咨询</li>
            </ul>

            <div class="qq_box item_text">
                <div>
                    <p><img src="/teachers/images/qq.png" alt=""> QQ:12366</p>
                    <h3>扫一扫加微信</h3>
                    <img src="/teachers/images/code.png" alt="">
                </div>

            </div>
            <div class="book_ss item_content">
                <div class="right_box">
                    <img src="/teachers/images/teacher_1.png" alt="">
                    <p><a>小微企业税收优惠政策</a>   <span>25</span> <img src="/teachers/images/play.png" alt=""></p>
                    <p class="small">
                        <a>讲师：合一欧老师</a><span>2017-10-16</span>
                    </p>
                </div>
                <div class="right_box">
                    <img src="/teachers/images/teacher_1.png" alt="">
                    <p><a>小微企业税收优惠政策</a>   <span>25</span> <img src="/teachers/images/play.png" alt=""></p>
                    <p class="small">
                        <a>讲师：合一欧老师</a><span>2017-10-16</span>
                    </p>
                </div>
                <div class="right_box">
                    <img src="/teachers/images/teacher_1.png" alt="">
                    <p><a>小微企业税收优惠政策</a>   <span>25</span> <img src="/teachers/images/play.png" alt=""></p>
                    <p class="small">
                        <a>讲师：合一欧老师</a><span>2017-10-16</span>
                    </p>
                </div>
                <div class="right_box">
                    <img src="/teachers/images/teacher_1.png" alt="">
                    <p><a>小微企业税收优惠政策</a>   <span>25</span> <img src="/teachers/images/play.png" alt=""></p>
                    <p class="small">
                        <a>讲师：合一欧老师</a><span>2017-10-16</span>
                    </p>
                </div>
                <div class="right_box">
                    <img src="/teachers/images/teacher_1.png" alt="">
                    <p><a>小微企业税收优惠政策</a>   <span>25</span> <img src="/teachers/images/play.png" alt=""></p>
                    <p class="small">
                        <a>讲师：合一欧老师</a><span>2017-10-16</span>
                    </p>
                </div>
                <div class="right_box">
                    <img src="/teachers/images/teacher_1.png" alt="">
                    <p><a>小微企业税收优惠政策</a>   <span>25</span> <img src="/teachers/images/play.png" alt=""></p>
                    <p class="small">
                        <a>讲师：合一欧老师</a><span>2017-10-16</span>
                    </p>
                </div>
            </div>
        </div>
        <div class="section_2_right">
            <h3><i></i>更多名师<a></a></h3>

            <div class="right_box">
                <img src="/teachers/images/teacher_1.png" alt="">
                <p>欧阳留情  <span>陕西国税局</span></p>
                <p class="small">
                    陕西国税12366纳税服务中心渠道管理组副组长，擅长发票相关业务。
                </p>
            </div>
            <div class="right_box">
                <img src="/teachers/images/teacher_1.png" alt="">
                <p>欧阳留情  <span>陕西国税局</span></p>
                <p class="small">
                    陕西国税12366纳税服务中心渠道管理组副组长，擅长发票相关业务。
                </p>
            </div>
        </div>
    </div>
</div>
<script>
    $("#btn_menu").on('click',function(e){
        $('#btn_menu li').removeClass('active');

        e.target.className='active';
        if(e.target.innerHTML=='业务咨询'){
            $('.item_content').css('display','none')
            $('.item_text').css('display','block')

        }
        if(e.target.innerHTML=='相关课程'){
            $('.item_content').css('display','block')
            $('.item_text').css('display','none')

        }
    })
</script>
<div class="foot">
    <p>
        <a href="http://www.sn-n-tax.gov.cn">国税官网</a>  | <a href="http://demo.cstaoding.com/">学堂首页</a>  | <a href="http://demo.cstaoding.com/about">关于学堂</a>
    </p>
    <p>
        版权所有：陕西省国家税务局  备案号：陕ICP备 06000245号  地址：西安市二环南路西段39号
    </p>
    <p>
        技术支持：西安网算数据科技有限公司
    </p>
    <p>
        今日访问量：54463    总访问量：16737325

    </p>
</div>
</body>
</html>