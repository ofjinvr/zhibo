$.fn.extend({
    'imgQuery':function(objConfig){
        this.mark =  objConfig.ident || this.attr('id') || this.attr('name');
        this.ident = this.mark+'ImageQueryPlugin';
        this.imglist = objConfig.imglist || alert('没有imglist列表的AjaxUrl地址'); //图片链接的请求地址
        this.host = objConfig.host || window.location.host;                       //主机
        this.uploadurl = objConfig.uploadurl || '';                               //打开文件上传的窗口网址
        this.optionality = objConfig.optionality || 'radio';                      //radio-单选 checkbox-多选
        if(this.parent().find('p.temp_image').length===0){
            this.before('<p class="temp_image"></p>');
        }
        $('body').append('<div id="'+this.ident+'" class="queryImagePlugin"></div>');
        $('#'+this.ident).html(
            '<style type="text/css">' +
            '#'+this.ident+'{position:absolute;top:0;left:0;display:none;padding:5px;width:70%;border:4px solid #ccc;border-radius:10px;background:#f5f5f5}' +
            '#'+this.ident+' h3{overflow:hidden;margin:10px 10px 0 10px;padding-bottom:10px;border-bottom:1px solid #e0e0e0;font-size:16px}' +
            '#'+this.ident+' h3 input{float:right}' +
            '#'+this.ident+' h3 span{float:right;margin-right:10px;color:#999;font-weight:normal;font-size:13px;line-height:26px;cursor:pointer}' +
            '#'+this.ident+' .image_box{overflow:auto;height:400px;border-top:1px solid #fff;border-bottom:1px solid #e0e0e0}' +
            '#'+this.ident+' li{position:relative;float:left}' +
            '#'+this.ident+' li input{position:absolute;top:0px;left:0px}' +
            '#'+this.ident+' img{margin:5px; border:1px solid #e0e0e0;vertical-align:bottom;height:100px;}' +
            '#'+this.ident+' .button_box{clear:both;margin:0 10px;padding:10px 0;padding-top:10px;border-top:1px solid #fff}' +
            '#'+this.ident+' .button_box input{margin:0 3px;padding:5px 15px}' +
            '#'+this.ident+' span.tips{margin-left:10px;font-size:16px;line-height:40px}' +
            '</style>'+
            '<h3><input type="button" class="button" value="上传图片">选择图片<span>刷新</span></h3>'+
            '<div class="image_box"></div>' +
            '<div class="button_box">'+
                '<input type="button" class="button2" value="添加">'+
                '<input type="button" class="button3" value="取消">'+
            '</div>'
        );
        var _this = this;
        //设置中心位置
        this.setCenter = function(){
            var queryImageLeft = ($(window).width() - $('#'+_this.ident).width()) / 2,
                queryImageTop = ($(window).height() - $('#'+_this.ident).height()) / 2;
            $('#'+_this.ident).css({'left': queryImageLeft,'top': queryImageTop,'z-index': 99999});
        }
        this.setCenter();
        $(window).resize(this.setCenter);
        //拉取图片
        this.getImageList = function(){
            $('#'+_this.ident).find('.image_box').html('<span class="tips">图片载入中</span>');
            $('#'+_this.ident).show();
            $.get(_this.imglist, function(result){
                var list = '<ul>';
                for (var i in result) {
                    list += '<li><label><img src="'+ _this.host+result[i] +'"/><input type="'+_this.optionality +'" name="input_picture" value="'+result[i]+'"/></label></li>';
                }
                list += '</ul>';
                if(result.length == 0){
                    $('#'+_this.ident).find('.image_box').html('<span class="tips">一张图片也木有</span>');
                }else{
                    $('#'+_this.ident).find('.image_box').html(list);
                }
            }, 'json');
        }
        this.click(this.getImageList);
        //设置图片
        $('#'+this.ident).find('.button_box>input:eq(0)').click(function(){
            var input_html = '';
            $('#'+_this.ident).find('.image_box input:checked').each(function(){
                var name_id = '';
                if(_this.optionality==='checkbox'){
                    name_id = _this.attr('name') || _this.attr('id') || 'pictrue';
                    name_id += '[]';
                }else{
                    name_id = _this.attr('name') || _this.attr('id') || 'pictrue';
                }
                input_html += '<img style="max-height:100px;" src="' + _this.host + $(this).val() + '"> ';
                input_html += '<input type="hidden" name="'+name_id+'" value="' + $(this).val() + '">';
            });
            $(_this).parent().find('p.temp_image').html(input_html);
            $('#'+_this.ident).hide('fast').find('.image_box');
        });
        //取消选择器
        $('#'+this.ident).find('.button_box>input:eq(1)').click(function(){
            $('#'+_this.ident).hide();
        });
        //打开上传
        $('#'+this.ident).find('h3>input').click(function(){
            opener = window.open(_this.uploadurl,'图片上传','height=450,width=600,top=0,left=0,toolbar=no,menubar=no,scrollbars=no,resizable=no,location=no,status=no');
        });
        //刷新
        $('#'+this.ident).find('h3>span').click(function(){
            _this.getImageList();
        });
    }
});