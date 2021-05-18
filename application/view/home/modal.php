<div class="modal">
    <div class="regModal">
        <h3>用户报名 <span class="tRight">×</span></h3>
        <form action="">
            <ul class="formUl">
                <li>姓名：</li>
                <li>单位名称：</li>
                <li>单位性质：</li>
                <li>职务：</li>
                <li>地区：</li>
                <li>手机号码：</li>
            </ul>
            <ul class="formUl">
                <input type="hidden" id="teachId" name="tid" value="">
                <li><input type="text" placeholder="请输入姓名" name="member_name"></li>
                <li><input type="text" placeholder="请输入企业名称" name="company_name"></li>
                <li>
                    <select name="company_nature" style="padding: 10px;border: 1px solid rgb(231,231,231);">
                        <option value="自然人">自然人</option>
                        <option value="个体">个体</option>
                        <option value="企业">企业</option>
                        <option value="其他">其他</option>
                    </select>
                </li>
                <li><input type="text" placeholder="请输入您的职务" name="job"></li>
                <li>
                    <select name="city" style="padding: 10px;border: 1px solid rgb(231,231,231);">
                        <option value="">请选择城市</option>
                        <option value="西安" >西安市</option>
                        <option value="咸阳" >咸阳市</option>
                        <option value="铜川">铜川市</option>
                        <option value="宝鸡">宝鸡市</option>
                        <option value="渭南">渭南市</option>
                        <option value="延安" >延安市</option>
                        <option value="汉中">汉中市</option>
                        <option value="榆林">榆林市</option>
                        <option value="安康">安康市</option>
                        <option value="商洛">商洛市</option>
                        <option value="杨凌">杨凌市</option>
                        <option value="韩城">韩城市</option>
                        <option value="西咸新区">西咸新区</option>
                    </select>
                    <select name="area" style="padding: 10px;border: 1px solid rgb(231,231,231);">
                        <option value="">请选择区(县)</option>
                    </select>
                    <script>
                        $(function(){
                            $('select[name=city]').change(function(){
                                $.get('<?=site_url('api/getCityArea')?>',{'cityname':$(this).val()},function(result){
                                    var arealist = '';
                                    $(result).each(function(k,v){
                                        arealist += '<option value="'+v.area_name+'">'+v.area_name+'</option>';
                                    })
                                    $('select[name=area]').html(arealist);
                                },'json')
                            })
                        })
                    </script>
                </li>
<!--                <li><input type="text" placeholder="请输入手机号码" name="mobile"></li>-->
<!--                <li><input type="text" placeholder="请输入验证码" class="yzm"><input type="button" value="获取验证码" class="hqyzm"></li>-->
            </ul>
            <input type="button" class="accButton" value="报名" id="baomingSubmit">
        </form>
    </div>
</div>
<script>

    $(".baoming").on('click',function (e) {
        $('.modal').show();
        $('.regModal').show();
        $('#teachId').val($(this).attr('data-tid'));
    })
    $('.tRight').on('click',function () {
        $('.modal,.accModal,.regModal').hide()
    })

    $('#baomingSubmit').click(function(){
        var data = {
            'tid' : $('input[name=tid]').val(),
            'member_name' : $('input[name=member_name]').val(),
            'company_name' : $('input[name=company_name]').val(),
            'company_nature' : $('select[name=company_nature]').val(),
            'job' : $('input[name=job]').val(),
            'city' : $('select[name=city]').val(),
            'area' : $('select[name=area]').val()
        }
        $.post('/api/baoming',data,function(result){
            alert(result);
            if(result==='报名成功'){
                $('.modal').hide();
            }
        },'html')
    })
</script>