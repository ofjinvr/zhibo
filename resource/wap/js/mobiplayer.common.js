var GsPlayer = {
	"winWidth": "",
	"winHeight": "",
	"videoHeight": "",
    "isUserFullScreen" : false, //用户主动操作全屏的状态（由于横屏会自动切换到全屏状态）
    init : function(){
		console.log(navigator.userAgent);
		if(/MicroMessenger/i.test(navigator.userAgent)){
			//$('.toolbar').addClass('status_bar_p');
		}
		//var winWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;
		//$('.toolset').append(" kk "+ winWidth+" ");
		//$('.toolset').append(navigator.userAgent);
		
function getInfo() 
{ 
var s = ""; 
s += " 网页 "+document.body.clientWidth+" "+document.body.clientHeight; 
s += " 屏幕 "+window.screen.width+" "+window.screen.height; 
s += " 屏幕可用 "+window.screen.availWidth+" "+window.screen.availHeight; 
s += " 窗口 "+window.innerWidth+" "+window.innerHeight; 
s += " ee "+document.documentElement.clientWidth+" "+document.documentElement.clientHeight; 
s += " dd "+$('body').width()+" "+$('body').height(); 
s += " dd "+jQuery('body').scrollTop(); 
s += " orientation "+window.orientation; 
//s+=" "+navigator.userAgent
$('.toolset').append(s);
} 
//getInfo(); 
        
		//$('.toolset').append(" s "+this.winWidth + " "+ this.winHeight+" ");
	
        if(this.isPortrait()){
			
			this.winWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        	this.winHeight = (window.innerHeight > 0) ? window.innerHeight : screen.height;
	
			if(this.winHeight>window.screen.height){
				this.winHeight=window.screen.height;
			}
			this.playerSize();
			console.log(this.winHeight);
			
            if(!this.isUserFullScreen){
                this.exitFullscreen();
            }
			if($('#tanmu_a')[0] && $('#tanmu_a').css('display')!='none' && $('#tanmu_a').hasClass('on')){
				CM.width=$('body').width();
				
			}
			//$('.toolset').append( this.winWidth + " "+ this.winHeight+" ");
			
			var h = this.topHalfHeight();
			//var r=h/(this.winHeight-h);
			//console.log(r);
			//var rm=10/11;
			//console.log(rm);
			//if(r>rm){
				//if(this.winHeight<481){
					//$('.toolbar').addClass('status_bar_p');
				//}
				//console.log(parseInt(this.winHeight*10/21));
				//this.videoHeight=parseInt(this.winHeight*10/21);
				//$("#topHalf").height(this.videoHeight);
			//}else{
				this.videoHeight=h;
				$("#topHalf").height(this.videoHeight);
			//}
			$('#tool_box').css('top',h+30);
			$('.qa_list_content ul li .qa_answer_question p').width(this.winWidth-47);
			this.chatQaFold(false);
			
			if(this.isUcOrQqBrowser() && this.isiPhone()){
				$('.survey, .survey_stat').css('bottom','44px');
			}
			if($('.slider-ft')[0]){
				if($('.onchat').hasClass('on')){
					chatprivatename();
				}else if($('.onqa').hasClass('on')){
					qaprivatename();
				}
				if($('#chat-textarea').hasClass('chat-edit-qa')){
					$('#chat-textarea').css('width',(GsPlayer.winWidth-52-55-10)+'px');
				}else{
					$('#chat-textarea').css('width',(GsPlayer.winWidth-52-55-10-38)+'px');
				}
			}
			if($('#dashang_box_donghua')[0]){
				$('#dashang_box_donghua').css('top',this.boxTopHeight());
			}
			
			$('.msg-content').css('width',(GsPlayer.winWidth-44)+'px');
			$('.qa_txt').css('width',(GsPlayer.winWidth-24)+'px');
			$('.about_list_content h2').css('width',(GsPlayer.winWidth-24)+'px');
			$('.about_list_content p').css('width',(GsPlayer.winWidth-24)+'px');
			//$('.status_bar_s span').width(parseInt(0.5 * this.winWidth)).css('display','block');
        }else{
			//$('.toolset').append(" hhh ");
			/*if($('#video-box')[0] && $('#video-box').hasClass('videotop') && !$('#rollcall-box').hasClass('on') && !$('#lottery-dialog').hasClass('on') && !$('#doc_big').hasClass('on') && !$('#card_box').hasClass('on') && !$('#net_box').hasClass('on') && !$('#tool_box').hasClass('on') && !$('#hongbao_box').hasClass('on')){
				$('#video-box').removeClass('videotop');
			}*/
			if($('.slider-ft')[0] && $('.slider-ft').hasClass('ontop')){
				$('#coverLayerempty').hide();
				$('.slider-ft').removeClass('ontop');
			}
			if($("#phizBtn")[0] && $("#phizBtn").hasClass("btn-phiz-on")) {
				closePhizBox();
			}
			if($('.chat-edit-area')[0] && $('.chat-edit-area').hasClass("chat-edit-on")) {
				$('.chat-edit-area').removeClass('chat-edit-on');
				$('#chat-textarea').trigger('blur');
				$('#btn-chat-submit')[0].focus();
			}
			GsPlayer.videoShow();
			GsPlayer.toolboxHide();
			/*if(/MicroMessenger/i.test(navigator.userAgent) && this.isiPhone() && !isiframe){
				this.winWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        		this.winHeight = (window.innerHeight > 0) ? window.innerHeight : screen.height;

				if(this.winHeight>(window.screen.availWidth-44)){
					this.winHeight-=268;
				}
				//$('.toolset').append(" winHeight "+this.winHeight);
			}else{*/
				this.winWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;
        		this.winHeight = (window.innerHeight > 0) ? window.innerHeight : screen.height;
			//}
			/*if(this.winWidth>window.screen.width){
				this.winWidth=window.screen.width;
			}*/
			//$('.toolset').append(" heng "+this.winHeight+" "+window.screen.height);
			if(this.winHeight>window.screen.height){
				this.winHeight=window.screen.height;
			}
			this.playerSize();
			/*if(this.winHeight>window.screen.height){
				this.winHeight=window.screen.height;
			}*/
			//$('.status_bar_s span').css('display','none');
            this.fullscreen();
			//$('.toolset').append(" heng "+this.winWidth);
            //this.videoOutside(false);
			//$('.toolset').append(" body "+$('body').height());
			if($('#tanmu_a')[0] && $('#tanmu_a').css('display')!='none' && $('#tanmu_a').hasClass('on')){
				CM.width=$('body').width();
			}
			if($('#dashang_box_donghua')[0]){
				$('#dashang_box_donghua').css('top',this.winHeight/3);
			}
        }
		if(!$('#doc-tab')[0]){
			$('.slider-ft').css('visibility','visible');
		}
		
		
    },
	playerSize: function () {
		/*$("#webPlayer").css({
			"width": this.winWidth+'px',
			"height": this.winHeight+'px'
		});*/
		/*if(/MicroMessenger/i.test(navigator.userAgent) && this.isiPhone()){
			$("#webPlayer").css({
				"width": '100%',
				"height": this.winHeight+'px',
				"bottom":"auto"
			});
		}else{*/
			$("#webPlayer").css({
				"width": '100%',
				"height": '100%'
			});
			//$('.toolset').append(" webPlayer "+$("#webPlayer").height());
		//}
		
	},
	topHalfHeight: function () {
		var h=0;
		if(typeof videoWidthHeight !== "undefined" && videoWidthHeight=="16:9"){
			h = parseInt((9 * this.winWidth)/16);	
		}else{
			h = parseInt(0.75 * this.winWidth);
			var r=h/(this.winHeight-h);
			var rm=10/11;
			if(r>rm){
				h=parseInt(this.winHeight*10/21);
			}
		}
		//var h = parseInt(0.75 * this.winWidth);
		//$("#topHalf").height(h);
		return h;
	},
	changeVideoScale: function (s) {
		videoWidthHeight=s;
		if(this.isPortrait()){
			this.videoHeight=this.topHalfHeight();
			$("#topHalf").height(this.videoHeight);
			this.chatQaFold(false);
		}
	},
	chatQaHeight: function(){
		var that = this;
		var headerHeight = 30;
        if($(".toolbar").hasClass('status_bar_p')){
            headerHeight = 0;
        }
		var tabsHeight=$('.tabs').height();
		var input_height=0;
		if($('#textarea-box')[0]){
			input_height=50;
		}
		return that.winHeight - that.topHalfHeight() - input_height - headerHeight-tabsHeight;
	},
	boxTopHeight:function(){
		var that = this;
		var headerHeight = 30;
        if($(".toolbar").hasClass('status_bar_p')){
            headerHeight = 0;
        }
		var tabsHeight=$('.tabs').height();
		return headerHeight+that.topHalfHeight()+tabsHeight;
	},
	chatQaFold: function (hasAnimate) {
		//$('.toolset').append(" d "+this.winWidth + " "+ this.winHeight+" ");
		var that = this;
		var chatQaBox = $("#chatQaBox");
        var headerHeight = 30;
        if($(".toolbar").hasClass('status_bar_p')){
            headerHeight = 0;
        }
		var uch=0;
		if(this.isUcBrowser()){
			//uch=44;
		}
		var tabsHeight=$('.tabs').height();
		$('#chatQaBox').height(that.winHeight-headerHeight-that.topHalfHeight()-uch);
		var h=that.winHeight-headerHeight-that.topHalfHeight()-tabsHeight-uch;
		$('.section-top').height(h);
		var slider_container_width=$('.slider-container').width();
		var slider_container_width_one=parseInt(slider_container_width/$('.tabs').find('li').length);
		if(slider_container_width_one>this.winWidth){
			$('.document-container,.slider-bd,.chapter-hd,.chapter-list-container').width(this.winWidth);
		}
		var hdoc;
		if($('#doc-tab')[0]){
			hdoc=h;
		}else{
			hdoc=$("#topHalf").height();
			$('.slider-box').height(h);
			
		}
		//$('.toolset').append(" hdoc "+hdoc);
		//$('.toolset').append(" topHalfHeight "+that.topHalfHeight());
		$('.document-container').height(hdoc).css({"line-height":hdoc+'px','width':'100%'});
		console.log(uch,that.winHeight,$('.slider-ft').height());
		//$('.toolset').append(" winHeight "+that.winHeight);
		//$('.slider-ft').css('top',(that.winHeight-$('.slider-ft').height()-uch)+"px");
        var animateTime = hasAnimate?200:0;
		
		var input_height=0;
		if($('#textarea-box')[0]){
			input_height=51;
		}
		
		chatQaBox.find(".slider-bd").each(function(){
			var self = $(this);
            var topBtmHeight = (self.hasClass('chat-bd') || self.hasClass('qa_list_content')) ? input_height : 0;
			//$('.toolset').append(" ddd "+(that.winHeight - that.topHalfHeight() - topBtmHeight - headerHeight-tabsHeight));
			//console.log(that.winHeight - that.topHalfHeight() - topBtmHeight - headerHeight-tabsHeight);
            self.css({
                "height":that.winHeight - that.topHalfHeight() - topBtmHeight - headerHeight-tabsHeight,
                "transition-duration": animateTime + 'ms',
                "-webkit-transition-duration": animateTime + 'ms',
                "-moz-transition-duration":animateTime + 'ms'
            });
		});
		//touchpanzoom();
		/*setTimeout(function(){
            chatQaBox.removeClass("section-bottom-unfold");
        },animateTime);*/
        //$('#foldBtn').removeClass('icon-cam-off');
	},
    listenScroll : function(){
        //iOS滚动条bugfix
        var chatQaBox = $("#chatQaBox");
        var chapterList = $(".chapter-list-container");
        //chatQaBox.find(".document-container").each(function(){
            //var self = $(".document-container");
            if($(".document-container")[0].scrollHeight <= $(".document-container")[0].innerHeight){
                $(".document-container").removeClass("allow-roll");
            }else{
                $(".document-container").addClass("allow-roll");
            }
           /* if(chapterList.length != 0){
                if(chapterList[0].scrollHeight <= chapterList.innerHeight()){
                    chapterList.removeClass("allow-roll");
                }else{
                    chapterList.addClass("allow-roll");
                }
            }*/
        //});
    },
	fullscreen: function () {
		//if(!$("#video-box").hasClass('videotop')){
			if(!$('#doc_big').hasClass('on')){
				setTimeout(function(){
					
					if($("#video-box")[0]){
						$("#video-box").addClass('video_fullscreen');
					}else if($("#doc-box")[0]){
						$('#topHalf').css('position','static');
						$("#doc-box").css({"line-height":GsPlayer.winHeight+'px','width':'100%','height':'100%','z-index':'501'}).addClass('video_fullscreen');
						resetPanzoom();
					}
					
				},0);
			}
			if($('.slider-ft').hasClass('show')){
				$('.slider-ft').css('visibility','hidden');
			}
			
		//}
	},
	exitFullscreen: function () {
		//if(!$("#video-box").hasClass('videotop')){
			if(!$('#doc_big').hasClass('on')){
				setTimeout(function(){
					if($("#video-box")[0]){
						$("#video-box").removeClass('video_fullscreen');
					}else{
						$('#topHalf').css('position','relative');
						$("#doc-box").removeClass('video_fullscreen');
						resetPanzoom();
					}
				},0);
			}
			if($('.slider-ft').hasClass('show')){
				$('.slider-ft').css('visibility','visible')
			}
			
		//}
	},
    videoOutside : function(b){
        if(b){
            $('#video-box').addClass('videotop');
        }else{
            $('#video-box').removeClass('videotop');
        }
    },
    isiPhone : function(){
        return /iphone/i.test(navigator.userAgent)
    },
    isUcOrQqBrowser : function(){
        return /ucbrowser/i.test(navigator.userAgent) || /mqqbrowser/i.test(navigator.userAgent);
    },
	isUcBrowser : function(){
        return /ucbrowser/i.test(navigator.userAgent);
    },
    isPortrait : function(){
		if(window.orientation==0 && window.innerWidth>window.innerHeight){
        	return false;
		}else{
			return window.orientation==180||window.orientation==0||window.orientation==undefined;
		}
    },
	getVideoTop : function(){
		var t=0;
		if(/MicroMessenger/i.test(navigator.userAgent)){
			t=42;
		}else if(/CriOS/i.test(navigator.userAgent)){
			t=44;
		}
		return t;
	},
	hidenCover:function(){
		if(!$('#rollcall-box').hasClass('on') && !$('#lottery-dialog').hasClass('on') && !$('#card_box').hasClass('on') && !$('#net_box').hasClass('on') && !$('#hongbao_box').hasClass('on') && !$('#dashang_box').hasClass('on')){
			$('#coverLayer').fadeOut(function(){$(this).css({opacity:1,display:'none'});});
		}
	},
	videoShow:function(){
		if($('#video-box')[0] && $('#video-box').hasClass('videotop') && $('#freeVotePopup').css('display')=='none' && $('#survey_stat').css('display')=='none' && !$('#rollcall-box').hasClass('on') && !$('#lottery-dialog').hasClass('on') && !$('#doc_big').hasClass('on') && !$('#card_box').hasClass('on') && !$('#net_box').hasClass('on')  && !$('#hongbao_box').hasClass('on') && !$('#dashang_box').hasClass('vout')){
			$('#video-box').removeClass('videotop');
			$('.video-box').css('clear','none');
			setTimeout(function(){$('.video-box').css('clear','both');},1000);
		}
	},
	toolboxHide:function(){
		if($('#tool_box').hasClass('on')){
			$('#tool_a').removeClass('on');
			jQuery('#tool_box').fadeOut(function(){
				jQuery('#tool_box').removeClass('on');
				if($('#app_tips')[0] && $('#app_tips').attr('data-show')==0){
					$('#app_tips').attr('data-show',1);
					$('#app_tips').fadeIn();
					setTimeout(function(){
						$('#app_tips').fadeOut();
					},5000);
				}
			});
			/*
			jQuery('#tool_box').show().animate({'top':"-120px"},{
				easing: 'easeInQuad',
				duration: 500,
				complete:function(){
					jQuery('#tool_box').hide();
					jQuery('#tool_box').removeClass('on');
					//GsPlayer.videoShow();
					//GsPlayer.hidenCover();
					if($('#app_tips')[0] && $('#app_tips').attr('data-show')==0){
						$('#app_tips').attr('data-show',1);
						$('#app_tips').fadeIn();
						setTimeout(function(){
							$('#app_tips').fadeOut();
						},5000);
					}
				}
			});
			*/
		}
		if($('#dashang_box').hasClass('on')){
			$(".daShang_detail").removeClass("daShang_detail_animat");
			$('#dashang_box').removeClass('on');
			if($('#gs_ds_money_type').val()==1){
				$('#gs_ds_imoney')[0].blur();
			}
		}
	}
};

var change_css_time;
$(function () {
	//var winWidth = (window.innerWidth > 0) ? window.innerWidth : screen.width;
	//$('.toolset').append(" kk "+ winWidth+" ");
	//var winHeight = (window.innerHeight > 0) ? window.innerHeight : screen.height;
	//$('.toolset').append(" hh "+ winHeight+" ");

	/*if($(window).scrollTop()!=0){
		$(window).scrollTop(0);
	}*/
	if($(window).scrollLeft()!=0){
		$(window).scrollLeft(0);
	}
	
	
    //if(GsPlayer.isiPhone()){
        //GsPlayer.init();
   // }else{
        setTimeout(function(){
            GsPlayer.init();
        },500);
   // }

	/*$(window).on('scroll',function(){
		if($(window).scrollTop()!=0){
			$(window).scrollTop(0);
		}
	})*/
	/*setInterval(function(){
        if(GsPlayer.isiPhone()){
            //iOS滚动条失效bugfix
            GsPlayer.listenScroll();
        }else{
            //部分安卓手机滚动条失效bugfix
            $(".slider-bd,.popup-main").append("<div class='fixAndroidScrollBugDiv'></div>");
            setTimeout(function(){
                $(".fixAndroidScrollBugDiv").remove();
            },50);
        }

    },150);*/
	$(document.body).bind("click", function (e) {
		var target = $(e.target);
		if (target.closest("#phizBox").length == 0) {
			closePhizBox();
		}

	});
	$('#tool_box ul').append('<li class="flex css" id="change_css"><a href="javascript:void(0)" class="change_css"><i></i><span>'+(typeof tmpBlackWhite !== "undefined" && tmpBlackWhite=='white'?i18n("player.css.yejian"):i18n("player.css.baitian"))+'</span></a></li>');
	//$('<div class="change_css"><a href="javascript:void(0);"><i></i></a></div>').insertAfter(".tabs");
	if($('.slider-ft')[0] && appDownload=="true"){
		$('.live_tabs').append('<div class="app_area"><a href="'+appDownloadUrl+'">'+i18n("player.app.down")+'</a><p class="border-box" id="app_tips" data-show="0">'+i18n("player.app.tips")+'<i></i></p></div>');
	}
	
	if($('.slider-ft')[0] && customerBtnEnabled=="true"){
		$('.live_tabs').append('<div class="app_area"  style="background-color:transparent;"><a href="'+customerBtnUrl+'" style="width: 55px; height: 25px; overflow: hidden;display:block;background-color:transparent;"><img src="'+customerBtnSrc+'" style="width: 100%; height: 100%;"></a></div>');
//		$('.live_tabs').append('<div class="app_area" style="background-color:transparent;background-image: url('+customerBtnSrc+');"><a style="background-color:transparent;" href="'+customerBtnUrl+'"></a></div>');
	}
	
	if($('.tabs li').length==1){
		$('.tabs li a').css({'text-align':'left','padding-left':'20px'});
	}
	
	$('#tool_box ul').on('tap','#change_css',function(){
		if(change_css_time){
			clearTimeout(change_css_time);
		}
		var url=$('#cssfile').attr('href');
		if($('#whitecss').length==0){
			$("<link>")
			.attr({
				id: "whitecss",
				rel: "stylesheet",
				type: "text/css",
				href: url.replace('/live_black.','/live_white.')
			}).appendTo("head");
			$('.chat-container').css('background-color','#f0f0f0');
			
			change_css_time=setTimeout(function(){
				$('.chat-container').css('background-color','#f0f0f0');
				
			},1000);
			$('#change_css a span').html(i18n("player.css.yejian"));
		}else{
			$('#whitecss').remove();
			$('.chat-container').css('background-color','#1b1b1c');
			
			change_css_time=setTimeout(function(){
				$('.chat-container').css('background-color','#1b1b1c');
				
			},1000);
			$('#change_css a span').html(i18n("player.css.baitian"));
		}
		$('#tool_box a.close').trigger('tap');
	});
	
	$('#tool_a').on('tap',function(){
		if(!$(this).hasClass('on')){
			$(this).addClass('on');
			if($('.audiotips')[0] && $('.audiotips').css('display')!='none'){
				if(audiotipstime){
					clearTimeout(audiotipstime);
				}
				$('.audiotips').fadeOut();
				
			}
			jQuery('#tool_box').fadeIn(function(){
				jQuery('#tool_box').addClass('on');
			});
		}else{
			$(this).removeClass('on');
			jQuery('#tool_box').fadeOut(function(){
				jQuery('#tool_box').removeClass('on');
				if($('#app_tips')[0] && $('#app_tips').attr('data-show')==0){
					$('#app_tips').attr('data-show',1);
					$('#app_tips').fadeIn();
					setTimeout(function(){
						$('#app_tips').fadeOut();
					},5000);
				}
			});
		}
	});
	
	$('#tool_box').on('tap',function(){
		$('#tool_a').removeClass('on');
		jQuery('#tool_box').fadeOut(function(){
			jQuery('#tool_box').removeClass('on');
			if($('#app_tips')[0] && $('#app_tips').attr('data-show')==0){
				$('#app_tips').attr('data-show',1);
				$('#app_tips').fadeIn();
				setTimeout(function(){
					$('#app_tips').fadeOut();
				},5000);
			}
		});
			/*
		jQuery('#tool_box').show().animate({'top':"-120px"},{
			easing: 'easeInQuad',
			duration: 500,
			complete:function(){
				jQuery('#tool_box').hide();
				jQuery('#tool_box').removeClass('on');
				GsPlayer.videoShow();
				GsPlayer.hidenCover();
				if($('#app_tips')[0] && $('#app_tips').attr('data-show')==0){
					$('#app_tips').attr('data-show',1);
					$('#app_tips').fadeIn();
					setTimeout(function(){
						$('#app_tips').fadeOut();
					},5000);
				}
			}
		});
		*/
	});
	
});

function nodoc(){
	$('.section-top').remove();
	$('#doc-tab').remove();
	$('.tabs li').eq(0).addClass('on');
	$('.slider-ft').css('visibility','visible').addClass('show');
	touchpanzoom();
}
function novideo(){
	var p='<div class="video_buttom doc_buttom fastclick"><a id="playBtn"><div class="video_img_c"><div class="video_img_i"><i class="triangle_button"></i></div></div></a></div>';
	//$('#video-box').remove();
	//$('#topHalf').html($('.section-top').html());
	if($('#audio_area')[0]){
		$('#topHalf').css('position','relative').append('<div id="ctrlbar-box" class="ctrlbar display-box"><div class="ctrl-left"><a id="ctrlPlayBtn" href="javascript:;" class="ctrl-play border-box"></a></div><div class="ctrl-center flex"><div id="ctrlSlider" class="ctrl-slider"><div id="gs-ctrlbar-buffer" class="ctrl-buffer" style="width:0%;"></div></div></div><div class="ctrl-right"><em id="gs-ctrlbar-curtime" class="ctrl-cur-time">00:00</em>/<em id="gs-ctrlbar-duration" class="ctrl-end-time">00:00</em></div></div>').append(p);
	
	}else{
		$('#doc-box').append(p);
	}
	//$('.section-top').remove();
	//$('#doc-tab').remove();
	$('.tabs li').eq(0).addClass('on');
	if($('.tabs li').eq(0).hasClass('onchat') || $('.tabs li').eq(0).hasClass('onqa') && $('.slider-ft')[0]){
		$('.slider-ft').css('visibility','visible').addClass('show');
	}
	if(GsPlayer.isPortrait()){
		$('#topHalf').css('position','relative');
		$('.document-container').height($('#topHalf').height()).css({"line-height":$('#topHalf').height()+'px','width':'100%'});
	}else{
		$('#topHalf').css('position','static');
		$("#doc-box").css({"line-height":GsPlayer.winHeight+'px','width':'100%','height':'100%'}).addClass('video_fullscreen');
	}
	
	touchpanzoom();
}
//文档提示
function doctextshan(){
	if(!$('#doc-tab').hasClass('on')){
		$('#doc-tab span').addClass('doctextshan');
		setTimeout(function(){$('#doc-tab span').removeClass('doctextshan');},2500);
	}
}

//聊天禁言
function chat_gag(){
	$('#is_chat_gag').val(1);
	if(gag_t_s==1){
		$('.gag-tips').show();
	}
	/*if($('.onchat').hasClass('on')){
		$('.chat_input_area').addClass('chat_gag');
		$('#chat-textarea').html(i18n("user.status.muteallchat")).prop('contenteditable',false);
	}*/
	
}
//聊天解禁
function chat_gag_off(){
	$('#is_chat_gag').val(0);
	/*if($('.onchat').hasClass('on')){
		$('.chat_input_area').removeClass('chat_gag');
		$('#chat-textarea').html('').prop('contenteditable',true);
	}*/
	
}
//聊天禁言移除
function chat_gag_remove(){
	if($('.gag-tips').css('display')!='none'){
		$('.gag-tips').hide();
		//gag_t_s=0;
	}
	/*$('.chat_input_area').removeClass('chat_gag');
	$('#chat-textarea').html('').prop('contenteditable',true);*/
}
//禁止问答
function qa_gag(){
	$('#is_qa_gag').val(1);
	if($('.onqa').hasClass('on')){
		$('.chat_input_area').addClass('qa_gag');
		$('#chat-textarea').html(i18n("user.status.muteallqa")).prop('contenteditable',false);
	}
	
}
//聊天解禁
function qa_gag_off(){
	$('#is_qa_gag').val(0);
	if($('.onqa').hasClass('on')){
		$('.chat_input_area').removeClass('qa_gag');
		$('#chat-textarea').html('').prop('contenteditable',true);
	}
	
}
//聊天禁言移除
function qa_gag_remove(){
	$('.chat_input_area').removeClass('qa_gag');
	$('#chat-textarea').html('').prop('contenteditable',true);
}


function phizBoxtoggle(){
	var phizBox = $("#phizBox");
	if (phizBox.hasClass("phiz-box-open")) {
		closePhizBox();
		
	} else {
		openPhizBox();
	}
}

function checkQuoteLength() {
	var $quote = $(".qa-quote");
	$quote.each(function () {
		var quoteAnswerLength = $(this).children("dd.a").length;
		var $moreBtn = $(this).children(".quote-more");
		if (quoteAnswerLength > 0) {
			$moreBtn.css('display','block');
		}
	});
}

function toggleQuote(t) {
	var $btn = $(t);
	var $quoteAnswerItem = $btn.siblings("dd.a");
	if ($btn.hasClass("quote-unfold")) {
		$quoteAnswerItem.hide();
		$btn.removeClass("quote-unfold");
	} else {
		$quoteAnswerItem.css('display','block');
		$btn.addClass("quote-unfold");
	}

}

//打开表情
function openPhizBox() {
	$("#phizBox").css('display','block');
	$("#phizBox").addClass("phiz-box-open");
	$('#phizBtn').addClass('btn-phiz-on');
}
//关闭表情
function closePhizBox() {
	$("#phizBox").hide();
	$("#phizBox").removeClass("phiz-box-open");
	$('#phizBtn').removeClass('btn-phiz-on');
	
}

function touchpanzoom(){
	TouchSlide({
		slideCell: "#chatQaBox",
		titCell: ".tabs li",
		mainCell: ".slider-container",
		defaultIndex: window.tabDefaultIndex,
		startFun:function(i,c){
			if($('#textarea-box')[0]){
				if($('.tabs li').eq(i).hasClass('onchat') || $('.tabs li').eq(i).hasClass('onqa')){
					$('.slider-ft').css('visibility','visible').addClass('show');
				}else{
					//$('#gs-doc').panzoom("enable");
					$('.slider-ft').css('visibility','hidden').removeClass('show');
				}
				if($('.slider-ft').hasClass('ontop')){
					//$('#video-box').removeClass('videotop');
					phizBoxtoggle();
					$('.slider-ft').removeClass('ontop');
					if ($("#phizBtn").hasClass("btn-phiz-on")) {
						closePhizBox();
					}
					GsPlayer.videoShow();
					
					$('.chat-edit-area').removeClass('chat-edit-on');
				}
			}
		},
		endFun:function(i,c){
			
			if($('#textarea-box')[0]){
				//if(window.webPriChat !== false){
					if($('.tabs li').eq(i).hasClass('onchat')){
						if(chatnamequeue.GetSize()>0){
							chatprivatename();
						}
						/*if(typeof ds_load_move === "function"){
							ds_load_move();
						}*/
					}else if(chatnamequeue_time){
						$('#private_msg').html('').hide();
						clearTimeout(chatnamequeue_time);
						chatnamequeue_time='';
					}
				//}
				if($('.tabs li').eq(i).hasClass('onqa')){
					console.log(qanamequeue);
					//$('.toolset').append(" L"+qanamequeue.GetSize()+" ");
					if(qanamequeue.GetSize()>0){
						qaprivatename();
					}
				}else if(qanamequeue_time){
					$('#qaname_msg').html('').hide();
					clearTimeout(qanamequeue_time);
					qanamequeue_time='';
				}
				if($('.tabs li').eq(i).hasClass('onchat')){
					$('.slider-ft').attr('data-type','chat');
					if($('#is_chat_gag').val()==0 && $('#is_qa_gag').val()==1){
						qa_gag_remove();
					}else if($('#is_chat_gag').val()==1 && $('#is_qa_gag').val()==1){
						qa_gag_remove();
						chat_gag();
					}else if($('#is_chat_gag').val()==1 && $('#is_qa_gag').val()==0 && !$('.chat_input_area').hasClass('chat_gag')){
						chat_gag();
					}
					$('#phizBtn').css('display','block');
					$('#chat-textarea').removeClass('chat-edit-qa').css('width',(GsPlayer.winWidth-52-55-10-38)+'px');
					if($(".chat-bd").hasClass('show-mine') && !$("#chatSelector").hasClass('checked')){
						$("#chatSelector").addClass('checked');
					}else if(!$(".chat-bd").hasClass('show-mine') && $("#chatSelector").hasClass('checked')){
						$("#chatSelector").removeClass('checked');
					}
				}else if($('.tabs li').eq(i).hasClass('onqa')){
					$('.slider-ft').attr('data-type','qa');
					if($('#is_chat_gag').val()==1 && $('#is_qa_gag').val()==0){
						chat_gag_remove();
					}else if($('#is_chat_gag').val()==1 && $('#is_qa_gag').val()==1){
						chat_gag_remove();
						qa_gag();
					}else if($('#is_chat_gag').val()==0 && $('#is_qa_gag').val()==1 && !$('.chat_input_area').hasClass('qa_gag')){
						qa_gag();
					}
					$('#phizBtn').hide();
					$('#chat-textarea').addClass('chat-edit-qa').css('width',(GsPlayer.winWidth-52-55-10)+'px');
					if($("#chat-textarea")[0]){
						$("#chat-textarea").html(getquestion());
						var h=$("#chat-textarea").height();
						$('.slider-ft').height(h+30);
						$('#btn-chat-submit').css('padding-bottom',(h-20)+"px");
						removechatediton();
					}
					
					if($(".qa_list_content").hasClass('show-mine') && !$("#chatSelector").hasClass('checked')){
						$("#chatSelector").addClass('checked');
					}else if(!$(".qa_list_content").hasClass('show-mine') && $("#chatSelector").hasClass('checked')){
						$("#chatSelector").removeClass('checked');
					}
				}else{
					$('.slider-ft').removeAttr('data-type');
				}
				if($('.qa_list_content').find('li').length>0){
					jQuery('.qa_list_content ul').scrollTo();
				}
				if($('.chat-bd').find('li').length>0){
					jQuery('.chat-bd ul').scrollTo();
				}
			}
		}
	});
	//panzoom();
	$('#qa-msg-list').on('tap','li .qa_answer .qa_answer_question .gs_bg_plus',function() {//问答展现
		var that=this;
		if($(that).hasClass('zhuan')){
			$(that).removeClass('zhuan');
			$(that).parent().find('p').removeClass('show');
			//jQuery("#qa-msg-list").scrollTo();
		}else{
			$(that).addClass('zhuan');
			$(that).parent().find('p').addClass('show');
			var length=$(that).parents('ul').find('li').length;
			var index=$(that).parents('li').index();
			if(index==length-1){
				jQuery("#qa-msg-list").scrollTo();
			}
			//jQuery("#qa-msg-list").scrollTo();
		}
	});
	/*$('#qa-msg-list').on('tap','li .gs_bg_plus',function() {//问答展现
		var that=this;
		if($(that).parent('li').hasClass('on')){
			jQuery(that).parent('li').find('.qa_issue_bottom').stop(true,true).slideUp(function(){
				$(that).parent('li').removeClass('on');
			});
		}else{
			$(that).parent('li').addClass('on');
			jQuery(that).parent('li').find('.qa_issue_bottom').stop(true,true).slideDown(function(){
				var length=$(this).parents('ul').find('li').length;
				var index=$(this).parent('li').index();
				console.log(length+" "+index);
				if(index==length-1){
					jQuery("#qa-msg-list").scrollTo();
				}
			});
		}
	});*/
	//if(window.webPriChat !== false){
		$('#chat-msg-list').on('click','li.privatechat',function(e){//私聊
			if($(e.target).closest('.msg-url').length==0){
			jQuery('#coverLayerempty2').fadeIn();
			$('.slider-ft').attr('data-type','private');
			var uch=0;
			if(GsPlayer.isUcBrowser()){
				uch=44;
			}
			var talkerid=$(this).attr('data-talkerid');
			var alkername=$(this).find('em').text();
			var role=($(this).hasClass('gs_organizer')?1:0);
			
			creatPrivateBox(talkerid,alkername);
			
			if($('#private_msg').css('display')!='none' && alkername==$('#private_msg em').text()){
				
				$('#private_msg').fadeOut();
			}

			$('.slider-ft').attr('data-talkerid',talkerid).attr('data-alkername',alkername).attr('data-role',role);
			
			jQuery('#private_'+talkerid).height(GsPlayer.chatQaHeight()+$('.tabs').height()-uch).css('display','block').stop(true,true).animate({'top':'0px'},500,function(){});
			$('#private_'+talkerid).find('.private_chat').height($('#private_'+talkerid).height()-$('#private_'+talkerid).find('.private_name').height());
			$('.slider-ft').addClass('onprivate');
			jQuery('#private_'+talkerid).find('.private_chat_content').scrollTo();
			}
			//$('#private_msg').insertBefore('');
		});
		$('#private_chat_box').on('tap','.private_chat_c .private_name a',function(){//关闭私聊
			var that=this;
			console.log('关闭私聊');
			setTimeout(function(){
				$('.slider-ft').removeAttr('data-talkerid').removeAttr('data-alkername');
				
				jQuery(that).parents('.private_chat_c').stop(true,true).animate({'top':'100%'},500,function(){
					$(this).hide();
					jQuery('#coverLayerempty2').fadeOut(500);
				});
				
				$('.slider-ft').removeClass('onprivate');
				$('.slider-ft').attr('data-type','chat');
				//直接到底部
				jQuery('.chat-bd ul').scrollTo({
					to : "tobottom"
				});
				chatprivatename();//关闭私聊继续显示其他提示
				setTimeout(function(){
				var st=$(window).scrollTop();
				console.log("scrollTopccc:"+st);
				if(st>0 && st<20){
					$(window).scrollTop(0);
				}
				},300);
			},350);
		});
		/*$("#chat-msg-list").bind("click", function(evt){
			var ele = evt.target;
			if($(ele).is(".user-name")){
				var uname = $(ele).text();
				var uid = $(ele).attr("uid");
				if(uid){
					appendTalkerOnNeed({id:uid, name:uname});
					changeTalker({talkerId:uid, talkerName:uname});
				}
			}
		});*/
	//}
}


function doc_bar_height(){
	if($('#doc-box')[0]){
	var w_h=$('#doc-box').height();
	if(jQuery('#gs-doc').parent().hasClass('canvas-container')){
		var d_h=$('#gs-doc').parent('.canvas-container').height();
	}else{
		var d_h=$('#gs-doc').height();
	}
	//console.log(w_h,d_h);
	if(d_h>w_h){
		$('.doc_bar').height(parseInt((w_h/d_h)*w_h));
	}else{
		$('.doc_bar').height(0);
	}
	if(jQuery('#gs-doc').parent().hasClass('canvas-container')){
		var tf=$('#gs-doc').parent('.canvas-container').css('transform')?$('#gs-doc').parent('.canvas-container').css('transform'):$('#gs-doc').parent('.canvas-container').css('-webkit-transform');
	}else{
		var tf=$('#gs-doc').css('transform')?$('#gs-doc').css('transform'):$('#gs-doc').css('-webkit-transform');
	}
	var d_top_arr=tf.replace('matrix(','').replace(')','').split(",");
	var d_top=d_top_arr[5];
	
	var s=d_top_arr[3];
	if(s==1 && d_top==0){
		if(jQuery('#gs-doc').parent().hasClass('canvas-container')){
			$('#gs-doc').parent('.canvas-container').attr('data-h',w_h-d_h);
		}else{
			$('#gs-doc').attr('data-h',w_h-d_h);
		}
	}
	if(s==1){
		d_top=d_top>0?'-'+d_top:d_top.replace('-','');
		
		d_top=Number(d_top)*s;
		
		var t=d_top/d_h;
		var top=t*w_h;
	}else{
		if(jQuery('#gs-doc').parent().hasClass('canvas-container')){
			var d_t=(d_h-w_h+parseInt($('#gs-doc').parent('.canvas-container').attr('data-h')))/2;
		}else{
			var d_t=(d_h-w_h+parseInt($('#gs-doc').attr('data-h')))/2;
		}
		var d_top2=d_t-d_top;
		var t=d_top2/d_h;
		var top=t*w_h;
	}
	top=top<5?0:top;
	$('.doc_bar').animate({'top':top+'px'},100);
	}
}

//(function ($, undefined) {
	$(function () {
		setTimeout(function(){
			var $panzoom;
			var oldx=0;
			var oldy=0;
			var touchendlength =0;
			if($('#gs-doc')[0]){
				//console.log("ppp");
				$panzoom=jQuery('#gs-doc').panzoom({
					startTransform: 'scale(1)',
					increment: 1,
					minScale: 1,
					contain: 'invert'
				});
				/*jQuery('#gs-doc').on('dblclick',function(){
					resetPanzoom();
				});*/
				doc_bar_height();
				if($('#doc-tab')[0]){
					//console.log("ppp33333");
					$panzoom.on('panzoomstart', function(e, panzoom, event, touches) {
						//console.log(touches);
						oldx=touches[0].clientX;
						oldy=touches[0].clientY;
						touchendlength=touches.length;
					})
					//$panzoom.on('panzoompan', function(e, panzoom, x, y) {
						//console.log(x, y);
						//$('#doc-box').scrollTop(y);
					//});
					$panzoom.on('panzoomend', function(e, panzoom, matrix, changed) {
						//console.log(e);
						//console.log(panzoom);
						//$('.toolset').append(" kk "+matrix+" ");
						console.log(matrix[0]);
						//var m=matrix.split(",");
						var index;
						if (changed) {
							doc_bar_height();
							if(e.changedTouches[0].pageX+100<oldx && touchendlength==1 && matrix[0]==1){//&& !$('#doc_big').hasClass('on')
			
								index=$("#chatQaBox .tabs li.ondoc").index();
								if(index<$("#chatQaBox .tabs li").length-1){
									$("#chatQaBox .tabs li").eq(index+1).trigger('click'); 
								}
			
							}else if(e.changedTouches[0].pageX-100>oldx && touchendlength==1 && matrix[0]==1){
								index=$("#chatQaBox .tabs li.ondoc").index();
								if(index>0){
									$("#chatQaBox .tabs li").eq(index-1).trigger('click'); 
								}
							}
						} else {
							console.log(e.changedTouches[0].pageX,oldx,touchendlength);
							if(e.changedTouches[0].pageX+100<oldx && touchendlength==1 && matrix[0]==1){//&& !$('#doc_big').hasClass('on')
								index=$("#chatQaBox .tabs li.ondoc").index();
								if(index<$("#chatQaBox .tabs li").length-1){
									$("#chatQaBox .tabs li").eq(index+1).trigger('click'); 
								}
							}else if(e.changedTouches[0].pageX-100>oldx && touchendlength==1 && matrix[0]==1){
								index=$("#chatQaBox .tabs li.ondoc").index();
								if(index>0){
									$("#chatQaBox .tabs li").eq(index-1).trigger('click'); 
								}
							}
						}
						if(GsPlayer.isPortrait()){
							if($('#doc_big').css('display')=='none'){
								$('#doc_big').fadeIn();
							}else{
								$('#doc_big').fadeOut();
							}
						}
					});
				}else{
					$panzoom.on('panzoomend', function(e, panzoom, matrix, changed) {
						if (changed) {
							doc_bar_height();
							if($('#audio_area')[0]){
								if($('#ctrlbar-box').css('visibility')=='hidden'){
									$('#ctrlbar-box').css('visibility','visible');
								}
							}
						}else{
							if($('#audio_area')[0]){
								if($('#ctrlbar-box').css('visibility')!='hidden'){
									$('#ctrlbar-box').css('visibility','hidden');
								}else{
									$('#ctrlbar-box').css('visibility','visible');
								}
							}
						}
						if(GsPlayer.isPortrait()){
							if($('#doc_big').css('display')=='none'){
								$('#doc_big').fadeIn();
							}else{
								$('#doc_big').fadeOut();
							}
						}
					});
				}
			}
			$('#doc_big').on('tap',function(){
				var that=this;
				if(GsPlayer.isPortrait()){
					if(!$(that).hasClass('on')){
						$(that).addClass('on');
						if($('#video-box')[0]){
							$('#video-box').addClass('videotop');
						}

						jQuery('#doc-box').insertBefore('#coverLayer');
						if($('#doc-tab')[0]){
							jQuery('.section-top').append('<div id="doc-tmp"></div>');
							jQuery('#doc-box').css({
							'position':'absolute',
							'z-index':501,
							'bottom':0,
							'top':'auto',
							'left':0
							}).animate({
							height:GsPlayer.winHeight+'px',
							width:GsPlayer.winWidth+'px',
							'line-height':GsPlayer.winHeight+'px'
							},500,function(){jQuery('#doc-box').css({'top':'0','bottom':'0','height':'auto'});resetPanzoom();});
						}else{
							jQuery('#topHalf').append('<div id="doc-tmp"></div>');
							jQuery('#doc-box').css({
							'position':'absolute',
							'z-index':501,
							'top':0,
							'left':0
							}).animate({
							height:GsPlayer.winHeight+'px',
							width:GsPlayer.winWidth+'px',
							'line-height':GsPlayer.winHeight+'px'
							},300,function(){resetPanzoom();});
						}
						
						//$('#coverLayer').fadeIn();	
					}else{
						
						$(that).removeClass('on');
						GsPlayer.videoShow();
						var hdoc;
						if($('#doc-tab')[0]){
							var headerHeight = 30;
							if($(".toolbar").hasClass('status_bar_p')){
								headerHeight = 0;
							}
							if(jQuery('#gs-doc').parent().hasClass('canvas-container')){
								jQuery('.canvas-container').css({
								'transform':'matrix(1, 0, 0, 1, 0, 0)'
								});
							}
							var tabsHeight=$('.tabs').height();
							var h=GsPlayer.winHeight-headerHeight-GsPlayer.topHalfHeight()-tabsHeight;
							hdoc=h;
							jQuery('#doc-box').css({'top':'auto','bottom':'0','height':GsPlayer.winHeight+'px'});
							jQuery('#doc-box').animate({
							height:hdoc+'px',
							width:GsPlayer.winWidth+'px',
							'line-height':hdoc+'px'
							},500,function(){
								jQuery('#doc-box').css({'position':'relative','z-index':395});
								jQuery('#doc-box').insertBefore('#doc-tmp');
								$('#doc-tmp').remove();
								resetPanzoom();
							});
							/*jQuery('#doc-box').css({
								'position':'relative',
								height:hdoc+'px',
								width:'100%',
								'line-height':hdoc+'px'
							});
							resetPanzoom();*/
						}else{
							jQuery('#doc-box').insertBefore('#doc-tmp');
							$('#doc-tmp').remove();
							hdoc=$("#topHalf").height();
							if(jQuery('#gs-doc').parent().hasClass('canvas-container')){
								jQuery('.canvas-container').css({
								'transform':'matrix(1, 0, 0, 1, 0, 0)'
								});
							}
							jQuery('#doc-box').animate({
							height:hdoc+'px',
							'top':'0px',
							width:'100%',
							'line-height':hdoc+'px'
							},500,function(){
								resetPanzoom();
								jQuery('#doc-box').css({'z-index':395});
								if($('.slider-ft')[0]){
									if($('.onchat').hasClass('on')){
										chatprivatename();
									}else if($('.onqa').hasClass('on')){
										qaprivatename();
									}
								}
							});
						}
						//GsPlayer.hidenCover();
						//$('#coverLayer').fadeOut();
					}
				}
			});
		},0);
	});
//})(jQuery);
function resetPanzoom(){
	if($('#gs-doc')[0]){
	if(jQuery('#gs-doc').parent().hasClass('canvas-container')){
		if(typeof pptLive !== "undefined"){
			pptLive.recordCanvas(pptLive.now_page_data);
		}else if(typeof pptRecord !== "undefined"){
			pptRecord.recordCanvas(pptRecord.now_page_id);
		}
		$panzoom.panzoom("resetDimensions");
    	$panzoom.panzoom("reset");
		setTimeout(function(){
		var h=$('.canvas-container').height();
		$('#floater-doc').css('margin-bottom',"-"+(h/2)+"px");
		},500);
		$('.canvas-container').css('clear','both');
		
		$('#doc-box').width(GsPlayer.winWidth);
		/*console.log("画布高度");
		console.log(h,$('#doc-box').height());
		if(h<$('#doc-box').height()){
			var t=($('#doc-box').height()-h)/2;
			//jQuery('#gs-doc').parent('.canvas-container').panzoom("setMatrix", [ 1, 0, 0, 1, 0, t ]);
			//$('.canvas-container').css('transform','matrix(1, 0, 0, 1, 0, '+t+')');
			//$panzoom.panzoom("setTransform", 'matrix(1, 0, 0, 1, 0, '+t+')');
		}*/
		
	}else{
    	jQuery('#gs-doc').panzoom("resetDimensions");
    	jQuery('#gs-doc').panzoom("reset");
	}
	doc_bar_height();
	if(!GsPlayer.isPortrait() && $('#doc_big')[0] && $('#doc_big').css('display')!='none'){
		$('#doc_big').hide();
	}
	}
}

function bodyRollEvent(){
	//$('.toolset').append( " bbb ");
    GsPlayer.init();
}

function createOrientationChangeProxy(fn, scope) {  
    return function() {  
 
        clearTimeout(scope.orientationChangedTimeout);  
        var args = Array.prototype.slice.call(arguments, 0);  
        scope.orientationChangedTimeout = setTimeout($.proxy(function() {  
 
            var ori = window.orientation;  
            if (ori != scope.lastOrientation) {  
                fn.apply(scope, args); // 这里才是真正执行回调函数  
            }  
            scope.lastOrientation = ori;  
        }, scope), 500);  
    };  
}
function bodyOrientationChange(){
	setTimeout(function(){
	bodyRollEvent();
	if($('#doc_big')[0]){
		if($('#doc_big').hasClass('on')){
			jQuery('#doc-box').animate({
			height:GsPlayer.winHeight+'px',
			width:GsPlayer.winWidth+'px',
			'line-height':GsPlayer.winHeight+'px'
			},100,function(){jQuery('#doc-box').css({'top':'0','bottom':'0','height':'auto'});resetPanzoom();});
		}else{
		resetPanzoom();
		}
		
	}else{
	resetPanzoom();
	}
	},0);
}
window.addEventListener("onorientationchange" in window ? "orientationchange" : "resize", createOrientationChangeProxy(function() {  
	bodyOrientationChange();
}, window), false);
if(top.location != location && !GsPlayer.isiPhone() && (/mqqbrowser/i.test(navigator.userAgent) || /tbs/i.test(navigator.userAgent) || /qq/i.test(navigator.userAgent) || /MicroMessenger/i.test(navigator.userAgent))){//iframe 安卓 微信或者qq横竖屏操作
	window.onhashchange=function(){
		var hashStr = location.hash.replace("#","");
		//$('.toolset').append(" hashStr "+hashStr);
		bodyOrientationChange();
	};
}
$(function(){
	window.onhashchange=function(){
		var hashStr = location.hash.replace("#","");
		//$('.toolset').append(" hashStr "+hashStr);
		console.log("hashStr "+hashStr);
		if(top.location != location && GsPlayer.isPortrait()){
			if(hashStr=="gs_video_go"){
				if($('#video-box')[0] && !$('#video-box').hasClass('videotop')){
					$('#video-box').addClass('videotop');
					$('.video-box').css('clear','none');
					setTimeout(function(){$('.video-box').css('clear','both');},1000);
				}
			}else if(hashStr=="gs_video_back"){
				if($('#video-box')[0] && $('#video-box').hasClass('videotop')){
					$('#video-box').removeClass('videotop');
					$('.video-box').css('clear','none');
					setTimeout(function(){$('.video-box').css('clear','both');},1000);
				}
			}
		}
	};
    var selScrollable = '.allow-roll';
	
    bodyRollEvent();
	
	$(document).bind('touchmove',function(e){
        e.preventDefault();
    });
	//var ochangetime;
    /*window.addEventListener("orientationchange",function(){
		//if(ochangetime){
			//clearTimeout(chatInputTime);
		//}
        if(GsPlayer.isiPhone()){
			//$('.status_bar_s span').css('display','none');
            setTimeout(function(){
				//$('.toolset').append( " ooo ");
				bodyRollEvent();
				resetPanzoom();
			},500);
        }else{
            //clearTimeout(toolbarHideTime);
            setTimeout(function(){
                bodyRollEvent();
                resetPanzoom();
            },500);
        }
        $(window).scrollTop(0);
    },false);*/
//$(window).resize(function(){
        //if(GsPlayer.isiPhone()){
			//$('.toolset').append( " rrr ");
            //GsPlayer.init();
        //}
    //});
    //$(window).resize(function(){
        //if(GsPlayer.isiPhone()){
			//$('.toolset').append( " rrr ");
            //GsPlayer.init();
        //}
    //});
	
   $('body').on('touchstart', selScrollable, function(e) {
        if (e.currentTarget.scrollTop === 0) {
            e.currentTarget.scrollTop = 1;
        } else if (e.currentTarget.scrollHeight === e.currentTarget.scrollTop + e.currentTarget.offsetHeight) {
            e.currentTarget.scrollTop -= 1;
        }
    });
    $('body').on('touchmove', selScrollable, function(e) {
        if(jQuery(this)[0].scrollHeight > jQuery(this).innerHeight()) {
            e.stopPropagation();
        }
    });
	

});

/**
 * 问答聊天时新内容默认自动滚至底部
 */
;(function(jQuery){
    jQuery.fn.scrollTo = function(options){
        var defaults = {
            to : "bottom",   //"top":滚至顶部,"bottom":滚至底部
            fn : function(){}
        }
        var opts = jQuery.extend({},defaults,options);
        return this.each(function(){
			
            var self = jQuery(this);
			//console.log(self);
            var parent = self.parent();
			//console.log(parent);
            var height = self.outerHeight();
			
            var scrollTop = parent.scrollTop();
            var parentHeight = parent.height();
            var scrollHeight = self.outerHeight();
			//console.log(height+" "+scrollTop+" "+parentHeight+" "+scrollHeight+" "+self.find('li').last().outerHeight());
			//console.log(self.attr('id'));
			//console.log(scrollTop+parentHeight,scrollHeight-self.find('li').last().outerHeight()-self.find('li').eq(self.find('li').size()-2).outerHeight());
			if(opts.to=='bottom' && self.attr('id')=='chat-msg-list' && $(".onchat").hasClass('on') && (scrollTop+parentHeight)<(scrollHeight-self.find('li').last().outerHeight()-self.find('li').eq(self.find('li').size()-2).outerHeight())){//不在底部时 不自动去底部
				opts.fn();
			}else{
				if(scrollTop+parentHeight<=scrollHeight){
					opts.fn();
					switch (opts.to){
						case "bottom":
						case "tobottom":
						//console.log('ddd');
							parent.scrollTop(height);
							break;
						case "top":
							parent.scrollTop(0);
							break;
						default :
							console.log(opts.to);
					}
				}else{
					opts.fn();
				}
			}
        });
    };
})(jQuery);
