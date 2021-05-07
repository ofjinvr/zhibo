(function(window,$){
	var websocket=null;
	var isOpen=false;
	var isClosed=false;
	var msgArray=new Array();
	var logObject=function(ip,port,sessionId,fun){
	 if(ip.indexOf("ws")!=0){
	 	 ip="ws://"+ip
	 }	
	  var url=ip+":"+port;
	  try{
	  websocket= new WebSocket(url);
	  websocket.onopen=function(){
	  	isOpen=true;
	  	isClosed=false;
	  	websocket.send("startSend:"+sessionId);
	  	for(var i=0;i<msgArray.length;i++){
	  	 websocket.send("["+new Date().toTimeString()+"]"+msgArray[i]);	
	  	}
	  	msgArray=new Array()
	  }
	  websocket.onclose=function(){
	  	isOpen=false;	
	  	isClosed=true;
	  }
	  websocket.onerror=function(data){
        
	   }
	  }catch(e){
	    console.log(e);
	  }
	}
	logObject.prototype.send=function(msg){
		if(websocket!=null&&isOpen){
		  websocket.send(msg);	
		}else{
		  if(!isClosed){
		     msgArray.push(msg);
		  }
		  return false;	
		}
	}
	logObject.prototype.isClosed=function(){
	  return isClosed;
	}
    logObject.prototype.isOpen=function(){
	  return isOpen;
	}
	window.logUtils=logObject;
})(window,jQuery)
var LINSENER_START_DEBUG="linsener_start_debug_anroid_gensee_";
var staticLog=console.log;
var staticDebug=console.debug;
var staticInfo=console.info;
var staticWarn=console.warn;
var staticError=console.error;
var LINSENER_OPEN="open";
var LINSENER_CLOSED="closed";
var LOG_STAET_DEBUG_KEY="log_start_debug_key";
var LOG_STAET_KEY_VAR=0;
var LINSENER_ALREADY_STATUS=false;
var isSend=false;
var logObject=null;
var isWebcoscket=false;
var debugLog=function(msg){
    var dateTime=new Date();
    try{
       msg=JSON.stringify(msg);
     }catch(e){
     }
      if(isWebcoscket){
	      msg="type=websocket:"+"["+dateTime.toTimeString()+"]"+msg
	    }else{
	      msg="["+new Date().toTimeString()+"]"+msg
	    }
     if(logObject!=null){
      if(logObject.isOpen()||!logObject.isClosed()){
         logObject.send(msg);
      }
     }
     if(LINSENER_ALREADY_STATUS){
     if(logObject==null||!logObject.isClosed()){
  	  var storage=window.localStorage;
      storage.setItem(LOG_STAET_DEBUG_KEY+LOG_STAET_KEY_VAR,msg);
       LOG_STAET_KEY_VAR++;
     }}
}
var logConsole=function(msg){
   if(isSend){
     debugLog(msg)
   }
}
var debugConsole=function(msg){
   if(isSend){
     debugLog(msg)
   }
}
var infoConsole=function(msg){
   if(isSend){
     debugLog(msg)
   }
}
var warnConsole=function(msg){
   if(isSend){
     debugLog(msg)
   }
}
var errorLog=function(msg){
   if(isSend){
     debugLog(msg)
   }
}
function linserLog(){ 
	if(location.href.indexOf("debug=true")>0) return;
   if(searchHerf("logip")!=null&&searchHerf("logip").length>0){
         console.log=logConsole
		 console.debug=debugConsole;
		 console.info=infoConsole;
		 console.warn=warnConsole;
		 console.error=errorLog;
		 if(!openWebsocket(function(){openDebugLog()})){
	       openDebugLog()
         }
    }else{
       openDebugLog()
    }
}
function openDebugLog(){
     initLog();
	 if(window.addEventListener){
		 window.addEventListener("storage",function(){
		 initLog()},false);
		}else if(window.attachEvent){
		 window.attachEvent("onstorage",function(){
		 initLog()});
	 }	
}
function initLog(){
	 var storage=window.localStorage;
	 var debugValue= storage.getItem(LINSENER_START_DEBUG);
	 if(debugValue==null){
		 return;
	 }
	 if(debugValue==LINSENER_OPEN&&!LINSENER_ALREADY_STATUS){
	     console.log=logConsole
		 console.debug=debugConsole;
		 console.info=infoConsole;
		 console.warn=warnConsole;
		 console.error=errorLog;
		 LINSENER_ALREADY_STATUS=true;
		 isSend=true
		 LOG_STAET_KEY_VAR=0;
		 
	 }else if(debugValue==LINSENER_CLOSED&&LINSENER_ALREADY_STATUS){
	     console.log=logConsole
		 console.debug=debugConsole;
		 console.info=infoConsole;
		 console.warn=warnConsole;
		 console.error=errorLog;
	    LINSENER_ALREADY_STATUS=false;
	     isSend=false;
	 }
}
function openWebsocket(closedFun){
   var ip=searchHerf("logip");
   if(ip!=null){
      var port=searchHerf("logport");
      var sessionId=searchHerf("logid");
      if(port==null){
        port=888;
      }
      if(sessionId==null){
        sessionId=1;
      }
      try{
	    isSend=true;
        logObject=new window.logUtils(ip,port,sessionId,closedFun) 
        return true;
      }catch(e){
       isSend=false;
       console.log(e);
      }
   }
   return false;
}
function searchHerf(name){
  var searchString=document.location.search;
  if(searchString.length>0){
  searchString=searchString.substring(1);
  }
  var searchArray=searchString.split("&");
  for(var i=0;i<searchArray.length;i++){
      var keyValue=searchArray[i].split("=");
      if(keyValue.length==2){
         if(keyValue[0]==name){
           return keyValue[1];
         }
      }
  }
 return null;
}
linserLog();
