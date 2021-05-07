<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>资源管理器</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <script src="<?php echo base_url('resource/js');?>/jquery.js"></script>
</head>
<body>
    <h1 class="title">资源管理器</h1>
    
    <div class="center">
        <div class="navbar">当前浏览位置: 
            <a href="<?php echo site_url('manage/data/explorer/uploaded_files');?>">upload</a>
            <?php foreach ($nav as $key => $row):?>
             &gt; 
            <a href="<?php echo site_url('manage/data/explorer/uploaded_files?dir=').implode('/',array_slice($nav,0,$key+1))?>">
                <?php echo $row;?>
            </a>
            <?php endforeach;?>
        </div>
        
        <table>
            <thead>
                <tr>
                    <th>文件名称</th>
                    <th>文件类型</th>
                    <th>文件大小</th>
                    <th>上传时间</th>
                    <th>上次访问时间</th>
                    <th>操作管理</th>
                </tr>
            </thead>
            <tbody>
                <?php if(!empty($flist)):?>
                <?php foreach($flist as $row):?>
                <tr>
                    <td><a href="
                            <?php
                            if($row['filetype']==='dir'){
                                echo site_url('manage/data/explorer/uploaded_files').'?dir='.str_replace('upload/','',$row['filename']);
                            }else{
                                echo base_url().$row['filename'];
                            }
                            ?>"  target="<?php echo $row['filetype']==='dir' ? '_self' : '_blank';?>">
                                <?php echo basename($row['filename']);?>
                        </a>
                    </td>
                    <td class="t_center">
                        <?php
                            switch ($row['filetype']) {
                                case 'file':
                                    echo '文件';break;
                                case 'dir':
                                    echo '目录';break;
                                case 'link':
                                    echo '快捷方式';break;
                                case 'block':
                                case 'char':
                                case 'fifo':
                                    echo '其他';break;
                                default:
                                    echo '未知';
                                    break;
                            }
                        ?>
                    </td>
                    <td class="t_right">
                        <?php
                            if($row['size']<1024){
                                echo $row['size'].'B';
                            }
                            if($row['size']>=1024 and $row['size'] < 1024*1024){
                                echo round($row['size']/1024,1).'KB';
                            }
                            if($row['size'] >= 1024*1024){
                                echo round($row['size']/1024/1024,2).'MB';
                            }
                        ?>
                    </td>
                    <td class="t_center"><?php echo date('Y-m-d H:i:s',$row['ctime']);?></td>
                    <td class="t_center"><?php echo date('Y-m-d H:i:s',$row['atime']);?></td>
                    <td class="t_center">
                        <a href="
                            <?php
                            if($row['filetype']==='dir'){
                                echo site_url('manage/data/explorer/uploaded_files').'?dir='.str_replace('upload/','',$row['filename']);
                            }else{
                                echo site_url().$row['filename'];
                            }
                            ?>" target="<?php echo $row['filetype']==='dir' ? '_self' : '_blank';?>">
                            <?php echo $row['filetype']==='dir' ? '浏览目录' : '打开文件';?>
                        </a>
                        |
                        <a href="<?php echo site_url('manage/data/explorer/delete_uploaded_file').'?filepath='.str_replace('upload/','',$row['filename']);?>" onclick="return confirm('确定删除吗?');">删除</a>
                    </td>
                </tr>
                <?php endforeach;?>
                <?php else:?>
                <tr>
                    <td class="t_center" colspan="6">暂无数据</td>
                </tr>
                <?php endif;?>
            </tbody>
        </table>
        <?php echo $page;?>
    </div>
</body>
</html>