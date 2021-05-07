function checkObjectIsNull(obj){
	if(obj==null||obj==undefined||typeof(obj)=='undefined'){
		return true;
	}else{
		return false;
	}
}
function replaceStr(str){
	if(checkObjectIsNull(str)){
		return str;
	}else{ 
		str=str.replace(/~/g,"~1");
		str=str.replace(/%/g,"~0");
		str=str.replace(/&/g,"~2");   
		str=str.replace(/@/g,"~3");
		str=str.replace(/\$/g,"~4");
		str=str.replace(/#/g,"~5");
		str=str.replace(/\+/g,"~6");
		return str;
	}
}
function isFunction(obj){
	if(checkObjectIsNull(obj)){
		return false;
	}
	if(typeof(obj)=="function"){
		return true;
	}else{
		return false;
	}
}
function isNumber(obj){
  if(checkObjectIsNull(obj)){
		return false;
	}
	if(typeof(obj)=="number"){
		return true;
	}else{
		return false;
	}
}
function serviceAddress(url){
	url=$.trim(url);
	if(url.indexOf("http://")==0){
	 	var index=url.indexOf("/","http://".length+1);
	 	if(index<0){
	 		return url;
	 	}else{
	 		return url.substring(0,index);
	 	}
	}else{
		return "";
	}
}
function lastAddress(url){
	url=$.trim(url);
	var index=url.lastIndexOf("/");
	if(url.lastIndexOf("/")>0){
		return url.substring(0,index+1);
	}else{
		return url;
	}
}
function fillUrl(surl,eurl){
	surl=$.trim(surl);
	if(surl.indexOf("http://")==0){
		return surl;
	}else{
		return lastAddress(eurl)+surl;
	}
}
 function replace(target,replaceArray){
   for(var i=0;i<replaceArray.length;i++){
      var replaceObj=replaceArray[i];
      target=target.replace(replaceObj[0],replaceObj[1]);    
   }
   return target;
}

