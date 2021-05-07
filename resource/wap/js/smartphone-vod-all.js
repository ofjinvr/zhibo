/** smartphone-vod.doc.js **/
/*
 * ====================================================
 * 文档
 */
var pptPath = "";

//文档回调处理器（供调度器任务回调）
function pptRelatedInHandler(pptdata){
	//$('.toolset').append(" ppt "+pptdata+" ");
	if(pptdata){
		if($("#gs-doc").css('display')=='none'){
			$("#gs-doc").show();
		}
		console.log("点播ppt",pptdata);
		changeChapter(pptdata.startTime);
		if(pptRecord && pptRecord.is_pptRecord==1){
			console.log(pptRecord);
			console.log("播放",pptRecord);
			//pptRecord.recordDrawTime(parseFloat(pptdata.startTime)*1000);
		}else{
			showPPT(pptdata);
		}
	}else{
		clearPPT();
	}
}
function showPPT(pptdata){
	$("#gs-doc").attr("src", pptPath + pptdata.pptName);
	//$("#gs-doc").css('display','block');
	doctextshan();
    jQuery("#gs-doc").one('load', function() {
        resetPanzoom();
    }).each(function() {
        if(this.complete){jQuery(this).load();doc_bar_height();}
    });
}

//文档回调处理器（供调度器任务回调）
function pptRelatedOutHandler(data){
	clearPPT();
}

function clearPPT(){
	if(!pptRecord && pptRecord.is_pptRecord!=1){
	$("#gs-doc").attr("src","");
	$("#gs-doc").hide();
	}
}

/*
 * 点播
 */
function loadPpts(resPath, data){
	Sch.setType("TYPE_PPT", pptRelatedInHandler, pptRelatedOutHandler, Sch.TASKMODE_SUBSTITUTION);
	pptPath = resPath;
	var datas = data.pageList;
	if(typeof datas !== "undefined" && datas.length>0){
		$('#chapter_empty').hide();
		for(var i in datas){
			var d = datas[i];
			Sch.addTask(new Task("TYPE_PPT", Number(d.startTime), Number(d.endTime), {pptName:d.hls,startTime:d.startTime}));
			loadChapter(d, i);
		}
	}else{
		$('.chapter-hd').hide();
	}
	Sch.createGapTask("TYPE_PPT", 0.5);
	
	$(function(){
		$('#chapter-box').on('click','li',function(){
			if(Media.started){
				var startime=$(this).attr('data-startime');
				if(jQuery('#ctrlSlider')[0]){
					if(window.testInterval){
						clearInterval(window.testInterval);
					}
					jQuery(Media.media).off("timeupdate");
					Media.media.pause();
					jQuery(Media.media).unbind("canplay");
					jQuery(Media.media).unbind('seeked');
					
				}
				if($(".video_loading").length>0){
					$(".video_loading").css('display','block').find('.spinner').html('<div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div>');
				}else{
					$('#video-box').append('<div class="video_loading"><div class="spinner"><div class="rect1"></div><div class="rect2"></div><div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div></div>');
					$(".video_loading").css('display','block');
				}
				jQuery(Media.media).unbind('seeked');
				Media.media.currentTime=startime;
				Media.media.play();
				jQuery(Media.media).bind('seeked',function(){
					$(".video_loading").css('display','none').find('.spinner').html('');
					Media.media.play();
					if (synChat && synChat.issynChat) {
						loadChatsSynClear();
						synChat.getMore(Media.media.currentTime);
					}
					if(jQuery('#ctrlSlider')[0]){
						if(window.testInterval){
							clearInterval(window.testInterval);
						}
						window.testInterval = setInterval(function(){
							jQuery(Media).trigger("timeupdate", jQuery(Media.media)[0].currentTime);
							Scheduler.requestTask(jQuery(Media.media)[0].currentTime);
						},190);
						jQuery(Media).on("timeupdate", function(evt){
							if(parseInt(jQuery(Media.media)[0].currentTime)>0){
								//$('.toolset').append(Media.media.currentTime+" ss ");
								jQuery("#gs-ctrlbar-curtime").text(Util.timeDuration(jQuery(Media.media)[0].currentTime));
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
					}
				});
				//$('.toolset').append( " "+startime+" ");
				$("#chapter-box").find(".current").removeClass("current");
				$(this).addClass("current");
				
				/*if($('#ctrlSlider')[0]){
					$("#gs-ctrlbar-curtime").text(Util.timeDuration(Media.media.currentTime));
					jQuery("#ctrlSlider").slider("value", Util.calcPercent(Media.media.currentTime, Media.duration) );
				}*/
			}
		});
		jQuery(Media).bind("timeupdate", function(evt, second){
			Sch.playback(second, "TYPE_PPT");
			Sch.playback(second, "TYPE_CHAT");
		});
	});
}

function loadChapter(ppt, idx){
	var chapterElem = '<li class="display-box" data-startime="'+(Number(ppt.startTime)==0?'0.01':ppt.startTime)+'" endtime="'+ppt.endTime+'"><div class="sn"><em class="sn-circle">'+(parseInt(idx)+1)+'</em></div>'
		+'<div class="title flex">'+ppt.title+'</div>'
		+'<div class="time">'+Util.timeDuration(ppt.startTime)+'</div></li>';
	$("#chapter-box").append(chapterElem);
}
function accSub(num1,num2){
   var r1,r2,m;
   try{
	   r1 = num1.toString().split('.')[1].length;
   }catch(e){
	   r1 = 0;
   }
   try{
	   r2=num2.toString().split(".")[1].length;
   }catch(e){
	   r2=0;
   }
   m=Math.pow(10,Math.max(r1,r2));
   n=(r1>=r2)?r1:r2;
   return (Math.round(num1*m-num2*m)/m).toFixed(n);
}

//切换章节
function changeChapter(ms){
	if(Util.isEmpty(ms))return;
	$("#chapter-box").find("li").each(function(){
		var endtime = $(this).attr("endtime");
		$("#chapter-box").find(".current").removeClass("current");
		if(Number(endtime) > Number(ms)){
			$(this).addClass("current");
			return false;
		}
	});
}

/** smartphone-vod.chat.js **/
/*
 * 聊天
 */

function loadChats(chats){
	if(chats.list.length>0){
		var txt='';
		for(var i in chats.list){
			var chat = chats.list[i];
			txt+=loadChat({type:"public",talkerId:"", talkerName:chat.sender, msg:chat.content,richtext:chat.richtext, time:chat.time});
		}
		$("#chat-msg-list").append(txt);
	}
	$(".gs-more-msg").remove();
	if(chats.more == "true" || chats.more === true){
		$('<div class="gs-more-msg"><span class="gs-more-msg-t">'+i18n("player.chat.history.more")+'</span></div>').insertAfter("#chat-msg-list");
		$(".gs-more-msg").bind("click", function(){
			getResource("chat", function(data){
				loadChats(data);
			});
		});
	}
	
}
//同步聊天
function loadChatsSyn(chats){
	var txt='';
	if (Number(chats.timestamp) < Number(synChat.lastSeekTime)) {
		return false;
	}
	if ($.isArray(chats.ems)) {
		for ( var i = 0; i < chats.ems.length; i++) {
			txt+=loadChat({type:"public",talkerId:"", talkerName:chats.ems[i].sender, msg:(chats.ems[i].text||htmlfilter(chats.ems[i].richtext)), time:synChat.startTime+Number(chats.timestamp)});
		}
	}else {
		txt =loadChat({type:"public",talkerId:"", talkerName:chats.ems.sender, msg:(chats.ems.text||htmlfilter(chat.ems.richtext)), time:synChat.startTime+Number(chats.timestamp)});
	}
	var tob='';
	if(jQuery('#chat-msg-list').parent().scrollTop()+jQuery('#chat-msg-list').parent().height()>=jQuery('#chat-msg-list').outerHeight() || jQuery('#chat-msg-list').outerHeight()<jQuery('#chat-msg-list').parent().height()){
		tob='tobottom';
	}else{
		tob='bottom';
	}
	$("#chat-msg-list").append(txt);
	jQuery("#chat-msg-list").scrollTo({to : tob,fn : function(){}});
}

function chatMore(flag) {
	$(".gs-more-msg").remove();
	$("#chatTextLoader").remove();
	$(".gs-more-msg").unbind("click");
	if (flag) {
		$('<div class="gs-more-msg"><span class="gs-more-msg-t">'+i18n("player.chat.history.more")+'</span></div>').insertBefore("#chat-msg-list");
		$(".gs-more-msg").bind("click", chatLoadAni);
	}
}

function loadChatsSynPre(chats){
	if (chats.needslice) {
		return false;
	}
	
	if(chats.data.length>0){
		var txt='';
		for(var i in chats.data){
			var chat = chats.data[i].ems;
			if ($.isArray(chat)) {
				for ( var j = 0; j < chat.length; j++) {
					txt+=loadChat({type:"public",talkerId:"", talkerName:chat[j].sender, msg:(chat[j].text||htmlfilter(chat[j].richtext)), time:synChat.startTime+Number(chats.data[i].timestamp)});
				}
			}else {
				txt+=loadChat({type:"public",talkerId:"", talkerName:chat.sender, msg:(chat.text||htmlfilter(chat.richtext)), time:synChat.startTime+Number(chats.data[i].timestamp)});
			}
			
		}
		$("#chatTextLoader").remove();
		$("#chat-msg-list").prepend(txt);
	}else {
		$("#chatTextLoader").remove();
	}
	if(chats.more == "true" || chats.more === true){
		$('<div class="gs-more-msg"><span class="gs-more-msg-t">'+i18n("player.chat.history.more")+'</span></div>').insertBefore("#chat-msg-list");
		$(".gs-more-msg").bind("click", chatLoadAni);
	}
}

function chatLoadAni() {
	$(".gs-more-msg").remove();
	$(".gs-more-msg").unbind("click");
	$('<div class="chatTextLoader" id="chatTextLoader"><div class="ballBeatLoader"><div></div><div></div><div></div></div></div>').insertBefore("#chat-msg-list");
	loadChatsSynPre(synChat.getMoreChat());
}

function loadChatsSynClear(){
	$("#chat-msg-list").html('');
}

function loadChat(chat){
	//console.log(chat);
	return createChatElem(chat);
	//$("#chat-msg-list").append(createChatElem(chat));
}

function createChatElem(chat){
	if(chat.richtext)chat.richtext = emotion2Local(chat.richtext);
	var sElem='';

	if(chat.senderRole&2 == 2){
		sElem += '<li class="gs_organizer"';
	}else{
		sElem += '<li';
	}
	
	sElem += ' data-talkerid="'+chat.talkerId+'"><div class="msg_l border-box"><span class="msg_l_t"></span><i class="gs_bg"></i><span class="msg_l_b"></span></div><div class="msg-info">';

	sElem += '<a class="user-name organizer-color"><em class="namecut">'+chat.talkerName+'</em></a>';

	sElem +='<span class="msg-time">'+Util.formatTime(chat.time*1000)+'</span></div>'+
    	'<div class="msg-content">'+chatformatUrl(chat.richtext||Util.escapeHTML(chat.msg)||"")+'</div></li>';
	return sElem;
}

function emotion2Local(richText){
	richText = richText.replace(/<img.*?emotion\\(.+?).(gif|png)\".*?>/gi, function (match, capture) {
			return changeUrl2Local(match);
		}); 
	return richText;
}

function htmlfilter(richtext) {
	if (richtext == undefined) {
		return " ";
	}
	try {
		var text = richtext.replace(/<\/?.*?>/gi,"");
		if (text==""||text.length == 0) {
			text = " ";
		}
		return text;
	} catch (e) {
		console.log("htmlfilter error:" + richtext);
		return " ";
	}
	
}

function changeUrl2Local(match){
	var idx1 = match.indexOf("src=");
	var idx2 = match.indexOf("emotion");
	console.log(match);
	return match.substring(0, idx1+5)+staticPrefix+"/static/"+match.substring(idx2).replace(/.(gif|png)/gi,'@2x.png').replace('@2x.pngt','.gift').replace('@2x@2x','@2x');
}
function chatformatUrl(content){
	if(Util.isEmpty(content)){
		return content;
	}
	var reg = /(?:<img.+?>)|(http[s]?|(www\.)){1}[\w\.\/\?=%&@:#;\*\$\[\]\(\){}'"\-]+([0-9a-zA-Z\/#])+?/ig,
		content = content.replace(reg, function(content) {
			if(/<img.+?/ig.test(content)){
				return content;
			}else{
				return '<a class="msg-url" href="'+content.replace(/^www\./,function(content){
					return "http://" + content;
				})+'">'+content+'</a>'
			}
		});
	return content;
}


/** smartphone-vod.qa.js **/
/*
 * ====================================================
 * 问答
 */

function loadHisQa(data){
	console.log(data);
	var qadatas = data.list;
	console.log("长度"+qadatas.length);
	//var j=0;
	var txt='';
	if(qadatas.length>0){
		for(i in qadatas){
			//j++;
			var qa = qadatas[i];
			if(checkQaDuplication(qa))continue;
			txt+=appendQa(qa);
			
			//if(j>=200){
				//break;
			//}
		}
		hideQaEmpty();
		$("#qa-msg-list").append(txt);
	}
		
	$(".gs-more-qa").remove();
	if(data.more == "true" || data.more === true){
		$('<div class="gs-more-qa"><span class="gs-more-qa-t">'+i18n("player.chat.history.more")+'</span></div>').insertAfter("#qa-msg-list");
		$(".gs-more-qa").bind("click", function(){
			getResource("qa", function(data){
				loadHisQa(data);
			});
		});
	}
	
}
function hideQaEmpty(){
	if($('#qa_empty')[0] && $('#qa_empty').css('display')!='none'){
		$('#qa_empty').hide();
	}
}
function checkQaDuplication(qa){
	var $el = $("#"+qa.questionid+"-"+qa.answerowner+"-"+qa.answertimestamp);
	return $el.length>0;
}

//加载一个问答
function appendQa(qa){
	//console.log('加载一个问答');
	//console.log(qa);
	return createQaEle(qa);
	//$("#qa-msg-list").append(createQaEle(qa));
    /*jQuery("#qa-msg-list").scrollTo({
        fn:function(){
            $("#qa-msg-list").append(createQaEle(qa));
        }
    });*/

}

function commitMsg(){
	commitQa();
	return false;
}

//创建一个问答页面元素
function createQaEle(qa){
	//console.log(qa);
	qa.question = Util.escapeHTML(qa.question);
	qa.answer = Util.escapeHTML(qa.answer);
	
	var ididx = qa.questionid.indexOf("_");
	if(ididx>0){
		qa.questionid = qa.questionid.substring(0, ididx);
	}
	
	if(typeof qa.questionowner!="string") qa.questionowner = "";
	if(typeof qa.answerowner!="string") qa.answerowner = "";
	
	qa.questionowner = qa.questionName?qa.questionName:qa.questionowner;
	qa.answerowner = qa.answerName?qa.answerName:qa.answerowner;

	var sQaEle = '<li id="'+qa.questionid+"-"+qa.answerowner+"-"+qa.answertimestamp+'" name="'+qa.questionid+'">';
	if(qa.answer){
		sQaEle += '<div class="qa_question"><div class="qa_top"><strong>'+Util.replaceholder(i18n("player.qa.questionask"),['<em class="namecut">'+qa.questionowner+'</em>'])+'</strong><span>'+Util.formatTime(qa.questionTime*1000)+'</span></div><div class="qa_txt">'+qa.question+'</div></div>';
		
		sQaEle += '<div class="qa_answer qa_answer_vod qa-answer-'+qa.questionid+'""><div class="qa_top"><strong>'+Util.replaceholder(i18n("player.qa.answer"),['<em class="namecut">'+qa.answerowner+'</em>','<em class="namecut">'+qa.questionowner+'</em>'])+'</strong><span>'+Util.formatTime(qa.answerTime*1000)+'</span></div><div class="qa_txt">'+qa.answer+'</div></div>';
		var his = getHisAElem(qa);
		sQaEle += his;
	}else{
		sQaEle += '<div class="qa_question"><div class="qa_top"><strong>'+Util.replaceholder(i18n("player.qa.questionask"),['<em class="namecut">'+qa.questionowner+'</em>'])+'</strong><span>'+Util.formatTime(qa.questionTime*1000)+'</span></div><div class="qa_txt">'+qa.question+'</div></div>';
	}
	
	sQaEle += '</li>';
	return sQaEle;
}

function getHisAElem(qa){
	var el = "";
	$(".qa-answer-"+qa.questionid).each(function(){
		if($(this).length>0){
			el += '<div class="qa_answer qa_answer_vod">'+$(this).html()+'</div>';
		}
	});
	return el;
}

/** smartphone-vod.vote.js **/

/*
 * ====================================================
 * 投票调查
 */
var closeVoteTime;
var survey = {};//for events:popup minimize close
var VoteSurvey = {};
var VoteSurveySubmited = {};
var LoadedVotes = {};

$(function(){
	$("#vote-select").on('tap','ul li a',function() {//选择别的问卷
		if(!$('#freeVotePopup').hasClass('force')){
			var that=this;
			var voteIndex = $(this).parent('li').index();
			jQuery("#freeVotePopup .survey_area").eq(voteIndex).fadeIn(300).siblings().fadeOut(300);
			$("#vote-select ul li").eq(voteIndex).addClass('on').siblings().removeClass('on');
			$("#curent-vote-title").text($(this).text());
			if($(this).parent('li').hasClass('is_force')){
				$('#freeVotePopup').addClass('force');
			}else{
				$('#freeVotePopup').removeClass('force');
			}
			jQuery('.survey .survey_list').slideUp();
			$('.survey a.survey_more').removeClass('zhuan');
			var id=$(this).attr('rel');
			/*if(VoteAndSurveyResult[id]){
				$('.title_set em').show();
				$('#curent-vote-title').unbind('click');
				$('#curent-vote-title').bind('click',function(){
					$('#survey_stat_title').text($(that).text());
					console.log(id);
					if(!isReadResult[id]){
						isReadResult[id]=id;
					}
					$('#voteresult_list .survey_stat_content').hide();
					jQuery('#vsr_'+id).fadeIn(300);
					$('#survey_list li').removeClass('on');
					$('#vsr-li-'+id).addClass('on');
					jQuery('.survey_stat').fadeIn();
					$('#freeVotePopup').css('z-index','597');
				});
			}else{
				$('.title_set em').hide();
				$('#curent-vote-title').unbind('click');
			}*/
		}
	});
	
	$('.survey a.survey_more').on('tap',function(){//点击更多问卷
		if(!$('#freeVotePopup').hasClass('force') && $("#vote-select").find('li').length>1){
			if($(this).hasClass('zhuan')){
				jQuery('.survey .survey_list').slideUp();
				$(this).removeClass('zhuan');
			}else{
				$(this).addClass('zhuan');
				jQuery('.survey .survey_list').slideDown();
			}
		}
	});
	
	$('#vote-list').on('tap','.survey_area .survey_content .survey_select ul li div,.survey_area .survey_content .survey_select ul li span',function(){//单选多选答题
		var that=this;
		if(!$(that).parents('.survey_content').hasClass('showright')){
			var is_radio=$(that).parents('.survey_select').hasClass('single');
			if($(that).parent('li').hasClass('checked') && !is_radio){
				$(that).parent('li').removeClass('checked');
			}else{
				if(is_radio){
					$(that).parents('ul').find('li').removeClass('checked');
				}
				$(that).parent('li').addClass('checked');
			}
		}
	});

	$('#freeVotePopup a.survey_close').on('tap',function(){
		if(!$('#freeVotePopup').hasClass('force')){
			jQuery(Media).trigger('closeVote');
			if(closeVoteTime){
				clearTimeout(closeVoteTime);
			}
			$('#curent-vote-title').unbind('click');
			jQuery('.survey .survey_list').slideUp();
			$('.survey a.survey_more').removeClass('zhuan');
			var vsId=$('#vote-select ul li.on a').attr('rel');
			$("#vote-select-"+vsId).remove();
			$("#vs_"+ vsId).remove();
			$("#freeVotePopup .vote-tips").text(Util.replaceholder(i18n("player.vote.unsubmittip"), [$("#vote-select li").length]));
			var len = $("#vote-select li").length;
			if(len<=1){
				$("#freeVotePopup").find('a.survey_more i').hide();
			}
			if(len>0){
				$("#vote-select ul li").eq(0).addClass('on').find('a').trigger('tap');
			}else{
				jQuery('#freeVotePopup').fadeOut(function(){
					GsPlayer.videoShow();
				});
				/*if($('#video-box')[0] && $('#survey_stat').css('display')=='none' && !$('#card_box').hasClass('on') && !$('#tool_box').hasClass('on') && !$('#doc_big').hasClass('on')){
					$('#video-box').removeClass('videotop');
				}*/
			}
		}
	});
	/*$(".popup-close").click(function () {
		jQuery(Media).trigger('closeVote');
        jQuery(this).closest(".popup-container").fadeOut(300,function(){
                    });
	});*/
	/*$("#freeVotePopup .select-list").click(function (evt) {
		var $li = $(evt.target).closest("li");
		var voteIndex = $li.index();
		jQuery("#freeVotePopup .popup-item").eq(voteIndex).fadeIn(300).siblings().fadeOut(300);
		$("#curent-vote-title").text($(evt.target).text());
	});*/
	
	Sch.setType("TYPE_VOTE", loadVote);
	jQuery(Media).bind("timeupdate", function(evt, second){
		Sch.playback(second, "TYPE_VOTE");
	});
});



function loadVotes(obj){
	if(!obj || !obj.voteSurveyList || obj.voteSurveyList.length==0)return;
	for(var i in obj.voteSurveyList){
		var vs = obj.voteSurveyList[i];
		console.log("投票"+i+":"+vs.id);
		if(LoadedVotes[vs.id]){
			console.log("投票数据重复:"+vs.id);
			continue;
		}
		LoadedVotes[vs.id] = vs.id;
//		loadVote(vs);
		Sch.addTask(new Task("TYPE_VOTE", Number(vs.startTime), Number(vs.startTime)+5, vs));
	}
}

function loadVote(vs){
	console.log(vs);
	if(vs.skip=="false"){
		if(VoteSurvey[vs.id]){
			return;
		}else{
			VoteSurvey[vs.id] = vs;
			jQuery(Media).trigger("videoExitFullScreen");
		}
		jQuery(Media).trigger('openVote');
	}else{
		if(VoteSurvey[vs.id]){
			if(!VoteSurveySubmited[vs.id]){
				$("#vote-select-"+vs.id).trigger('tap');
				jQuery(Media).trigger("videoExitFullScreen");
			}
			return;
		}else{
			VoteSurvey[vs.id] = vs;
			jQuery(Media).trigger("videoExitFullScreen");
		}
		if($("#freeVotePopup").css("display")=="none"){
			jQuery(Media).trigger('openVote');
		}
	}
	
	$('#video-box').addClass('videotop');
    /*if(vs.skip=="false"){
		$("#webPlayer").prepend(createForceVoteAndSurvey(vs));
		jQuery("#vs_"+ vs.id).fadeIn(300);
		$("#vs_"+ vs.id+" .submit-btn").bind("click", function(){
			commitVoteAndSurvey(vs.id);
		});
	}else{*/
		$("#vote-list").append(createVoteAndSurvey(vs));
		var lic='';
		if($("#vote-select").find('li').length==0){
			$("#curent-vote-title").text(vs.title);
			$("#vs_"+ vs.id).css('display','block');
			if(vs.skip=="false"){
				lic=' class="on is_force"';
				$("#freeVotePopup").addClass('force');
			}else{
				lic=' class="on"';
			}
			/*if(VoteAndSurveyResult[vs.id]){
				$('.title_set em').show();
			}else{
				$('.title_set em').hide();
			}*/
		}else{
			if(vs.skip=="false"){
				lic=' class="is_force"';
			}
		}
		$("#vote-select ul").append('<li id="vote-select-'+vs.id+'"'+lic+'><a href="javascript:;" rel="'+vs.id+'">'+Util.escapeHTML(vs.title)+'</a></li>');
		$("#vs_"+ vs.id+" .submit-btn").bind("click", function(){
			commitVoteAndSurvey(vs.id);
		});
		jQuery("#freeVotePopup").fadeIn(300);
		if($("#vote-select li").length>1){
			$("#freeVotePopup").find('a.survey_more i').css('display','block');
		}else{
			$("#freeVotePopup").find('a.survey_more i').hide();
		}
		$("#freeVotePopup .vote-tips").text(Util.replaceholder(i18n("player.vote.unsubmittip"), [$("#vote-select li").length]));
	//}
//	alert("loadVote:"+vs.skip);
    	/*if(vs.skip=="false"){
		if(VoteSurvey[vs.id]){
			return;
		}else{
			VoteSurvey[vs.id] = vs;
			jQuery(Media).trigger("videoExitFullScreen");
		}
		jQuery(Media).trigger('openVote');
		$("#webPlayer").prepend(createForceVoteAndSurvey(vs));
		$("#vs_"+ vs.id+" .popup-submit-btn").bind("click", function(){
			commitVoteAndSurvey(vs.id);
		});
	}else{
		if(VoteSurvey[vs.id]){
			if(!VoteSurveySubmited[vs.id]){
				$("#voteBtn").click();
				$("#curent-vote-title").text(vs.title);
				$("#vote-select-"+vs.id).click();
				jQuery(Media).trigger("videoExitFullScreen");
				closeSelectList();
			}
			
			return;
		}else{
			VoteSurvey[vs.id] = vs;
			jQuery(Media).trigger("videoExitFullScreen");
		}
		
		$("#vote-list").prepend(createVoteAndSurvey(vs));
		$("#curent-vote-title").text(vs.title);
		$("#vote-select").prepend('<li id="vote-select-'+vs.id+'"><a href="javascript:;">'+Util.escapeHTML(vs.title)+'</a></li>');
		$("#vs_"+ vs.id+" .popup-submit-btn").bind("click", function(){
			commitVoteAndSurvey(vs.id);
		});
		if($("#freeVotePopup").css("display")=="none"){
			jQuery(Media).trigger('openVote');
		}
		jQuery("#freeVotePopup").fadeIn(300);
		$("#freeVotePopup .vote-tips").text(Util.replaceholder(i18n("player.vote.unsubmittip"), [$("#vote-select li").length]));
		if($("#vote-select li").length == 0){
			$("#freeVotePopup .waiting-layer").show();
		}else{
			$("#freeVotePopup .waiting-layer").hide();
		}
	}*/
}

function createVoteAndSurvey(vs){
	var questions = vs.questions;
	var sElem = '<div class="survey_area" id="vs_'+ vs.id+'">';
	if(vs.skip=="false"){
		sElem+='<div class="survey_tips border-box">'+i18n("player.vote.cantskiptip")+'</div>';
	}
	
	sElem+='<div class="survey_content allow-roll">';
			
	for(var i in questions){
		var question = questions[i];
		if(question.type=="single" || question.type=="multi"){
			sElem += createVote(i, question);
		}else if(question.type=="text"){
			sElem += createSurvey(i, question);
		}
	}
	sElem += '</div>';
	sElem += '<div class="Unfinished_sprompt"><span>'+i18n("player.vote.answerAllRequired")+'</span></div>';
	sElem += '<div class="buttom_submit">'+
		    '<button class="submit_set submit-btn" type="button">'+i18n("player.button.submit")+'</button>'+
		'</div><div class="buttom_submit_result"><span></span></div>'+
		'</div>';
	return sElem;
}

	
function createVote(idx, vote){
	var sVoteElem = '<div class="survey_select'+(vote.type=="single"?' single':' multi')+'" id="'+vote.id+'">'+
	'<h3>'+vote.subject+'</h3><ul>';
	for(var i in vote.items){
		var item = vote.items[i];
		sVoteElem += '<li rel="'+(Number(i)+1)+'"'+(isCorrectItem(item)?' class="right"':'')+'><div>';
		sVoteElem +=  '<a><i></i></a>';
		/*if(vote.type==="single"){
			sVoteElem += '<input type="radio" value="'+(Number(i)+1)+'" name="radio-'+vote.id+'-'+idx+'"> '+Util.escapeHTML(item.content);
		}else{
			sVoteElem += '<input type="checkbox" value="'+(Number(i)+1)+'"> '+Util.escapeHTML(item.content);
		}*/
		if(isCorrectItem(item)){
			sVoteElem += '<strong>'+i18n("player.vote.rightanswer")+'</strong>';
		}
		sVoteElem +=  '</div>';
		sVoteElem +=  '<span>'+Util.escapeHTML(item.content)+'</span>';
		sVoteElem +=  '</li>';
	}
	sVoteElem +=  '</ul></div>';
	return sVoteElem;
}

function createSurvey(idx, survey){
	var sSurveyElem = '<div class="survey_select diaocha" id="'+survey.id+'">' +
			'<h3>'+Util.escapeHTML(survey.subject)+'</h3>'+
			'<div class="textarea">'+
				'<textarea class="border-box vote-tarea"></textarea>'+
			'</div>'+
		'</div>';
	return sSurveyElem;
}

function commitVoteAndSurvey(vsId){
	if(closeVoteTime){
		clearTimeout(closeVoteTime);
	}
	var vsData = VoteSurvey[vsId];
	if(vsData.skip=="false"){
		//console.log(isAllQuestionAnswered(vsData));
		if(isAllQuestionAnswered(vsData)>0){
			jQuery("#vs_"+ vsId).find('.Unfinished_sprompt').stop(true,true).fadeIn();
			//alert(i18n("player.vote.answerAllRequired"));
			setTimeout(function(){jQuery("#vs_"+ vsId).find('.Unfinished_sprompt').stop(true,true).fadeOut();},3000);
			return false;
		}else{
			jQuery("#vs_"+ vsId).find('.Unfinished_sprompt').stop(true,true).fadeOut();
		}
	}
	//else{
		//if(!isOneAnsweredAtLeast(vsData)){
			//alert(i18n("player.vote.answerOneRequired"));
			//return false;
		//}
	//}
	
	jQuery("#vs_"+vsId+" .submit-btn").unbind("click").fadeOut();
	$("#vs_"+vsId+" .buttom_submit_result span").html(i18n("player.vote.label.submited"));
	jQuery("#vs_"+vsId+" .buttom_submit_result").fadeIn();
	var anum=0;
	var rnum=0;
	$("#vs_"+vsId).find(".survey_select").each(function(){
		if($(this).find('li.right').length>0){
			anum++;
		}
		if($(this).hasClass("single")){
			var answer = "";
			if($(this).find('li.checked').length>0){
				if(answer.length==0){
					answer = $(this).find('li.checked').attr('rel');
				}else{
					answer += ","+ $(this).find('li.checked').attr('rel');
				}
			}
			/*$(this).find(":radio").each(function(){
				if($(this).attr("checked")=="checked"||this.checked){
					if(answer.length==0){
						answer = $(this).val();
					}else{
						answer += ","+ $(this).val();
					}
				}
				$(this).attr("disabled", "disabled");
			});*/
			setAnswer(vsId, $(this).attr("id"), answer);
			$(this).off();
			if($(this).find('li.checked').eq(0).hasClass('right')){
				rnum++;

			}
		}else if($(this).hasClass("multi")){
			var answer = "";
			var manum=$(this).find('li.right').length;
			var mrnum=0;
			$(this).find("li.checked").each(function(){
				if(answer.length==0){
					answer = $(this).attr('rel');
				}else{
					answer += ","+ $(this).attr('rel');
				}
				if($(this).hasClass('right')){
					mrnum++;
				}
			});
			if(manum>0 && manum==mrnum){
				rnum++;
			}
			/*$(this).find(":checkbox").each(function(){
				if($(this).attr("checked")=="checked"||this.checked){
					if(answer.length==0){
						answer = $(this).val();
					}else{
						answer += ","+ $(this).val();
					}
				}
				$(this).attr("disabled", "disabled");
			});*/
			setAnswer(vsId, $(this).attr("id"), answer);
			$(this).off();
		}else if($(this).hasClass("diaocha")){
			var testarea = $(this).find("textarea");
			var answer = testarea.val();
			setAnswer(vsId, $(this).attr("id"), answer);
			testarea.attr("disabled", "disabled");
		}
		
	});
	
	$("#vs_"+ vsId).find(".survey_content").addClass("showright");
	
	VoteSurveySubmited[vsId] = vsId;
	submitVoteAndSurvey([VoteSurvey[vsId]]);
	
	//sendVoteOrSurvery([VoteSurvey[vsId]]);
	if(vsData.skip=="false"){//提交完答案去掉强制
		$('#freeVotePopup').removeClass('force');
	}
	var closertime=0;
	if(anum>0){
		var point=Math.round((rnum/anum)*100);
		var rt='';
		if(point<60){
			rt=i18n("player.vote.label.point1");
		}else if(point<85 && point>=60){
			rt=i18n("player.vote.label.point2");
		}else if(point>=85){
			rt=i18n("player.vote.label.point3");
		}
		$("#vs_"+vsId+" .buttom_submit_result span").html(rt);
		//$('.buttom_submit_result').fadeIn();
		closertime=10000;
	}else{
		closertime=2000;
	}
	closeVoteTime=setTimeout(function(){
		/*$('#curent-vote-title').unbind('click');*/
		$("#vote-select-"+vsId).remove();
		$("#vs_"+ vsId).remove();
		$("#freeVotePopup .vote-tips").text(Util.replaceholder(i18n("player.vote.unsubmittip"), [$("#vote-select li").length]));
		var len = $("#vote-select li").length;
		if(len<=1){
			$("#freeVotePopup").find('a.survey_more i').hide();
		}
		if(len>0){
			$("#vote-select ul li").eq(0).addClass('on').find('a').trigger('tap');
		}else{
			$("#curent-vote-title").text("");
			$("#freeVotePopup .survey_close").trigger('tap');
		}
	},closertime);
}

function isAllQuestionAnswered(vsData){
	var i=0;
	var h=0;
	$("#vs_"+vsData.id).find(".survey_select").each(function(){
		var that=this;
		if($(that).hasClass("single")){
			if($(that).find("li.checked").length==0){
				jQuery(that).parent('.survey_content').animate({scrollTop:h},500);
				i++;
				return false;
			}
		}else if($(that).hasClass("multi")){
			if($(that).find("li.checked").length==0){
				jQuery(that).parent('.survey_content').animate({scrollTop:h},500);
				i++;
				return false;
			}
		}else if($(that).hasClass("diaocha")){
			var val = $(that).find("textarea").val();
			if(!val||$.trim(val).length<1){
				jQuery(that).parent('.survey_content').animate({scrollTop:h},500);
				i++;
				return false;
			}
		}
		h+=$(that).height();
	});
	return i;
}

function setAnswer(vsId, itemId, value){
	//var questions = vsData.question;
	for(var i in VoteSurvey[vsId].questions){
		if(VoteSurvey[vsId].questions[i].id===itemId){
			VoteSurvey[vsId].questions[i].answer = value;
			break;
		}
	}
}

function isCorrectItem(item){
	return item.correct =="true" || item.correct == true;
}/*
function createVoteAndSurvey(vs){
	var questions = vs.questions;
	var sElem = '<div class="popup-item" id="vs_'+ vs.id+'" style="display:block;">'
						+'<div class="popup-main allow-roll">'
					+'<div class="vote-list">';
	for(var i in questions){
		var question = questions[i];
		if(question.type=="single" || question.type=="multi"){
			sElem += createVote(i, question);
		}else if(question.type=="text"){
			sElem += createSurvey(i, question);
		}
	}
	sElem += '</div></div>'+
		'<div class="popup-submit">'+
		    '<button class="popup-submit-btn" type="button">'+i18n("player.button.submit")+'</button>'+
		'</div>'+
		'</div>';
	return sElem;
}

function createForceVoteAndSurvey(vs){
	var questions = vs.questions;
	var sElem = '<div id="vs_'+ vs.id+'" class="popup-container vote-coerce-popup dialog-videocompatible">'
						+'<div class="popup-hd">'
						+'<div class="select-box">'
						+'<div class="selected-item">'+Util.escapeHTML(vs.title)+'</div>'
						+'<span class="select-lock"></span>'
						+'</div>'
						+'<div class="vote-tips"><marquee behavior="alternate"  scrollamount="3" >'+i18n("player.vote.cantskiptip")+'</marquee></div>'
						+'<span class="popup-close-disable"></span>'
					+'</div>'
					+'<div class="popup-bd">'
					+'<div class="popup-item" style="display:block;">'
					+'<div class="popup-main allow-roll">'
					+'<div class="vote-list">';
					for(var i in questions){
						var question = questions[i];
						if(question.type=="single" || question.type=="multi"){
							sElem += createVote(i, question);
						}else if(question.type=="text"){
							sElem += createSurvey(i, question);
						}
					}           
	sElem += '</div>'
			+'</div>'
			+'<div class="popup-submit">'
			+'<button class="popup-submit-btn" type="button">'+i18n("player.button.submit")+'</button>'
			+'</div>'
			+'</div>'
			+'</div>'
			+'</div>';
	return sElem;
}
	
function createVote(idx, vote){
	var sVoteElem = '<dl class="toupiao question vote-item" id="'+vote.id+'">'+
					'<dt>'+Util.escapeHTML(vote.subject)+'</dt>';
	for(var i in vote.items){
		var item = vote.items[i];
		sVoteElem += '<dd><label>'; //class="rightans"
		if(vote.type==="single"){
			sVoteElem += '<input type="radio" value="'+(Number(i)+1)+'" name="radio-'+vote.id+'-'+idx+'"> '+Util.escapeHTML(item.content);
		}else{
			sVoteElem += '<input type="checkbox" value="'+(Number(i)+1)+'"> '+Util.escapeHTML(item.content);
		}
		if(isCorrectItem(item)){
			sVoteElem += '<span class="right-ans showAfter"> - '+i18n("player.vote.rightanswer")+'</span>';
		}
		sVoteElem +=  '</label></dd>';
	}
	sVoteElem +=  '</dl>';
	return sVoteElem;
}

function createSurvey(idx, survey){
	var sSurveyElem = '<dl class="vote-item diaocha question" id="'+survey.id+'">' +
			'<dt>'+Util.escapeHTML(survey.subject)+'</dt>'+
			'<dd>'+
				'<textarea class="vote-tarea"></textarea>'+
			'</dd>'+
		'</dl>';
	return sSurveyElem;
}

function commitVoteAndSurvey(vsId){
	var vsData = VoteSurvey[vsId];
	if(vsData.skip=="false"){
		if(!isAllQuestionAnswered(vsData)){
			alert(i18n("player.vote.answerAllRequired"));
			return false;
		}
	}else{
		if(!isOneAnsweredAtLeast(vsData)){
			alert(i18n("player.vote.answerOneRequired"));
			return false;
		}
	}
	
	$("#vs_"+ vsId+" .popup-submit-btn").unbind("click");
	$("#vs_"+ vsId+" .popup-submit-btn").text(i18n("player.button.submited"));
	
	$("#vs_"+vsId).find(".question").each(function(){
		if($(this).hasClass("toupiao")){
			var answer = "";
			$(this).find(":radio").each(function(){
				if($(this).attr("checked")=="checked"||this.checked){
					if(answer.length==0){
						answer = $(this).val();
					}else{
						answer += ","+ $(this).val();
					}
				}
				$(this).attr("disabled", "disabled");
			});
			$(this).find(":checkbox").each(function(){
				if($(this).attr("checked")=="checked"||this.checked){
					if(answer.length==0){
						answer = $(this).val();
					}else{
						answer += ","+ $(this).val();
					}
				}
				$(this).attr("disabled", "disabled");
			});
			setAnswer(vsData, $(this).attr("id"), answer);
		}else if($(this).hasClass("diaocha")){
			var testarea = $(this).find("textarea");
			var answer = testarea.val();
			setAnswer(vsData, $(this).attr("id"), answer);
			testarea.attr("disabled", "disabled");
		}

		var $span = $(this).find(".correctFlag");
		$span.parent().addClass("rightans");
		
	});
	
	$("#vs_"+ vsId).find(".showAfter").removeClass("showAfter");
	$closeDisable = $("#vs_"+ vsId).find(".popup-close-disable");
	if($closeDisable.length>0){
		$closeDisable.removeClass("popup-close-disable").addClass("popup-close");
		$closeDisable.bind("click", function(){
			$("#vs_"+vsId).hide();
			jQuery(Media).trigger('closeVote');
		});
	}
	
	VoteSurveySubmited[vsId] = vsId;
	submitVoteAndSurvey([VoteSurvey[vsId]]);
	
	if(vsData.skip=="false"){
		$("#vs_"+vsId).hide();
		jQuery(Media).trigger('closeVote');
	}else{
		var len = $("#vote-select li").length;
		if(len>1){
			var idx = $("#vote-select-"+vsId).index();
			var next = (idx==len-1)?0:idx+1;
			$("#vote-select li").eq(next).click();
		}else{
			$("#curent-vote-title").text("");
			$("#freeVotePopup .popup-close").click();
		}
		$("#vote-select-"+vsId).remove();
		$("#vs_"+ vsId).remove();
		$("#freeVotePopup .vote-tips").text(Util.replaceholder(i18n("player.vote.unsubmittip"), [$("#vote-select li").length]));
		if($("#vote-select li").length == 0){
			$("#freeVotePopup .waiting-layer").show();
		}else{
			$("#freeVotePopup .waiting-layer").hide();
		}
	}

}

function isAllQuestionAnswered(vsData){
	var allAnswered = true;
	$("#vs_"+vsData.id).find(".question").each(function(){
		var answered = true;
		if($(this).hasClass("toupiao")){
			$(this).find(":radio").each(function(){
				answered = false;
				if($(this).attr("checked")=="checked"||this.checked){
					answered = true;
					return false;
				}
			});
			$(this).find(":checkbox").each(function(){
				answered = false;
				if($(this).attr("checked")=="checked"||this.checked){
					answered = true;
					return false;
				}
			});
			
		}else if($(this).hasClass("diaocha")){
			var val = $(this).find("textarea").val();
			if(!val||$.trim(val).length<1){
				answered = false;
			}
		}
		if(!answered){
			allAnswered = false;
			return false;
		}
	});
	return allAnswered;
}

function isOneAnsweredAtLeast(vsData){
	var oneAnswered = false;
	$("#vs_"+vsData.id).find(".question").each(function(){
		if($(this).hasClass("toupiao")){
			$(this).find(":radio").each(function(){
				if($(this).attr("checked")=="checked"||this.checked){
					oneAnswered = true;
					return false;
				}
			});
			$(this).find(":checkbox").each(function(){
				if($(this).attr("checked")=="checked"||this.checked){
					oneAnswered = true;
					return false;
				}
			});
			
		}else if($(this).hasClass("diaocha")){
			var val = $(this).find("textarea").val();
			if(val&&$.trim(val).length>0){
				oneAnswered = true;
			}
		}
		if(oneAnswered){
			return false;
		}
	});
	return oneAnswered;
}

function setAnswer(vsData, itemId, value){
	var questions = vsData.questions;
	for(var i in questions){
		if(questions[i].id===itemId){
			questions[i].answer = value;
			break;
		}
	}
}

function isCorrectItem(item){
	return item.correct =="true" || item.correct == true;
}*/


/** smartphone-vod.card.js **/
/*
 * ====================================================
 * 答题卡
 */
$(function(){
	$('#card_box').on('tap','#card_back',function(){
		/*if($('#video-box')[0] && $('#freeVotePopup').css('display')=='none' && $('#survey_stat').css('display')=='none' && !$('#doc_big').hasClass('on') && !$('#tool_box').hasClass('on')){
			$('#video-box').removeClass('videotop');
		}*/
		$('#card_box').animate({'left':'150%'},500,function(){
			$('#card_box').removeClass('on');
			$('#card_small').fadeIn();
			GsPlayer.videoShow();
			GsPlayer.hidenCover();
			/*if(!$('#lottery-dialog').hasClass('on') && !$('#tool_box').hasClass('on')){
				$('#coverLayer').hide();
			}*/
		});
		
	});
	$('#card_small').on('tap',function(){
		$('#card_small').fadeOut();
		if($('#video-box')[0]){
			$('#video-box').addClass('videotop');
		}
		$('#card_box').animate({'left':'50%'},500,function(){
			$('#card_box').addClass('on');
			$('#coverLayer').css('display','block');
		});
		
	});
	$('#card_box').on('tap','.uniterming div,.judge_topic div',function(){//答题选择
		var that=this;
		if(!$(that).hasClass('on')){
			$(that).parents('tr').find('div').removeClass('on');
			$(that).addClass('on');
			if($('#card_submit').hasClass('submit_no')){
				$('#card_submit').removeClass('submit_no');
			}
		}
	});
	$('#card_box').on('tap','.multiple_choice div',function(){//多选答题选择
		var that=this;
		if(!$(that).hasClass('on')){
			$(that).addClass('on');
			if($('#card_submit').hasClass('submit_no')){
				$('#card_submit').removeClass('submit_no');
			}
		}else{
			$(that).removeClass('on');
			if($(that).parent('.multiple_choice').find('div.on').length==0 && !$('#card_submit').hasClass('submit_no')){
				$('#card_submit').addClass('submit_no');
			}
		}
	});
	
	$('#card_box').on('tap','#card_submit',function(){//提交答案
		console.log("提交");
		if(!$(this).hasClass('submit_no')){
			//$('.toolset').append(" tt ");
			var vsId=$('#card_box').attr('data-id');
			var vsData = CardSurvey[vsId];
			var type=$('#card_box').attr('data-type');
			//$('.toolset').append(" tt2 "+$('#card_box .card_question').find('div.on').length+" ");
			if($('#card_box .card_question').find('div.on').length==0){
				return false;
			}else{
				$("#card_box").find(".card_question").each(function(){
					if(type=='single' || type=='judge'){
						var answer = "";
						if($(this).find('div.on').length>0){
							answer = $(this).find('div.on').attr('rel');
						}
						setCardAnswer(vsData, $(this).attr("id"), answer);
						CardAnswer[vsId]={"id":$(this).attr("id"),'answer':answer,"type":type};
						$(this).off();
					}else{
						var answer = "";
						$(this).find("div.on").each(function(){
							if(answer.length==0){
								answer = $(this).attr('rel');
							}else{
								answer += ","+ $(this).attr('rel');
							}
						});
	
						setCardAnswer(vsData, $(this).attr("id"), answer);
						CardAnswer[vsId]={"id":$(this).attr("id"),'answer':answer,"type":type};
						$(this).off();
					}
				});
				//$('.toolset').append(" tt3 ");
				console.log('提交答题卡');
				console.log(CardSurvey[vsId]);
				console.log(CardAnswer);
				submitVoteAndSurvey([CardSurvey[vsId]]);
				closeCard();
			}
		}
	});
	
	$('#card_box').on('tap','#card_close',function(){//关闭答题卡答案
		closeCard();
	});
	
	Sch.setType("TYPE_CARD", loadCard);
	jQuery(Media).bind("timeupdate", function(evt, second){
		Sch.playback(second, "TYPE_CARD");
	});
});
function closeCard(){
	/*if($('#video-box')[0] && $('#freeVotePopup').css('display')=='none' && $('#survey_stat').css('display')=='none' && !$('#doc_big').hasClass('on') && !$('#lottery-dialog').hasClass('on') && !$('#tool_box').hasClass('on')){
		$('#video-box').removeClass('videotop');
	}*/
	var headerHeight = 30;
	if($(".toolbar").hasClass('status_bar_p')){
		headerHeight = 0;
	}
	$('#card_box').animate({'top':(headerHeight+GsPlayer.topHalfHeight())+'px','opacity':0},500,function(){
		$(this).css({'visibility':'hidden'});
		$(this).removeClass('on');
		GsPlayer.videoShow();
		GsPlayer.hidenCover();
		/*if(!$('#lottery-dialog').hasClass('on') && !$('#tool_box').hasClass('on')){
			$('#coverLayer').hide();
		}*/
	});
}
var CardSurvey = {};
var CardAndSurveyResult = {};
var CardAnswer = {};
//function loadCardAndSurveys(obj){
//	console.log("加载答题卡内容");
//	console.log(obj);
//	if(!obj || !obj.contentArray || obj.contentArray.length==0)return;
//	for(var i in obj.contentArray){
//		var vs = obj.contentArray[i];
//		if(vs.rootType ==="vote" || vs.rootType ==="survey"){
//
//			if(CardSurvey[vs.id])continue;
//			vs.type='publish_card';
//			CardSurvey[vs.id] = vs;
//			loadCard({"id":vs.id, "name":vs.name, "type":"question", "title":vs.subject, "skip":vs.skip, "questions":vs.question});
//		}else if(vs.rootType ==="result"){
//			if(CardAndSurveyResult[vs.id])continue;
//			CardAndSurveyResult[vs.id] = vs;
//			loadCardResult(vs);
//		}
//	}
//}
//var CardSurvey = {};
function loadCards(obj){
	if(!obj || !obj.cardList || obj.cardList.length==0)return;
	for(var i in obj.cardList){
		var vs = obj.cardList[i];
		console.log("投票"+i+":"+vs.id);
		if(CardSurvey[vs.id]){
			console.log("投票数据重复:"+vs.id);
			continue;
		}
		CardSurvey[vs.id] = vs;
		Sch.addTask(new Task("TYPE_CARD", Number(vs.startTime), Number(vs.startTime)+5, vs));
	}
}


function loadCard(vs){
	console.log("加载答题卡");
	console.log(vs);
	if($('#video-box')[0]){
	jQuery(Media).trigger("videoExitFullScreen");
	}
	var headerHeight = 30;
	if($(".toolbar").hasClass('status_bar_p')){
		headerHeight = 0;
	}
	$("#card_box").html(createCardElem(vs)).attr('data-id',vs.id);
	$('#card_box').css({'top':(headerHeight+GsPlayer.topHalfHeight())+'px','visibility':'visible','opacity':0,'display':'block'});
	if($('#video-box')[0]){
		$('#video-box').addClass('videotop');
	}
	if($('#video-box').length==0 && $('#card_small').css('display')!='none'){
		$('#card_small').fadeOut();
		$('#card_box').css({'left':'50%'});
	}
	$('#card_box').animate({'top':0,'opacity':1},500,function(){
		if(GsPlayer.isUcOrQqBrowser()){//UC,QQ浏览器全屏点名时退出全屏
			GsPlayer.exitFullscreen();
		}
		$('#card_box').addClass('on');
		$('#coverLayer').css('display','block');
	});
	
}
function loadCardResult(vs){
	console.log("加载答案");
	console.log(vs);
	if($('#video-box')[0]){
		jQuery(Media).trigger("videoExitFullScreen");
		$('#video-box').addClass('videotop');
	}
	if($('#video-box').length==0 && $('#card_small').css('display')!='none'){
		$('#card_small').fadeOut();
	}
	$("#card_box").html(createCardResultElem(vs)).attr('data-id',vs.id);
	var headerHeight = 30;
	if($(".toolbar").hasClass('status_bar_p')){
		headerHeight = 0;
	}
	$('#card_box').css({'top':(headerHeight+GsPlayer.topHalfHeight())+'px','visibility':'visible','opacity':0,'display':'block','left':'50%'});
	$('#card_box').animate({'top':0,'opacity':1},500,function(){
		if(GsPlayer.isUcOrQqBrowser()){//UC,QQ浏览器全屏点名时退出全屏
			GsPlayer.exitFullscreen();
		}
		$('#card_box').addClass('on');
		$('#coverLayer').css('display','block');
	});
}
function createCardResultElem(vs){//答案
	var txt='';
	txt+='<div class="title_box display-box"><span class="top_flex">'+i18n("player.card.title")+'</span><a class="close" id="card_close"><i></i></a></div>';
	txt+='<div class="synopsis"><div>';
	var vateTotal =(vs.question[0].total && vs.question[0].total!='')?parseInt(vs.question[0].total):0;
	var tanswer='';
	if(vs.question[0].type=='single'){
		if(vs.question[0].items.length>2){
			for(var j in vs.question[0].items){
				var item=vs.question[0].items[j];
				if(item.correct =="true" || item.correct == true){
					tanswer='<span class="my_letter">'+getCardName(j)+'</span>';
				}
			}
		}else{
			for(var j in vs.question[0].items){
				var item=vs.question[0].items[j];
				if(item.correct =="true" || item.correct == true){
					if(j==0){
						tanswer='<em></em>';
					}else{
						tanswer='<i></i>';
					}
				}
			}
		}
	}else{
		for(var j in vs.question[0].items){
			var item=vs.question[0].items[j];
			if(item.correct =="true" || item.correct == true){
				tanswer+=getCardName(j);
			}
		}
		if(tanswer!=''){
			tanswer='<span class="my_letter">'+tanswer+'</span>';
		}
	}
	if(tanswer!=''){
		txt+='<div class="teacher_answer"><span>'+i18n("player.card.teacheranswer")+'</span>'+tanswer+'</div>';
	}
	if(CardAnswer[vs.id]){
		var answerlength=1;
		txt+='<div class="my_answer"><span>'+i18n("player.card.myanswer")+'</span>';
		if(CardAnswer[vs.id].type=='single'){
			txt+='<span class="my_letter">'+getCardName(parseInt(CardAnswer[vs.id].answer)-1)+'</span>';
		}else if(CardAnswer[vs.id].type=='judge'){
			if(CardAnswer[vs.id].answer==1){
				txt+='<em></em>';
			}else{
				txt+='<i></i>';
			}
		}else{
			var answerlist=CardAnswer[vs.id].answer.split(",");
			var atxt='';
			for(var a in answerlist){
				atxt+=getCardName(parseInt(answerlist[a])-1);
			}
			answerlength=answerlist.length;
			txt+='<span class="my_letter">'+atxt+'</span>';
		}
		txt+='</div>';
	}
		
	txt+='</div><span class="respondence">'+Util.replaceholder(i18n("player.card.answertotal"),['<span class="number_width">'+vateTotal+'</span>'])+'</span></div>';
	txt+='<div class="answer_sheet_answer"><div class="answer_show_box"><ul>';
	var r=0;
	var sr=0;
	for(var i in vs.question[0].items){
		var item = vs.question[0].items[i];
		if(isCardCorrectItem(item)){
			sr++;
		}
		var itemTotal = item.total;
		var rate=calcRate(itemTotal, vateTotal);
		if(vs.question[0].type=='single'){
			if(vs.question[0].items.length>2){
				txt+='<li class="display_list_box'+(isCardCorrectItem(item)?' strong_show':'')+'">'+(tanswer!=''?'<strong>'+i18n("player.vote.rightanswer")+'</strong>':'')+'<em>'+getCardName(i)+'</em><div class="top_flex"><p><i style="width: '+rate+'%;"></i></p></div><span>'+itemTotal+'</span><span class="percentage">('+rate+'%)</span></li>';
				
			}else{
				txt+='<li class="display_list_box'+(isCardCorrectItem(item)?' strong_show':'')+'">'+(tanswer!=''?'<strong>'+i18n("player.vote.rightanswer")+'</strong>':'')+''+(i==0?'<span class="true"><em></em></span>':'<span class="false"><em></em></span>')+'<div class="top_flex"><p><i style="width: '+rate+'%;"></i></p></div><span>'+itemTotal+'</span><span class="percentage">('+rate+'%)</span></li>';
			}
			if(CardAnswer[vs.id] && isCardCorrectItem(item) && (parseInt(CardAnswer[vs.id].answer)-1)==i){
				r++;
			}
		}else{
			txt+='<li class="display_list_box'+(isCardCorrectItem(item)?' strong_show':'')+'">'+(tanswer!=''?'<strong>'+i18n("player.vote.rightanswer")+'</strong>':'')+'<em>'+getCardName(i)+'</em><div class="top_flex"><p><i style="width: '+rate+'%;"></i></p></div><span>'+itemTotal+'</span><span class="percentage">('+rate+'%)</span></li>';
			if(answerlist && IsContain(answerlist,parseInt(i)+1) && isCardCorrectItem(item)){
				r++;
			}
		}
	}
	txt+='</ul></div></div>';
	if(CardAnswer[vs.id] && tanswer!=''){
		txt+='<div class="butttom_show">';
		if(r==sr && r>0 && answerlength==r){	
			txt+='<span class="pass_show"><i></i><span>'+i18n("player.card.pass")+'</span></span>';
		}else{
			txt+='<div class="disqualification"><i></i><span>'+i18n("player.card.nopass")+'</span></div>';
		}
		txt+='</div>';
	}
	return txt;
}
function IsContain(arr,value){
  for(var i=0;i<arr.length;i++)
  {
	 if(arr[i]==value)
	  return true;
  }
  return false;
}
function getCardName(i){
	var name_arr=['A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T'];
	return name_arr[i];
}
function createCardElem(vs){
	var txt='';
	txt+='<div class="title_box display-box"><span class="top_flex">'+i18n("player.card.title")+'</span>'+($('#video-box')[0]?'':'<a class="conceal" id="card_back"><i></i></a>')+'</div>';
	txt+='<div class="synopsis"><span class="description">'+i18n("player.card.tips")+'</span></div>';
	txt+='<div class="options">';
	txt+=reateCardAndSurvey(vs);
	txt+='<div class="options_buttom_submit"><button class="submit_button submit_no" id="card_submit" type="button">'+i18n("player.card.submit")+'</button></div>';
	txt+='</div>';
	return txt;
}
function reateCardAndSurvey(vs){
	var questions = vs.questions;
	var txt='';
	
	for(var i in questions){
		var question = questions[i];
		if(question.type=="single"){
			if(question.items.length>2){//单选
				$("#card_box").attr('data-type','single');
				txt+='<div class="uniterming card_question" id="'+question.id+'">';
					txt+='<table>';
						txt+='<tr>';
						for(var j in question.items){
							txt+='<td><div rel="'+(Number(j)+1)+'"><span>'+question.items[j].content+'</span></div></td>';
						}
						txt+='</tr>';
					txt+='</table>';	
				txt+='</div>';
			}else{//判断题
				$("#card_box").attr('data-type','judge');
				txt+='<div class="judge_topic card_question" id="'+question.id+'">';
					txt+='<table>';
						txt+='<tr>';
						for(var j in question.items){
							txt+='<td><div rel="'+(Number(j)+1)+'"><span class="'+(j==0?'true_img':'false_img')+'"></span></div></td>';
						}
						txt+='</tr>';
					txt+='</table>';	
				txt+='</div>';
			}
		}else if(question.type=="multi"){//多选
			$("#card_box").attr('data-type','multi');
			txt+='<div class="multiple_choice card_question" id="'+question.id+'">';
				txt+='<table>';
					txt+='<tr>';
					for(var j in question.items){
						txt+='<td><div rel="'+(Number(j)+1)+'"><span>'+question.items[j].content+'</span><a></a></div></td>';
					}
					txt+='</tr>';
				txt+='</table>';	
			txt+='</div>';
		}
	}

	return txt;
}

function setCardAnswer(vsData, itemId, value){
	var questions = vsData.question;
	for(var i in questions){
		if(questions[i].id===itemId){
			questions[i].answer = value;
			break;
		}
	}
}

function isCardCorrectItem(item){
	return item.correct =="true" || item.correct == true;
}