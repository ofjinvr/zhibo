<div class="foot">
    <p>
        <a href="http://www.sn-n-tax.gov.cn">国税官网</a>  | <a href="<?=site_url()?>">学堂首页</a>  | <a href="<?php echo site_url('about')?>">关于学堂</a>
    </p>
    <p>
        版权所有：陕西省国家税务局  备案号：陕ICP备 06000245号  地址：西安市二环南路西段39号
    </p>
    <p>
        技术支持：西安网算数据科技有限公司
    </p>
    <p>
        今日访问量：<?=$webinfo['pv_today']?>    总访问量：<?=$webinfo['pv_all']?>

    </p>
</div>
<style>
div.foot a{color:#999;}
</style>
<?php include 'modal.php';?>
<?php include 'login.php';?>
<?php include 'reg.php';?>