//定义XMLHttpRrequest对象
var xmlHttp=createXmlHttpRequestObject();

//获取XMLHttpRrequest对象
function createXmlHttpRequestObject(){
	//用来存储将要使用的XMLHttpRrequest对象
	var xmlHttp;
	//如果在internet Explorer下运行
	if(window.ActiveXObject){
		try{
			xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
		}catch(e){
			xmlHttp=false;
		}

	}else{
	//如果在Mozilla或其他的浏览器下运行
		try{
			xmlHttp=new XMLHttpRequest();
		}catch(e){
			xmlHttp=false;
		}
	}
	 //返回创建的对象或显示错误信息
	if(!xmlHttp)
		alert("返回创建的对象或显示错误信息");
		else
		return xmlHttp;
}
//使用XMLHttpRequest对象创建异步HTTP请求
function process(){
	if(register.name.value==""){
		alert("请输入姓名！");
   		    register.name.select();
			return(false);
		}
	if(register.tel.value==""){
		alert("请输入电话号码！");
		register.tel.select();
		return(false);
		}
	if(checkphone(register.tel.value)!=true){
		alert("您输入的电话号码的格式不正确！");
		register.tel.select();
		return(false);
		}	

	if(register.address.value==""){
		alert("请输入联系地址！");
		register.address.select();
		return(false);
	}
	
	//在xmlHttp对象不忙时进行处理
	if(xmlHttp.readyState==4 || xmlHttp.readyState==0){
		//获取用户在线表单中输入的姓名	
		name = document.getElementById("name").value;
		tel = document.getElementById("tel").value;
		addresss =document.getElementById("address").value;
		//在服务器端执行quickstart.php
		
		xmlHttp.open("GET","index.php?m=Home&c=Login&a=register_ok&name="+name+"&tel="+tel+"&address="+addresss,true);
		//定义获取服务器端响应的方法
		xmlHttp.onreadystatechange=handleServerResponse;
		//向服务器发送请求
		xmlHttp.send(null);
	}else
		//如果服务器忙,1秒后重试
		setTimeout('process()',1000);
}
//当收到服务器端的消息时自动执行
function handleServerResponse(){
	//在处理结束时进入下一步
	if(xmlHttp.readyState==4){
		console.log('ok')
		//状态为200表示处理成功结束
		if(xmlHttp.status==200){
			//获取服务器端发来的XML信息
			xmlResponse=xmlHttp.responseXML;
			//获取XML中的文档对象(根对象)
			xmlDocumentElement=xmlResponse.documentElement;
			//获取第一个文档子元素的文本信息
			helloMessage=xmlDocumentElement.firstChild.data;
			//使用从服务器端发来的消息更新客户端显示的内容
			document.getElementById("msg").innerHTML='<i>'+helloMessage+'</i>';
		}else{
			//如果HTTP的状态不是200表示发生错误
        	alert("There was a problem accessing the server:"+xmlHttp.statusText);
		}
	}
}

//验证电话号码的格式是否正确
function checkphone(tel){
	var str=tel;
	var Expression=/^(\d{3}-)(\d{8})$|^(\d{4}-)(\d{7})$|^(\d{4}-)(\d{8})$|^(\d{11})$/;  
	var objExp=new RegExp(Expression);
	if(objExp.test(str)==true){
		return true;
	}else{
		return false;
	}
}	

function keydown(){
	if(event.keyCode==8){
		event.keyCode=0;
		event.returnValue=false;
		alert("当前设置不允许使用退格键");
	}
	if(event.keyCode==13){
		event.keyCode=0;
		event.returnValue=false;
		alert("当前设置不允许使用回车键");
	}
	if(event.keyCode==116){
		event.keyCode=0;
		event.returnValue=false;
		alert("当前设置不允许使用F5刷新键");
	}
	if((event.altKey)&&((window.event.keyCode==37)||(window.event.keyCode==39))){
		event.returnValue=false;
		alert("当前设置不允许使用Alt+方向键←或方向键→");
	}
	if((event.ctrlKey)&&(event.keyCode==78)){
	   event.returnValue=false;
	   alert("当前设置不允许使用Ctrl+n新建IE窗口");
	}
	if((event.shiftKey)&&(event.keyCode==121)){
	   event.returnValue=false;
	   alert("当前设置不允许使用shift+F10");
	}
}

function click() {
	event.returnValue=false;
	alert("当前设置不允许使用右键！");
}

// 格式化日期，如月、日、时、分、秒保证为2位数
function formatNumber (n) {
	n = n.toString()
	return n[1] ? n : '0' + n;
}
// 参数number为毫秒时间戳，format为需要转换成的日期格式
function formatTime (number) {
	var format;
	var m=formatNumber(parseInt(number/60));
	var s=formatNumber(number%60);
	return m+":"+s;
}
