<link rel="stylesheet" href="<?php echo base_url('resource/home')?>/css/modal.css">
<header>
    <div class="mainTop">
        <div class="bannerTop">
            <div class="bannerText mediate">
                <img src="<?php echo base_url('resource/home')?>/images2/logo3.png" alt="" style="float: left; width: 600px;  max-height: 129px">
            </div>
            <div class="bannerSearch" style="float: right">
                <p style="display:inline-block;vertical-align:bottom">
                    <input type="text" class="bannerSearchInput" placeholder="请输入查询信息">
                    <span class="zoom" id="searchBtn"></span>
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

                   <div id="uerName" style="color:#fff;display:inline-block;height:32px;margin-top:5px;">欢迎您：<span><?=substr_replace($_SESSION['member']['mobile'],'****',4,4)?></span><a href="<?=site_url('index/logout')?>" style="color:red ;margin-left:10px;">退出</a></div>

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
                <li <?php if($nav==='about') echo 'class="active"';?>>
                    <a href="<?php echo site_url('about');?>">关于学堂</a>
                </li>
            </ul>
        </div>
    </div>
</header>
<script>
         if(window.sessionStorage){
              var mobile = sessionStorage.getItem('userMobile');
              mobile=mobile.replace(/(\d{3})\d{4}(\d{4})/, '$1****$2');
                $('#uerName span').html(mobile);
            }else{
              var mobile ='';
            }




</script>