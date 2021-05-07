<!DOCTYPE html>
<!-- saved from url=(0125)http://xt.szgs.gov.cn/Wap/Live/pastList.html?&firstCate=0&firstCate=0&secondCate=0&roleId=0&fAreaId=30&sAreaId=0&onlineType=0 -->
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

<meta name="viewport" content="maximum-scale=1.0,minimum-scale=1.0,user-scalable=0,width=device-width,initial-scale=1.0">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black"> 
<meta name="format-detection" content="telephone=no,email=no,date=no,address=no">
<title>直播</title>
<link rel="stylesheet" type="text/css" href="css/base.css">
<link rel="stylesheet" type="text/css" href="css/live.css">
<script type="text/javascript" src="../js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="js/function.js"></script>
<script type="text/javascript">
</script>
<script type="text/javascript" src="js/live.js"></script>
</head>
<body>
<header>
	<div class="headerTop clearfix">
		<a href="" class="back"></a>
		<div class="headerText">直播回放</div>
	</div>
</header>
<!-- <div style="background-color:#eee; padding:5px 0px;">
	<a href="/Wap/Live/pastList.html" style="width:100%;">
	<div style="height:40px; line-height:40px; text-align:center; background-color:#fff;">
		<img src="/Public/Wap/images/videoLiveIcon.png" style=" vertical-align:middle; margin-right:5px;">直播周四见
	</div>
	</a>
</div> -->
<div class="listPageTopBlock">
	<div class="topListType">
		<div class="leftType">按状态：</div>
		<div class="typeAll"><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;onlineType&#39;,0)" class="sel">全部</a></div>
		<div class="typeContent">
			<a href="javascript:void(0);" onclick="selectTypeForPage(&#39;onlineType&#39;,1)">参加直播</a>
			<a href="javascript:void(0);" onclick="selectTypeForPage(&#39;onlineType&#39;,2)">回看直播</a>
		</div>
		<div style="clear:both;"></div>
	</div>
	<div class="topListType">
		<div class="leftType">按角色：</div>
		<div class="typeAll"><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;roleId&#39;,0)" class="sel">全部</a></div>
		<div class="typeContent">
			<a href="javascript:void(0);" onclick="selectTypeForPage(&#39;roleId&#39;,1)">个体户</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;roleId&#39;,2)">企业</a>		</div>
		<div style="clear:both;"></div>
	</div>
	<div class="topListType">
		<div class="leftType">按分类：</div>
		<div class="typeAll"><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;firstCate&#39;,0)" class="sel">全部</a></div>
		<div class="typeContent">
			<a href="javascript:void(0);" onclick="selectTypeForPage(&#39;firstCate&#39;,2)">税收政策</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;firstCate&#39;,3)">办税指南</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;firstCate&#39;,4)">软件操作</a>			<!--需要进行判断是否有二级分类，如果有二级分类才显示-->
			<!--测试数据先用税收政策的数据-->
					</div>
		<div style="clear:both;"></div>
	</div>
	<div class="topListType">
		<div class="leftType">按地区：</div>
		<div class="typeAll"><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,0)">全部</a></div>
		<div class="typeContent">
			<a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,10)">罗湖</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,139)">福田</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,30)" class="sel">南山</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,50)">蛇口</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,70)">盐田</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,145)">车购</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,146)">直属</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,147)">海洋</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,140)">宝安</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,90)">龙岗</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,110)">光明</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,141)">坪山</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,142)">龙华</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,143)">大鹏</a><a href="javascript:void(0);" onclick="selectTypeForPage(&#39;fAreaId&#39;,144)">前海</a>			<!--需要进行判断是否有二级分类，如果有二级分类才显示-->
			<!--测试数据先用市局的数据-->
					</div>
		<div style="clear:both;"></div>
	</div>
	<input type="hidden" name="firstCate" value="0">
	<input type="hidden" name="secondCate" value="0">
	<input type="hidden" name="roleId" value="0">
	<input type="hidden" name="fAreaId" value="30">
	<input type="hidden" name="sAreaId" value="0">
	<input type="hidden" name="onlineType" value="0">
</div>
<!--直播列表-->
<div class="liveList">
		
	<ul>
						<li>
			
			<a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-267bd4f1d3f34be3926464a2bb1320a0" onclick="setWatchLive(267)"><img src="images/59c4da27b845e.jpg"></a>
			<div class="live_mask"></div>
			<!---往期图--->
			<div class="overliveIcon"></div>
			<!--直播属性信息--->
			<div class="liveInfoBlock">
				<div class="infoRight"><a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-267bd4f1d3f34be3926464a2bb1320a0" onclick="setWatchLive(267)" class="overliveButton"></a></div>
				<div class="infoLeft">
					<div class="livetitle">新办纳税人培训</div>
					<div class="liveunit">南山区国税局</div>
					<div class="livetime">
						<font>直播时间：2017-09-25 10:00</font>
					</div>
				</div>
			</div>
			
		</li>				<li>
			
			<a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-0c0902fc3fe54885a94ee311aeee595c" onclick="setWatchLive(205)"><img src="images/59f6d94d3a3c6.jpg"></a>
			<div class="live_mask"></div>
			<!---往期图--->
			<div class="overliveIcon"></div>
			<!--直播属性信息--->
			<div class="liveInfoBlock">
				<div class="infoRight"><a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-0c0902fc3fe54885a94ee311aeee595c" onclick="setWatchLive(205)" class="overliveButton"></a></div>
				<div class="infoLeft">
					<div class="livetitle">增值税一般纳税人纳税申报热点问题剖析</div>
					<div class="liveunit">南山区国家税务局</div>
					<div class="livetime">
						<font>直播时间：2017-05-12 10:00</font>
					</div>
				</div>
			</div>
			
		</li>				<li>
			
			<a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-9bbd34c53be7460babba0b479cd6aa9c" onclick="setWatchLive(173)"><img src="images/59f6d94d3a3c6.jpg"></a>
			<div class="live_mask"></div>
			<!---往期图--->
			<div class="overliveIcon"></div>
			<!--直播属性信息--->
			<div class="liveInfoBlock">
				<div class="infoRight"><a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-9bbd34c53be7460babba0b479cd6aa9c" onclick="setWatchLive(173)" class="overliveButton"></a></div>
				<div class="infoLeft">
					<div class="livetitle">《外出经营活动税收管理证明》相关业务办理流程培训</div>
					<div class="liveunit">南山区国家税务局</div>
					<div class="livetime">
						<font>直播时间：2017-03-07 10:00</font>
					</div>
				</div>
			</div>
			
		</li>				<li>
			
			<a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-86df1ee9c61d4fb79b4dc11816a47c58" onclick="setWatchLive(133)"><img src="images/59f6d94d3a3c6.jpg"></a>
			<div class="live_mask"></div>
			<!---往期图--->
			<div class="overliveIcon"></div>
			<!--直播属性信息--->
			<div class="liveInfoBlock">
				<div class="infoRight"><a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-86df1ee9c61d4fb79b4dc11816a47c58" onclick="setWatchLive(133)" class="overliveButton"></a></div>
				<div class="infoLeft">
					<div class="livetitle">新版电子税务局操作指引</div>
					<div class="liveunit">前海国税局</div>
					<div class="livetime">
						<font>直播时间：2016-10-31 16:47</font>
					</div>
				</div>
			</div>
			
		</li>				<li>
			
			<a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-743141cc686b467fb5fe268195907814" onclick="setWatchLive(130)"><img src="images/3bc98436c3b34de89635201a3f4203e5_63.jpg.jpg"></a>
			<div class="live_mask"></div>
			<!---往期图--->
			<div class="overliveIcon"></div>
			<!--直播属性信息--->
			<div class="liveInfoBlock">
				<div class="infoRight"><a target="_blank" href="http://xtzb.szgs.gov.cn/webcast/site/vod/play-743141cc686b467fb5fe268195907814" onclick="setWatchLive(130)" class="overliveButton"></a></div>
				<div class="infoLeft">
					<div class="livetitle">金三系统非居民业务流程培训</div>
					<div class="liveunit">南山区国税局</div>
					<div class="livetime">
						<font>直播时间：2016-10-26 12:13</font>
					</div>
				</div>
			</div>
			
		</li>				<li>
			
			<a target="_blank" href="http://xt.szgs.gov.cn/Wap/Live/pastList.html?&amp;firstCate=0&amp;firstCate=0&amp;secondCate=0&amp;roleId=0&amp;fAreaId=30&amp;sAreaId=0&amp;onlineType=0" onclick="setWatchLive(128)"><img src="images/fdd229221a934ee990591afe7ed2e036_书本.jpg.jpg"></a>
			<div class="live_mask"></div>
			<!---往期图--->
			<div class="overliveIcon"></div>
			<!--直播属性信息--->
			<div class="liveInfoBlock">
				<div class="infoRight"><a target="_blank" href="http://xt.szgs.gov.cn/Wap/Live/pastList.html?&amp;firstCate=0&amp;firstCate=0&amp;secondCate=0&amp;roleId=0&amp;fAreaId=30&amp;sAreaId=0&amp;onlineType=0" onclick="setWatchLive(128)" class="overliveButton"></a></div>
				<div class="infoLeft">
					<div class="livetitle">新办纳税人发票业务培训</div>
					<div class="liveunit">南山区国税局</div>
					<div class="livetime">
						<font>直播时间：2016-08-22 15:30</font>
					</div>
				</div>
			</div>
			
		</li>	</ul>
		<!--公用分页样式-->
	<div class="pageSize" style="margin:20px 0;">
		<div class="page">    &nbsp;<span class="current">1</span><a href="http://xt.szgs.gov.cn/wap/live/pastlist/firstCate/0/secondCate/0/roleId/0/fAreaId/30/sAreaId/0/onlineType/0/p/2.html">2</a>    <a href="http://xt.szgs.gov.cn/wap/live/pastlist/firstCate/0/secondCate/0/roleId/0/fAreaId/30/sAreaId/0/onlineType/0/p/2.html">下一页</a> </div>	</div>
</div>
<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "https://hm.baidu.com/hm.js?8e15e253997b843617687b0c2f518856";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();
</script>
<div class="publicFooter">
	国税首页 | 学堂首页 | 网站公告 | 关于学堂 <br>
	版权所有：陕西省国家税务局  备案号：陕ICP备 06000245号 <br>
	地址：西安市二环南路西段39号 <br>
	技术支持：西安网算数据科技有限公司
</div>


</body></html>