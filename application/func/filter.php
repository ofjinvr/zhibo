<?php
function my_filter_get(){
    $rolename = ['个体','企业'];
    $cityname = ['省直属分局','西安国税','咸阳国税','铜川国税','宝鸡国税','渭南国税','延安国税','汉中国税','榆林国税','安康国税','商洛国税','杨凌国税','韩城国税','西咸新区国税','西安','咸阳','铜川','宝鸡','渭南','延安','汉中','榆林','安康','商洛','杨凌','韩城','西咸新区'];
    $typename = ['财税政策','办税指南','软件操作'];
    if(!empty($_GET['rolename']) and !in_array($_GET['rolename'],$rolename)){
        $_GET['rolename'] = '';
    }
    if(!empty($_GET['cityname']) and !in_array($_GET['cityname'],$cityname)){
        $_GET['cityname'] = '';
    }
    if(!empty($_GET['typename']) and !in_array($_GET['typename'],$typename)){
        $_GET['typename'] = '';
    }
    return null;
}