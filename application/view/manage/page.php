<?php if(!empty($page)):?>
<div class="page">
    <em>(共<?php echo $page['amount_all']?>条信息)</em>
    <a title="首页" href="<?php echo $page['index_page']?>">首页</a>
    <a title="上一页" href="<?php echo $page['prev_page']?>">上一页</a>
    <?php foreach($page['paging'] as $key => $value):?>
    <?php if($page['current']===$key):?>
    <span title="第<?php echo $key;?>页"><?php echo $key;?></span>
    <?php else:?>
    <a title="第<?php echo $key;?>页" href="<?php echo $value;?>"><?php echo $key;?></a>
    <?php endif;?>
    <?php endforeach;?>
    <a title="下一页" href="<?php echo $page['next_page']?>">下一页</a>
    <a title="尾页" href="<?php echo $page['end_page']?>">尾页</a>
    <select onchange="javascript:window.location.href=this.value">
        <?php foreach($page['all_page'] as $key => $value):?>
            <?php if($page['current']===$key):?>
            <option title="第<?php echo $key;?>页" value="<?php echo $value;?>" selected>第<?php echo $key;?>页</option>
            <?php else:?>
            <option title="第<?php echo $key;?>页" value="<?php echo $value;?>">第<?php echo $key;?>页</option>
            <?php endif;?>
        <?php endforeach;?>
    </select>
</div>
<?php endif;?>