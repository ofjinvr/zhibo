/**
* 直播视频页
*/
$(document).ready(function(e) {	
	//直播报名
	if($(".liveList ul li a.yugaoButton").size() > 0){
		$(".liveList ul li a.yugaoButton").click(function(e) {
			if(!checkIsLogin()){
				//return false;
			}
			var thisObj		= $(this);
			var live_id	= $(this).attr("data-id");
			var liveurl	= $(this).attr("data-url");
			var ks	= $(this).attr("data-ks");
			$.ajax({
				type: "post",
				url: "/Wap/Train/onlineSign.html",
				async: false, //同步加载,默认为异步
				cache: false,
				data:"live_id="+live_id,
				dataType: "json",
				success: function(data) {
				
					if(data.status == 1){
						// thisObj.addClass("yugaoButtonEd");
						// thisObj.removeClass("yugaoButton");
						$("#jrlive"+ks).html("<a href='"+liveurl+"' class='yugaoButton' target='_blank'>进入直播</a>");
						// thisObj.unbind("click");
						window.top.art.dialog.open("/Wap/Train/signResult.html?live_id="+live_id,{id:"trainResultDialogId",title: '直播报名', width: 460, height: 300,lock:true});
						return false;
					}else{
						window.top.art.dialog.open("/Wap/Train/signResultFalse.html?falseStr="+data.info,{id:"trainResultDialogId",title: '直播报名', width: 460, height: 300,lock:true});
						return false;
					}
				}
			});
		});
	}
});

/**
* 观看直播赠送学分
* author		: bob
* create date	: 2016-01-18
*/
function setWatchLive(id){
	$.ajax({
		type: "post",
		url: "/Wap/Live/watchlive.html",
		async: false, //同步加载,默认为异步
		cache: false,
		data:"id="+id,
		dataType: "json",
		success: function(data) {}
	});
}