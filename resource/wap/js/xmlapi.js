function getQaAndMsg(url,content,fn){
console.log("[xmlapi][init] Start to get Qa and Msg infomation.");
var xml;
var xmlhttp;
if (window.XMLHttpRequest)
  {// code for IE7+, Firefox, Chrome, Opera, Safari
  xmlhttp=new XMLHttpRequest();
  }
else
  {// code for IE6, IE5
  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
  }
xmlhttp.onreadystatechange=function()
  {
  if (xmlhttp.readyState==4 && xmlhttp.status==200)
    {
	  console.log("[xmlapi][init] The Ajax is success.")
	  xml=xmlhttp.responseXML;
	         //FF   
	     if(xml==null){
	     var xmlDoc;
	     xml=xmlhttp.responseText
        if (document.implementation.createDocument) {   
            var parser = new DOMParser()   
            xmlDoc = parser.parseFromString(xml, "application/xml")   
           //IE   
          } else if (window.ActiveXObject) {   
            xmlDoc = new ActiveXObject("Microsoft.XMLDOM")   
            xmlDoc.async="false"  
            xmlDoc.loadXML(xml)   
         }
	     xml=xmlDoc
        }
         fn.call(this,xml);
    }
  }
 xmlhttp.open("post",url,true);
 xmlhttp.send(content);
 console.log("[xmlapi][content]"+content);
}
function parserXml(xml){
console.log("[xmlapi][init] Parsed xml infomation.")
var obj={};
if(typeof xml!=undefined&&xml!=null){
 var rootNode=xml.documentElement;
 var qa=rootNode.getElementsByTagName("qa");
 var qaArray=new Array();
 for(var i=0;i<qa.length;i++){
	 var qaObj={};
	 qaObj.question=getXmlNodeAttr(qa[i],"question");
	 qaObj.questionTime=getXmlNodeAttr(qa[i],"questiontimestamp");
	 qaObj.questionName=getXmlNodeAttr(qa[i],"questionowner");
	 qaObj.answerTime=getXmlNodeAttr(qa[i],"qaanswertimestamp");
	 qaObj.answerName=getXmlNodeAttr(qa[i],"answerowner");
	 qaObj.answer=getXmlNodeAttr(qa[i],"answer");
     qaArray.push(qaObj);
 }
 obj.qaArray=qaArray;
  var msg=rootNode.getElementsByTagName("msg");
  var msgArray=new Array();
  for(var i=0;i<msg.length;i++){
	 var msgObj={};
	 msgObj.question=getXmlNodeAttr(msg[i],"question");
	 msgObj.questionTime=getXmlNodeAttr(msg[i],"questiontimestamp");
	 msgObj.questionName=getXmlNodeAttr(msg[i],"questionowner");
	 msgObj.answerTime=getXmlNodeAttr(msg[i],"qaanswertimestamp");
	 msgObj.answerName=getXmlNodeAttr(msg[i],"answerowner");
	 msgObj.answer=getXmlNodeAttr(msg[i],"answer");
	 msgArray.push(msgObj);
   }
   obj.msgArray=msgArray;
 }else{
		 console.log("[xmlapi][init] Through the Ajax  return value is empty.")
 }
  createHtml(obj)
}
function createHtml(obj){	
  console.log("[xmlapi][init] Through the xml to create Q.A and MSG.")
	var qaArray=obj.qaArray;
	var qaDiv=$("#qa");	
	if(typeof qaArray!="undefined"){ 
	for(var i=0;i<qaArray.length;i++){
	   var qaObj=qaArray[i]; 
	   var p=$("<p></p>");
	    if(qaObj.question!=""&&qaObj.question!=undefined){
	    	p.html(toDate(qaObj.questionTime)+"&nbsp;&nbsp;"+qaObj.questionName+":"+qaObj.question+"<br/>");
	    }
	      if(qaObj.answer!=""&&qaObj.answer!=undefined){
	    	p.html(p.html()+toDate(qaObj.answerTime)+"&nbsp;&nbsp;"+qaObj.answerName+":"+qaObj.answer);   
	    }
	  	qaDiv.append(p);
	}
  }
     qaDiv.append($("<p>&nbsp;</p>"));
	 qaDiv.append($("<p>&nbsp;</p>"));
   var msgArray=obj.msgArray;
	var msgDiv=$("#msg");
	
  if(typeof msgArray!="undefined"){
	for(var i=0;i<msgArray.length;i++){
	   var msgObj=msgArray[i]; 
	   var p=$("<p></p>");
	    if(msgObj.question!=""&&msgObj.question!=undefined){
	    	p.html(toDate(msgObj.questionTime)+"&nbsp;&nbsp;"+msgObj.questionName+":"+msgObj.question+"<br/>");
	    }
	    if(msgObj.answer!=""&&msgObj.answer!=undefined){
	    	p.html(p.html()+toDate(msgObj.answerTime)+"&nbsp;&nbsp;"+msgObj.answerName+":"+msgObj.answer);
	    }
	     msgDiv.append(p);  
	}
 }
	 msgDiv.append($("<p>&nbsp;</p>"));
	 msgDiv.append($("<p>&nbsp;</p>"));
	 	
  $("#player-ppt2 .scroll").each(
		function(){
			$(this).height($("#player-ppt-content").height()-3*40)
		}  
  );
  $("#player-ppt2").css("display","block");
	console.log("[init] InitObj.qaScroll is created.");
    initObj.qaScroll=new iScroll( initObj.qaScrollId);
    $("#msgScroll").css("display","block");
	console.log("[init] initObj.msgScrollId is created.")
	 
    initObj.msgScroll=new iScroll(initObj.msgScrollId);
   $("#msgScroll").css("display","none");   
   $("#player-ppt2").css("display","none");
   console.log("[xmlapi][init] Create Q.A and MSG are ended.")
}
function toDate(dateTime){
	dateTime=dateTime-0;
	var date=new Date(dateTime*1000);
     var hours=	date.getHours();
     var minus=date.getMinutes();
     var second=date.getSeconds();
     if(minus<10){
    	 minus="0"+minus;
     }
   if(hours<10){
    	 hours="0"+hours;
     }
     if(second<10){
    	 second="0"+second;
     }
     return hours+":"+minus+":"+second;
}
