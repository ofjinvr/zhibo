var Util = {
	trim:function(str) {
		if (typeof str !== "string") {
			return str;
		}
		if (typeof str.trim === "function") {
			return str.trim();
		} else {
			return str.replace(/^(\u3000|\s|\t|\u00A0)*|(\u3000|\s|\t|\u00A0)*$/g, "");
		}
	},
	isEmpty:function(obj){
		if(obj === undefined){
			return true;
		}else if(obj==null){
			return true;
		}else if(typeof obj === "string"){
			if(this.trim(obj) == ""){
				return true;
			}
		}
		return false;
	},
	isNotEmpty:function(obj){
		return !this.isEmpty(obj);
	},
	breachHTML:function(str){
		if(typeof str !== "string" || this.isEmpty(str))return str;
		return str.replace(/\</g,"&lt;");
	},
	escapeHTML:function(str){
		if(typeof str !== "string" || this.isEmpty(str))return str;
		return str.replace(/\&/g,"&amp;").replace(/\</g,"&lt;");
	},
	checkTime:function(num){
		var n = Number(num);
		if(n<10)n = "0"+n;
		return n;
	},
	timeDuration : function(second) {
		if (!second || isNaN(second))
			return;
		second = parseInt(second);
		var time = '';
		var hour = second / 3600 | 0;
		if (hour != 0) {
			time += this.checkTime(hour) + ':';
		}
		var min = (second % 3600) / 60 | 0;
		time += this.checkTime(min) + ':';
		var sec = (second - hour * 3600 - min * 60) | 0;
		time += this.checkTime(sec);
		return time;
	},
	calcPercent : function(value, total) {
		if (isNaN(value) || Number(value) == 0)
			return "0";
		if (isNaN(total) || Number(total) == 0)
			return "0";
		return Math.round(Number(value) * 100 / Number(total));
	},
	formatTime : function(time) {
		var date = new Date();
		date.setTime(time);
		var h = date.getHours();
		var m = date.getMinutes();
		var s = date.getSeconds();
		return this.checkTime(h) + ":" + this.checkTime(m) + ":" + this.checkTime(s);
	},
	//占位符替换
	replaceholder:function(str, values){
		return str.replace(/\{(\d+)\}/g, function(m, i) {
			return values[i];
		});
	}
};