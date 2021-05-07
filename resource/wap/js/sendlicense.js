var licenseObj;
var keepLiveServer=null;
function sendLicense(obj){
    
	console.log("[sendLicense]The sendLicense is start.")
	licenseObj=obj;
	licenseObj.watchMaxDuration=0;
	licenseObj.startTime=new Date().getTime();
	licenseObj.lastTime=0;
	licenseObj.needlicense="1";
	licenseObj.isFirstStartPlay=true;
	keepLiveServer=licenseObj.service;
	isFirstStartPlay();
	updateTime();
	isEndVideo();
	lisenceFn();
	window.setInterval("lisenceFn()",licenseObj.intervalTime);
	$(window).unload(function(){
	       	 licenseObj.live=false;
	       	 lisenceFn();
	   })
}
function lisenceFn(){
  var service=licenseObj.service;
  var siteid="siteid="+licenseObj.siteId;
  var userid="userid="+licenseObj.userId;
  var confid="confid="+licenseObj.confId;
  var username="username="+encodeURIComponent(licenseObj.username);
  var tid="tid="+licenseObj.tkId+",t="+Math.round(liveTime())+",d="+Math.round(licenseObj.watchMaxDuration*1000)+",v="+Math.round(licenseObj.totalTime*1000)+",sc=2,pos="+Math.round(licenseObj.popcorn.currentTime*1000);
  if(licenseObj.tkExtend!=""&&licenseObj.tkExtend.length>0){
    tid=tid+","+licenseObj.tkExtend;
  }
  var other="other="+escape(tid);
  console.log("[sendlicense]The other is value:"+other+";licenseObj.session:"+licenseObj.session+";tid:"+tid);
  var onlylogin="onlylogin="+licenseObj.onlylogin;
  if(!licenseObj.session){
    type="type=0";
    var url=licenseObj.service+"?"+siteid+"&"+userid+"&"+confid+"&"+onlylogin+"&"+type+"&"+username+"&r="+new Date().getTime();
    var hostid = "";
    if (licenseObj.hostId == "" || licenseObj.hostId == null || licenseObj.hostId == undefined) {
  	  hostid = "";
    }else {
  	  hostid="hostid="+licenseObj.hostId;
  	  url += "&"+ hostid;
    }
    var xmlUrl=war_context_path+"/site/xmlService";
    var backUrl=licenseObj.albBackService+"?"+siteid+"&"+userid+"&"+confid+"&"+onlylogin+"&"+type+"&"+username+"&r="+new Date().getTime(); 
    console.log("[license] the license url:"+xmlUrl+"?encodeXml="+escape(url));
    getSessionId(url,xmlUrl,url,backUrl);
  }else{
	type="type=1";
	if(licenseObj.live){
		type="type=2";
	}
	sessionid="sessionid="+licenseObj.session;
	needlicense="needlicense="+licenseObj.needlicense;
	var url=visitScheme+keepLiveServer+"?"+siteid+"&"+userid+"&"+confid+"&"+onlylogin+"&"+type+"&"+sessionid+"&"+needlicense+"&"+other+"&"+username+"&r="+new Date().getTime();  
	console.log("[license]  the service url : "+licenseObj.service); 	
    console.log("[license] the other infomation : "+tid); 
    console.log("[license] url:"+url);
	licenseObj.imgObj.attr("src",url);
  }
}
function liveTime(){
 return new Date().getTime()-licenseObj.startTime;
}
function updateTime(){
	var medioObj=licenseObj.popcorn;
	medioObj.addEventListener("timeupdate",updateTimeBind);	
}
function updateTimeBind(){ 
        	var medioObj=licenseObj.popcorn;
		if(medioObj.currentTime>licenseObj.lastTime){
		 licenseObj.watchMaxDuration+=medioObj.currentTime-licenseObj.lastTime;
		}
		licenseObj.lastTime=medioObj.currentTime;	
	}
function isEndVideo(){
	var medioObj=licenseObj.popcorn;
	medioObj.addEventListener("ended",endVideoBind);
}
function endVideoBind(){
	licenseObj.needlicense="1";
}
function isFirstStartPlay(){
	var medioObj=licenseObj.popcorn;
	medioObj.addEventListener("canplay",startPlayBind);
}
function startPlayBind(){
	licenseObj.isFirstStartPlay=false;
}
function unbindAllFunction(){
	var medioObj=$(licenseObj.popcorn);
	medioObj.unbind("timeupdate",updateTimeBind);
	medioObj.unbind("ended",endVideoBind);
	medioObj.unbind("canplay",startPlayBind);
}
function switchPlay(playId){
	unbindAllFunction();
	licenseObj.popcorn=document.getElementById(playId);
	isFirstStartPlay();
	updateTime();
	isEndVideo();
	licenseObj.licenseSwitch.call(this,playId);
}
function getSessionId(url,xmlUrl,dataUrl,backUrl){
	if(url.indexOf("http://")<0 && url.indexOf("https://")<0){
		url="http://"+url;
	}
	if (visitScheme == "https://" && url.indexOf("https://")<0) {
		url = url.replace("http://","https://");
	}
	console.log("[getSessionId] url:"+url)
	   $.ajax({
             url:url,
             success:function(dataArrayList){
		       if(dataArrayList==""){
            	 console.log("[getSessionIdByService] the license error!");
            	 getSessionIdByBackALB(backUrl,dataUrl,xmlUrl,url);
               }else{
               var msg="";
               var dataArray=dataArrayList.split(",");
               var data=dataArray[0];
               console.log("[getSessionId] the license success!");
               if(data=="-1"){
            	   msg=licenseObj.alreadyLogin;
            	   msg=encodeURIComponent(msg);
    		       licenseObj.liceseReason=2;
    		       sendError(msg)
               }else if(data=="0"){
            	   msg=licenseObj.notEnoughLicense;
            	   msg=encodeURIComponent(msg);
    		       licenseObj.liceseReason=1;
    		       sendError(msg)
               }else{  
                   keepLiveServer=licenseObj.service;
            	   licenseObj.session=data;
            	   console.log("[getSessionId] the sessionId:"+licenseObj.session);
            	   if(dataArray.length>1){
            		  var endStr= dataArray[1].substring(dataArray[1].length-1);
            		   if(endStr=="/"){
            			licenseObj.sessionCallXml.sessionDataUrlInfo=dataArray[1];   
            		   }else{
            			 licenseObj.sessionCallXml.sessionDataUrlInfo=dataArray[1]+"/"; 
            		   }
                	   
                	   licenseObj.sessionCallXml.isSessionDataUrlInfo=true;
            	   }else{
            		   licenseObj.sessionCallXml.isSessionDataUrlInfo=false;
            	   }
            	   licenseObj.sessionCall.call(this,licenseObj.sessionCallXml,licenseObj.sessionCallParams);
               }
              }
             },
             error:function(){
            	console.log("[getSessionId] the license error!");
            	getSessionIdByBackALB(backUrl,dataUrl,xmlUrl,url);
             }
           }
          );
}
function getSessionIdByService(xmlUrl,url,backUrl,serviceUrl){
	console.log("[getSessionIdByService]xmlUrl:"+xmlUrl+";url:"+url);
	  $.ajax({
    	    type: 'POST',
             url:xmlUrl,
             data:{encodeXml:url},
             success:function(dataArrayList){
            	  var dataArray=dataArrayList.split(",");
               var data=dataArray[0];
               var msg="";
            	 console.log("[getSessionIdByService] the license success!");
               if(data=="-1"){
            	   msg=licenseObj.alreadyLogin;
            	   msg=encodeURIComponent(msg);
    		       licenseObj.liceseReason=2;
    		       sendError(msg);
               }else if(data=="0"){
            	   msg=licenseObj.notEnoughLicense;
            	   msg=encodeURIComponent(msg);
    		         licenseObj.liceseReason=1;
    		       sendError(msg)
               }else if(data==undefined||data.length==0){
            	   msg=licenseObj.notApplicationLicense;
            	   msg=encodeURIComponent(msg);
            	   licenseObj.liceseReason=3;
            	   sendError(msg);
               }else{   
            	   licenseObj.session=data;
            	   keepLiveServer=licenseObj.service;
            	   console.log("[getSessionIdByService] the sessionId:"+licenseObj.session);
            	   if(dataArray.length>1){
                	  var endStr= dataArray[1].substring(dataArray[1].length-1);
            		   if(endStr=="/"){
            			licenseObj.sessionCallXml.sessionDataUrlInfo=dataArray[1];   
            		   }else{
            			 licenseObj.sessionCallXml.sessionDataUrlInfo=dataArray[1]+"/"; 
            		   }
            	       licenseObj.sessionCallXml.isSessionDataUrlInfo=true;
            	   }else{
            		   licenseObj.sessionCallXml.isSessionDataUrlInfo=false;
            	   }
            	   licenseObj.sessionCall.call(this,licenseObj.sessionCallXml,licenseObj.sessionCallParams);
               }
            },
            error:function(e){
            	   console.log("[getSessionIdByService] the license error!");
            	   getSessionIdByBackALB(backUrl,serviceUrl,xmlUrl,url);
            	   
            }
         }
       );
}
function getSessionIdByBackALB(backUrl,serviceUrl,xmlUrl,dataUrl){
	if(backUrl.indexOf("http://")<0 && backUrl.indexOf("https://")<0){
		backUrl="http://"+url;
	}
	if (visitScheme == "https://" && backUrl.indexOf("https://")<0) {
		backUrl = backUrl.replace("http://","https://");
	}
	console.log("[getSessionIdByBackALB] url:"+backUrl)
	   $.ajax({
             url:backUrl,
             success:function(dataArrayList){
               var msg="";
               var dataArray=dataArrayList.split(",");
               var data=dataArray[0];
            	 console.log("[getSessionIdByBackALB] the license success!");
               if(data=="-1"){
            	   msg=licenseObj.alreadyLogin;
            	   msg=encodeURIComponent(msg);
    		       licenseObj.liceseReason=2;
    		       sendError(msg)
               }else if(data=="0"){
            	   msg=licenseObj.notEnoughLicense;
            	   msg=encodeURIComponent(msg);
    		       licenseObj.liceseReason=1;
    		       sendError(msg)
               }else{  
                     keepLiveServer=licenseObj.albBackService;
            	   licenseObj.session=data;
            	   console.log("[getSessionIdByBackALB] the sessionId:"+licenseObj.session);
            	   if(dataArray.length>1){
            		  var endStr= dataArray[1].substring(dataArray[1].length-1);
            		   if(endStr=="/"){
            			licenseObj.sessionCallXml.sessionDataUrlInfo=dataArray[1];   
            		   }else{
            			 licenseObj.sessionCallXml.sessionDataUrlInfo=dataArray[1]+"/"; 
            		   }
                	   
                	   licenseObj.sessionCallXml.isSessionDataUrlInfo=true;
            	   }else{
            		   licenseObj.sessionCallXml.isSessionDataUrlInfo=false;
            	   }
            	   licenseObj.sessionCall.call(this,licenseObj.sessionCallXml,licenseObj.sessionCallParams);
               }
             },
             error:function(){
            	console.log("[getSessionIdByBackALB] the license error!");
            	getSessionId(serviceUrl,xmlUrl,dataUrl,backUrl);
             }
           }
          );
}
function sendError(msg){
	var url=war_context_path+"/site/config!lc?code="+licenseObj.code;
			 $.ajax({
             url:url,
             success:function(data){
            		console.log("[license] the first play infomation areadly sended is success,the url:"+url);           	
                    document.location.href=licenseObj.href+msg;
			 },
			 error:function(){        	
            		console.log("[license] the first play infomation areadly sended is error,the url:"+url);
			         document.location.href=licenseObj.href+msg;
			 }
			 });
}
