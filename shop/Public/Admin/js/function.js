function user_login_check(){
	if(login.username.value==''){
		alert('用户名不能为空！');
		login.username.focus();
		return false;
	}	
	if(login.password.value==''){
		alert('密码不能为空！');
		login.password.focus();
		return false;
	}
	return true;
}