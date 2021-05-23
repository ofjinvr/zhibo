<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <link rel="stylesheet" href="/resource/home/css/common.css">
    <link rel="stylesheet" href="/resource/home/css/reset.css">
    <link rel="stylesheet" href="/teachers/css/goodTeacher.css">
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

<div class="sectionMain_box">
    <div class="section_left">
        <div class="section_top">
            <img src="/images/mingshi.png" alt="">
            <span>名师风采</span>
        </div>
        <div class="category category_3">
            <ul>
                <h3>按分类</h3>
                <li class="active">全部</li>
            </ul>
        </div>
    </div>
    <div class="section_right">
        <div class="item_box">
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p1.png" alt=""></div>
                <div class="item_content">
                    <h3>王晓梅</h3>
                    <h4>陕西东信税务师事务所</h4>
                    <p>具有大中型房地产企业、大中型工业企业、大中型商贸企业主岗会计的从业经历。</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p2.png" alt=""></div>
                <div class="item_content">
                    <h3>倪旻</h3>
                    <h4>陕西东信税务师事务所</h4>
                    <p>熟悉企业所得税汇算清缴、土地增值税清算审查等各类涉税鉴证实务经验。</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p3.png" alt=""></div>
                <div class="item_content">
                    <h3>杨楠</h3>
                    <h4>陕西国税12366纳税服务中心</h4>
                    <p>陕西国税12366纳税服务中心高级座席，擅长纳税人热点难点问题的解答</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p4.png" alt=""></div>
                <div class="item_content">
                    <h3>王蕊</h3>
                    <h4>陕西东信税务师事务所</h4>
                    <p>会计师，注册税务师。谙熟企业会计准则及相关涉税法规。</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p5.png" alt=""></div>
                <div class="item_content">
                    <h3>史蕊</h3>
                    <h4>陕西国税12366纳税服务中心</h4>
                    <p>陕西国税12366纳税服务中心高级坐席，擅长企业所得税相关业务。</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p6.png" alt=""></div>
                <div class="item_content">
                    <h3>丁馨</h3>
                    <h4>陕西国税12366纳税服务中心</h4>
                    <p>陕西国税12366纳税服务中心渠道管理组副组长，擅长发票相关业务。</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p7.png" alt=""></div>
                <div class="item_content">
                    <h3>易娅岚</h3>
                    <h4>咸阳市长武县国家税务局</h4>
                    <p>咸阳市长武县国家税务局，擅长纳税服务、发票管理政策及业务咨询，插画及平面设计。</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p8.png" alt=""></div>
                <div class="item_content">
                    <h3>卢梦冰</h3>
                    <h4>陕西国税12366纳税服务中心</h4>
                    <p>陕西国税12366纳税服务中心渠道管理组副组长，擅长增值税相关业务。</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p10.png" alt=""></div>
                <div class="item_content">
                    <h3>马翌祯</h3>
                    <h4>省局货物和劳务税处</h4>
                    <p>省局货物和劳务税处，负责增值税政策管理，主讲营业税改征增值税</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
            <div class="item_list">
                <div class="item_img"><img src="/resource/home/images2/p11.png" alt=""></div>
                <div class="item_content">
                    <h3>姜蝉蝉</h3>
                    <h4>陕西国税12366纳税服务中心</h4>
                    <p>擅长增值税、企业所得税政策解答以及纳税申报表填写</p>
                </div>
                <div class="item_btn">
                    <a href="">详情</a>
                </div>
            </div>
        </div>
    </div>
</div>
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