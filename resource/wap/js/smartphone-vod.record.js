/*
 * ====================================================
 * 标注
 */
if (typeof pptRecord == "undefined") {
	pptRecord = {
		history_data:{},
		pointer_list:[],
		record_canvas:{},
		is_pptRecord:0,
		now_page_id:'',
		now_page_k:0,
		record_last_time:0,
		record_max_time:0,
		record_page:[],
		record_page_id:{},
		//record_page_time:[],
		record_datas:{},
		record_datas_time:{},
		page_arr:[],
		page_list:{},
		record_jsanno:[],
		record_jsanno_old:{},
		record_MainAnno:''
	};
}


//加载record
function pptGetRecord(data){
	console.log('加载record.js');
	console.log(data);
	if(data.conf.jsanno && data.conf.jsanno!=null){
		pptRecord.record_max_time=parseFloat(data.conf.duration)*1000;
		pptRecord.record_MainAnno=data.conf.jsanno;
		var k=0;
		var document_obj={};
		var multirecord_obj={};
		for(var m=0;m<data.conf.module.length;m++){
			if(data.conf.module[m].name=='document'){
				document_obj=data.conf.module[m].document;
			}else if(data.conf.module[m].name=='multirecord'){
				multirecord_obj=data.conf.module[m].multirecord;
			}
		}
		//解析document
		if(multirecord_obj){
			console.log("判断document",$.isArray(document_obj));
			if($.isArray(document_obj)){
				for (var i = 0; i < document_obj.length; i++) {
					if($.isArray(document_obj[i].page)){
						//console.log(document_obj[i].page);
						for (var j = 0; j < document_obj[i].page.length; j++) {
							
							var page_id=document_obj[i].id+'_'+document_obj[i].page[j].id;
							if(k==0){
								pptRecord.now_page_id=page_id;
							}
							var width=parseInt(document_obj[i].page[j].width);
							var height=parseInt(document_obj[i].page[j].height);
							var starttimestamp=parseFloat(document_obj[i].page[j].starttimestamp)*1000;
							var stoptimestamp=parseFloat(document_obj[i].page[j].stoptimestamp)*1000;
							var hls=document_obj[i].page[j].hls;
							//console.log({page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls});
							pptRecord.record_page[k]={page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls};
							pptRecord.record_page_id[page_id]={page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls};
							k++;
							//pptRecord.record_page_time[k]={page_id:page_id,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp};
						}
						//console.log(pptRecord.record_page);
					}else{
						//console.log(document_obj[i].page);
						var page_id=document_obj[i].id+'_'+document_obj[i].page.id;
						if(k==0){
							pptRecord.now_page_id=page_id;
						}
						var width=parseInt(document_obj[i].page.width);
						var height=parseInt(document_obj[i].page.height);
						var starttimestamp=parseFloat(document_obj[i].page.starttimestamp)*1000;
						var stoptimestamp=parseFloat(document_obj[i].page.stoptimestamp)*1000;
						var hls=document_obj[i].page.hls;
						
						pptRecord.record_page[k]={page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls};
						pptRecord.record_page_id[page_id]={page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls};
						k++;
					}
				}
			}else{
				if($.isArray(document_obj.page)){
					for (var j = 0; j < document_obj.page.length; j++) {
						
						var page_id=document_obj.id+'_'+document_obj.page[j].id;
						if(k==0){
							pptRecord.now_page_id=page_id;
						}
						var width=parseInt(document_obj.page[j].width);
						var height=parseInt(document_obj.page[j].height);
						var starttimestamp=parseFloat(document_obj.page[j].starttimestamp)*1000;
						var stoptimestamp=parseFloat(document_obj.page[j].stoptimestamp)*1000;
						var hls=document_obj.page[j].hls;
						
						pptRecord.record_page[k]={page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls};
						pptRecord.record_page_id[page_id]={page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls};
						k++;
						//pptRecord.record_page_time[k]={page_id:page_id,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp};
					}
				}else{
					
					var page_id=document_obj.id+'_'+document_obj.page.id;
					if(k==0){
						pptRecord.now_page_id=page_id;
					}
					var width=parseInt(document_obj.page.width);
					var height=parseInt(document_obj.page.height);
					var starttimestamp=parseFloat(document_obj.page.starttimestamp)*1000;
					var stoptimestamp=parseFloat(document_obj.page.stoptimestamp)*1000;
					var hls=document_obj.page.hls;
					
					pptRecord.record_page[k]={page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls};
					pptRecord.record_page_id[page_id]={page_id:page_id,width:width,height:height,starttimestamp:starttimestamp,stoptimestamp:stoptimestamp,hls:hls};
					k++;
				}
			}
			console.log(pptRecord.record_page);
			console.log(pptRecord.now_page_id);
			
					
			//pptRecord.recordDrawShowTime(starttime);
			//pptRecord.now_page_id=pptRecord.record_page[0].page_id;//设置当前播放页id
		}
		//解析jsanno
		if($.isArray(multirecord_obj)){
			var n=0;
			var jsanno_array=[];
			
			for (var i = 0; i < multirecord_obj.length; i++) {
				if((multirecord_obj[i].jsanno && multirecord_obj[i].jsanno!=null) || (multirecord_obj[i].anno && multirecord_obj[i].anno!=null)){
					if(!multirecord_obj[i].jsanno && multirecord_obj[i].anno){
						multirecord_obj[i].jsanno=multirecord_obj[i].anno.replace('xml','js');
					}
					if(!jsanno_array[multirecord_obj[i].jsanno]){
						jsanno_array[multirecord_obj[i].jsanno]=multirecord_obj[i].jsanno;
						pptRecord.record_jsanno[n]={jsanno:multirecord_obj[i].jsanno,starttimestamp:parseFloat(multirecord_obj[i].starttimestamp)*1000,stoptimestamp:parseFloat(multirecord_obj[i].stoptimestamp)*1000,duration:parseFloat(multirecord_obj[i].duration)*1000};
						n++;
					}else if(jsanno_array[multirecord_obj[i].jsanno]){
						pptRecord.record_jsanno[n]={jsanno:multirecord_obj[i].jsanno,starttimestamp:parseFloat(multirecord_obj[i].starttimestamp)*1000,stoptimestamp:parseFloat(multirecord_obj[i].stoptimestamp)*1000,duration:parseFloat(multirecord_obj[i].duration)*1000};
						n++;
					}
				}
			}
			console.log("js数组",pptRecord.record_jsanno);
			if(pptRecord.record_jsanno[0]){
				$.ajax({
				  type: 'GET',
				  url: pptPath+pptRecord.record_jsanno[0].jsanno,
				  dataType: 'json',
				  timeout: 15000,
				  success: function(annodata){
					pptRecord.recordShouwDoc(annodata);
					pptRecord.record_jsanno_old[pptRecord.record_jsanno[0].jsanno]=1;//设置jsanno加载成功
					pptRecord.is_pptRecord=1;//第一个anno加载成功设置标注可以播放
					pptRecord.recordCreatCanvas();//创建画布
					
					pptRecord.recordCanvas(pptRecord.now_page_id);//设置画布宽度适应手机界面
					pptRecord.recordCanvasCreatPanzoom();
				  },
				  error: function(xhr, type){
					//alert('Ajax error!')
					console.log(pptPath+pptRecord.record_jsanno[0].jsanno+"加载失败");
					pptRecord.record_jsanno=[];
					pptRecord.recordGetMainAnno();
				  }
				});
			}else{
				pptRecord.recordGetMainAnno();
			}
		}else{
			if(multirecord_obj.jsanno){
				var jsanno=multirecord_obj.jsanno;
				pptRecord.record_jsanno[0]={jsanno:jsanno,starttimestamp:parseFloat(multirecord_obj.starttimestamp)*1000,stoptimestamp:parseFloat(multirecord_obj.stoptimestamp)*1000,duration:parseFloat(multirecord_obj.duration)*1000};
				$.ajax({
				  type: 'GET',
				  url: pptPath+jsanno,
				  dataType: 'json',
				  timeout: 15000,
				  success: function(annodata){
					pptRecord.recordShouwDoc(annodata);
					pptRecord.record_jsanno_old[jsanno]=1;
					pptRecord.is_pptRecord=1;
					pptRecord.recordCreatCanvas();
					
					pptRecord.recordCanvas(pptRecord.now_page_id);
					pptRecord.recordCanvasCreatPanzoom();
				  },
				  error: function(xhr, type){
					//alert('Ajax error!')
					console.log(pptPath+jsanno+"加载失败");
					pptRecord.record_jsanno=[];
					pptRecord.recordGetMainAnno();//加载默认的
				  }
				});
			}else{
				pptRecord.recordGetMainAnno();
			}
		}
		console.log(pptRecord.record_jsanno);
	}
}
//判断anno.js是否加载
pptRecord.recordDrawTime=function(starttime){
	//console.log("判断anno.js是否加载");
	//console.log("加载时间",starttime);
	/*if(starttime==0){
		pptRecord.record_canvas.clear();
	}*/
	if(starttime>=pptRecord.record_max_time){
		return;
	}else{
		if(pptRecord.record_jsanno.length>1){
			var m=0;
			
			for(var i=0;i<pptRecord.record_jsanno.length;i++){
				if(pptRecord.record_jsanno[i].starttimestamp<=starttime && pptRecord.record_jsanno[i].stoptimestamp>starttime){
					m++;
					if(pptRecord.record_jsanno_old[pptRecord.record_jsanno[i].jsanno]){
						pptRecord.recordDrawGetdocTime(starttime);
					}else{
						//m++;
						pptRecord.record_jsanno_old[pptRecord.record_jsanno[i].jsanno]=1;
						$.ajax({
						  type: 'GET',
						  url: pptPath+pptRecord.record_jsanno[i].jsanno,
						  dataType: 'json',
						  timeout: 15000,
						  success: function(annodata){
							  console.log(annodata);
								pptRecord.recordShouwDoc(annodata);
								//pptRecord.recordDrawGetdocTime(starttime);
								pptRecord.recordDrawGetdocTime(starttime);
			
						  },
						  error: function(xhr, type){
							//alert('Ajax error!')
							console.log(pptPath+pptRecord.record_jsanno[i].jsanno+'加载失败');
							pptRecord.record_jsanno=[];
							pptRecord.recordGetMainAnno(starttime);//加载默认的
							//pptRecord.record_jsanno_old[jsanno]=1;
							//pptRecord.recordDrawGetdocTime(starttime);
							
						  }
						});
					}
					break;
				}
			}
			
			if(m==0){
				//console.log("没有标注信息继续加载文档");
				//return;
				pptRecord.recordDrawGetdocTime(starttime);
			}
		}else{
			pptRecord.recordDrawGetdocTime(starttime);
		}
	}
};
//判断当前page_id和切换文档背景图片
pptRecord.recordDrawGetdocTime=function(starttime){
	//console.log(pptRecord.record_page);
	//console.log("判断当前page_id和切换文档背景图片");
	if(pptRecord.record_page.length>1){
		for(var i=0;i<pptRecord.record_page.length;i++){
			if(pptRecord.record_page[i].starttimestamp<=starttime && pptRecord.record_page[i].stoptimestamp>starttime){
				//console.log(starttime,pptRecord.now_page_id,pptRecord.record_page[i].page_id);
				if(pptRecord.now_page_k!=i){//pptRecord.now_page_id!=pptRecord.record_page[i].page_id || 
					//设置now_page_id 和重置画布背景图
					pptRecord.record_last_time=0;
					pptRecord.now_page_id=pptRecord.record_page[i].page_id;
					pptRecord.now_page_k=i;
					console.log("设置now_page_id 和重置画布背景图");
					console.log(pptRecord.now_page_id);
					pptRecord.record_canvas.clear();
					pptRecord.pointer_list=[];
					pptRecord.history_data={};
					pptRecord.recordCanvas(pptRecord.now_page_id);
					pptRecord.recordCanvasResetPanzoom();
					if(pptRecord.record_datas_time[pptRecord.now_page_id] && pptRecord.record_datas_time[pptRecord.now_page_id].length>0){
						pptRecord.recordDrawShowTime(starttime);
					}
				}else{
					//当前页向前拖直接清空
					/*if(pptRecord.record_last_time>starttime){
						pptRecord.record_canvas.clear();
						pptRecord.pointer_list=[];
						pptRecord.history_data={};
					}*/
					if(pptRecord.record_datas_time[pptRecord.now_page_id] && pptRecord.record_datas_time[pptRecord.now_page_id].length>0){
						pptRecord.recordDrawShowTime(starttime);
					}
				}
				break;
			}
		}
	}else{
		if(pptRecord.record_datas_time[pptRecord.now_page_id] && pptRecord.record_datas_time[pptRecord.now_page_id].length>0){
			pptRecord.recordDrawShowTime(starttime);
		}
	}
};
//根据时间执行标注动画
pptRecord.recordDrawShowTime=function(starttime){
	pptRecord.addobj=[];
	pptRecord.delobj=[];
	var n=0;
	//console.log("根据时间执行标注动画");
	//console.log(pptRecord.record_last_time,starttime);
	if(pptRecord.record_last_time<=starttime){
		for(var i=0;i<pptRecord.record_datas_time[pptRecord.now_page_id].length;i++){
			if(pptRecord.record_datas_time[pptRecord.now_page_id][i].timestamp>pptRecord.record_last_time && pptRecord.record_datas_time[pptRecord.now_page_id][i].timestamp<=starttime){
				//console.log("根据时间执行标注动画");
				//console.log(pptRecord.record_datas_time[i].id);
				//console.log(pptRecord.record_datas[pptRecord.record_datas_time[i].id]);
				var o=pptRecord.recordShowDraw(pptRecord.record_datas[pptRecord.record_datas_time[pptRecord.now_page_id][i].id]);
				if(o){
					n++;
					pptRecord.addobj.push(o);
				}
				if(i==pptRecord.record_datas_time[pptRecord.now_page_id].length-1){
					pptRecord.record_last_time=starttime;
					break;
				}
			}else if(pptRecord.record_datas_time[pptRecord.now_page_id][i].timestamp>starttime){
				pptRecord.record_last_time=starttime;
				break;
			}
		}
		
	}else if(pptRecord.record_last_time>starttime || starttime==0){
		console.log("根据时间执行标注动画22222");
		console.log(pptRecord.record_last_time,starttime);
		//清理画布
		//if(starttime<=1000){
			pptRecord.record_canvas.clear();
			pptRecord.pointer_list=[];
			pptRecord.history_data={};
		//}
		//pptRecord.recordDrawGetdocTime(starttime);
		for(var i=0;i<pptRecord.record_datas_time[pptRecord.now_page_id].length;i++){
			if(pptRecord.record_datas_time[pptRecord.now_page_id][i].timestamp<=starttime){
				var o=pptRecord.recordShowDraw(pptRecord.record_datas[pptRecord.record_datas_time[pptRecord.now_page_id][i].id]);
				if(o){
					n++;
					pptRecord.addobj.push(o);
				}
			}else if(pptRecord.record_datas_time[pptRecord.now_page_id][i].timestamp>starttime){
				pptRecord.record_last_time=starttime;
				break;
			}
		}
	}
	//if(n>0){
		//console.log(pptRecord.addobj);
	if(pptRecord.addobj.length>0){
		pptRecord.record_canvas.add2(pptRecord.addobj);
	}
		
	//}
	//console.log(pptRecord.delobj);
	if(pptRecord.delobj.length>0){
		for(var i=0;i<pptRecord.delobj.length;i++){
			pptRecord.record_canvas.remove(pptRecord.history_data[pptRecord.delobj[i]]);
		}
	}
	if(pptRecord.pointer_list.length>0){
		//console.log("激光笔覆盖");
		//console.log(pptRecord.pointer_list);
		for(var p=0;p<pptRecord.pointer_list.length;p++){
			pptRecord.record_canvas.bringToFront(pptRecord.pointer_list[p]);
		}
	}
	//console.log("最后时间",pptRecord.record_last_time);
};
//获取主anno.js
pptRecord.recordGetMainAnno=function(starttime){
	if(pptRecord.record_MainAnno){
		pptRecord.record_jsanno[0]={jsanno:pptRecord.record_MainAnno,starttimestamp:0,stoptimestamp:pptRecord.record_max_time,duration:pptRecord.record_max_time};
		if(starttime){
			if(pptRecord.record_jsanno_old[pptRecord.record_MainAnno]){
				pptRecord.recordDrawGetdocTime(starttime);
			}else{
				$.ajax({
				  type: 'GET',
				  url: pptPath+pptRecord.record_MainAnno,
				  dataType: 'json',
				  timeout: 15000,
				  success: function(annodata){
					pptRecord.recordShouwDoc(annodata);
					pptRecord.record_jsanno_old[pptRecord.record_MainAnno]=1;
					if(pptRecord.is_pptRecord==0){
						pptRecord.is_pptRecord=1;
						pptRecord.recordCreatCanvas();
						
						pptRecord.recordCanvas(pptRecord.now_page_id);
						pptRecord.recordCanvasCreatPanzoom();
					}
		
					pptRecord.recordDrawGetdocTime(starttime);
					
				  },
				  error: function(xhr, type){
					//alert('Ajax error!')
					console.log("默认anno.js加载失败");
				  }
				});
			}
		}else{
			$.ajax({
			  type: 'GET',
			  url: pptPath+pptRecord.record_MainAnno,
			  dataType: 'json',
			  timeout: 15000,
			  success: function(annodata){
				pptRecord.recordShouwDoc(annodata);
				pptRecord.record_jsanno_old[pptRecord.record_MainAnno]=1;
				pptRecord.is_pptRecord=1;
				pptRecord.recordCreatCanvas();
				
				pptRecord.recordCanvas(pptRecord.now_page_id);
				pptRecord.recordCanvasCreatPanzoom();
			  },
			  error: function(xhr, type){
				//alert('Ajax error!')
				console.log("默认anno.js加载失败");
			  }
			});
		}
	}else{
		console.log("没有默认anno.js");
	}
};
//创建标注画布
pptRecord.recordCreatCanvas=function(){
	jQuery('#gs-doc').panzoom("destroy");
	$('#gs-doc').remove();
	$('#doc-box').append('<div id="floater-doc"></div><canvas id="gs-doc"></canvas>');
	pptRecord.record_canvas = this.__canvas = new fabric.Canvas('gs-doc', {
		//isDrawingMode: false,
		selection: false
	});
	fabric.Object.prototype.originX = 'center';
	fabric.Object.prototype.originY = 'center';
	fabric.Object.prototype.selectable = false;
	
	
};
//设置画布宽高和背景
pptRecord.recordCanvas=function(page_id){
	//pptRecord.record_canvas.clear();
	console.log(page_id);
	console.log(pptRecord.record_page_id[page_id]);
	
	var canvas_width=pptRecord.record_page_id[page_id].width;
	var canvas_height=pptRecord.record_page_id[page_id].height;
	var canvas_pic=pptPath+pptRecord.record_page_id[page_id].hls;
	
	var body_width=GsPlayer.winWidth;
	var body_height=GsPlayer.winHeight;
	
	var ratio=1;
	//if(body_width<canvas_width){
		ratio=body_width/canvas_width;
	//}
	pptRecord.record_canvas.setZoom(ratio).setWidth(canvas_width*ratio).setHeight(canvas_height*ratio);
	
	pptRecord.record_canvas.setBackgroundImage("", pptRecord.record_canvas.renderAll.bind(pptRecord.record_canvas), {
		width: pptRecord.record_canvas.width,
		height: pptRecord.record_canvas.height,
		originX: 'left',
		originY: 'top'
	});
	
	pptRecord.record_canvas.setBackgroundImage(canvas_pic, pptRecord.record_canvas.renderAll.bind(pptRecord.record_canvas), {
		width: pptRecord.record_canvas.width,
		height: pptRecord.record_canvas.height,
		originX: 'left',
		originY: 'top'
	});
	
	//var h=$('.canvas-container').height();
	$('#floater-doc').css('margin-bottom',"-"+((canvas_height*ratio)/2)+"px");
	$('.canvas-container').css('clear','both');
};
//缩放功能启用
pptRecord.recordCanvasCreatPanzoom=function(){
	$panzoom=jQuery('#gs-doc').parent('.canvas-container').panzoom({
		startTransform: 'scale(1)',
		increment: 1,
		minScale: 1,
		contain: 'invert',
		duration:300
	});
	doc_bar_height();
	if($('#doc-tab')[0]){
		//console.log("ppp33333");
		$panzoom.on('panzoomstart', function(e, panzoom, event, touches) {
			//console.log(touches);
			oldx=touches[0].clientX;
			oldy=touches[0].clientY;
			touchendlength=touches.length;
		});
		//$panzoom.on('panzoompan', function(e, panzoom, x, y) {
			//console.log(x, y);
			//$('#doc-box').scrollTop(y);
		//});
		$panzoom.on('panzoomend', function(e, panzoom, matrix, changed) {
			//console.log(e);
			//console.log(panzoom);
			//$('.toolset').append(" kk "+matrix+" ");
			console.log(matrix[0]);
			//var m=matrix.split(",");

			if (changed) {
				/*var h=$('.canvas-container').height();
				if(h<$('#doc-box').height() && matrix[0]==matrix[3] && matrix[0]==1){
					var t=($('#doc-box').height()-h)/2;
					$panzoom.panzoom("setTransform", 'matrix(1, 0, 0, 1, 0, '+t+')');
				}*/
				doc_bar_height();
				if(e.changedTouches[0].pageX+100<oldx && touchendlength==1 && matrix[0]==1){//&& !$('#doc_big').hasClass('on')
			
					index=$("#chatQaBox .tabs li.ondoc").index();
					if(index<$("#chatQaBox .tabs li").length-1){
						$("#chatQaBox .tabs li").eq(index+1).trigger('click'); 
					}

				}else if(e.changedTouches[0].pageX-100>oldx && touchendlength==1 && matrix[0]==1){
					index=$("#chatQaBox .tabs li.ondoc").index();
					if(index>0){
						$("#chatQaBox .tabs li").eq(index-1).trigger('click'); 
					}
				}
			} else {
				console.log(e.changedTouches[0].pageX,oldx,touchendlength);
				if(e.changedTouches[0].pageX+100<oldx && touchendlength==1 && matrix[0]==1){//&& !$('#doc_big').hasClass('on')
					index=$("#chatQaBox .tabs li.ondoc").index();
					if(index<$("#chatQaBox .tabs li").length-1){
						$("#chatQaBox .tabs li").eq(index+1).trigger('click'); 
					}
				}else if(e.changedTouches[0].pageX-100>oldx && touchendlength==1 && matrix[0]==1){
					index=$("#chatQaBox .tabs li.ondoc").index();
					if(index>0){
						$("#chatQaBox .tabs li").eq(index-1).trigger('click'); 
					}
				}
			}
			if(GsPlayer.isPortrait()){
				if($('#doc_big').css('display')=='none'){
					$('#doc_big').fadeIn();
				}else{
					$('#doc_big').fadeOut();
				}
			}
		});
	}else{
		
		$panzoom.on('panzoomend', function(e, panzoom, matrix, changed) {
			//console.log("触摸触摸触摸触摸触摸触摸");
			//console.log(matrix);
			if (changed) {
				/*var h=$('.canvas-container').height();
				if(h<$('#doc-box').height() && matrix[0]==matrix[3] && matrix[0]==1){
					var t=($('#doc-box').height()-h)/2;
					$panzoom.panzoom("setTransform", 'matrix(1, 0, 0, 1, 0, '+t+')');
				}*/
				doc_bar_height();
				if($('#audio_area')[0]){
					if($('#ctrlbar-box').css('visibility')=='hidden'){
						$('#ctrlbar-box').css('visibility','visible');
					}
				}
			}else{
				if($('#audio_area')[0]){
					if($('#ctrlbar-box').css('visibility')!='hidden'){
						$('#ctrlbar-box').css('visibility','hidden');
					}else{
						$('#ctrlbar-box').css('visibility','visible');
					}
				}
			}
			if(GsPlayer.isPortrait()){
				if($('#doc_big').css('display')=='none'){
					$('#doc_big').fadeIn();
				}else{
					$('#doc_big').fadeOut();
				}
			}
		});
	}
};
//重置缩放
pptRecord.recordCanvasResetPanzoom=function(){
	resetPanzoom();
};
//解析标注数据
pptRecord.recordShouwDoc=function(xmlDoc){
	console.log('解析标注数据');
	//console.log(xmlDoc);
	var elements = xmlDoc.module.command;
	//console.log(elements);
	console.log(elements.length);
	//var dl=pptRecord.record_datas_time.length;
	
	for (var i = 0; i < elements.length; i++) {
		var data={};
		data.type=elements[i].type;
		if(data.type==3){
			data.id=elements[i].id+"-"+elements[i].removed;
		}else{
			data.id=elements[i].id;
		}
		data.timestamp=parseFloat(elements[i].timestamp)*1000;
		data.documentid=elements[i].documentid;
		data.pageid=elements[i].pageid;
		data.page_id=elements[i].documentid+'_'+elements[i].pageid;
		
		if(elements[i].color!=null){
			var color_txt=elements[i].color;
			var color_arr=color_txt.split(',');
			var color=color_arr[0];
			var opacity=parseFloat(color_arr[1]);
			if(opacity<1){
				var rgba=new fabric.Color(color).toRgb().replace('rgb(','').replace(')','');
				
				data.color='rgba('+rgba+','+0.75+')';
			}else{
				data.color=new fabric.Color(color).toRgb();
			}
		}
		if(elements[i].fontsize!=null){
			data.fontsize=elements[i].fontsize;
		}
		
		if(elements[i].linesize!=null){
			data.linesize=elements[i].linesize;
		}
		
		if(elements[i].style!=null){
			data.style=elements[i].style;
		}
		//console.log(id,type,timestamp,documentid,pageid,color_txt,linesize,fontsize);
		if(data.type==2){//自由笔
			
			var p=elements[i].p;
			
			var s_p='';
			for (var j = 0; j < p.length; j++) {
				var point=p[j].split(',');
				s_p+=(j==0?'M':'L')+' '+point[0]+' '+point[1]+' ';
			}
			data.s_p=s_p;
			
		}else if(data.type==3){//删除
			data.removed=elements[i].removed;
			
		}else if(data.type==4){//文字
			data.start_p=elements[i].p.split(',');
			data.end_p=elements[i].ep.split(',');
			if(elements[i].text){
				data.value=elements[i].text;//.replace(/\r\n/g,'<br>').replace(/\n/g,'<br>')
			}
		}else if(data.type==5){//椭圆
			data.start_p=elements[i].p.split(',');
			data.end_p=elements[i].ep.split(',');
			
		}else if(data.type==6){//矩形
			data.start_p=elements[i].p.split(',');
			data.end_p=elements[i].ep.split(',');
			
		}else if(data.type==8 || data.type==7){//线
			data.start_p=elements[i].p.split(',');
			data.end_p=elements[i].ep.split(',');
			
		}else if(data.type==9 || data.type==1){//激光笔
			data.start_p=elements[i].p.split(',');
		}	
		//console.log(data);
		
		pptRecord.record_datas[data.id]=data;
		//var t={id:data.id,timestamp:data.timestamp};
		if(!pptRecord.page_list[data.page_id]){
			pptRecord.page_arr.push(data.page_id);
			pptRecord.page_list[data.page_id]=1;
			pptRecord.record_datas_time[data.page_id]=[];
		}
		pptRecord.record_datas_time[data.page_id].push({id:data.id,timestamp:data.timestamp});
	}
	for(var i=0;i<pptRecord.page_arr.length;i++){
		pptRecord.record_datas_time[pptRecord.page_arr[i]].sort(function(a,b){
			return a.timestamp-b.timestamp;
		});
	}
	console.log(pptRecord.record_datas);
	console.log("分页数据");
	console.log(pptRecord.record_datas_time);
	
};
//画标注
pptRecord.recordShowDraw=function(data){
	var rzoom=pptRecord.record_canvas.getZoom();
	if(data.type==2){//自由笔
	//console.log("自由笔",pptRecord.record_canvas.getZoom());
		var line = new fabric.Path(data.s_p, { 
			
			fill: false,
			stroke: data.color,
			strokeLineCap:'round',
			strokeWidth: (rzoom>1?data.linesize/rzoom:data.linesize)
		});
		//pptRecord.record_canvas.add(line);
		pptRecord.history_data[data.id]=line;
		return line;
	}else if(data.type==3){//删除
		if(data.removed==0){//清屏
			console.log("清屏");
			pptRecord.record_canvas.clear();
			pptRecord.pointer_list=[];
			pptRecord.history_data={};
			pptRecord.addobj=[];
			pptRecord.delobj=[];
		}else{
			//console.log("删除",data.removed);
			pptRecord.delobj.push(data.removed);
			//pptRecord.record_canvas.remove(pptRecord.history_data[data.removed]);
		}
	}else if(data.type==4 && data.value){//文字
		var start_p=data.start_p;
		var end_p=data.end_p;
	
		var text =  new fabric.Text(data.value, {
			fontSize:    data.fontsize,
			lineHeight:0.8,
			fontFamily:'simsun',
			fontStyle:   'normal',
			fill:      data.color,
			originX: 'left',
   			originY: 'top',
			
			left:parseInt(start_p[0]),
			top:parseInt(start_p[1])
	
			/*left : ((parseInt(start_p[0])+parseInt(end_p[0]))/2)/pptRecord.record_canvas.getZoom(),
			top : ((parseInt(start_p[1])+parseInt(end_p[1]))/2)/pptRecord.record_canvas.getZoom(),
			
			width : parseInt(end_p[0])-parseInt(start_p[0])/pptRecord.record_canvas.getZoom(),
			height : parseInt(end_p[1])-parseInt(start_p[1])/pptRecord.record_canvas.getZoom()*/
		});
		//console.log(text);
		//pptRecord.record_canvas.add(text);
		pptRecord.history_data[data.id]=text;
		return text;
	}else if(data.type==5){//椭圆
		console.log(data);
		var start_p=data.start_p;
		var end_p=data.end_p;
		
		var rect = new fabric.Ellipse({
			top : (parseInt(start_p[1])+parseInt(end_p[1]))/2,
			left : (parseInt(start_p[0])+parseInt(end_p[0]))/2,
			rx : Math.abs(parseInt(end_p[0])-parseInt(start_p[0]))/2,
			ry : Math.abs(parseInt(end_p[1])-parseInt(start_p[1]))/2,
			stroke: data.color,
			strokeWidth: data.linesize,
			fill : 'rgba(0,0,0,0)'
		});
		//pptRecord.record_canvas.add(rect);
		pptRecord.history_data[data.id]=rect;
		return rect;
	}else if(data.type==6){//矩形
		var start_p=data.start_p;
		var end_p=data.end_p;
		
		var rect = new fabric.Rect({
			
			top : (parseInt(start_p[1])+parseInt(end_p[1]))/2,
			left : (parseInt(start_p[0])+parseInt(end_p[0]))/2,
			width : parseInt(end_p[0])-parseInt(start_p[0]),
			height : parseInt(end_p[1])-parseInt(start_p[1]),
			stroke: data.color,
			strokeWidth: data.linesize,
			fill : 'rgba(0,0,0,0)'
		});
		//pptRecord.record_canvas.add(rect);
		pptRecord.history_data[data.id]=rect;
		return rect;
	}else if(data.type==8 || data.type==7){//线
		var start_p=data.start_p;
		var end_p=data.end_p;
		if(data.style==0 || data.type==7){//直线
			var line = new fabric.Path('M '+start_p[0]+' '+start_p[1]+' L '+end_p[0]+' '+end_p[1], { 
				strokeLineCap:'round',
				stroke: data.color,
				strokeWidth: data.linesize
			});
			//pptRecord.record_canvas.add(line);
			pptRecord.history_data[data.id]=line;
			return line;
		}else if(data.style==1){//虚线
		
			var line = new fabric.Path('M '+start_p[0]+' '+start_p[1]+' L '+end_p[0]+' '+end_p[1], { 
				strokeDashArray: [data.linesize*2, data.linesize*2],
				stroke: data.color,
				strokeWidth: data.linesize
			});
			//pptRecord.record_canvas.add(line);
			pptRecord.history_data[data.id]=line;
			return line;
		}else if(data.style==2){//带箭头

			var triangle = pptRecord.createArrowHead([start_p[0],start_p[1], end_p[0],end_p[1]],data.color,data.linesize);
			
			var line = new fabric.Path('M '+start_p[0]+' '+start_p[1]+' L '+end_p[0]+' '+end_p[1], { 
				
				strokeLineCap:'round',
				stroke: data.color,
				strokeWidth: data.linesize
			});
			var grp = new fabric.Group([triangle,line],{selectable:false});			
			
			//pptRecord.record_canvas.add(grp);
			pptRecord.history_data[data.id]=grp;
			return grp;
		}
	}else if(data.type==9 || data.type==1){//激光笔
		var start_p=data.start_p;
		if(!pptRecord.history_data['pointer_'+data.documentid+'_'+data.pageid+'_'+data.style]){
			var imgElement = document.getElementById((data.style && data.style==1)?'pointEx2':'pointEx');
			var oImg = new fabric.Image(imgElement, {
				left:(parseInt(start_p[0])+16),
				top:(parseInt(start_p[1])+16)
			});
			pptRecord.record_canvas.bringToFront(oImg);
			pptRecord.history_data['pointer_'+data.documentid+'_'+data.pageid+'_'+data.style]=oImg;
			//console.log("激光笔");
			if(pptRecord.pointer_list.length>0){
				pptRecord.pointer_list[pptRecord.pointer_list.length]=oImg;
			}else{
				pptRecord.pointer_list[0]=oImg;
			}
			console.log(pptRecord.pointer_list.length);
			
		}else if(!pptRecord.isEmptyObject(pptRecord.history_data['pointer_'+data.documentid+'_'+data.pageid+'_'+data.style])){
			pptRecord.history_data['pointer_'+data.documentid+'_'+data.pageid+'_'+data.style].set({left:parseInt(start_p[0])+16,top:parseInt(start_p[1])+16});
			pptRecord.record_canvas.bringToFront(pptRecord.history_data['pointer_'+data.documentid+'_'+data.pageid+'_'+data.style]);
			//canvas.renderAll();
		}
	}
	/*if(data.type!=9 && data.type!=1 && pptRecord.pointer_list.length>0){
		//console.log("激光笔覆盖");
		//console.log(pptRecord.pointer_list);
		for(var p=0;p<pptRecord.pointer_list.length;p++){
			pptRecord.record_canvas.bringToFront(pptRecord.pointer_list[p]);
		}
	}*/
};
pptRecord.isEmptyObject=function(e) {  
    var t;  
    for (t in e)  
        return !1;  
    return !0;
};
//画箭头
pptRecord.createArrowHead=function(points,color,linesize){
	var headLength = 15,

			x1 = points[0],
			y1 = points[1],
			x2 = points[2],
			y2 = points[3],

			dx = x2 - x1,
			dy = y2 - y1,

			angle = Math.atan2(dy, dx);

	angle *= 180 / Math.PI;
	angle -= 90;

	var startPoints = [];
	//console.log(linesize);
	switch(linesize){
		case "1":
		startPoints = [
		{x: 0, y: 0},
		{x: 3, y: 3},
		{x: 6, y: 0},
		{x: 3, y: 10}
		];
		break;
		case "2":
		startPoints = [
		{x: 0, y: 0},
		{x: 5, y: 5},
		{x: 10, y: 0},
		{x: 5, y: 15}
		];
		break;
		case "3":
		startPoints = [
		{x: 0, y: 0},
		{x: 6, y: 6},
		{x: 12, y: 0},
		{x: 6, y: 18}
		];
		break;
		case "4":
		startPoints = [
		{x: 0, y: 0},
		{x: 8, y: 8},
		{x: 16, y: 0},
		{x: 8, y: 20}
		];
		break;
		case "6":
		startPoints = [
		{x: 0, y: 0},
		{x: 10, y: 10},
		{x: 20, y: 0},
		{x: 10, y: 25}
		];
		break;
	}
	//console.log(startPoints);
	
	var polygon = new fabric.Polygon(startPoints, {
		angle: angle,
		fill: color,
		top: y2,
		left: x2
	//selectable: false
	});
	return polygon;
};