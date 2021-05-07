var messageXml=function(url,fun,obj){
console.log("[messageXml]The url is"+url)
this.xmlurl=url;
this.completeFun=fun;
this.params=obj;
this.createIframe=createIframe;
this.messageChange=messageChange;
this.createIframe();
getXmlData(url);
}
function createIframe(){
console.log("[createIframe] the iframe is start.");
var that=this;
that.iframeObj=$("<iframe>");
that.iframeObj.css("display","none");
that.iframeObj.attr("src",that.xmlurl);
$(document.body).append(that.iframeObj);
}
function messageChange(e){
	console.log("[messageChange]The message is start.")
	var that=this;
	var xml=e.data;
	that.xml=xml;
	that.iframeObj.remove();
	that.completeFun.call(this,xml,this.params);
}
function getXmlData(xmlUrl){
	   $.ajax({
             url:xmlUrl,
             dateType:'xml',
             success:function(xml){
               console.log("[getXmlData] Ajax is success.");
               var xmlDoc=parserXML(xml)
               console.log("[getXmlData] The xml analytical result:"+xmlDoc);
               var e={data:xmlDoc};
               messageChange(e)
             },
             error:function(){
            	 console.log("[getXmlData]The xmlUrl:"+xmlUrl+" is error.")
             }
           }
          );
}