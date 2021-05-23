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
<div class="category category3 category_3">
    <ul>
        <div class="categoryTitle">
            <h3>按地区</h3>
            <select name="cityname">
                <option value="">全部</option>
                <option value="西安" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='西安'){echo 'selected';}?>>西安市</option>
                <option value="咸阳" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='咸阳'){echo 'selected';}?>>咸阳市</option>
                <option value="铜川" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='铜川'){echo 'selected';}?>>铜川市</option>
                <option value="宝鸡" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='宝鸡'){echo 'selected';}?>>宝鸡市</option>
                <option value="渭南" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='渭南'){echo 'selected';}?>>渭南市</option>
                <option value="延安" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='延安'){echo 'selected';}?>>延安市</option>
                <option value="汉中" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='汉中'){echo 'selected';}?>>汉中市</option>
                <option value="榆林" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='榆林'){echo 'selected';}?>>榆林市</option>
                <option value="安康" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='安康'){echo 'selected';}?>>安康市</option>
                <option value="商洛" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='商洛'){echo 'selected';}?>>商洛市</option>
                <option value="杨凌" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='杨凌'){echo 'selected';}?>>杨凌市</option>
                <option value="韩城" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='韩城'){echo 'selected';}?>>韩城市</option>
                <option value="西咸新区" <?php if(!empty($_GET['cityname']) and $_GET['cityname']==='西咸新区'){echo 'selected';}?>>西咸新区</option>
            </select>
            <script>
                $(function(){
                    $('select[name=cityname]').change(function(){
                        window.location.href = "?cityname="+$(this).val()+"<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?>";
                    })
                })
            </script>
        </div>
        <li class="<?php if(empty($_GET['areaname'])){echo 'active';}?>"><a href="?areaname=<?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?><?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?>">不限</a></li>
        <?php foreach($arealist as $row):?>
            <li class="<?php if(!empty($_GET['areaname']) and $_GET['areaname']===$row['area_name']){echo 'active';}?>">
                <a href="?areaname=<?=$row['area_name']?><?php if(!empty($_GET['typename'])){echo "&typename={$_GET['typename']}";}?><?php if(!empty($_GET['rolename'])){echo "&rolename={$_GET['rolename']}";}?><?php if(!empty($_GET['cityname'])){echo "&cityname={$_GET['cityname']}";}?>"><?=$row['area_name']?></a>
            </li>
        <?php endforeach;?>

    </ul>
</div>