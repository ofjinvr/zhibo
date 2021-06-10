$(function(){
    // var num= 100000*Math.random();
    // var name=  '游客'+ Math.floor(num);
    // var flag=true;
    var lid=$('#lid').val();

    $('.descrip').on('click',function(){
        $('.chatroom_right').removeClass('hide');
        $('.chatroom_body').addClass('hide');
        $('.keyin').addClass('hide');
    })

    $('.hudong').on("click",function(){
        $('.chatroom_right').addClass('hide');
        $('.chatroom_body').removeClass('hide');
        $('.keyin').removeClass('hide');
    })

    $('.button').on('click',function(){
        //判断是否为空
        if($('.input').val()==''){
            alert('请输入发言内容');
            return false;
        }else{
            var msg=$('.input').val();
            PutMessage(msg);
            $('.input').val('');
            showNewMessage();
        }
    })

    $('.input').on('keyup',function(e){
        if(e.keyCode==13){
            if($('.input').val()==''){
                alert('请输入发言内容');
                return false;
            }
            PutMessage($('.input').val());
            $('.input').val('');
            showNewMessage();
        }
    })

    function getLocalTime(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString();
    }

    //显示最新的信息
    function showNewMessage(){
        var innerHeight=$('.chatinner').height();
        var contentHeight=$('.chatcontent').height();
        $('.chatcontent').scrollTop(innerHeight-contentHeight+50)
    }

    //获取连接
    function getConnect(){
        $.ajax({
            type:'post',
            dataType:'json',
            data:{
                'lid':lid
            },
            url:'http://wlnsrxt.sn-n-tax.gov.cn/api/getChatMsg',
            success:function(data){
                if(data.length>0){
                    console.log(data);
                    var res=data;
                    var chatinner=document.getElementById('chatinner');
                    for(var i=0;i<res.length;i++){
                        var ul = document.createElement('ul');
                        var title=document.createElement('li');
                        title.innerHTML=res[i].member_name +'('+ res[i].ip + ')'+' &nbsp;' + getLocalTime(res[i].pubtime);
                        title.className='info';
                        if(res[i].is_manage==1){
                            title.className='info teacher';
                            title.innerHTML='管理员';
                        }else if(document.cookie.indexOf(res[i].session_id)>0){
                            title.className='info self';
                        }
                        console.log(title);
                        var msg=document.createElement('li');
                        msg.className='question'
                        msg.innerHTML=res[i].message;
                        console.log(msg);
                        ul.appendChild(title);
                        ul.appendChild(msg);
                        chatinner.appendChild(ul);
                    }
                    showNewMessage();
                }

            },
            error:function(error){
                console.log(error)
            }
        });
    }
    //发送数据
    function PutMessage(msg,cookie){
        $.ajax({
            type:'post',
            dataType:'json',
            data:{
                'lid':lid,
                'msg':msg
            },
            url:'http://wlnsrxt.sn-n-tax.gov.cn/api/putChatMsg',
            success:function(data){
                if(data.error>0){
                    alert(data.info);
                }
            },
            error:function(error){
                console.log(error)
            }
        });
    }

    setInterval(function(){
        getConnect(lid);
    },1000);
})