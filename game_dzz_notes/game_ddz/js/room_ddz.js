var status='begin';
var now_flag="";
var flag="";
var lord="";

//ajax
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
var type=0;
function send_r(url,t){
	type=t;
	send_request(url);
}

function processRequest(){
	if(http_request.readyState==1){

	}
	if(http_request.readyState==4){
		if(http_request.status==200){
			if(type==0){
				var text=http_request.responseText.split("|");
				player1_name=text[0];
				player2_name=text[1];
				
				lord=text[4];
				lord_p=text[5];
				flag=text[6];
				
				if(status!='wait'){
					do_ani_p(text[3]);
					do_self_p(text[2]);
					do_user_info(text[9],text[10],text[11],text[12],text[13],text[14]);
				}
				player1_show=text[7];
				player2_show=text[8];
			}
		}
	}
}

//规则
function pai_v(pai){
	var v;
	if(pai=='3'||pai=='F3'||pai=='T3'||pai=='H3'){
		v=3;
	}
	if(pai=='4'||pai=='F4'||pai=='T4'||pai=='H4'){
		v=4;
	}
	if(pai=='5'||pai=='F5'||pai=='T5'||pai=='H5'){
		v=5;
	}
	if(pai=='6'||pai=='F6'||pai=='T6'||pai=='H6'){
		v=6;
	}
	if(pai=='7'||pai=='F7'||pai=='T7'||pai=='H7'){
		v=7;
	}
	if(pai=='8'||pai=='F8'||pai=='T8'||pai=='H8'){
		v=8;
	}
	if(pai=='9'||pai=='F9'||pai=='T9'||pai=='H9'){
		v=9;
	}
	if(pai=='10'||pai=='F10'||pai=='T10'||pai=='H10'){
		v=10;
	}
	if(pai=='11'||pai=='F11'||pai=='T11'||pai=='H11'){
		v=11;
	}
	if(pai=='12'||pai=='F12'||pai=='T12'||pai=='H12'){
		v=12;
	}
	if(pai=='13'||pai=='F13'||pai=='T13'||pai=='H13'){
		v=13;
	}	
	if(pai=='1'||pai=='F1'||pai=='T1'||pai=='H1'){
		v=14;
	}	
	if(pai=='2'||pai=='F2'||pai=='T2'||pai=='H2'){
		v=15;
	}
	if(pai=='JOKE1'){
		var v=16;
	}
	if(pai=='JOKE2'){
		var v=17;
	}	
	if(pai=="no"){
		v=0;
	}
	return v;
}

function pai_a(pai){
	var split_pai=pai.split(",");
	var pai_num=split_pai.length-1;
	var count=new Array(1,1,1,1,1,1,1,1,1,1,1,1);
	var k=0;
	for(var i=1;i<pai_num;i++){
		if(pai_v(split_pai[i])==pai_v(split_pai[i-1])){
			count[k]++;
		}else{
			k++;
		}
	}
	var r='';
	for(var i=0;i<count.length;i++){
		r=r+count[i]+",";
	}
	//单
	if(pai_num==1){
		return pai_c(pai_v(split_pai[0]),pai_num,pai_v(split_pai[0]));
	}
	//对
	if(pai_num==2&&r=="2,1,1,1,1,1,1,1,1,1,1,1,"){
		return pai_c(pai_v(split_pai[0]),pai_num,'dui'+pai_v(split_pai[0]));
	}
	//三只
	if(pai_num==3&&r=="3,1,1,1,1,1,1,1,1,1,1,1,"){
		return pai_c(pai_v(split_pai[0]),pai_num,"san");
	}
	//四只
	if(pai_num==4&&r=="4,1,1,1,1,1,1,1,1,1,1,1,"){
		return pai_c(pai_v(split_pai[0]),pai_num,"zha");
	}
	//三带二
	if(pai_num==5&&(r=="3,2,1,1,1,1,1,1,1,1,1,1,"||r=="2,3,1,1,1,1,1,1,1,1,1,1,")){
		if(count[0]>count[1]){
			return pai_c(pai_v(split_pai[2]),pai_num,"sandaiyidui");
		}else{
			return pai_c(pai_v(split_pai[4]),pai_num,"sandaiyidui");
		}
	}
	//连队
	if((pai_num==6&&r=="2,2,2,1,1,1,1,1,1,1,1,1,")||(pai_num==8&&r=="2,2,2,2,1,1,1,1,1,1,1,1,")||(pai_num==10&&r=="2,2,2,2,2,1,1,1,1,1,1,1,")||(pai_num==12&&r=="2,2,2,2,2,2,1,1,1,1,1,1,")||(pai_num==14&&r=="2,2,2,2,2,2,2,1,1,1,1,1,")||(pai_num==16&&r=="2,2,2,2,2,2,2,2,1,1,1,1,")||(pai_num==18&&r=="2,2,2,2,2,2,2,2,2,1,1,1,")||(pai_num==20&&r=="2,2,2,2,2,2,2,2,2,2,1,1,")){
		var flag=0;
		for(var i=2;i<pai_num;i+=2){
			if(pai_v(split_pai[i])-pai_v(split_pai[i-1])!=1){
				flag=1;
				break;
			}
		}
		if(flag==0){
			return pai_c(pai_v(split_pai[pai_num-1]),pai_num,"liandui");
		}
	}	
	//顺子	
	if((pai_v(split_pai[pai_num-1])<=pai_v(1))&&pai_num>=5&&r=="1,1,1,1,1,1,1,1,1,1,1,1,"){
		var flag=0;
		for(var i=1;i<pai_num;i++){
			if(pai_v(split_pai[i])-pai_v(split_pai[i-1])!=1){
				flag=1;
				break;
			}
		}
		if(flag==0){
			return pai_c(pai_v(split_pai[pai_num-1]),pai_num,"shunzi");
		}		
	}
	//对王
	if(pai_num==2&&((pai_v(split_pai[0])==16&&pai_v(split_pai[1])==17)||(pai_v(split_pai[0])==17&&pai_v(split_pai[1])==16))){
		return pai_c(100,pai_num,"wangzha");
	}
	return Array(0,0,0);
}

function pai_c(v,num,t){
	var arr=new Array();
	arr[0]=v;
	arr[1]=num;
	arr[2]=t;
	return arr;
}

function no_show_p(){
	var p_show_var='no,';
	send_r("show_p.php?id="+id+"&player_id="+player_id+"&p_show_var="+p_show_var+"&time="+Math.random(),1);
}

function show_p(){
	if(flag!=player_id){
		alert("It's not your turn now!");
	}else{
		var p_show=new Array();
		var p_show_var="";
		var j=0;
		for(var i=0;i<p.length-1;i++){
			if(document.getElementById("self_p_top_"+p[i]).innerHTML){
				p_show[j++]=p[i];
				p_show_var+=p[i]+",";
			}
		}
		if(p_show_var==""){
			alert("您还没有选取牌！");
		}else{
			var self_pai=pai_a(p_show_var);
			if(player_id=="player1"){
				if(player2_show){
					var ani_pai=pai_a(player2_show);
				}else{
					var ani_pai=new Array(0,0);
				}
			}else{
				if(player1_show){
					var ani_pai=pai_a(player1_show);
				}else{
					var ani_pai=new Array(0,0);
				}
				
			}
			if(self_pai[0]&&(self_pai[0]==100||ani_pai[0]==0||(ani_pai[0]!=100&((self_pai[1]==ani_pai[1]&&self_pai[0]-ani_pai[0]>0)||self_pai[2]=="zha")))){
				send_r("show_p.php?id="+id+"&player_id="+player_id+"&p_show_var="+p_show_var+"&time="+Math.random(),1);
			}else{
				alert("您的出牌不符合规则！");
			}
		}
	}
}

function do_show_p(p_ori,object){
	if(player1_show==""&&player2_show==""){
		
	}else{
		var arr_player1_show=pai_a(player1_show);
		var arr_player2_show=pai_a(player2_show);
	}
	var split_p=p_ori.split(",");
	var show="<table><tr>";
	for(var i=0;i<split_p.length-1;i++){
		if(i==split_p.length-2){
			show+="<td style='background:url(images/"+split_p[i]+".gif) no-repeat left top; width:71px;'>";
		}else{
			show+="<td style='background:url(images/"+split_p[i]+".gif) no-repeat left top;'>";
		}
	}
	show+="</tr></table>";
	document.getElementById(object).innerHTML=show;
}

function click_p(p){
	if(document.getElementById("self_p_top_"+p).innerHTML){
		document.getElementById("self_p_top_"+p).innerHTML="";
	}else{
		document.getElementById("self_p_top_"+p).innerHTML='<img src="images/point.gif" />';
	}
}

//用户信息
var user_info='';
function do_user_info(player1_face,player2_face,player1_win_p,player2_win_p,player1_run_p,player2_run_p){
	user_info="<div class='user_info'><table>";
	if(player_id=='player1'){
		user_info+="<tr><td>对家："+player2_name+"</td><td>胜率："+player2_win_p+"%</td><td>逃跑率："+player2_run_p+"%</td></tr>";
		user_info+="<tr><td>本家："+player1_name+"</td><td>胜率："+player1_win_p+"%</td><td>逃跑率："+player1_run_p+"%</td></tr>";
	}else{
		user_info+="<tr><td>对家："+player1_name+"</td><td>胜率："+player1_win_p+"%</td><td>逃跑率："+player1_run_p+"%</td></tr>";
		user_info+="<tr><td>本家："+player2_name+"</td><td>胜率："+player2_win_p+"%</td><td>逃跑率："+player2_run_p+"%</td></tr>";		
	}
	user_info+="</table></div>";
}

//对家
var ani_p='';
function do_ani_p(ani_num){
	ani_p="<div class='ani_p'><table><tr>";
	for(var i=0;i<ani_num;i++){
		if(i==ani_num-1){
			ani_p+="<td class='side_p'></td>";
		}else{
			ani_p+="<td></td>";
		}
	}
	ani_p=ani_p+"</tr></table></div>";
}

//本家
var self_p='';
function do_self_p(P){
	self_p='<div class="self_p"><table><tr class="self_p_top">';
	p=P.split(",");
	for(var i=0;i<p.length-1;i++){
		self_p+="<td id='self_p_top_"+p[i]+"'></td>";
	}	
	self_p+="</tr><tr>";
	for(var i=0;i<p.length-1;i++){
		if(i==p.length-2){
			self_p+="<td style='background:url(images/"+p[i]+".gif) no-repeat left top; width:71px;'><a href='javascript:void(0);' onclick=\"click_p(\'"+p[i]+"\');\"><img src='images/blank.gif' /></a></td>";
		}else{
			self_p+="<td style='background:url(images/"+p[i]+".gif) no-repeat left top;'><a href='javascript:void(0);' onclick=\"click_p(\'"+p[i]+"\')\"><img src='images/blank.gif' /></a></td>";
		}
	}	
	self_p=self_p+"</tr></table></div>";
}

//对家出牌区
var ani_show="<div class='ani_show' id='ani_show'></div>";

//本家出牌区
var self_show="<div class='self_show' id='self_show'></div>";

//本家按钮
var self_button="<div class='self_button' id='self_button'></div>";

var kaiguan_1=0;
function get_info(){
	//对家逃跑
	if(status=="ing"&&(player1_name==""||player2_name=="")){
		send_r("end.php?id="+id+"player_id="+player_id+"&time="+Math.random(),1);
		alert("对家已经逃跑，点击确定返回大厅。");
		document.location.href="hall.php";
	}
	if(now_flag!=flag){
		now_flag=flag;
		status="begin";
	}
	if(flag&&kaiguan_1==0){
		status="begin";
		kaiguan_1=1;
	}
	if(player1_name==''||player2_name==''){
		document.getElementById("main_echo").innerHTML="<img src='images/loading.gif' /><br/>等待对家加入！<a href=''><img src='images/invite.gif' /></a>";
		document.getElementById("loading").style.display="none";
		status='wait';
	}else if(status=='wait'){
		status='begin';
	}
	if(status=="begin"&&self_p){
		main_echo='';
		main_echo+=ani_p;
		main_echo+=ani_show;
		main_echo+=user_info;
		main_echo+=self_show;
		main_echo+=self_button;
		main_echo+=self_p;
		document.getElementById("loading").style.display="none";
		document.getElementById("main_echo").innerHTML=main_echo;
		if(flag==player_id){
			if(player_id=="player1"){
				do_show_p(player2_show,"ani_show");
			}else{
				do_show_p(player1_show,"ani_show");
			}			
			document.getElementById("self_button").innerHTML="<a href='javascript:void(0);' onclick='show_p();'><img src='images/show_hand.gif' /></a>";
			if((player_id=="player2"&&player1_show!=""&player1_show!='no,')||(player_id=="player1"&&player2_show!=""&player2_show!='no,')){
				document.getElementById("self_button").innerHTML+="<a href='javascript:void(0);' onclick='no_show_p();'><img src='images/no_show_hand.gif' /></a>";
			}
		}else{
			document.getElementById("self_button").innerHTML="<img src='images/loading.gif' /><br/>等待对家响应！<br/>";
			if(player_id=="player1"){
				do_show_p(player1_show,"self_show");
			}else{
				do_show_p(player2_show,"self_show");
			}
		}
		document.getElementById("self_button").innerHTML+="<a href='hall.php'><img src='images/run.gif' /></a>";
		status='ing';
	}
	if(lord==""&&self_p){
		document.getElementById("self_button").innerHTML="<a href='javascript:void(0)' onclick='send_r("+"\""+"get_lord.php?id="+id+"&player_id="+player_id+"&time="+Math.random()+"\",1)'><img src='images/lord.gif' /></a><a href='javascript:void(0)' onclick='send_r("+"\""+"get_lord.php?action=no&id="+id+"&player_id="+player_id+"&time="+Math.random()+"\",1)'><img src='images/no_lord.gif' /></a>";
	}
	send_r("get_info.php?id="+id+"&player_id="+player_id+"&time="+Math.random(),0);
}
		
		
		
		
		
		
		
		
		
		
		