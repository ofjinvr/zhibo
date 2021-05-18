$(function(){
    // var num= 100000*Math.random();
    // var name=  '游客'+ Math.floor(num);
    // var flag=true;
    var lid=5;

    $('.descrip').on('click',function(){
        console.log(123)
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
            return
        }else{
            var msg=$('.input').val();
            // console.log(msg);
            var cookie=document.cookie;
            PutMessage(msg,cookie);
            $('.input').val('');
            showNewMessage();
        }
    })

    $('.input').on('keyup',function(e){
        if($('.input').val()==''){
            return
        }
        if(e.keyCode==13){
            console.log('输入');
            var msg=$('.input').val();
            var cookie=document.cookie;
            PutMessage(msg,cookie);
            $('.input').val('');
            showNewMessage();
        }
    })

    function getLocalTime(nS) {
        return new Date(parseInt(nS) * 1000).toLocaleString().substr(0,17);
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
            url:'http://demo.cstaoding.com/api/getChatMsg',
            success:function(data,textStatus){
                if(data.length>0){
                    console.log(data);
                    var res=data;
                    var chatinner=document.getElementById('chatinner');
                    for(var i=0;i<res.length;i++){
                        var ul = document.createElement('ul');
                        var title=document.createElement('li');
                        title.innerHTML='游客'+res[i].ip+' &nbsp;' +getLocalTime(res[i].pubtime);
                        title.className='info';
                        if(res[i].ident==1){
                            title.className='info teacher';
                            title.innerHTML='管理员';
                        }else if(document.cookie==res[i].session_id){
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
                }
                showNewMessage()
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
                'msg':msg,
                'cookie':cookie
            },
            url:'http://demo.cstaoding.com/api/putChatMsg',
            success:function(data,textStatus){
                if(data.length>0){
                    console.log(data);
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