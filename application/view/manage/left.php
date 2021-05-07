<div id="main">
    <div class="left">
        <dl class="current">
            <dt><a href="javascript:void(0);" class="home"></a></dt>
            <dd><a href="javascript:void(0);">主页</a></dd>
        </dl>
        <dl>
            <dt><a href="javascript:void(0);" class="application"></a></dt>
            <dd><a href="javascript:void(0);">应用</a></dd>
        </dl>
        <dl>
            <dt><a href="javascript:void(0);" class="user"></a></dt>
            <dd><a href="javascript:void(0);">账户</a></dd>
        </dl>
        <dl>
            <dt><a href="javascript:void(0);" class="setting"></a></dt>
            <dd><a href="javascript:void(0);">设置</a></dd>
        </dl>
        <dl>
            <dt><a href="javascript:void(0);" class="manage"></a></dt>
            <dd><a href="javascript:void(0);">管理</a></dd>
        </dl>
    </div>

    <div class="middel">
        <?php foreach ($menu as $mod => $value):?>
        <div class="menulist">
            <h1><?php echo ucfirst($mod); ?></h1>
            <div class="title">管理控制台</div>
            <div class="list">
                <?php foreach($value as $meun_list):?>
                <dl>
                    <dt><?php echo $meun_list['title']?></dt>
                    <?php foreach($meun_list['list'] as $key => $row):?>
                    <dd><a href="<?php echo site_url('manage').'/'.$mod.'/'.$key; ?>" target="main_iframe"><?php echo $row;?></a></dd>
                    <?php endforeach;?>
                </dl>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
<!--div id=main的结束标记在index视图中-->
