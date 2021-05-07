/**
* 前台公共JS函数库
*
*/
//加载视频播放窗口
function videoDialog(titled){
	window.top.art.dialog.open(videoUrl,{id:"videoDialogId",title: titled, width: $(window).width(), height:300,lock:true});
}


/**
* 按照条件进行筛选
* author		: bob
* create date	: 2016-01-04
*/
function selectTypeForPage(key,val){
	$("input[name='"+key+"']").val(val);
	if(key == "firstCate"){
		if($("input[name='secondCate']").size()>0){
			$("input[name='secondCate']").val(0);
		}
	}
	if(key == "fAreaId"){
		if($("input[name='sAreaId']").size()>0){
			$("input[name='sAreaId']").val(0);
		}
	}

	var firstCate		= $("input[name='firstCate']").val();
	if(firstCate == undefined){
		firstCate		= 0;	
	}
	pageUrl				= pageUrl + "?&firstCate="+firstCate;
	if($("input[name='firstCate']").size()> 0){
		var firstCate	= $("input[name='firstCate']").val();
		pageUrl			+= "&firstCate="+firstCate;
	}
	if($("input[name='secondCate']").size()> 0){
		var secondCate	= $("input[name='secondCate']").val();
		pageUrl			+= "&secondCate="+secondCate;
	}
	if($("input[name='roleId']").size()> 0){
		var roleId		= $("input[name='roleId']").val();
		pageUrl			+= "&roleId="+roleId;
	}
	if($("input[name='fAreaId']").size()> 0){
		var fAreaId		= $("input[name='fAreaId']").val();
		pageUrl			+= "&fAreaId="+fAreaId;
	}
	if($("input[name='sAreaId']").size()> 0){
		var sAreaId		= $("input[name='sAreaId']").val();
		pageUrl			+= "&sAreaId="+sAreaId;
	}
	
	if($("input[name='onlineType']").size() > 0){
		var onlineType	= $("input[name='onlineType']").val();
		pageUrl			+= "&onlineType="+onlineType;
	}
	if($("input[name='videoSearchText']").size() > 0){
		var searchText	= $("input[name='videoSearchText']").val();
		pageUrl			+= "&a1="+searchText+"&a2=1";
	}
	if($("input[name='timestamp']").size() > 0){
		var timestamp	= $("input[name='timestamp']").val();
		pageUrl			+= "&timestamp="+timestamp;
	}
	window.location.href= pageUrl;
}

/**
* 检测用户是否已经登录
* author		: bob
* create date	: 2016-01-09
**/
function checkIsLogin() {
    var result = false;
    $.ajax({
        type: "post",
        url: "/Wap/Login/checkIsLogin.html",
        async: false, //同步加载,默认为异步
        cache: false,
        dataType: "html",
        success: function(data) {
            if(data == "0") {//没有登录
				window.location.href = "/Wap/Login/dzswj.html";
                result = false;
            } else {//已登录
                result = true;
            }
        }
    });
    return result;
}