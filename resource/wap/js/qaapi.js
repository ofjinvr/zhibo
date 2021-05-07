function ajaxContent(url,content,fn,callFun){
console.log("[xmlapi][init] Start to get Qa and Msg infomation.")
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
         fn.call(this,xml,callFun);
    }
  }
 xmlhttp.open("post",url,true);
 xmlhttp.send(content);
 console.log("[xmlapi][content]"+content);
}
function parserXml(xml,fn){
console.log("[xmlapi][init] Parsed xml infomation.") 
var obj={};
if(typeof xml!=undefined&&xml!=null){
 var rootNode=xml.documentElement;
 var qa=rootNode.getElementsByTagName("qa");
 var qaArray=new Array();
 for(var i=0;i<qa.length;i++){
	 var qaObj={};
	 qaObj.questionid=getXmlNodeAttr(qa[i],"id");
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
  var chatlistNode=rootNode.getElementsByTagName("chatlist");
 var chatArray=new Array();
 for(var i=0;i<chatlistNode.length;i++){
    var chatList=chatlistNode[i].getElementsByTagName("chat");
    for(var j=0;j<chatList.length;j++){
     var chatObject={};
     chatObject.time=getXmlNodeAttr(chatList[j],"time");
     chatObject.sender=getXmlNodeAttr(chatList[j],"sender");
     chatObject.receiver=getXmlNodeAttr(chatList[j],"receiver");
     chatObject.content=getNodeValue(chatList[j]);
     chatArray.push(chatObject);
    }
 }
 obj.chatArray=chatArray;
 console.log("call function:"+obj)
  fn.call(this,obj)
}
function parserMsgXml(xml,fn){
var obj={};
if(typeof xml!=undefined&&xml!=null){
   var msgArray=new Array();
 var rootNode=xml.documentElement;
  var msg=rootNode.getElementsByTagName("msg");
  for(var i=0;i<msg.length;i++){
	 var msgObj={};
	 msgObj.id=getXmlNodeAttr(msg[i],"id");
	 msgObj.question=getXmlNodeAttr(msg[i],"question");
	 msgObj.questionTime=getXmlNodeAttr(msg[i],"questiontimestamp");
	 msgObj.questionName=getXmlNodeAttr(msg[i],"questionowner");
	 msgObj.answerTime=getXmlNodeAttr(msg[i],"qaanswertimestamp");
	 msgObj.answerName=getXmlNodeAttr(msg[i],"answerowner");
	 msgObj.answer=getXmlNodeAttr(msg[i],"answer");
	 msgArray.push(msgObj);
   }
   obj.list=msgArray;
 }else{
	 console.log("[xmlapi][init] Through the Ajax  return value is empty.")
 }
  fn.call(this,obj)
}
function parseChatXml(xml,fn){
var obj={};
if(typeof xml!=undefined&&xml!=null){
   var chatArray=new Array();
 var rootNode=xml.documentElement;
  var chatlist=rootNode.getElementsByTagName("chatlist"); 
 for(var j=0;j<chatlist.length;j++){
   obj.more=getXmlNodeAttr(chatlist[j],"more");
   obj.page=getXmlNodeAttr(chatlist[j],"page");
  var chat=chatlist[j].getElementsByTagName("chat");
  for(var i=0;i<chat.length;i++){
	 var chatObject={};
	 chatObject.time=getXmlNodeAttr(chat[i],"time");
     chatObject.sender=getXmlNodeAttr(chat[i],"sender");
     chatObject.receiver=getXmlNodeAttr(chat[i],"receiver");
     chatObject.content=getNodeValue(chat[i]);
     chatObject.senderRole=getXmlNodeAttr(chat[i],"senderRole");
     chatArray.push(chatObject);
   }
  }
   obj.list=chatArray;
 }else{
	 console.log("[xmlapi][init] Through the Ajax  return value is empty.")
 }
  fn.call(this,obj)
}

function parseQaXml(xml,fn){
	var obj={};
	if(typeof xml!=undefined&&xml!=null){
	 var rootNode=xml.documentElement;
	 var qa=rootNode.getElementsByTagName("qa");
	 obj.more = rootNode.getAttribute("more");
	 obj.page = rootNode.getAttribute("page");
	 var qaArray=new Array();
	 for(var i=0;i<qa.length;i++){
		 var qaObj={};
		 qaObj.questionid=getXmlNodeAttr(qa[i],"id");
		 qaObj.question=getXmlNodeAttr(qa[i],"question");
		 qaObj.questionTime=getXmlNodeAttr(qa[i],"questiontimestamp");
		 qaObj.questionName=getXmlNodeAttr(qa[i],"questionowner");
		 qaObj.answerTime=getXmlNodeAttr(qa[i],"qaanswertimestamp");
		 qaObj.answerName=getXmlNodeAttr(qa[i],"answerowner");
		 qaObj.answer=getXmlNodeAttr(qa[i],"answer");
	     qaArray.push(qaObj);
	 }
	 obj.qaArray=qaArray;
	}
	console.log("call function:"+obj)
	fn.call(this,obj)
}