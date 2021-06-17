<div class="modal" id="loginBox">
    <div class="accModal">
        <h3>用户登录 <span class="tRight">×</span></h3>
<<<<<<< HEAD
        <form action="" method="post">
            <input type="hidden" name="_hash" value="<?=sha1(time()+mt_rand(100000,999999))?>">
            <ul class="formUl" style="width: 108px; text-align: right; line-height: 3em;">
=======
        <form action="">
            <ul class="formUl" style="width: 108px;">
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
                <li>手机：</li>
                <li>密码：</li>
            </ul>
            <ul class="formUl">
                <li><input type="text" name="mobile"></li>
<<<<<<< HEAD
                <li><input type="password" name="pwd" autocomplete="off"></li>
=======
                <li><input type="password" name="pwd"></li>
>>>>>>> 95749a69f2634d6483d4c9f6e340dd792701177b
            </ul>
            <input type="button" class="accButton" value="登录" id="loginBtn">
        </form>
    </div>
</div>
<script>
$(function(){
    $('#loginShow').on('click',function(){
        $('#loginBox').show();
        $('#loginBox>div').show();
    });
    $('span.tRight').on('click',function(){
        $('#loginBox').hide();
        $('#loginBox>div').hide();
    })
    $('#loginBtn').click(function(){
     var usermobile=$('#loginBox').find('input[name=mobile]').val();
    sessionStorage.setItem('userMobile',usermobile)

        var data = {
            'mobile' : $('#loginBox').find('input[name=mobile]').val(),
            'pwd' : $('#loginBox').find('input[name=pwd]').val()
        }
        $.post('<?=site_url('api/login')?>',data,function(result){
        console.log(result);
            if(result.err>0){
                alert(result.msg);
            }else{
                alert('登录成功');
                location.reload();

                $('#loginBox').hide();
                 $('#loginBox>div').hide();
                $('#loginShow').hide();
                $('#regShow').hide();
                $('#uerName').css('display','inline-block');

            }
        },'json');

    })

})
</script>