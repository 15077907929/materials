var http_request=false;
function send_request(url){
	http_request=false;
	if(window.XMLHttpRequest){
		http_request=new XMLHttpRequest();
		if(http_request.overrideMineType){
			http_request.overrideMineType('text/xml');
		}
	}else if(window.ActiveXObject){
		try{
			http_request=new ActiveXObject("Msxml2.XMLHTTP");
		}catch(e){
			try{
				http_request=new ActiveXObject("Microsoft.XMLHTTP");
			}catch(e){}
		}
	}
	if(!http_request){
		alert("不能创建XMLHttpRequest对象！");
		return false;
	}
	http_request.onreadystatechange=processRequest;
	http_request.open("GET",url,true);
	http_request.send(null);
}

//处理返回信息
var text='';
function send_r(url,t){
	type=t;
	send_request(url);
}

function processRequest(){
	if(http_request.readyState==1){
		
	}
	
	if(http_request.readyState==4){
		if(http_request.status==200){
			text=http_request.responseText;
		}
	}
}

function get_rooms(){
	send_request("get_rooms.php?time="+Math.random());
	if(text){
		document.getElementById("rooms").innerHTML=text;
	}
}