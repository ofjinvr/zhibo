<header>
    <div class="mainTop">
        <div class="bannerTop">
            <div class="bannerText">
                <img src="<?php echo base_url('resource/home')?>/images/icon1.png" alt="" style="float: left;margin-right: 30px">
                <p class="bannerTextT">陕西省国家税务局</p>
                <p class="bannerTextI">Shanxi Province Office.SAT</p>
            </div>
            <div class="bannerSearch">
                <p>
                    <input type="text" class="bannerSearchInput" placeholder="请输入查询信息">
                    <span class="zoom">
                        </span>
                    <button class="searchButton" onclick="javascript:alert('敬请期待')">登陆</button>
                    <button class="searchButton" onclick="javascript:alert('敬请期待')">注册</button>
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
                <li <?php if($nav==='nav') echo 'class="active"';?>>
                    <a href="#">税务导航</a>
                </li>
                <li <?php if($nav==='about') echo 'class="active"';?>>
                    <a href="<?php echo site_url('about');?>">关于学习</a>
                </li>
            </ul>
        </div>
    </div>
</header>