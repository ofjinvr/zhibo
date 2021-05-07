(function(window,$){
var chatAndMsg=function(url,siteId,userId,confId){
  this.url=url;
  this.siteId=siteId;
  this.userId=userId;
  this.confId=confId;
  this.chatPage=1;
  this.more=true;
  this.qaPage = 1;
  this.qaMore = true;
}
chatAndMsg.prototype={
  chatDeal:function(parserXml,callFn){
  var that=this;
  if(that.more){
	  ajaxContent(this.url,
	  '<?xml version="1.0" encoding="utf-8"?><chatHistory siteid="'+this.siteId+'" userid="'+this.userId+'" confid="'+this.confId+'" live="false" page="'+this.chatPage+'"/>',
	  parserXml,
	  function(data){
	     if(data.page!=undefined&&data.page!=null&&typeof(data.page)!="undefined"&&data.page!=""&&data.page.length>0){
	       that.chatPage=data.page-0+1;
	     }else{
	       that.chatPage=that.chatPage+1;
	     }
	     if(data.more!="true"){
	       that.more=false;
	     }
	     callFn(data);
	 });  
   } 
 },
 msgDeal:function(parserXml,callFn){
    ajaxContent(this.url,
	  '<?xml version="1.0" encoding="utf-8"?><leaveMsgHistory siteid="'+this.siteId+'" userid="'+this.userId+'" confid="'+this.confId+'" live="false" />',
	  parserXml,
	  function(data){
	    callFn(data);
      });  
 },
 qaDeal: function (parserXml, callFn) {
 	var that = this;
 	if(that.qaMore){
         ajaxContent(this.url,
                 '<?xml version="1.0" encoding="utf-8"?><qaHistory siteid="' + this.siteId + '" userid="' + this.userId + '" confid="' + this.confId + '" live="false" page="' + this.qaPage +'"/>',
                 parserXml,
                 function (data) {
         	        if (data.page != undefined && data.page != null && typeof(data.page) != "undefined" && data.page != "" && data.page.length > 0) {
                         that.qaPage = data.page - 0 + 1;
                     } else {
                         that.qaPage = that.qaPage + 1;
                     }
                     if (data.more != "true") {
                         that.qaMore = false;
                     }
                     callFn(data);
                 });
 	}
 }
}
window.ChatMsg=chatAndMsg;
})(window,jQuery)