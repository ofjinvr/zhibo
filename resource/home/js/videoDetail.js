/**
* 视频播放详情页
*/
$(document).ready(function(e) {
	//鼠标在视频上面的事件
    $(".videoList ul li div.img").hover(
    	function(e){
			$(this).find("div").show();
		},
		function(e){
			$(this).find("div").hide();	
		}
    );
	
	//鼠标放在分类上时的事件
	$(".videoInfoLeft .selTitle ul li").click(function(e){
		var index	= $(this).index();
		//给选择的标题的加减样式
		$(".videoInfoLeft .selTitle ul li").removeClass("sel");
		$(this).addClass("sel");
		
		//根据选择显示或者隐藏模块
		$(".videoInfoLeft .videoInfoLeftContent ul li").hide();
		$(".videoInfoLeft .videoInfoLeftContent ul li:eq("+index+")").show();
		
	});
	
	
	//鼠标在星星上的效果
	$(".commentTop .star a").hover(
		function(e){
			var num		= $(this).attr("val");
			updateStar(num);
		},
		function(e){
			updateStar(0);	
		}
	);
	//记录评价的分数
	$(".commentTop .star a").click(function(e){
		var num		= $(this).attr("val");
		$("input[name='starScore']").val(num);
		updateStar(num);
	});
	
	//绑定收藏的事件
	$(".playControl a.collectionButton").click(function(e) {

		if(!checkIsLogin()){
			return false;
		}
		var thisObj		= $(this);
		var sourceId	= $(this).attr("data-id");
		$.ajax({
			type: "post",
			url: "/Video/addfav.html",
			async: false, //同步加载,默认为异步
			cache: false,
			data:"sourceId="+sourceId+"&typeId=2",
			dataType: "json",
			success: function(data) {
				if(data.status == 1){
					thisObj.addClass("collectionButtonEd");
					thisObj.removeClass("collectionButton");
					thisObj.html("已收藏");
					window.art.dialog({id:'msgbox',content:'收藏成功',lock:true,width:250,height:100}).time(3);
					return false;
				}else{
					window.art.dialog({content:data.info,lock:true,width:250,height:100,ok:function(){}}).time(2);
					return false;
				}
			}
		});
	});
	//绑定下载的事件
	$(".relationInfo dl dt .info .download,.relationInfo dl dt a.downData").click(function(e) {	
		var sourceId	= $(this).attr("data-id");
		$.ajax({
			type: "post",
			url: "/Video/checkdown.html",
			async: false, //同步加载,默认为异步
			cache: false,
			data:"id="+sourceId,
			dataType: "json",
			success: function(data) {
				if(data.status == 1){
					window.location.href="/Video/downfile/id/"+sourceId+".html";
				}else{
					window.art.dialog({content:data.info,lock:true,width:250,height:100}).time(3);
					return false;
				}
			}
		});
	});
	
	//评论提交
	/* $("#commentButton").click(function() {
		alert(123);
		if(!checkIsLogin()){
			return false;
		}
		var starScore	= $("#starScore").val();
		var commentText	= $("#commentText").val();
		var vodeoId	= $("#vodeoId").val();
		if(starScore=='0'){
			window.art.dialog({content:'请选择星级',lock:true,width:250,height:100}).time(3);
			return false;
		}
		if(commentText==''){
			window.art.dialog({content:'请填写评论内容',lock:true,width:250,height:100}).time(3);
			return false;
		}
		if(commentText.length>10000){
			window.art.dialog({content:'请勿长篇大论',lock:true,width:250,height:100}).time(3);
			return false;
		}
		if(vodeoId=='' || vodeoId=='0'){
			window.art.dialog({content:'参数错误',lock:true,width:250,height:100}).time(3);
			return false;
		}
		$.ajax({
			type: "post",
			url: "/Video/commentSubmit.html",
			async: false, //同步加载,默认为异步
			cache: false,
			data:"vodeoId="+vodeoId+'&starScore='+starScore+'&commentText='+commentText,
			dataType: "json",
			success: function(data) {
				if(data.status == 1){
					window.art.dialog({content:'评论成功，审核后其它人可见！',lock:true,width:250,height:100}).time(3);
					window.location.href="/Video/videoDetail/id/"+vodeoId+"/comment/1.html?"+Math.random()+"#addComment";
				}else{
					window.art.dialog({content:data.info,lock:true,width:250,height:100}).time(3);
					return false;
				}
			}
		});
	}); */
});
/*
* 更改tage
* author		: gg
* create date	: 2013-01-16
*/
function selectTab(num){
	if(num=='1'){
		var index	= 3;
		//给选择的标题的加减样式
		$(".videoInfoLeft .selTitle ul li").removeClass("sel");
		//根据选择显示或者隐藏模块
		$(".videoInfoLeft .videoInfoLeftContent ul li").hide();
		$(".videoInfoLeft .selTitle ul li:eq("+index+")").addClass("sel");
		$(".videoInfoLeft .videoInfoLeftContent ul li:eq("+index+")").show();
	}
	
}

/*
* 更改tage
* author		: gg
* create date	: 2013-01-16
*/
function clickPractice(){
	if(!checkIsLogin()){
		return false;
	}
	return true;
	
}
/*
* 更改星星的数量
* author		: bob
* create date	: 2015-11-28
*/
function updateStar(num){
	var starScore	= parseInt($("input[name='starScore']").val());
	$(".commentTop .star a").removeClass("sel");
	if(num == 0 && starScore > 0){
		for(var i=1;i<=starScore;i++){
			$(".commentTop .star a[val='"+i+"']").addClass("sel");
		}
	}else if(num > 0){
		for(var i=1;i<=num;i++){
			$(".commentTop .star a[val='"+i+"']").addClass("sel");
		}	
	}
}
/*
* 增加播放视频学分
* author		: gg
* create date	: 2016-01-14
*/
function addVideoScure(num){
	$.ajax({
		type: "post",
		url: "/Video/addVideoScore.html",
		async: false, //同步加载,默认为异步
		cache: false,
		data:"id="+num,
		dataType: "json",
		success: function(data) {
//			if(data.statuss == 0){
//				alert('学分记录成功');
//			}
		}
	});
}
/*
* 记录用户播放
* author		: gg
* create date	: 2016-01-14
*/
function matchVideo(num){
	$.ajax({
		type: "post",
		url: "/Video/matchVideo.html",
		async: false, //同步加载,默认为异步
		cache: false,
		data:"id="+num,
		dataType: "json",
		success: function(data) {
//			if(data.statuss == 0){
//				alert('学分记录成功');
//			}
		}
	});
}