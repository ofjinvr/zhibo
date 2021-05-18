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