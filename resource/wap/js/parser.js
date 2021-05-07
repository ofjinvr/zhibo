function getXmlNodeAttr(node,attrName){
if(!node) return "";
if(!node.attributes) return "";
if(node.attributes[attrName]!=null) return node.attributes[attrName].value;
if(node.attributes.getNamedItem(attrName)!=null) return node.attributes.getNamedItem(attrName).value;
return "";
}
function parserXML(xml){
	console.log("[parser][parserXML]Start parser xml.")
	var objXml={};
	var rootNode=xml.documentElement;
	objXml.novideo=getXmlNodeAttr(rootNode,"novideo");
    objXml.hlsaudioonly=getXmlNodeAttr(rootNode,"hlsaudioonly");
    if(getXmlNodeAttr(rootNode,"ver")=="5"){
        objXml.hls=getXmlNodeAttr(rootNode,"mobilenormal");
        objXml.highHls=getXmlNodeAttr(rootNode,"mobilehigh");
    }else{
        objXml.hls=getXmlNodeAttr(rootNode,"hls");
    }
    objXml.duration=getXmlNodeAttr(rootNode,"duration");
    objXml.startTime=getXmlNodeAttr(rootNode,"starttime");
    objXml.jscontent=getXmlNodeAttr(rootNode,"js");
    objXml.playing=true;
    objXml.livetextfile=getXmlNodeAttr(rootNode,"livetextfile");
    objXml.voteSurveyList=new Array();
    objXml.lotteryArray=new Array();
    objXml.layoutArray=new Array();
    objXml.cardList= new Array();
    if(objXml.hls!=""){    
		var moduleArray=rootNode.getElementsByTagName("module");
		var pageList=new Array();
		for(var i=0;i<moduleArray.length;i++){			
		  if(getXmlNodeAttr(moduleArray[i],"name")=="document"){
			  var documentArray=moduleArray[i].childNodes;
			  for(var j=0;j<documentArray.length;j++){
				var documentName=getXmlNodeAttr(documentArray[j],"name"); 
				parserDocument(documentArray[j],documentName,pageList);
			  }
		  }else if(getXmlNodeAttr(moduleArray[i],"name")=="vote"||getXmlNodeAttr(moduleArray[i],"type")=="survey"){
			 var name=getXmlNodeAttr(moduleArray[i],"name");
			  var childArray=moduleArray[i].childNodes;
			  for(var k=0;k<childArray.length;k++){
				  console.log(getXmlNodeAttr(childArray[k],"type"));
				if(childArray[k].nodeName=='command' ){
				   if (getXmlNodeAttr(childArray[k],"type") == 'publish_card') {
					   parserCard(name,objXml.cardList,childArray[k]);
				   }else {
					   parserVoteSurvey(name,objXml.voteSurveyList,childArray[k]);
				   }
				 }
			  }
		  }else if(getXmlNodeAttr(moduleArray[i],"name")=="lottery"){
		    var lotteryArray=moduleArray[i].childNodes;
		    for(var g=0;g<lotteryArray.length;g++){
		        var lotteryObj=lotteryArray[g];
		        parserLottery(lotteryObj, objXml.lotteryArray);
		    }
		  }else if(getXmlNodeAttr(moduleArray[i],"name")=="layout"){
		     var layoutArray=moduleArray[i].childNodes;
		    for(var g=0;g<layoutArray.length;g++){
		        var layoutObj=layoutArray[g];
		        parserLayout(layoutObj,objXml.layoutArray);
		    }
		  }
		}
	 if(pageList.length>0){
	    pageList.sort(asc);
	    objXml.pageList=pageList;
	  }
	}else{
	  objXml.playing=false;
	}
	console.log("[parser][parserXML]Ended parser xml.")
	return objXml;
}
function parserLottery(lotteryObj,lotteryArray){
   var obj={};
   obj.cmd=getXmlNodeAttr(lotteryObj,"cmd");
   obj.timestamp=getXmlNodeAttr(lotteryObj,"timestamp");
   obj.info=getXmlNodeAttr(lotteryObj,"info");
    if($.trim(obj.cmd)!=""){
       lotteryArray.push(obj);
  }
}
function parserLayout(layoutObj,layoutArray){
  var obj={};
  
  obj.timestamp=getXmlNodeAttr(layoutObj,"timestamp");
  obj.type=getXmlNodeAttr(layoutObj,"type");
  if($.trim(obj.type)!=""){
    layoutArray.push(obj);
  }
}
function parserDocument(doc,docName,resultList){
	var pageArray=doc.childNodes;
	for(var i=0;i<pageArray.length;i++){
	 var pageObj=pageArray[i];
	 if(pageObj.nodeName=="page"){
	     var resultObj={};
	     resultObj.docName=docName;
	     resultObj.title=getXmlNodeAttr(pageObj,"title");
	     resultObj.hls=getXmlNodeAttr(pageObj,"hls");
	     resultObj.startTime=getXmlNodeAttr(pageObj,"starttimestamp");
	     resultObj.endTime=getXmlNodeAttr(pageObj,"stoptimestamp");
	     resultObj.content=getXmlNodeAttr(pageObj,'content');
	     resultList.push(resultObj);
      }
	}
    return resultList;
}
function asc(objx,objy){
	if((objx.startTime-0)>(objy.startTime-0)){
		return 1;
	}else{
		return -1;
	}
}
function parserVoteSurvey(name,voteSurveyList,doc){
	var obj={};
	obj.id=getXmlNodeAttr(doc,"id");
	obj.name=name;
	obj.skip=getXmlNodeAttr(doc,"skip");
	obj.startTime=getXmlNodeAttr(doc,"timestamp");
    var childArray=doc.childNodes;
    obj.questions=new Array();
    for(var i=0;i<childArray.length;i++){
    	if(childArray[i].nodeName=="subject"){
    	   	obj.title=$.trim(childArray[i].textContent);
    	}else if(childArray[i].nodeName=='question'){
    		var question={};
    		question.id=getXmlNodeAttr(childArray[i],"id");
    		question.type=getXmlNodeAttr(childArray[i],"type");
    		question.answer=getXmlNodeAttr(childArray[i],"answer");
    		parseQuestion(childArray[i],question);
    		obj.questions.push(question);
    	}
    }
    voteSurveyList.push(obj);
}

function parserCard(name,cardList,doc){
	var obj={};
	obj.id=getXmlNodeAttr(doc,"id");
	obj.name=name;
	obj.skip=getXmlNodeAttr(doc,"skip");
	obj.startTime=getXmlNodeAttr(doc,"timestamp");
    var childArray=doc.childNodes;
    obj.questions=new Array();
    for(var i=0;i<childArray.length;i++){
    	if(childArray[i].nodeName=="subject"){
    	   	obj.title=$.trim(childArray[i].textContent);
    	}else if(childArray[i].nodeName=='question'){
    		var question={};
    		question.id=getXmlNodeAttr(childArray[i],"id");
    		question.type=getXmlNodeAttr(childArray[i],"type");
    		question.answer=getXmlNodeAttr(childArray[i],"answer");
    		parseQuestion(childArray[i],question);
    		obj.questions.push(question);
    	}
    }
    cardList.push(obj);
}




function parseQuestion(doc,question){
	var childArray=doc.childNodes;
	var items=new Array();
	for(var i=0;i<childArray.length;i++){
		var child=childArray[i];
		if(child.nodeName=="subject"){
			question.subject=$.trim(child.textContent);
		}else if(child.nodeName=='item'){
		   var obj={};
		   obj.id=getXmlNodeAttr(child,"id");
		   obj.content=$.trim(child.textContent);
		   obj.correct=getXmlNodeAttr(child,"correct");
		   items.push(obj);
		}
	}
   question.items=items;
}
//root format {nodeName:nodeName(must),value:value(optional),attrArray:[{name:name(must),value:value(must)}](optional)}
function createXml(root,encoding){
	if(checkObjectIsNull(encoding)){
		encoding="";
	}else{
		encoding="encoding=\""+encoding+"\"";
	}
    var  xmlDoc="<?xml version=\"1.0\" "+encoding+"?>";
    if(!checkObjectIsNull(root)){
        xmlDoc+=createNode(root);
    }
	return xmlDoc;
}
//obj format {nodeName:nodeName(must),value:value(optional),attrArray:[{name:name(must),value:value(must)}](optional)}
function createNode(obj,isCdata){
	if(checkObjectIsNull(isCdata)){
		isCdata=true;
	}
	if(checkObjectIsNull(obj))return;
	if(checkObjectIsNull(obj.nodeName))return;
  var node="<"+obj.nodeName;
  if(!checkObjectIsNull(obj.attrArray)){
	  for(var i=0;i<obj.attrArray.length;i++){
		  var attr=obj.attrArray[i];
		  node+=" "+attr.name+"=\""+attr.value+"\""; 
	  }
  }
  var node=node+">"
  if(!checkObjectIsNull(obj.value)){
	  if(isCdata){
		node=node+"<![CDATA["+obj.value+"]]>";   
	  }else{
		node=node+obj.value;     
	  }   
  }
  var node=node+"</"+obj.nodeName+">"
  return node;
}
// parent is parent node, child is child node ,tag the insert label,indexof is the tag  in the parent of order ,from 1;
function addNode(parent,child,tag,indexof){
		 var result=0;
	if(!checkObjectIsNull(tag)){
	 if(checkObjectIsNull(indexof)){
		 indexof=1;
	 }
	 var cloneStr=parent;
	 var startIndex=0;
	 for(var i=0;i<indexof;i++){
		 startIndex=cloneStr.indexOf(tag,startIndex);
		 if(startIndex==-1)return;
		 var tempIndex=cloneStr.lastIndexOf("<",startIndex);
		 var tempEndTag=cloneStr.lastIndexOf("</",startIndex);
		 if(tempIndex<=tempEndTag){
			 i--;
		 }
		 startIndex=startIndex+tag.length;
	 }
	 if(startIndex==0)return;
	 cloneStr=cloneStr.substring(startIndex+tag.length);
	 result+=startIndex+tag.length
	 startIndex=0;
	 var s=0;
	 var con=true;
	 while(con){
		startIndex=cloneStr.indexOf(tag);
		if(startIndex==-1)return;
		var tempIndex=cloneStr.lastIndexOf("<",startIndex);
		var tempEndTag=cloneStr.lastIndexOf("</",startIndex);
		if(tempIndex<=tempEndTag){
		  s--;	
		}else{
		  s++;
		}
		if(s<0){
			result+=tempEndTag
			con=false;
		} 
	 }
	}else{
		var cloneStr=parent;
	    result=cloneStr.lastIndexOf("</");
	    if(result==-1)return;
	}
	return parent.substring(0,result)+child+parent.substring(result);
}
function getNodeValue(node){
	var textContent=$.trim(node.textContent);
	return textContent;
}