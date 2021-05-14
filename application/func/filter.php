<?php
function my_filter_get(){
    $rolename = ['个体','企业'];
    $cityname = ['西安','咸阳','铜川','宝鸡','渭南','延安','汉中','榆林','安康','商洛'];
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