//调整框架的大小高度
function resize_height(){
    var win_height = $(window).height(),
        win_width = $(window).width(),
        herder_height = $("div.header").height(),
        left_width = $('div.left').width()+$('div.middel').width();
        body_height = win_height-herder_height;
    $("#main,#main_iframe").height(body_height);
    $('#main_iframe').width(win_width-left_width-5);
}
$(function(){
    $(window).resize(function(){
      resize_height();
    }); 
    resize_height(); 
});

//退出登录弹出效果
$(function(){
    $(".logout").hover(function(){
        $(this).find('.slide_down').stop().fadeIn('fast');
    },function(){
        $(this).find('.slide_down').stop().fadeOut('fast');
    });
})

//左侧菜单切换效果,中间菜单初始显示第一个
$(function(){
    $('div.menulist').eq(0).show();
    
    var left_box_list = $('div.left').find('dl');
    var mid_box_list = $('div.middel').find('div.menulist');
    left_box_list.click(function(){
        var index = $(this).index();
        left_box_list.removeClass('current').eq(index).addClass('current');
        mid_box_list.hide().eq(index).show();
    })
})