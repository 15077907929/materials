// 设置系统剪贴板
// 作者: 开发笔记

var ZeroClipboard = {
	
	version: "1.0.7",
	clients: {}, // 在注册页面上载的客户，通过ID索引
	moviePath: 'Public/js/zeroclipboard/ZeroClipboard.swf', // 所需要的Flash动画地址
	nextId: 1, // 下一副图片
	
	$: function(thingy) {
		// DOM的简单中查找效用函数
		if (typeof(thingy) == 'string') thingy = document.getElementById(thingy);
		if (!thingy.addClass) {
			// 延长几个有用的方法元素
			thingy.hide = function() { this.style.display = 'none'; };
			thingy.show = function() { this.style.display = ''; };
			thingy.addClass = function(name) { this.removeClass(name); this.className += ' ' + name; };
			thingy.removeClass = function(name) {
				var classes = this.className.split(/\s+/);
				var idx = -1;
				for (var k = 0; k < classes.length; k++) {
					if (classes[k] == name) { idx = k; k = classes.length; }
				}
				if (idx > -1) {
					classes.splice( idx, 1 );
					this.className = classes.join(' ');
				}
				return this;
			};
			thingy.hasClass = function(name) {
				return !!this.className.match( new RegExp("\\s*" + name + "\\s*") );
			};
		}
		return thingy;
	},
	
	setMoviePath: function(path) {
		// 设置路径
		this.moviePath = path;
	},
	
	dispatch: function(id, eventName, args) {
		// 接收事件从Flash影片，发送到客户端		
		var client = this.clients[id];
		if (client) {
			client.receiveEvent(eventName, args);
		}
	},
	
	register: function(id, client) {
		// 注册新的客户端接收事件
		this.clients[id] = client;
	},
	
	getDOMObjectPosition: function(obj, stopObj) {
		// 获得这些元素的绝对坐标
		var info = {
			left: 0, 
			top: 0, 
			width: obj.width ? obj.width : obj.offsetWidth, 
			height: obj.height ? obj.height : obj.offsetHeight
		};

		while (obj && (obj != stopObj)) {
			info.left += obj.offsetLeft;
			info.top += obj.offsetTop;
			obj = obj.offsetParent;
		}

		return info;
	},
	
	Client: function(elem) {
		// 构造，上传新客户
		this.handlers = {};
		
		// 唯一ID
		this.id = ZeroClipboard.nextId++;
		this.movieId = 'ZeroClipboardMovie_' + this.id;
		
		// 注册客户收取Flash事件
		ZeroClipboard.register(this.id, this);
		
		// 创建动画
		if (elem) this.glue(elem);
	}
};

ZeroClipboard.Client.prototype = {
	
	id: 0, // 唯一的ID
	ready: false, // 检测动画是否已准备好接收事件
	movie: null, // 参考图片对象
	clipText: '', // 文本复制到剪贴板
	handCursorEnabled: true, // 是否显示手形光标，光标或默认指针
	cssEffects: true, // 使基于DOM的CSS鼠标效果货柜
	handlers: null, // 用户事件处理
	
	glue: function(elem, appendElem, stylesToAdd) {
		// 项目的DOM元素对象或id
		this.domElement = ZeroClipboard.$(elem);
		
		// 略高于浮动对象，或者zIndex=99，没有设置DOM元素
		var zIndex = 99;
		if (this.domElement.style.zIndex) {
			zIndex = parseInt(this.domElement.style.zIndex, 10) + 1;
		}
		
		if (typeof(appendElem) == 'string') {
			appendElem = ZeroClipboard.$(appendElem);
		}
		else if (typeof(appendElem) == 'undefined') {
			appendElem = document.getElementsByTagName('body')[0];
		}
		
		// 定位
		var box = ZeroClipboard.getDOMObjectPosition(this.domElement, appendElem);
		
		// 造成上述元素的DIV的浮动
		this.div = document.createElement('div');
		var style = this.div.style;
		style.position = 'absolute';
		style.left = '' + box.left + 'px';
		style.top = '' + box.top + 'px';
		style.width = '' + box.width + 'px';
		style.height = '' + box.height + 'px';
		style.zIndex = zIndex;
		
		if (typeof(stylesToAdd) == 'object') {
			for (addedStyle in stylesToAdd) {
				style[addedStyle] = stylesToAdd[addedStyle];
			}
		}
		
		
		
		appendElem.appendChild(this.div);
		
		this.div.innerHTML = this.getHTML( box.width, box.height );
	},
	
	getHTML: function(width, height) {
		// 返回网页中的动画
		var html = '';
		var flashvars = 'id=' + this.id + 
			'&width=' + width + 
			'&height=' + height;
			
		if (navigator.userAgent.match(/MSIE/)) {
			// IE浏览器获得一个OBJECT标签
			var protocol = location.href.match(/^https/i) ? 'https://' : 'http://';
			html += '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000" codebase="'+protocol+'download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,0,0" width="'+width+'" height="'+height+'" id="'+this.movieId+'" align="middle"><param name="allowScriptAccess" value="always" /><param name="allowFullScreen" value="false" /><param name="movie" value="'+ZeroClipboard.moviePath+'" /><param name="loop" value="false" /><param name="menu" value="false" /><param name="quality" value="best" /><param name="bgcolor" value="#ffffff" /><param name="flashvars" value="'+flashvars+'"/><param name="wmode" value="transparent"/></object>';
		}
		else {
			// 其他浏览器得到所有的嵌入式标签
			html += '<embed id="'+this.movieId+'" src="'+ZeroClipboard.moviePath+'" loop="false" menu="false" quality="best" bgcolor="#ffffff" width="'+width+'" height="'+height+'" name="'+this.movieId+'" align="middle" allowScriptAccess="always" allowFullScreen="false" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" flashvars="'+flashvars+'" wmode="transparent" />';
		}
		return html;
	},
	
	hide: function() {
		// 暂时隐藏屏幕外浮
		if (this.div) {
			this.div.style.left = '-2000px';
		}
	},
	
	show: function() {
		// 显示通话结束后
		this.reposition();
	},
	
	destroy: function() {
		// 控制和消灭浮动层
		if (this.domElement && this.div) {
			this.hide();
			this.div.innerHTML = '';
			
			var body = document.getElementsByTagName('body')[0];
			try { body.removeChild( this.div ); } catch(e) {;}
			
			this.domElement = null;
			this.div = null;
		}
	},
	
	reposition: function(elem) {
		// 重新定位浮动分区，可以选择新的区域
		// 警告：不能改变容器的大小，只有位置
		if (elem) {
			this.domElement = ZeroClipboard.$(elem);
			if (!this.domElement) this.hide();
		}
		
		if (this.domElement && this.div) {
			var box = ZeroClipboard.getDOMObjectPosition(this.domElement);
			var style = this.div.style;
			style.left = '' + box.left + 'px';
			style.top = '' + box.top + 'px';
		}
	},
	
	setText: function(newText) {
		// 设置文本复制到剪贴板
		this.clipText = newText;
		if (this.ready) this.movie.setText(newText);
	},
	
	addEventListener: function(eventName, func) {
		// 用户事件添加事件监听器
eventName = eventName.toString().toLowerCase().replace(/^on/, '');
		if (!this.handlers[eventName]) this.handlers[eventName] = [];
		this.handlers[eventName].push(func);
	},
	
	setHandCursor: function(enabled) {
		// 使手形光标（真），或默认箭头光标（假）
		this.handCursorEnabled = enabled;
		if (this.ready) this.movie.setHandCursor(enabled);
	},
	
	setCSSEffects: function(enabled) {
		// 启用或禁用的CSS DOM的影响区域
		this.cssEffects = !!enabled;
	},
	
	receiveEvent: function(eventName, args) {
		// 接收从Flash事件
		eventName = eventName.toString().toLowerCase().replace(/^on/, '');
				
		// 对某些特殊行为事件
		switch (eventName) {
			case 'load':
				//电影声，它已准备好，但在IE浏览器，这是情况并非总是如此...
				// 错误修正：不能延长嵌入在Firefox的DOM元素，必须使用传统的功能
				this.movie = document.getElementById(this.movieId);
				if (!this.movie) {
					var self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 1 );
					return;
				}
				
						if (!this.ready && navigator.userAgent.match(/Firefox/) && navigator.userAgent.match(/Windows/)) {
					var self = this;
					setTimeout( function() { self.receiveEvent('load', null); }, 100 );
					this.ready = true;
					return;
				}
				
				this.ready = true;
				this.movie.setText( this.clipText );
				this.movie.setHandCursor( this.handCursorEnabled );
				break;
			
			case 'mouseover':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('hover');
					if (this.recoverActive) this.domElement.addClass('active');
				}
				break;
			
			case 'mouseout':
				if (this.domElement && this.cssEffects) {
					this.recoverActive = false;
					if (this.domElement.hasClass('active')) {
						this.domElement.removeClass('active');
						this.recoverActive = true;
					}
					this.domElement.removeClass('hover');
				}
				break;
			
			case 'mousedown':
				if (this.domElement && this.cssEffects) {
					this.domElement.addClass('active');
				}
				break;
			
			case 'mouseup':
				if (this.domElement && this.cssEffects) {
					this.domElement.removeClass('active');
					this.recoverActive = false;
				}
				break;
		} // 开关eventName
		
		if (this.handlers[eventName]) {
			for (var idx = 0, len = this.handlers[eventName].length; idx < len; idx++) {
				var func = this.handlers[eventName][idx];
			
				if (typeof(func) == 'function') {
					// 实际函数参考
					func(this, args);
				}
				else if ((typeof(func) == 'object') && (func.length == 2)) {
					func[0][ func[1] ](this, args);
				}
				else if (typeof(func) == 'string') {
					// 函数名称
					window[func](this, args);
				}
			} // 事件处理程序中定义的foreach
		} // 用户定义的事件处理程序
	}
	
};
