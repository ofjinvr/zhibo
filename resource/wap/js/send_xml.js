function sendContent(url,content,fn,errorFn){
console.log("[xmlapi][init] Start to get Qa and Msg infomation.");
console.log("[xmlapi sendContent]"+url);
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
    }else if(xmlhttp.readyState==4 && xmlhttp.status!=200){
      if(errorFn==null||errorFn==undefined||typeof(errorFn)=='undefined'||typeof(errorFn)!='function'){
        console.log("[sendContent]result status:"+xmlhttp.status)
      }else{
        errorFn.call(this,xml, xmlhttp.status);
       }
    }
  }
 xmlhttp.open("post",url,true);
 xmlhttp.send(content);
 console.log("[xmlapi][content]"+content);
}

