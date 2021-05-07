var audiotipstime;

var Media = {
	media:null,
	started:false,
	duration:1,
	openCount:0,
	preStatus:null,
	init:function(mode){
		//$('.toolset').append("init ");
		if(mode=="videoFirst"){//1
			touchpanzoom();
			console.log("aaaaaaaaaa");
			$("#gs-audio").remove();
			//$(".video_buttom").remove();
			Media.media = $("#gs-video")[0];
			
			jQuery(Media.media).bind('timeupdate', function(){
				Media.curtime1 = Media.curtime2;
				Media.curtime2 = Media.media.currentTime;
				if(Media.curtime1>0){
					jQuery(Media).trigger("timeupdate", Number(Media.curtime1));
					if(pptRecord && pptRecord.is_pptRecord==1){
						//console.log("播放时间 "+Media.curtime1+" "+parseInt(parseFloat(Media.curtime1)*1000));
						pptRecord.recordDrawTime(parseInt(parseFloat(Media.curtime1)*1000));
					}
					if (synChat && synChat.issynChat) {
						synChat.chatCurrent(Media.media.currentTime);
					}
				}
			});
			jQuery(Media.media).bind('playing', function(){
				Media.ended = false;
			});
			jQuery(Media.media).bind('webkitendfullscreen', function(){
				Scheduler.requestTask(Media.curtime1, Media.media.currentTime);
				if(Media.ended && Media.duration > Media.curtime1){
					jQuery(Media).trigger("timeupdate", Media.duration);
					Scheduler.requestTask(Media.duration);
				}
			});
			jQuery(Media.media).bind('ended', function(){
				Media.ended = true;
				if (synChat && synChat.issynChat) {
				   synChat.lastSeekTime = 0;
				   loadChatsSynClear();
				}
			});
			
			jQuery(Media.media).bind('seeked',function(){
				$(".video_loading").css('display','none').find('.spinner').html('');
				Media.media.play();
//				Media.initCtrlbar({duration:Media.duration});
				if (synChat && synChat.issynChat) {
				loadChatsSynClear();
				synChat.getMore(Media.media.currentTime);
				}
				//请求函数
			});
			
			$("#playBtn").on("click", function(){
				Media.media.play();
				$(".video_buttom").hide();
				if(!GsPlayer.isUcOrQqBrowser()){
					$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
				}
			});
			
			//全屏退出
			jQuery(Media).bind("videoExitFullScreen", function(evt){
				Media.media.webkitExitFullScreen();
			});		

		}else if(mode=="videoOnly"){//3
			nodoc();
			$("#gs-audio").remove();
			//$(".video_buttom").remove();
			Media.media = $("#gs-video")[0];
			
			jQuery(Media.media).bind('timeupdate', function(){
				Media.curtime1 = Media.curtime2;
				Media.curtime2 = Media.media.currentTime;
				if(Media.curtime1>0){
					jQuery(Media).trigger("timeupdate", Number(Media.curtime1));
					if(pptRecord && pptRecord.is_pptRecord==1){
						pptRecord.recordDrawTime(parseInt(parseFloat(Media.curtime1)*1000));
					}
					if (synChat && synChat.issynChat) {
						synChat.chatCurrent(Media.media.currentTime);
					}
				}
			});
			jQuery(Media.media).bind('playing', function(){
				Media.ended = false;
			});
			jQuery(Media.media).bind('webkitendfullscreen', function(){
				Scheduler.requestTask(Media.curtime1, Media.media.currentTime);
				if(Media.ended && Media.duration > Media.curtime1){
					jQuery(Media).trigger("timeupdate", Media.duration);
					Scheduler.requestTask(Media.duration);
				}
			});
			jQuery(Media.media).bind('ended', function(){
				Media.ended = true;
				if (synChat && synChat.issynChat) {
					   synChat.lastSeekTime = 0;
					   loadChatsSynClear();
				}
			});
			$("#playBtn").on("click", function(){
				Media.media.play();
				$(".video_buttom").hide();
				if(!GsPlayer.isUcOrQqBrowser()){
				$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
				}
			});
			//全屏退出
			jQuery(Media).bind("videoExitFullScreen", function(evt){
				Media.media.webkitExitFullScreen();
			});
		}else if(mode=="docFirst"){
			novideo();
			$('#doc-box').on('click',function(){
				if($('#ctrlbar-box').css('visibility')!='hidden'){
					$('#ctrlbar-box').css('visibility','hidden');
				}else{
					$('#ctrlbar-box').css('visibility','visible');
				}
			});
			//console.log("ppp1111");
			Media.media = $("#gs-audio")[0];
			
			jQuery(Media.media).bind('playing', function(){
				$(".video_buttom").hide();
				if(!$("#ctrlPlayBtn").hasClass("ctrl-pause")){
					$("#ctrlPlayBtn").addClass("ctrl-pause");
				}
			});
			jQuery(Media.media).bind('ended', function(){
				if("true" != loopPlay){
					$(".video_buttom").css('display','block');
					$("#ctrlPlayBtn").removeClass("ctrl-pause");
				}
				if (synChat && synChat.issynChat) {
					   synChat.lastSeekTime = 0;
					   loadChatsSynClear();
				}
			});
			jQuery(Media.media).bind('pause', function(){
				$(".video_buttom").css('display','block');
				if($("#ctrlPlayBtn").hasClass("ctrl-pause")){
					$("#ctrlPlayBtn").removeClass("ctrl-pause");
				}
			});
			
			$('body').on("click","#playBtn", function(){
				Media.media.play();
				$(".video_buttom").hide();
				$("#ctrlPlayBtn").addClass("ctrl-pause");
				if(!GsPlayer.isUcOrQqBrowser()){
				$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
				}
				$('#ctrlbar-box').css('visibility','hidden');
			});

			$('body').on("click","#ctrlPlayBtn", function(){
				if($("#ctrlPlayBtn").hasClass("ctrl-pause")){
					$("#ctrlPlayBtn").removeClass("ctrl-pause");
					$(".video_buttom").css('display','block');
					Media.media.pause();
				}else{
					$("#ctrlPlayBtn").addClass("ctrl-pause");
					$(".video_buttom").hide();
					Media.media.play();
				}
			});

			$(".video-widget").css("visibility", "hidden");
			
			window.testInterval = setInterval(function(){
				jQuery(Media).trigger("timeupdate", Media.media.currentTime);
				Scheduler.requestTask(Media.media.currentTime);
			},190);
		}
		//微信监听自动播放
		document.addEventListener("WeixinJSBridgeReady", function() {
			Media.media.play();
		}, false);
		if(mode=="videoFirst" || mode=="videoOnly"){
			$('#video-box').append('<div class="audiotips">'+i18n("player.audio.tips")+'</div>');
			audiotipstime=setTimeout(function(){
				$('.audiotips').fadeOut();
			},15000);
			
			Media.touchvideo();
			
			jQuery('#tool_box').on('click','#audio_a',function(){
				var url=$('#gs-video').attr('src');
				var audiourl=url.replace('record.','recordaudioonly.');
				var currentTime=Media.media.currentTime;
				//$('.toolset').append(currentTime+" ");
				$('#gs-video').remove();
				$('.video-box').addClass('audio_bg');
				$('#topHalf').css('position','relative').append('<div id="ctrlbar-box" class="ctrlbar display-box"><div class="ctrl-left"><a id="ctrlPlayBtn" href="javascript:;" class="ctrl-play border-box"></a></div><div class="ctrl-center flex"><div id="ctrlSlider" class="ctrl-slider"><div id="gs-ctrlbar-buffer" class="ctrl-buffer" style="width:0%;"></div></div></div><div class="ctrl-right"><em id="gs-ctrlbar-curtime" class="ctrl-cur-time">00:00</em>/<em id="gs-ctrlbar-duration" class="ctrl-end-time">00:00</em></div></div>');
				
				jQuery('<audio id="gs-video" class="audio-widget" controls="true" src="'+audiourl+'">Your browser does not support the audio tag.</audio>').insertAfter('#webPlayer');
				Media.media = jQuery("#gs-video")[0];
				jQuery(Media.media).off();
				Media.media.play();
				if($(".video_loading").length>0){
					$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
				}else{
					$('#video-box').append('<div class="video_loading"><div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>');
					$(".video_loading").css('display','block');
				}
				jQuery(Media.media).unbind("canplay");
				jQuery(Media.media).unbind('seeked');
				jQuery(Media.media).bind("canplay",function(){
					Media.media.currentTime=currentTime;
					Media.media.pause();
					
				});
				
				jQuery(Media.media).bind('seeked',function(){
					$(".video_loading").css('display','none').find('.spinner').html('');
					Media.media.play();
					Media.initCtrlbar({duration:Media.duration});
					if (synChat && synChat.issynChat) {
					loadChatsSynClear();
					synChat.getMore(Media.media.currentTime);
					}
					//请求函数
				});
				

				//$('.toolset').append(" new "+Media.media.currentTime+" ");
				$("#ctrlPlayBtn").addClass("ctrl-pause");
				$('#audio_a').remove();
				$('.video_buttom').remove();
				
				
				//$('#tool_box ul').append('<li class="flex video" id="video_a"><a href="javascript:void(0)"><i></i><span>'+i18n("player.closevideo.video")+'</span></a></li>');
				$('<li class="flex video" id="video_a"><a href="javascript:void(0)"><i></i><span>'+i18n("player.closevideo.video")+'</span></a></li>').insertBefore('#change_css');
				/*if($('#video-box')[0] && $('#freeVotePopup').css('display')=='none' && $('#survey_stat').css('display')=='none' && !$('#doc_big').hasClass('on') && !$('#lottery-dialog').hasClass('on')){
					$('#video-box').removeClass('videotop');
				}*/
				GsPlayer.toolboxHide();
				jQuery(Media.media).unbind('playing');
				jQuery(Media.media).bind('playing', function(){
					$(".video_buttom").hide();
					if(!$("#ctrlPlayBtn").hasClass("ctrl-pause")){
						$("#ctrlPlayBtn").addClass("ctrl-pause");
					}
				});
				jQuery(Media.media).unbind('ended');
				jQuery(Media.media).bind('ended', function(){
					if("true" != loopPlay){
						$(".video_buttom").css('display','block');
						$("#ctrlPlayBtn").removeClass("ctrl-pause");
					}
					if (synChat && synChat.issynChat) {
						   synChat.lastSeekTime = 0;
						   loadChatsSynClear();
					}
				});
				jQuery(Media.media).unbind('pause');
				jQuery(Media.media).bind('pause', function(){
					$(".video_buttom").css('display','block');
					if($("#ctrlPlayBtn").hasClass("ctrl-pause")){
						$("#ctrlPlayBtn").removeClass("ctrl-pause");
					}
				});
				$("#playBtn").off("click");
				$("#playBtn").on("click", function(){
					Media.media.play();
					$(".video_buttom").hide();
					$("#ctrlPlayBtn").addClass("ctrl-pause");
					if(!GsPlayer.isUcOrQqBrowser()){
					$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
					}
					$('#ctrlbar-box').css('visibility','hidden');
				});
				$("#ctrlPlayBtn").off("tap");
				$("#ctrlPlayBtn").on("tap", function(){
					if($("#ctrlPlayBtn").hasClass("ctrl-pause")){
						$("#ctrlPlayBtn").removeClass("ctrl-pause");
						$(".video_buttom").css('display','block');
						Media.media.pause();
					}else{
						$("#ctrlPlayBtn").addClass("ctrl-pause");
						$(".video_buttom").hide();
						Media.media.play();
					}
				});

				
				window.testInterval = setInterval(function(){
					jQuery(Media).trigger("timeupdate", Media.media.currentTime);
					Scheduler.requestTask(Media.media.currentTime);
					if(pptRecord && pptRecord.is_pptRecord==1){
						
						pptRecord.recordDrawTime(parseInt(parseFloat(Media.media.currentTime)*1000));
					}
					if (synChat && synChat.issynChat) {
						synChat.chatCurrent(Media.media.currentTime);
					}
				},190);
				

				jQuery(Media.media).bind('ended', function(){
					if("true" == loopPlay){
						Media.media.play();
					}
					if (synChat && synChat.issynChat) {
						   synChat.lastSeekTime = 0;
						   loadChatsSynClear();
					}
				});
				
				jQuery(Media.media).bind('playing', function(){
					Media.started = true;
					$(".video_loading").remove();
					$(".video_buttom").hide();
				});
				
				//暂停控制
				jQuery(Media).unbind('openVote');
				jQuery(Media).bind('openVote', function(){
					Media.openCount++;
					if(Media.preStatus==null){
						Media.preStatus = (Media.media.paused?"paused":"playing");
						Media.media.pause();
					}
				});
				jQuery(Media).unbind('closeVote');
				jQuery(Media).bind('closeVote', function(){
					console.log("closeVote, openCount:"+Media.openCount+", preStatus:"+Media.preStatus);
					Media.openCount--;
					if(Media.preStatus == "playing"){
						if(Media.openCount<=0){
							Media.preStatus = null;
							Media.media.play();
							Media.openCount=0;
						}
					}
				});
				
				jQuery(Media).unbind("videoExitFullScreen");
			});
			jQuery('#tool_box').on('click','#video_a',function(){
				var url=$('#gs-video').attr('src');
				var audiourl=url.replace('recordaudioonly.','record.');
				var currentTime=Media.media.currentTime;
				$('#gs-video').remove();
				if($('#ctrlbar-box')[0]){
					$('#ctrlbar-box').remove();
				}
				if(window.testInterval){
					clearInterval(window.testInterval);
				}
				jQuery(Media.media).unbind("canplay");
				jQuery(Media.media).unbind('seeked');
				$('.video-box').removeClass('audio_bg').html('<video id="gs-video" class="video-widget" webkit-playsinline playsinline controls x-webkit-airplay="allow" x5-playsinline src="'+audiourl+'">Your browser does not support the video tag.</video>');
				Media.media = jQuery("#gs-video")[0];
				jQuery(Media.media).off();
				//Media.media.currentTime=currentTime;
				//Media.media.play();
				Media.media.play();
				if($(".video_loading").length>0){
					$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
				}else{
					$('#video-box').append('<div class="video_loading"><div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>');
					$(".video_loading").css('display','block');
				}
				jQuery(Media.media).unbind("canplay");
				jQuery(Media.media).unbind('seeked');
				jQuery(Media.media).bind("canplay",function(){
					Media.media.currentTime=currentTime;
					Media.media.pause();
				});
				jQuery(Media.media).bind('seeked',function(){
					$(".video_loading").css('display','none').find('.spinner').html('');
					Media.media.play();
					if (synChat && synChat.issynChat) {
					loadChatsSynClear();
					synChat.getMore(Media.media.currentTime);
					}
					//
				});
				//touch
				Media.touchvideo();
				$('#video_a').remove();
				//$('#tool_box ul').append('<li class="flex audio" id="audio_a"><a href="javascript:void(0)"><i></i><span>'+i18n("player.closevideo.audio")+'</span></a></li>');
				$('<li class="flex audio" id="audio_a"><a href="javascript:void(0)"><i></i><span>'+i18n("player.closevideo.audio")+'</span></a></li>').insertBefore('#change_css');
				
				/*if($('#video-box')[0] && $('#freeVotePopup').css('display')=='none' && $('#survey_stat').css('display')=='none' && !$('#doc_big').hasClass('on') && !$('#lottery-dialog').hasClass('on')){
					$('#video-box').removeClass('videotop');
				}*/
				GsPlayer.toolboxHide();
				
				jQuery(Media.media).unbind('timeupdate');
				jQuery(Media.media).bind('timeupdate', function(){
					Media.curtime1 = Media.curtime2;
					Media.curtime2 = Media.media.currentTime;
					if(Media.curtime1>0){
						jQuery(Media).trigger("timeupdate", Number(Media.curtime1));
						if(pptRecord && pptRecord.is_pptRecord==1){
							pptRecord.recordDrawTime(parseInt(parseFloat(Media.curtime1)*1000));
						}
						if (synChat && synChat.issynChat) {
							synChat.chatCurrent(Media.media.currentTime);
						}
					}
				});
				jQuery(Media.media).unbind('playing');
				jQuery(Media.media).bind('playing', function(){
					Media.ended = false;
				});
				jQuery(Media.media).unbind('webkitendfullscreen');
				jQuery(Media.media).bind('webkitendfullscreen', function(){
					Scheduler.requestTask(Media.curtime1, Media.media.currentTime);
					if(Media.ended && Media.duration > Media.curtime1){
						jQuery(Media).trigger("timeupdate", Media.duration);
						Scheduler.requestTask(Media.duration);
					}
				});
				jQuery(Media.media).unbind('ended');
				jQuery(Media.media).bind('ended', function(){
					Media.ended = true;
					if (synChat && synChat.issynChat) {
						   synChat.lastSeekTime = 0;
						   loadChatsSynClear();
					}
				});

				//全屏退出
				jQuery(Media).unbind("videoExitFullScreen");
				jQuery(Media).bind("videoExitFullScreen", function(evt){
					Media.media.webkitExitFullScreen();
				});
				
			});
		}else{
			$('#tool_a').remove();
			$('#tool_box').remove();
		}
		//if(loopPlay=="true"){
			//$(Media.media).attr('loop','loop');
		//}
		jQuery(Media.media).bind('ended', function(){
			if("true" == loopPlay){
				//jQuery(Media).trigger("timeupdate", 0);
				//$(".video_buttom").hide();
				//Media.media.currentTime=0;
				Media.media.play();
				//Scheduler.requestTask(Media.media.currentTime);
			}
			if (synChat && synChat.issynChat) {
				   synChat.lastSeekTime = 0;
				   loadChatsSynClear();
			}
		});
		
		jQuery(Media.media).bind('playing', function(){
			Media.started = true;
			$(".video_loading").remove();
			$(".video_buttom").hide();
		});
		
		//暂停控制
		jQuery(Media).bind('openVote', function(){
			Media.openCount++;
			if(Media.preStatus==null){
				Media.preStatus = (Media.media.paused?"paused":"playing");
				Media.media.pause();
			}
		});
		jQuery(Media).bind('closeVote', function(){
			console.log("closeVote, openCount:"+Media.openCount+", preStatus:"+Media.preStatus);
			Media.openCount--;
			if(Media.preStatus == "playing"){
				if(Media.openCount<=0){
					Media.preStatus = null;
					Media.media.play();
					Media.openCount=0;
				}
			}
		});
		
		onPlayerReady();
	},
	touchvideo:function(){
		if(GsPlayer.isiPhone()){
			var startPosition, endPosition, deltaX, deltaY, moveLength;
			jQuery('video#gs-video').unbind('touchstart');
			jQuery('video#gs-video').unbind('touchmove');
			jQuery('video#gs-video').unbind('touchend');
			jQuery('video#gs-video').bind('touchstart', function (e) {
				var touch = e.touches[0];
				startPosition = {
					x: touch.pageX,
					y: touch.pageY
				}
				if($('#video_progress').length==0){
					$('#video-box').append('<div class="video_progress" id="video_progress"></div>');
				}else{
					$('#video_progress').hide();
				}
			});
			
			jQuery('video#gs-video').bind('touchmove', function (e) {
				var touch = e.touches[0];
				endPosition = {
					x: touch.pageX,
					y: touch.pageY
				}
				deltaX = endPosition.x - startPosition.x;
				//$('.toolset').append(deltaX+" ");
				if(deltaX>0){
					var currentTime=parseInt(Media.media.currentTime);
					var ltimne=parseInt(Media.duration-currentTime);
					if(ltimne>0){
						var t=parseInt((deltaX/GsPlayer.winHeight)*ltimne);
						var newcurrentTime=currentTime+t;
						if(newcurrentTime>Media.duration){
							newcurrentTime=Media.duration;
						}
						var baifenbi=parseInt(newcurrentTime*100/Media.duration);
						$('#video_progress').html(baifenbi+'%').show();
						
					}
				}else if(deltaX<0){
					var currentTime=parseInt(Media.media.currentTime);
					var t=parseInt((-deltaX/GsPlayer.winHeight)*currentTime);
					var newcurrentTime=currentTime-t;
					if(newcurrentTime<0){
						newcurrentTime=0;
					}
					var baifenbi=parseInt(newcurrentTime*100/Media.duration);
					$('#video_progress').html(baifenbi+'%').show();
					
				}
			});
			
			jQuery('video#gs-video').bind('touchend', function (e) {
				var touch = e.changedTouches[0];
				
				endPosition = {
					x: touch.pageX,
					y: touch.pageY
				}
				console.log(endPosition);
				deltaX = endPosition.x - startPosition.x;
				
				if(deltaX>0){
					var currentTime=parseInt(Media.media.currentTime);
					var ltimne=parseInt(Media.duration-currentTime);
					if(ltimne>0){
						var t=parseInt((deltaX/GsPlayer.winHeight)*ltimne);
						var newcurrentTime=currentTime+t;
						if(newcurrentTime>Media.duration){
							newcurrentTime=Media.duration;
						}
						var baifenbi=parseInt(newcurrentTime*100/Media.duration);
						$('#video_progress').html(baifenbi+'%').show();
					}
				}else if(deltaX<0){
					var currentTime=parseInt(Media.media.currentTime);
					var t=parseInt((-deltaX/GsPlayer.winHeight)*currentTime);
					var newcurrentTime=currentTime-t;
					if(newcurrentTime<0){
						newcurrentTime=0;
					}
					var baifenbi=parseInt(newcurrentTime*100/Media.duration);
					$('#video_progress').html(baifenbi+'%').show();
				}
				$('#video_progress').remove();
				//Media.media.play();
				
				if(newcurrentTime && newcurrentTime>0){
					if($(".video_loading").length>0){
						$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
					}else{
						$('#video-box').append('<div class="video_loading"><div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>');
						$(".video_loading").css('display','block');
					}
					jQuery(Media.media).unbind("canplay");
					jQuery(Media.media).unbind('seeked');
	
					Media.media.currentTime=newcurrentTime;
	
					jQuery(Media.media).bind('seeked',function(){
						$(".video_loading").css('display','none').find('.spinner').html('');
						Media.media.play();
						if (synChat && synChat.issynChat) {
							loadChatsSynClear();
							synChat.getMore(Media.media.currentTime);
						}
					});
				}
			});
		}
	},
	initCtrlbar:function(data){
		//$('.toolset').append("initCtrlbar ");
		console.log("总时长",data.duration);
		var gs_total_duration = data.duration;//s
		Media.duration = data.duration;//s
		var du = Util.timeDuration(Math.round(gs_total_duration));
		console.log("总时长",du);
		$("#gs-ctrlbar-duration").text(du);
		
		jQuery("#ctrlSlider").slider({
			range: "min",
			value: 0,
			change: function(event, ui) {
			},
			start:function(){
				if(window.testInterval){
					clearInterval(window.testInterval);
				}
				jQuery(Media.media).off("timeupdate");
				Media.media.pause();
				jQuery(Media.media).unbind("canplay");
				jQuery(Media.media).unbind('seeked');
			},
			stop:function(event, ui) {
				var v = ui.value;
				var s = gs_total_duration * Number(v)/ 100;
				//jQuery('.toolset').append(jQuery(Media.media)[0].currentTime+" n ");
				var currentTime=Number(s);
				
				if($('.video-box').hasClass('audio_bg')){
					if($(".video_loading").length>0){
						$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
					}else{
						$('#video-box').append('<div class="video_loading"><div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>');
						$(".video_loading").css('display','block');
					}
				}
				jQuery(Media.media)[0].currentTime=currentTime;
				//jQuery('.toolset').append(jQuery(Media.media)[0].currentTime+" stop ");
				jQuery(Media.media).unbind('seeked');
				jQuery(Media.media).bind('seeked',function(){
					
					//jQuery('.toolset').append(jQuery(Media.media)[0].currentTime+" end ");
					jQuery(Media.media)[0].play();
					if($('.video-box').hasClass('audio_bg')){
						$(".video_loading").css('display','none').find('.spinner').html('');
					}
					if(window.testInterval){
						clearInterval(window.testInterval);
					}
					window.testInterval = setInterval(function(){
						jQuery(Media).trigger("timeupdate", jQuery(Media.media)[0].currentTime);
						Scheduler.requestTask(jQuery(Media.media)[0].currentTime);
					},190);
					jQuery(Media.media).off("timeupdate");
					jQuery(Media.media).on("timeupdate", function(evt){
						if(parseInt(jQuery(Media.media)[0].currentTime)>0){
							//$('.toolset').append(Media.media.currentTime+" ss ");
							//console.log("播放时间");
							//console.log(Media.media.currentTime,Media.duration);
							var c=jQuery(Media.media)[0].currentTime>Media.duration?Media.duration:jQuery(Media.media)[0].currentTime;
							
							jQuery("#gs-ctrlbar-curtime").text(Util.timeDuration(Math.round(c)));
							jQuery("#ctrlSlider").slider("value", Util.calcPercent(jQuery(Media.media)[0].currentTime, Media.duration) );
							if(pptRecord && pptRecord.is_pptRecord==1){
								//console.log("播放currentTime",Media.media.currentTime);
								pptRecord.recordDrawTime(parseInt(parseFloat(jQuery(Media.media)[0].currentTime)*1000));
							}
							if (synChat && synChat.issynChat) {
								synChat.chatCurrent(Media.media.currentTime);
							}
						}
					});
					if (synChat && synChat.issynChat) {
					loadChatsSynClear();
					synChat.getMore(Media.media.currentTime);
					}
					//请求函数
					
					return false;
				});
				//Media.media.currentTime = Number(s);
				console.log("seek:"+s);
			}
		});
		jQuery(Media.media).off("timeupdate");
		jQuery(Media.media).on("timeupdate", function(evt){
			if(parseInt(Media.media.currentTime)>0){
				var c=jQuery(Media.media)[0].currentTime>Media.duration?Media.duration:jQuery(Media.media)[0].currentTime;
				$("#gs-ctrlbar-curtime").text(Util.timeDuration(Math.round(c)));
				//$('.toolset').append(Media.media.currentTime+" s ");
				jQuery("#ctrlSlider").slider("value", Util.calcPercent(Media.media.currentTime, Media.duration) );
			}
			if(pptRecord && pptRecord.is_pptRecord==1){
				//console.log("播放currentTime",Media.media.currentTime);
				pptRecord.recordDrawTime(parseInt(parseFloat(Media.media.currentTime)*1000));
			}
		});
	}
};

