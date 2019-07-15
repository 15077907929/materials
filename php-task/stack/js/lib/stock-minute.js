var stock_minute={
		data:null,
		datacount:242,
		avgdata:new Array(),
		istouch:false,
		name:"",
		xy:[],
		load:function(name,c,o){
			this.name=name;
			stock.ajax({Action:name,stockID:stock.stockID,stockType:stock.stockType},function(result,data){
				if(!result||data==""){
					c.call(o,false);
				}else{
					data=data.split(" ");
					stock_minute.data=data;
					c.call(o,true);
					/*	
					if(data[0].split(",").length==7){
						stock_minute.data=data;
						c.call(o,true);
					}else{
						c.call(o,false);	
					}
					*/
				}
				delete data;
			});
		},
		//画图
		canvas:function(){
			this.dispose();//先处理数据
			this.k.load();//加载K线图
			this.l.load();//加载K线图
			this.sellbuy();
			//只加载一次
			if(!this.istouch){
				this.istouch=true;
				this.touch.load();
			}
			$("#loading").hide();//隐藏加载框
		},
		reload:function(){
			this.load(this.name,function(result){
				if(result){
					if(stock.current==stock_minute.name){
						stock_minute.canvas();
					}
				}
			})	
		},
		//更新行情
		update:function(){
			//追加行情
			if(this.data.length>0){
				if(this.data[this.data.length-1].split(",")[0].split(":").length==3){
					this.data.pop();
				}
				this.data.push(stock.data[31]+","+stock.data[3]+",-1");
			}
			if(stock.current==this.name){
				$("#dot").animate({opacity:0.1},300,function(){
					stock_minute.canvas();
					$("#dot").animate({opacity:1},300);	
				})
			}
		},
		k:{
			width:1020,
			height:300,
			define:{max:0,min:0,avg:0,differ:0,PRE:0},//自定义变量(最高价格)
			id:null,
			load:function(){
				var data=stock_minute.data;
				var $this=null,index=0,price=0;
				if(data==null){return false;}
				this.id=stock_minute.name+"-k";
				var cans=document.getElementById(this.id).getContext('2d');
				$("#"+this.id).attr("width",this.width);
				$("#"+this.id).attr("height",this.height);
				cans.beginPath();
				cans.translate(0.5,0.5);
				cans.lineWidth = 1;  
				cans.strokeStyle=stock.color.border;
				//画框
				cans.strokeRect(0, 0, this.width-1,this.height-1);
				cans.strokeStyle=stock.color.withinBorder;
				//内框线(11:30-13:30 相差2个像素)
				cans.moveTo(this.width/2-2,0);
				cans.lineTo(this.width/2-2,this.height);
				index=0;
				var style="grey";
				//横线
				for(var i=1;i<=12;i++){
					if(i%4==2){
						cans.moveTo(0,this.height/12*i);
						cans.lineTo(this.width,this.height/12*i);
						//当前价格
						price=stock.addNum(this.define.max,-this.define.differ/12*i);
						if(price>this.define.PRE){
							style="red";
						}else if(price<this.define.PRE){
							style="green";
						}
						//价格
						$this=$("#"+stock_minute.name).find(".price li").eq(index);
						$this.css({top:this.height/12*i/2});
						$this.attr("class","");
						$this.addClass(style);
						$this.html(price.toFixed(2));
						//涨幅
						$this=$("#"+stock_minute.name).find(".range li").eq(index);
						$this.css({top:parseInt(this.height/12*i/2)});
						$this.attr("class","");
						$this.addClass(style);
						$this.html(((price-this.define.PRE)/(this.define.PRE)*100).toFixed(2)+"%");
						index++;
					}
				}
				cans.stroke();
				cans.closePath();
				//虚线
				cans.beginPath();
				cans.strokeStyle=stock.color.solid;
				var x=0;
				var y=0;
				for(var i=0;i<this.width/12;i++){
					y=this.getY(this.define.PRE);
					cans.moveTo(x,y);
					x+=6;
					cans.lineTo(x,y);
					x+=6;
				}
				cans.stroke();
				cans.closePath();
				stock_minute.xy=[];
				//曲线
				cans.beginPath();
				cans.lineWidth = 2; 
				cans.strokeStyle=stock.color.trend;
				var _data=data[0].split(",");
				var x=0;
				var y=this.getY(_data[1]);
				cans.moveTo(x,y);
				stock_minute.xy.push({x:x,y:y});
				//从1开始
				for(var i=1;i<data.length;i++){
					var _data=data[i];
					if(_data!=""){
						_data=_data.split(",");
					}	
					x+=this.width/(stock_minute.datacount-1);
					y=this.getY(_data[1]);
					cans.lineTo(x,y);
					stock_minute.xy.push({x:x,y:y});
				}
				if(stock.hq.isRun()){
					$("#dot").css({left:x/2,top:y/2});
				}else{
					$("#dot").css({left:-1000});	
				}
				cans.stroke();
				//背景
				cans.lineTo(x, this.height);
				cans.lineTo(0, this.height);
				cans.fillStyle=stock.color.fill;
				cans.fill();
				cans.closePath();
				cans.globalCompositeOperation="destination-over";
				//平均线
				data=stock_minute.avgdata;
				cans.beginPath();
				cans.lineWidth = 2;  
				cans.strokeStyle=stock.color.minuteAvg;
				cans.moveTo(0,this.getY(data[0]));
				for(var i=1;i<data.length;i++){
					x=stock_minute.xy[i].x;
					y=this.getY(data[i]);
					cans.lineTo(x,y);
				}
				cans.stroke();
				cans.closePath();
				cans.save();
				//释放内存
				$this=null,index=null,price=null;
				delete cans;
				delete data;
			},
			//Y坐标
			getY:function(price){
				return (this.define.max-price)/this.define.differ*this.height
			}
		},
		//L线
		l:{
			width:0,
			height:0,	
			define:{max:0,allsize:0},//自定义变量(成交量)
			id:null,
			load:function(){
				var data=stock_minute.data;
				var $this=null,index=0,price=0;
				if(data==null){return false;}
				this.id=stock_minute.name+"-l";
				var cans=document.getElementById(this.id).getContext('2d');
				this.width=parseInt($("#"+this.id).width())*2;
				this.height=parseInt($("#"+this.id).height())*2;
				$("#"+this.id).attr("width",this.width);
				$("#"+this.id).attr("height",this.height);
				cans.beginPath();
				cans.translate(0.5,0.5);
				cans.lineWidth = 1;  
				cans.strokeStyle=stock.color.border;
				//画框
				cans.strokeRect(0, 0, this.width-1,this.height-1);
				cans.stroke();
				cans.closePath();
				cans.beginPath();
				cans.fillStyle =stock.color.volume;
				cans.linewidth=0;
				var x=0;
				var y=0;
				var w=this.width/stock_minute.datacount*0.6;
				var h=0;
				if(this.define.max*1>100000000){
					$("#"+stock_minute.name).find(".max-volume").html((this.define.max/100000000).toFixed(2)+"亿手");
				}else{
					$("#"+stock_minute.name).find(".max-volume").html((this.define.max/1000000).toFixed(2)+"万手");
				}
				//最大成交量
				for(var i=0;i<data.length;i++){
					var _data=data[i];
					if(_data!=""){
						_data=_data.split(",");
					}
					h=(_data[2]/this.define.max)*this.height*0.98;
					if(h!=0){
						y=this.height-h;
						cans.fillRect(x,y,w,h);
					}
					x+=this.width/(stock_minute.datacount);
				}
				cans.closePath();
				cans=null;
				delete data;
			}
		},
		//处理数据
		dispose:function(){
			var data=this.data,_data,define;
			var PRE=stock.data[2]*1;//昨日收盘价
			var limit_up=(PRE*1.1).toFixed(2);//涨停
			var limit_down=(PRE*0.9).toFixed(2);//跌停
			var price_max=0,price_min=100000000,volume_max=0;
			var length=data.length;
			this.avgdata=new Array();
			var sumPrice=new Array(),_sumPrice=0;
			var sumVolume=new Array(),_sumVolume=0;
			for(var i=0;i<length;i++){
				_data=data[i].split(",");
				if(parseFloat(_data[1])>price_max){price_max=_data[1];}
				if(parseFloat(_data[1])<price_min){price_min=_data[1];}
				if(parseFloat(_data[2])>volume_max){volume_max=_data[2];}
				if(i!=0){_sumPrice=sumPrice[i-1];_sumVolume=sumVolume[i-1];}
				if(_data[2]!=-1){
					sumPrice[i]=(_data[3]*1+_sumPrice*1);
					sumVolume[i]=(_data[2]*1+_sumVolume*1);
					this.avgdata.push((sumPrice[i]/sumVolume[i]).toFixed(2));
				}
			}
			if(price_max==price_min){
				//涨
				if(price_max>=PRE){
					price_max=limit_up;
					price_min=PRE;
				}else{
					price_max=PRE;
					price_min=limit_down;
				}
			}else if(price_max<PRE){
				price_max=PRE;
			}else if(price_min>PRE){
				price_min=PRE;
			}
			//开盘价为0，停牌
			if(stock.data[1]==0){
				price_max=limit_up;
				price_min=limit_down;
			}
			price_max*=1;
			price_min*=1;
			price_max+=(price_max-price_min)/11;
			price_min-=(price_max-price_min)/11;
			console.log(price_max)
			define={
				max:price_max,
				min:price_min,
				//改
				avg:(stock.addNum(price_max,price_min)/2),	
				differ:(price_max-price_min),
				PRE:stock.data[2]
			}
			//赋值
			stock_minute.k.define=define;
			define={
				max:volume_max
			}
			stock_minute.l.define=define;
			//释放内存
			delete data;
			delete sum;
			_data=null;
			length=null;
			define=null;
			price_max=null,price_min=null,volume_max=null;
	},
	//设置买卖数据
	sellbuy:function(){
		var data=stock.data;
		//卖
		var str="";
		for(var i=5;i>0;i--){
			var size=parseInt( data[18+i*2]/100);
			var price=data[19+2*i];
			var style="red";
			if(price==data[2]){
				style="grey";
			}else if(price<data[2]){
				style="green";	
			}
			if(price==0){
				price="&nbsp;&nbsp;---";
			}
			str+='<li><span class="name">卖'+i+'</span><span class="price '+style+'">'+price+'</span><span class="size">'+size+'</span></li>';
		}
		str+='<li class="hr"></li>';
		for(var i=1;i<=5;i++){	
			var size=parseInt( data[8+i*2]/100);
			var style="red";
			var price=data[9+2*i];
			if(price==data[2]){
				style="grey";
			}else if(price<data[2]){
				style="green";	
			}
			if(price==0){
				price="&nbsp;&nbsp;---";
			}
			str+='<li><span class="name">买'+i+'</span><span class="price '+style+'">'+price+'</span><span class="size">'+size+'</span></li>';
		}
		$("#sell-buy").html(str);
	},
	//监听事件
	touch:{
		map:null,
		spirit:null,
		load:function(){
			var touchID=$("#"+stock_minute.name).find(".touch").attr("id");//当前ID
			this.map=document.getElementById(touchID);
			if(stock.isPC){
				$("#"+touchID).mousedown(function(e){
					stock_minute.touch.touchStart(e.clientX,e.clientY);
					document.onmousemove = function(e) {
						if (!stock_minute.touch.spirit) return;
						stock_minute.touch.touchMove(e.clientX,e.clientY);	
					}
					document.onmouseup = function () {
						if (!stock_minute.touch.spirit) return;
						stock_minute.touch.touchEnd();	
					}
				});
			}else{
				function touchStart(event) {
					//阻止网页默认动作（即网页滚动）
					event.preventDefault();	
					if (stock_minute.touch.spirit || !event.touches.length) return;
					var touch = event.touches[0];
					stock_minute.touch.touchStart(touch.pageX,touch.pageY);
				}
				function touchMove(event) {
					event.preventDefault();
					if (!stock_minute.touch.spirit || !event.touches.length) return;
					var touch = event.touches[0];
					stock_minute.touch.touchMove(touch.pageX,touch.pageY);
				}
				function touchEnd(event) {
					if (!stock_minute.touch.spirit) return;
					stock_minute.touch.touchEnd();	
				}
				this.map.addEventListener("touchstart", touchStart, false);
				this.map.addEventListener("touchmove", touchMove, false);
				this.map.addEventListener("touchend", touchEnd, false);
			}
		},
		//cls等于1点击时
		handle:function(x,y){
			var index=Math.round(stock_minute.datacount/stock_minute.k.width*x*2);
			var data=stock_minute.data[index];
			if(data==undefined){
				if($("#"+stock_minute.name).find(".x").css("top")=="-1000px"){
					$("#header ul").hide();
					return false;
				}
				index=stock_minute.xy.length-1;
				data=stock_minute.data[index];
			}
			$("#header ul").show();
			data=data.split(",");
			y=stock_minute.xy[index].y/2;
			$("#"+stock_minute.name).find(".x").css({top:y});
			$("#"+stock_minute.name).find(".x").find(".current-price").html(data[1]);
			$("#"+stock_minute.name).find(".x").find(".current-range").html(((data[1]-stock_minute.k.define.PRE)/(stock_minute.k.define.PRE)*100).toFixed(2)+"%");
			$("#"+stock_minute.name).find(".y").css({left:parseInt(stock_minute.xy[index].x/2)});
			if(data[2]==-1){
				var volume="--";
			}else{
				var volume=parseInt(data[2]);
			}
			var str="";
			str+='<li>当前价：'+data[1]+'</li>';
			str+='<li>成交量：'+volume+'</li>';
			str+='<li>时间：'+data[0]+'</li>';
			$("#header ul").html(str);
			data=null;
		},
		touchStart:function(x,y){
			x-=stock.touch.left;
			y-=stock.touch.top;
			this.spirit = document.createElement("div");	
			this.map.appendChild(this.spirit);
			this.spirit.className = "xy";
			$("#"+stock_minute.name).find(".xy").html('<div class="x"><span class="current-price"></span><span class="current-range"></span></div><div class="y"></div>');
			this.handle(x,y);
		},
		touchMove:function(x,y){
			x-=stock.touch.left;
			y-=stock.touch.top;
			if(x<0){x=0;}
			if(y<0){y=0;}
			this.handle(x,y);
		},
		touchEnd:function(){
			this.map.removeChild(this.spirit);
			$("#header ul").hide();
			this.spirit = null;
		}
	}
}