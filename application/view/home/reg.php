<div class="modal" id="regBox">
    <div class="accModal">
        <h3>用户注册 <span class="tRight">×</span></h3>
        <form action="">
            <ul class="formUl">
                <li>手机号码：</li>
                <li>短信验证码：</li>
                <li>密码：</li>
                <li>重复密码：</li>
                <li>昵称：</li>
            </ul>
            <ul class="formUl">
                <input type="hidden" id="teachId" name="tid" value="">
                <li><input type="text" name="mobile"></li>
                 <li><input type="text" class="sms_code" name="sms_code" style="width:50%;display:inline-block"><input type="button" value="获取验证码" class="hqyzm" style="display:inline-block"></li>
                <li><input type="password" name="pwd"></li>
                <li><input type="password" name="pwd2"></li>
                <li><input type="text" name="nickname"></li>
            </ul>
            <input type="button" class="accButton" value="注册" id="regBtn">
        </form>
    </div>
</div>
<script>
    $(function(){
        $('#regShow').on('click',function(){
            $('#regBox').show();
            $('#regBox>div').show();
        });
        $('span.tRight').on('click',function(){
            $('#regBox').hide();
            $('#regBox>div').hide();
        })
        $('input[class="hqyzm"]').click(function(){
                var data = {
                               'mobile' : $('#regBox').find('input[name=mobile]').val()
                            }
             $.post('<?=site_url('api/sms')?>',data,function(result){
             console.log(result);
                            if(result.err>0){
                                alert(result.msg);
                            }else{
                                alert('验证码已发送');

                            }
                        },'json');
        })
            $('#regBtn').click(function(){

            var username=$('#regBox').find('input[name=nickname]').val();
                var data = {
                    'mobile': $('#regBox').find('input[name=mobile]').val(),
                    'sms_code':$('#regBox').find('input[name=sms_code]').val(),
                    'pwd': $('#regBox').find('input[name=pwd]').val(),
                    'pwd2':$('#regBox').find('input[name=pwd2]').val(),
                   'nickname':$('#regBox').find('input[name=nickname]').val()
                }
                $.post('<?=site_url('api/reg')?>',data,function(result){
                    if(result.err>0){
                        alert(result.msg);
                    }else{
                        alert("注册成功");
                        location.reload();
                        $('#loginShow').hide();
                        $('#regShow').hide();
                    }
                },'json');

            })

    })
</script>