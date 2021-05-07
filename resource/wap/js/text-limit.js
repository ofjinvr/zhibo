/*
 * 富文本字数限制公共方法
 */


   //chat字符数校验
	function valChat(id,limitLen){
		var richText = $(id).html();
		if(richText.length > limitLen){
			if(getChgLen(id,richText) > limitLen){
				 $(id).html(getLimitMsg(id,richText,limitLen));
				 poDiv();
			}
		}
	}
	
	//粘贴和输入法一次输入多个字符的控制或者其他不可控情况下发送时截取
	function valSubChat(id,limitLen) {
		var richText = $(id).html();
		if(richText.length > limitLen){
			var len = getChgLen(id,richText);
			if(len > 255){
				var charlen = richText.length;
				var index = 0;
				var count =limitLen;
				//转义字符标识
				var escflag = false;
				//图片标识
				var picflag = false;
				for ( var i = 0; i < richText.length - 1 && count > 0; i++) {
					var txt = richText.charAt(i);
					index += 1;
					if (picflag) {
						if (txt == ">") {
							count -= 1;
							picflag = false;
						}
						continue;
					}
                    if (escflag) {
						if (txt == ";") {
							count -= 1;
							escflag = false;
						}
						continue;
					}
					if (txt == "<") {
				        picflag = true;
					}else if(txt == "&"){
						escflag = true;
					}else {
						count -= 1;
						continue;
					}
				}
				$(id).html(richText.substring(0,index));
				poDiv();
			}
		}
	}
	//将表情转换为一个字符后，转换后长度,html中转义字符很多，只能使用text判断字符个数，如果图片过多，此处会被频繁调用
	function getChgLen(id,msg){
		var text =$(id).text();
		var picObj = msg.match(/<img.*?emotion\/(.+?).(gif|png)\".*?>/gi);
		var picNum = picObj == null ? 0 : picObj.length;
		var len = text.length + picNum;
		return len;
	}
    //html中存在转义字符，方法用来删除长度过长是最后一个html中的一个字符或一个转义字符
	function getLimitMsg(id,msg,limitLen){
		var index = msg.length;
		//判断结束字符转义字符，图片，和普通字符
		if (msg.match(/&[^&]+;$/)){
			index = msg.search(/&[^&]+;$/);
		}else if(msg.match(/<img[^<]*?emotion\/([^<]+?).(gif|png)\"[^<]*?>$/)){
			index = msg.search(/<img[^<]*?emotion\/([^<]+?).(gif|png)\"[^<]*?>$/);
		}else {
			var excLen = getChgLen(id,msg) - limitLen;
			index = index - excLen;
		}
		var newmsg = msg.substring(0,index);
		return newmsg;
	}
	
	//chrome下div光标无法定位和blur，使用其他可编辑标签进行焦点操作
	function poDiv() {
		var obj = $("textarea") || $("input");
		try {
			obj.focus();
			obj.blur();
		} catch (e) {
			// TODO: handle exception
			console.log("error: no textarea or text input");
		}
		
    }