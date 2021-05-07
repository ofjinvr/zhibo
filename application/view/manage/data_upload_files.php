<!DOCTYPE HTML>
<html lang="zh">
<head>
    <meta charset="UTF-8">
    <title>资源管理器</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('resource/admin');?>/css/iframe.css">
    <script src="<?php echo base_url('resource/js');?>/jquery.js"></script>
    <script src="<?php echo base_url('plugin/plupload');?>/plupload.full.min.js"></script>
    <script src="<?php echo base_url('plugin/plupload');?>/plupload_config.js"></script>
</head>
<body>
    <h1 class="title">资源管理器</h1>
    <div class="center">
        <div class="plupload_dirname">
            <form>
                <p class="uploadTo">文件上传到: <span>/upload/<?php echo $setdir;?></span> <input class="setdir" type="button" value="修改"></p>
                <p class="setUplodeTo">
                    设置文件上传路径: <span>/upload/</span>
                    <input type="text" name="plupload_setdir" value="<?php echo $setdir;?>" class="dirname_text">
                    <input type="submit" class="setdir" value="保存"></p>
            </form>
        </div>
        <div id="plupload">
        <h3>
            <button id="start_upload">开始上传</button>
            <button id="browse">选择文件</button>
            文件上传
        </h3>
            <ul class="queue" id="upList">
            </ul>
        <div class="achieve">
            <span>上传了<span class="success_count">0</span>/<span class="total">0</span>个文件</span>
            <span class="tips">你可以在Chrome,Firefox,IE9以上的浏览器中拖拽文件到此处.</span>
            <button class="achieve">完成</button>
        </div>
    </div>
    </div>
    
    
    <script>
    //实例化一个plupload上传对象
    plupload_config.browse_button = 'browse';
    plupload_config.url = '<?php echo site_url('manage/data/explorer/upload_files/action');?>';
    plupload_config.flash_swf_url = '<?php echo site_url('plugin/plupload');?>/Moxie.swf';
    plupload_config.silverlight_xap_url = '<?php echo site_url('plugin/plupload');?>/Moxie.xap';
    plupload_config.multipart_params = {
        'plupload_setdir' : '<?php echo $setdir;?>' //告知服务器端上传到的路径
    }
    
    var uploader = new plupload.Uploader(plupload_config);
    

    //初始化后触发
    //uploader.bind('Init',function(uploader){});
    //当Init事件发生后触发
    //uploader.bind('PostInit',function(uploader){});
    //每一个文件被添加到上传队列前触发(主要用来过滤)
    //uploader.bind('FileFiltered',function(uploader,file){});
    
    //当文件添加到上传队列后触发
    uploader.bind('FilesAdded',function(uploader,files){
        for(var i = 0, len = files.length; i<len; i++){
            var file_name = files[i].name; //文件名
            //构造html来更新UI
            var html = '<li id="' + files[i].id +'"><dl><dt>'+
                    '<a class="delete" href="javascript:void(0);">移除</a>'+
                    '<span class="status">等待</span>'+
                    '<span class="filename">' + file_name + '</span></dt>'+
                    '<dd class=""></dd></dl></li>';
            $('#upList').append(html);
        }
        var total = $('#plupload').find('span.total').html();
        $('#plupload').find('span.total').html(parseInt(total)+i);
        
    });
    
    //当文件从上传队列移除后触发
    uploader.bind('FilesRemoved',function(uploader,files){
        $('#'+files[0].id).remove();
        var total = $('#plupload').find('span.total').html();
        $('#plupload').find('span.total').html(parseInt(total)-1);
    });
    
    //当上传队列发生变化后触发，即上传队列新增了文件或移除了文件。QueueChanged事件会比FilesAdded或FilesRemoved事件先触发
    //uploader.bind('QueueChanged',function(uploader){});
    //当调用plupload实例的refresh()方法后会触发该事件，把文件添加到上传队列后也会触发该事件。
    //uploader.bind('Refresh',function(uploader){});
    //当使用Plupload实例的setOption()方法改变当前配置参数后触发
    //uploader.bind('OptionChanged',function(uploader,option_name,new_value,old_value){});
    //当上传队列的状态发生改变时触发
    //uploader.bind('StateChanged',function(uploader){});
    
    //当上传队列中某一个文件开始上传后触发
    uploader.bind('UploadFile',function(uploader,file){
        $('#'+file.id).find('span.status').text('上传中');
    });
    
    //当队列中的某一个文件正要开始上传前触发
    uploader.bind('BeforeUpload',function(uploader,file){
        $('#'+file.id).find('a.delete').remove();
    });
    
    //会在文件上传过程中不断触发，可以用此事件来显示上传进度
    uploader.bind('UploadProgress',function(uploader,file){
        $('#'+file.id).find('dd').css('width',file.percent+'%');
    });
    
    //当队列中的某一个文件上传完成后触发
    uploader.bind('FileUploaded',function(uploader,file,responseObject){
        var result = eval('('+responseObject.response+')');
        if(result.error === '1'){
            $('#'+file.id).find('span.status').css('color','#f00').text(result.msg);
            $('#'+file.id).find('dd').addClass('fail');
        }else{
            $('#'+file.id).find('span.status').text('完成').end().find('dd').addClass('success');
            var success_count = $('#plupload').find('span.success_count').text();
            $('#plupload').find('span.success_count').text(++success_count);
        }
        
    });
    
    //当使用文件小片上传功能时，每一个小片上传完成后触发
    uploader.bind('ChunkUploaded',function(uploader,file,responseObject){
        var result = eval('('+responseObject.response+')');
        if(result.error === '1'){
            uploader.stop();
            $('#'+file.id).find('span.status').css('color','#f00').text(result.msg);
            $('#'+file.id).find('dd').addClass('fail');
        }
    });
    
    //当上传队列中所有文件都上传完成后触发
    uploader.bind('UploadComplete',function(uploader,files){
        uploader.disableBrowse(false);
        alert('文件队列上传完毕');
    });
    
    //当发生错误时触发
    uploader.bind('Error',function(uploader,errObject){
        $('#'+errObject.file.id).find('span.status').css('color','#f00').text('上传失败');
        $('#'+errObject.file.id).find('dd').addClass('fail');
    });
    
    //当调用destroy方法时触发
    uploader.bind('Destroy',function(uploader){});

    //在实例对象上调用init()方法进行初始化
    uploader.init();
    
    //最后给"开始上传"按钮注册事件
    $('#start_upload').click(function(){
        uploader.disableBrowse(true);
        uploader.start(); //调用实例对象的start()方法开始上传文件，当然你也可以在其他地方调用该方法
    });


    //点击移除文件
    $('#plupload').on('click','a.delete',function(){
        var file = uploader.getFile($(this).parents('li').attr('id'));
        if(file instanceof Object){
            //移除fileAPI中的文件,或SWF中的文件
            uploader.removeFile(file);
        }
    })
    
    
    //点击完成
    $('#plupload').on('click','button.achieve',function(){
        $('#plupload').find('ul#upList>li').each(function(){
            var file = uploader.getFile($(this).attr('id'));
            if(file instanceof Object){
                //移除fileAPI中的文件,或SWF中的文件
                uploader.removeFile(file);
            }
        })
        $('span.success_count,span.total').text(0);
    })
    
    
    //设置上传路径
    $('div.plupload_dirname').find('input.setdir').click(function(){
        $(this).parents('p.uploadTo').hide().next().show();
    });



    //打印对象-调试用
    function wobj(obj){ 
        var description = ""; 
        for(var i in obj){   
            var property=obj[i];   
            description+=i+" = "+property+"\n";  
        }   
        alert(description); 
    } 
    </script>
</body>
</html>