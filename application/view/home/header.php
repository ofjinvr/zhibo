<link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/modal.css">
<<<<<<< HEAD
  <script type="text/javascript" src="<?php echo base_url('resource')?>/js/jquery.js"></script>
<!--[if lt IE 9]>
<script src="http://www.taoding.cn/resource/home/js/html5-shiv.js"></script>

<style>article,aside,dialog,footer,header,section,footer,nav,figure,menu,form{display:block}</style>
<![endif]-->


=======
<!--[if lt IE 9]><font color="red">您的浏览器版本过低，可能无法正常显示。请升级您的浏览器</font> <![endif]--> 
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
<header>
    <div class="mainTop">
        <div class="bannerTop">
            <div class="bannerText mediate">
                <img src="<?php echo base_url('resource/home')?>/images2/logo3.png" alt="" style="float: left; width: 600px;  max-height: 129px">
            </div>
            <div class="bannerSearch" style="float: right">
                <p style="display:inline-block;vertical-align:bottom">
<<<<<<< HEAD
                    <input type="text" class="bannerSearchInput" placeholder="请输入查询信息" >
                    <span class="zoom" id="searchBtn"><img src="<?php echo base_url('resource/home')?>/images/search.png"></img></span>
=======
                    <input type="text" class="bannerSearchInput" placeholder="请输入查询信息">
                    <span class="zoom" id="searchBtn"></span>
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
                    <script>
                        $(function(){
                            var doSearch = function(){
                                var kw = $('input.bannerSearchInput').val();
                                window.location.href = '<?=site_url('index/search/'.(!empty($type)?$type:'live'))?>?kw='+kw;
                            }
                            $('#searchBtn').click(doSearch);
                            $('input.bannerSearchInput').keyup(function(e){
                                if(e.which == 13){
                                    doSearch();
                                }
                            })
                        })
                    </script>
                    <?php if(!empty($_SESSION['member']['id'])):?>

                   <div id="uerName" style="color:#fff;display:inline-block;height:32px;margin-top:5px;">欢迎您：<span><?=$_SESSION['member']['member_name']?></span><a href="<?=site_url('index/logout')?>" style="color:red ;margin-left:10px;">退出</a></div>

                    <?php else:?>
                    <button class="searchButton" id="loginShow">登陆</button>
                    <button class="searchButton" id="regShow">注册</button>
                    <?php endif;?>
                </p>
            </div>
        </div>
        <div class="navDiv">
            <ul class="navTop">
                <li <?php if($nav==='index') echo 'class="active"';?>>
                    <a href="<?php echo site_url();?>">首页</a>
                </li>
                <li <?php if($nav==='live') echo 'class="active"';?>>
                    <a href="<?php echo site_url('live');?>">直播教室</a>
                </li>
                <li <?php if($nav==='replay') echo 'class="active"';?>>
                    <a href="<?php echo site_url('replay');?>">直播回放</a>
                </li>
                <li <?php if($nav==='video') echo 'class="active"';?>>
                    <a href="<?php echo site_url('video');?>">视频学习</a>
                </li>
                <li <?php if($nav==='teach') echo 'class="active"';?>>
                    <a href="<?php echo site_url('teach');?>">现场培训</a>
                </li>
                <li <?php if($nav==='teacher') echo 'class="active"';?>>
                    <a href="<?php echo site_url('teacher');?>">名师风采</a>
                </li>
                <li <?php if($nav==='about') echo 'class="active"';?>>
                    <a href="<?php echo site_url('about');?>">关于学堂</a>
                </li>
            </ul>
        </div>
    </div>
</header>
