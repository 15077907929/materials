//登录验证函数
function admin_login_check(){
	if(log.admin_name.value==''){
		alert('请输入用户名！');
		log.admin_name.focus();
		return false;
	}	
	if(log.admin_pass.value==''){
		alert('请输入密码！');
		log.admin_pass.focus();
		return false;
	}	
	if(log.code.value==''){
		alert('请输入验证码！');
		log.code.focus();
		return false;
	}
	return true;
}

function check_question(){	
	if(question.no_order.value!=""){
		var reg=/^[0-9]*$/;
		if(!reg.test(question.no_order.value)){
			alert('请输入数字！');
			question.no_order.focus();
			return false;
		}
	}
	if(question.title.value==""){
		alert('请输入标题！');
		question.title.focus();
		return false;		
	}	
	if(question.correct.value==""){
		alert('请输入正确答案！');
		question.correct.focus();
		return false;		
	}
}

function check_del(url){  
	var mymessage=confirm("确认要删除该条记录吗？");  
	if(mymessage==true){  
		location.href=url;
	} 
}  