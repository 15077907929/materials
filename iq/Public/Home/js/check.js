function check_login(){
	if(login.name.value==''){
		alert("请输入姓名！");
		login.name.focus();
		return false;
	}
	if(login.tel.value==''){
		alert("请输入手机号码！");
		login.tel.focus();
		return false;
	}	
	if(!check_tel(login.tel.value)){
		alert('请输入有效的手机号码！'); 
		login.tel.focus();
		return false;
	}
	if(login.key.value==''){
		alert("请输入口令！");
		login.key.focus();
		return false;
	}
	return true;
}

function check_get_key(){
	var tel=get_key.tel.value;
	if(tel==''){
		alert("请输入手机号码！");
		get_key.tel.focus();
		return false;
	}
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
	if(!myreg.test(tel)) { 
		alert('请输入有效的手机号码！'); 
		get_key.tel.focus();
		return false; 
	} 
	create_key(tel);
}

function check_tel(tel){
	var myreg = /^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/; 
	if(!myreg.test(tel)) { 
		return false; 
	}
	return true;
}