/*
	Scheduler
	定时任务触发
	Created: 2012-06-15 sam.huang
*/
(function(window, undefined){

	function Scheduler(){
		this.TASKMODE_DEFAULT = 0;//每个任务独立
		this.TASKMODE_SUBSTITUTION = 1;//每个任务可替代，即只要执行最新的任务即可。
		this.typeSetting = {};
		this.taskGroups = {};
		this.preTaskPoint = 0;
		this.supportPlayback = false;
		
		this.createEmptyTaskgroup = function(type){
			return {type:type, begin:0, preTaskPoint:0, tasks:[]};
		};
		
		this.findTasks4exe = function(taskPoint, taskGroup){
			var tasks = [];
			for(var curIdx = taskGroup.begin; curIdx < taskGroup.tasks.length; curIdx++){
				var task = taskGroup.tasks[curIdx];
				if(task.startPoint <= taskPoint){//请求点已到达任务的开始点
					if(!task.endPoint || task.endPoint >= taskPoint){
						tasks.push(task);
						taskGroup.begin = curIdx+1;
						console.log("taskGroup:"+taskGroup.type+",begin:"+taskGroup.begin);
					}
				}else{
					break;
				}
			}
			return tasks;
		};
		
		function isSubstitutionMode(taskGroup){
			var setting = this.typeSetting[taskGroup.type];
			var mode = setting.mode;
			return mode == this.TASKMODE_SUBSTITUTION;
		}
		
		this.findLastTask4exe = function(taskPoint, taskGroup){
			var lastTask = null;
			for(var curIdx = taskGroup.begin; curIdx < taskGroup.tasks.length; curIdx++){
				var task = taskGroup.tasks[curIdx];
				if(task.startPoint <= taskPoint){//请求点已到达任务的开始点
					if(task.endPoint >= taskPoint){
						lastTask = task;
						taskGroup.begin = curIdx+1;
						console.log("taskGroup:"+taskGroup.type+",begin:"+taskGroup.begin);
					}
				}else{
					break;
				}
			}
			return lastTask;
		};
		
		this.executable = function(task){
			return task && task.executable;
		};
		
		this.getTaskGroup = function(type){
			if(type && this.taskGroups[type]){
				return this.taskGroups[type];
			}else{
				return this.createEmptyTaskgroup(type);
			}
		};
		
		this.inhandle = function(task){
			task.inhandle(this.typeSetting[task.type].inhandler);
		};
		
		this.outhandle = function(task){
			task.outhandle(this.typeSetting[task.type].outhandler);
		};
		
		this.bubblePush = function(taskGroup, task){
			var tasks = taskGroup.tasks;
			var insertIdx = getInsertIdx(taskGroup, task);
//			debug("[scheduler][bubblePush] insertIdx:"+insertIdx);
			tasks.splice(insertIdx, 0, task);
			return insertIdx;
		};
		
		var getInsertIdx = function(taskGroup, task2insert){
			var tasks = taskGroup.tasks;
			var len = tasks.length;
			var begin = taskGroup.begin;
			for(var i = len-1; i>=begin; i--){//插入的有效下标：begin -> len
				var task = tasks[i];
				if(task.startPoint <= task2insert.startPoint){
					return i+1;
				}
			}
			return begin;
		};
		
	};
	Scheduler.fn = Scheduler.prototype = {
		setType : function(type, inhandler, outhandler, mode, supportPlayback){
			this.typeSetting[type] = {
				inhandler : inhandler,
				outhandler : outhandler,
				mode : mode,
				supportPlayback : supportPlayback ? supportPlayback : false
			};
		},
		
		addTask: function(task){
			var taskGroup;
			if(!task.type){
				taskGroup = this.taskGroups.defaultGroup;
			}else{
				if(!this.taskGroups[task.type]){
					this.taskGroups[task.type] = this.createEmptyTaskgroup(task.type);
				}
				taskGroup = this.taskGroups[task.type];
			}
			var idx = this.bubblePush(taskGroup, task);
			console.log("[scheduler] add a task:",task);
			return idx;
		},
		removeTask: function(data, compareFn, group) {
			var taskGroup = this.taskGroups[group];
			for(var i = taskGroup.begin; i<taskGroup.tasks.length;i++){
				var task = taskGroup.tasks[i];
				if(compareFn(task.data, data)){
					delete task.executable;
					return true;
				}
			}
			return false;
		},
		removeTaskById: function(id, group) {
			var taskGroup = this.taskGroups[group];
			for(var i in taskGroup.tasks){
				var task = taskGroup.tasks[i];
				if(id === task.id){
					delete task.executable;
					return true;
				}
			}
			return false;
		},
		request: function(taskPoint, type){
			var taskGroup = this.getTaskGroup(type);
			if(typeof this.typeSetting[type] == "undefined")return;
			var mode = this.typeSetting[type].mode;
			var tasks;
			if(mode == Sch.TASKMODE_SUBSTITUTION){
				var task = this.findLastTask4exe(taskPoint, taskGroup);
				tasks = task?[task]:[];
			}else{
				tasks = this.findTasks4exe(taskPoint, taskGroup);
			}
//			console.log("[scheduler][request] taskPoint:"+taskPoint+", find "+ tasks.length +" tasks.");
			for(var i in tasks){
				var task = tasks[i];
				if(this.executable(task)){
//					info("[scheduler][request] taskPoint:"+taskPoint+", inhandle task:", task);
					this.inhandle(task);
				}
			}
		},
		findTasks2ExeByMode: function(taskPoint, type){
			var taskGroup = this.getTaskGroup(type);
			var mode = this.typeSetting[type].mode;
			var tasks = [];
			if(mode == Sch.TASKMODE_SUBSTITUTION){
				var task = this.findLastTask4exe(taskPoint, taskGroup);
				tasks = task?[task]:[];
			}else{
				tasks = this.findTasks4exe(taskPoint, taskGroup);
			}
			return tasks;
		},
		getAllTasks: function(){
			return this.taskGroups;
		},
		setTaskPointFn: function(taskPointFn){
			this.taskPointFn = taskPointFn;
		},
		start: function(){
			if(this.setIntervalId){
				return;
			}
			if(!this.taskPointFn){
				error("please set taskPointFn for the scheduler.");
			}
			var sch = this;
			this.setIntervalId = setInterval(function(){
				 for(var type in sch.taskGroups){
					 sch.request(this.taskPointFn(), type);
				 }
				 }, 350);
//			info("[scheduler][start] setInterval's Id:", this.setIntervalId);
		},
		restart: function(){
			if(this.taskPointFn){
//				info("[scheduler][restart] by start method.");
				this.start(this.taskPointFn);
			}
		},
		stop: function(){
			if(this.setIntervalId){
				clearInterval(this.setIntervalId);
				delete this.setIntervalId;
			}
		},
		seek: function(seekPoint, type){
			var taskGroup = this.taskGroups[type];
			if(!taskGroup)return;
			taskGroup.begin = 0;
			var task = this.findLastTask4exe(seekPoint, taskGroup);
			if(this.executable(task)){
//				info("[scheduler][seek] seekPoint:"+seekPoint+", inhandle task:", task);
				this.inhandle(task);
			}
			if(!this.setIntervalId){
//				info("[scheduler][seek] restart the setInterval.");
				this.restart();
			}
		},
		playback: function(playbackPoint, type){
			var taskGroup = this.taskGroups[type];
			if(!taskGroup)return;
			if(playbackPoint < taskGroup.preTaskPoint){
				if(taskGroup.begin != 0){
					console.log("taskGroup:"+taskGroup.type+",begin:"+taskGroup.begin+" > 0");
				}
				taskGroup.begin = 0;
			}
			var tasks = this.findTasks4exe(playbackPoint, taskGroup);
			if(tasks==null || tasks.length==0)return;
			for(var idx in tasks){
				var task = tasks[idx];
				if(this.executable(task)){
					this.inhandle(task);
					taskGroup.preTaskPoint = task.startPoint;
				}
			}
		},
		createGapTask: function(type, precision){
			if(typeof precision == "undefined")precision=0;
			console.log("[scheduler][createGapTask] precision:", precision);
			var taskGroup = this.taskGroups[type];
			if(!taskGroup)return;
			var preEnd = 0, tasks = taskGroup.tasks;
			for(var i=0; i<tasks.length;i++){
				var task = tasks[i];
				if(task.startPoint>preEnd+Number(precision)){
					var newtask = new Task(type, preEnd, task.startPoint);
					tasks.splice(i, 0, newtask);
					i++;
				}
				preEnd = task.endPoint;
			}
//			info("---------------type:"+type+",precision:"+precision);
			var newtask = new Task(type, preEnd, preEnd+1);
			tasks.push(newtask);
		}
		
	};
	
	window.Task = function Task(type, startPoint, endPoint, data, id){
		this.id = id;
		this.startPoint = Number(startPoint);
		this.endPoint = Number(endPoint);
		this.type = type;
		this.data = data;
		this.executable = true;
		this.inhandle = function(handler){
			handler(data);
		};
		this.outhandle = function(handler){
			if(handler)handler(data);
		};
	};
	
	window.Scheduler = window.Sch = new Scheduler();
})(window);

/*
 * 请求所有任务
 * 
 */
Scheduler.requestTask = function(time, type) {
	if(type){
		Sch.request(time, type);
	}else{
		Sch.request(time, "TYPE_PPT");
		Sch.request(time, "TYPE_VOTE");
	}
};

Scheduler.addEventHandler = function(event, inhandler, outhandler){
	Sch.setType(event, inhandler, outhandler, Sch.TASKMODE_DEFAULT);
};

Scheduler.addDurationTask = function(startValue, endValue, type, data){
	var task = new Task(type, startValue, endValue||Number(startValue)+200000, data );
	Sch.addTask(task);
};

Scheduler.removeDurationTask = function(compareQa, qa, type){
	Sch.removeTask(qa, compareQa, type);
};

