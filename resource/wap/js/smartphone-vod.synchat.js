
if (typeof synChat == "undefined") {
	synChat = {
			startTime:"",
			duration:"",
			chatMainFile:"",
			chatList:[],
			requestedData:{},
			lastTime:0,
			chatData:[],
			currentTime:0,
			issynChat:false,
			lastSeekTime:0,
			sliceStartTime:0,
			slicemoreflag:false,
		    playTime:0
	}
}

function chatTimeSort(a,b){
	return a.timestamp-b.timestamp;
}


function chatGetSyn(data){
	console.log('解析xml.js');
	console.log(data);
	synChat.issynChat = true;
	if(data.conf.jschat && data.conf.jschat!=null){
		Sch.setType("TYPE_CHAT", loadChatsSyn);
		var offset = new Date().getTimezoneOffset();
		var d =new Date(data.conf.starttime.replace(/\-/g, "/")).getTime();
		synChat.startTime = d/1000 - offset * 60;
		console.log('synChat.startTime:' + synChat.startTime + "时区是" + offset);
		synChat.duration=data.conf.duration;
		synChat.chatMainFile=data.conf.jschat;
		var multirecord_obj={};
		//如果存在解析出chat所在对象
		for(var m=0;m<data.conf.module.length;m++){
			if(data.conf.module[m].name=='multirecord'){
				multirecord_obj=data.conf.module[m].multirecord;
			}
		}
		
		if(multirecord_obj && $.isArray(multirecord_obj)){
			var jschat_array=[];
			var n = 0;
			for (var i = 0; i < multirecord_obj.length; i++) {
				if(multirecord_obj[i].chat && multirecord_obj[i].chat!=null){
					if(!jschat_array[multirecord_obj[i].chat]){
						jschat_array[multirecord_obj[i].chat]=multirecord_obj[i].chat;
						synChat.chatList[n]={jschat:multirecord_obj[i].jschat,starttimestamp:multirecord_obj[i].starttimestamp,stoptimestamp:multirecord_obj[i].stoptimestamp,duration:multirecord_obj[i].duration};
						n++;
					}else {
						synChat.chatList[n-1].stoptimestamp = multirecord_obj[i].stoptimestamp;
					}
				}
			}
			if(synChat.chatList[0]){
				synChat.requestedData[synChat.chatList[0].jschat] = 1;
				$.ajax({
				  type: 'GET',
				  url: resPath+synChat.chatList[0].jschat,
				  dataType: 'json',
				  timeout: 15000,
				  success: function(data){
					  if ($.isArray(data.module.chat)) {
						  synChat.chatData = data.module.chat;
						  synChat.chatData.sort(chatTimeSort);
						  if (data.module.chat.length > 0) {
							  synChat.currentTime = data.module.chat[data.module.chat.length-1].timestamp;
						  }
						  var vs;
						  for ( var i = 0; i < synChat.chatData.length; i++) {
							  vs = synChat.chatData[i];
							  Sch.addTask(new Task("TYPE_CHAT", Number(vs.timestamp), Number(vs.timestamp)+1, vs));
						  }
					  }
				  },
				  error: function(xhr, type){
					console.log(resPath+synChat.chatList[0].jschat+"加载失败");
					if (synChat.chatList.length == 1) {
						synChat.chatGetMain();
					}
				  }
				});
			}else{
				synChat.chatGetMain();
			}
		}else if(multirecord_obj && multirecord_obj.jschat){
			var jschat = multirecord_obj.jschat;
			$.ajax({
				  type: 'GET',
				  url: resPath+jschat,
				  dataType: 'json',
				  timeout: 15000,
				  success: function(data){
					  if ($.isArray(data.module.chat)) {
						  synChat.chatData = data.module.chat;
						  synChat.chatData.sort(chatTimeSort);
						  if (data.module.chat.length > 0) {
							  synChat.currentTime = data.module.chat[data.module.chat.length-1].timestamp;
						  }
						  var vs;
						  for ( var i = 0; i < synChat.chatData.length; i++) {
							  vs = synChat.chatData[i];
							  Sch.addTask(new Task("TYPE_CHAT", Number(vs.timestamp), Number(vs.timestamp)+1, vs));
						  }
					  }
				  },
				  error: function(xhr, type){
					console.log("单一文件加载失败");
					synChat.chatGetMain();
				  }
				});
		}else {
			synChat.chatGetMain();
		}
	}
}
	
	synChat.chatGetMain = function(starttime) {
		synChat.chatList = [];
		if (synChat.chatMainFile) {
			if (starttime) {
				$.ajax({
					  type: 'GET',
					  url: resPath+synChat.chatMainFile,
					  dataType: 'json',
					  timeout: 15000,
					  success: function(data){
						  if ($.isArray(data.module.chat)) {
							  synChat.chatData = data.module.chat;
							  synChat.chatData.sort(chatTimeSort);
							  var vs;
							  for ( var i = 0; i < synChat.chatData.length; i++) {
								if (synChat.chatData[i].timestamp > synChat.currentTime) {
									vs = synChat.chatData[i];
									Sch.addTask(new Task("TYPE_CHAT", Number(vs.timestamp), Number(vs.timestamp)+1, vs));
								}
							  }
						  }
					  },
					  error: function(xhr, type){
					    console.log("默认chat.js加载失败");
					  }
					});
			}else {
				$.ajax({
					  type: 'GET',
					  url: resPath+synChat.chatMainFile,
					  dataType: 'json',
					  timeout: 15000,
					  success: function(data){
						  if ($.isArray(data.module.chat)) {
							  synChat.chatData = data.module.chat;
							  synChat.chatData.sort(chatTimeSort);
							  var vs;
							  for ( var i = 0; i < synChat.chatData.length; i++) {
								  vs = synChat.chatData[i];
								  Sch.addTask(new Task("TYPE_CHAT", Number(vs.timestamp), Number(vs.timestamp)+1, vs));
							  }
						  }
					  },
					  error: function(xhr, type){
					    console.log("默认chat.js加载失败");
					  }
					});
			}
		}else {
		console.log("没有默认chat.js");
		}
	}
	
    synChat.chatCurrent = function(starttime) {
		if(starttime>=synChat.duration){
			return;
		}
    	if (starttime < synChat.lastSeekTime || Number(starttime) - synChat.playTime > 3) {
			loadChatsSynClear();
			synChat.getMore(starttime);
			synChat.playTime = Number(starttime);
			return;
		}
		synChat.playTime = Number(starttime);
		if (synChat.chatList.length > 1) {
			var m=0;
			for(var i=0;i<synChat.chatList.length;i++){
				if(starttime >= synChat.chatList[i].starttimestamp &&  starttime<= synChat.chatList[i].stoptimestamp){
					if(synChat.requestedData[synChat.chatList[i].jschat]){
						
					}else{
						m++;
						synChat.requestedData[synChat.chatList[i].jschat]=1;
						$.ajax({
						  type: 'GET',
						  url: resPath+synChat.chatList[i].jschat,
						  dataType: 'json',
						  timeout: 15000,
						  success: function(data){
							if ($.isArray(data.module.chat)) {
								  var newdata = data.module.chat;
								  synChat.chatData = synChat.chatData.concat(newdata);
								  synChat.chatData.sort(chatTimeSort);
								  var vs;
								  for ( var j = 0; j < newdata.length; j++) {
									//放入任务调度
									  vs = newdata[j];
									  Sch.addTask(new Task("TYPE_CHAT", Number(vs.timestamp), Number(vs.timestamp)+1, vs));
								  }
							}
						  },
						  error: function(xhr, type){
							console.log('分片加载失败');
						  }
						});
					}
				}
			}
			if(m==0){
			}
		}
	}
    synChat.chatslice = function(index){
    	synChat.requestedData[synChat.chatList[index].jschat]=1;
    	$.ajax({
			  type: 'GET',
			  url: resPath+synChat.chatList[index].jschat,
			  dataType: 'json',
			  timeout: 15000,
			  success: function(data){
				if ($.isArray(data.module.chat)) {
					  var newdata = data.module.chat;
					  synChat.chatData = synChat.chatData.concat(newdata);
					  synChat.chatData.sort(chatTimeSort);
					  var vs;
					  for ( var j = 0; j < newdata.length; j++) {
						//放入任务调度
						  vs = newdata[j];
						  Sch.addTask(new Task("TYPE_CHAT", Number(vs.timestamp), Number(vs.timestamp)+1, vs));
					  }
					  if (synChat.slicemoreflag) {
						  loadChatsSynPre(synChat.getMoreChat());
					  }
				}
			  },
			  error: function(xhr, type){
				synChat.slicemoreflag = false;
				console.log('分片加载失败');
			  }
		});
    }
  
    synChat.getMore=function(currenttime){
    	var flag = false;
    	synChat.slicemoreflag = false;
    	if (currenttime) {
    		synChat.lastSeekTime = currenttime;
    		if (synChat.chatData.length > 0) {
				if (synChat.chatData[0].timestamp < currenttime) {
					synChat.lastTime = currenttime;
					flag = true;
				}
			}
		}
    	chatMore(flag);
    }
    
    synChat.getMoreChat=function(){
    	var chat = {more:false,data:[],needslice:false};
    	if (synChat.lastTime != 0) {
    		if (synChat.chatList.length <= 1) {
    			synChat.sliceStartTime = 0;
    			var chatdata = synChat.chatData;
    			var n = 0;
    			var len = chatdata.length - 1;
    			var m = 0;
	    		for(var i = len; i >= 0; i--){
	    			if (Number(chatdata[i].timestamp) < Number(synChat.lastTime) && Number(chatdata[i].timestamp) >= Number(synChat.sliceStartTime) && n < 50) {
	    				chat.data.push(chatdata[i]);
	    				m = i;
	    				n ++ ;
					}
	    		}
	    		if (n != 0 && m != 0) {
	    			chat.more = true;
				}
			}else{
				var sliceindex = 0;
				for(var i=0;i<synChat.chatList.length;i++){
					console.log(synChat.lastTime);
					console.log(synChat.chatList[i].starttimestamp);
					console.log(synChat.chatList[i].stoptimestamp);
					console.log(i);
					console.log(synChat.lastTime > synChat.chatList[i].starttimestamp);
					console.log(synChat.lastTime <= synChat.chatList[i].stoptimestamp);
	    			if(Number(synChat.chatList[i].starttimestamp) < Number(synChat.lastTime)   && Number(synChat.chatList[i].stoptimestamp) >=  Number(synChat.lastTime)){
	    				synChat.sliceStartTime = synChat.chatList[i].starttimestamp;
	    				sliceindex = i;
	    				if (i >= 1) {
	    					for(var j = i-1;j >= 0;j--){
	    						if (synChat.requestedData[synChat.chatList[j].jschat]) {
	    							synChat.sliceStartTime = synChat.chatList[j].starttimestamp;
	    							sliceindex = j;
								}else {
									break;
								}
	    					}
						}
	    				break;
	    			}
	    		}
	    		var chatdata = synChat.chatData;
	    		var n = 0;
	    		var len = chatdata.length - 1;
	    		var m = 0;
	    		for(var i = len; i >= 0; i--){
	    			if (Number(chatdata[i].timestamp) < Number(synChat.lastTime) && Number(chatdata[i].timestamp) >= Number(synChat.sliceStartTime) && n < 50) {
	    				chat.data.push(chatdata[i]);
	    				m = i;
	    				n++ ;
					}	
				}
	    		if (n != 0 && m != 0) {
	    			chat.more = true;
				}else if (n == 0 && m == 0){
					synChat.slicemoreflag = true;
					chat.needslice = true;
					if (sliceindex >= 2) {
						synChat.chatslice(sliceindex - 1)
					}
				}
	    	}
		}
    	chat.data.sort(chatTimeSort);
    	if (chat.data.length >= 1) {
    		synChat.lastTime = chat.data[0].timestamp;
		}
    	return chat;
    }
