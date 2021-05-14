<div class="category category1">
    <ul>
        <h3>按角色</h3>
        <li class="<?php if(empty($_GET['rolename'])){echo 'active';}?>">
            <a href="?<?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?><?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?>">全部</a></li>
        <li class="<?php if(!empty($_GET['rolename']) and $_GET['rolename']==='个体'){echo 'active';}?>">
            <a href="?rolename=个体<?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?><?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?>">个体</a></li>
        <li class="<?php if(!empty($_GET['rolename']) and $_GET['rolename']==='企业'){echo 'active';}?>">
            <a href="?rolename=企业<?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?><?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?>">企业</a></li>
    </ul>
</div>
<div class="category category2">
    <ul>
        <h3>按分类</h3>
        <li class="<?php if(empty($_GET['typename'])){echo 'active';}?>">
            <a href="?<?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">全部</a></li>
        <li class="<?php if(!empty($_GET['typename']) and $_GET['typename']==='财税政策'){echo 'active';}?>">
            <a href="?typename=财税政策<?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">财税政策</a></li>
        <li class="<?php if(!empty($_GET['typename']) and $_GET['typename']==='办税指南'){echo 'active';}?>">
            <a href="?typename=办税指南<?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">办税指南</a></li>
        <li class="<?php if(!empty($_GET['typename']) and $_GET['typename']==='软件操作'){echo 'active';}?>">
            <a href="?typename=软件操作<?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">软件操作</a></li>
    </ul>
</div>
<div class="category category3">
    <ul>
        <h3>按地区</h3>
        <li class="<?php if(empty($_GET['cityname'])){echo 'active';}?>"><a href="?<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">全部</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='西安'){echo 'active';}?>"><a href="?cityname=西安<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">西安</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='咸阳'){echo 'active';}?>"><a href="?cityname=咸阳<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">咸阳</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='铜川'){echo 'active';}?>"><a href="?cityname=铜川<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">铜川</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='宝鸡'){echo 'active';}?>"><a href="?cityname=宝鸡<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">宝鸡</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='渭南'){echo 'active';}?>"><a href="?cityname=渭南<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">渭南</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='延安'){echo 'active';}?>"><a href="?cityname=延安<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">延安</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='汉中'){echo 'active';}?>"><a href="?cityname=汉中<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">汉中</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='榆林'){echo 'active';}?>"><a href="?cityname=榆林<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">榆林</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='安康'){echo 'active';}?>"><a href="?cityname=安康<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">安康</a></li>
        <li class="<?php if(!empty($_GET['cityname']) and $_GET['cityname']==='商洛'){echo 'active';}?>"><a href="?cityname=商洛<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>">商洛</a></li>
    </ul>
</div>