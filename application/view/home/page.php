<?php if(!empty($page)):?>
<div class="classPage">
    <div class="page">
        <?php foreach($page['paging'] as $key => $row):?>
            <?php if($page['current']===$key):?>
                <span class="current"><?=$key?></span>
            <?php else:?>
                <a href="<?=$row?>"><?=$key?></a>
            <?php endif;?>
        <?php endforeach;?>
        <a href="<?=$page['next_page']?>">下一页</a>
        <a href="<?=$page['end_page']?>">末页</a>
    </div>
</div>
<?php endif;?>