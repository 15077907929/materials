//结算
function check_balance(){
	if(balance.email.value==''){
		alert('请输入邮箱！');
		balance.email.focus();
		return false;
	}	
	if(!isEmail(balance.email.value)){
		alert('请输入您的有效邮箱地址 !');
		balance.email.focus();
		return false;
	}
	if(balance.country.value==''){
		alert('请输入国家！');
		balance.country.focus();
		return false;
	}	
	if(balance.realname.value==''){
		alert('请输入您的名称！');
		balance.realname.focus();
		return false;
	}	
	if(balance.tel.value==''){
		alert('请输入您的电话！');
		balance.tel.focus();
		return false;
	}		
	if(!checkTel(balance.tel.value)){
		alert('固定电话有误，请重填！');
		balance.tel.focus();
		return false;
	}	
	if(balance.mobile.value==''){
		alert('请输入您的手机！');
		balance.mobile.focus();
		return false;
	}
	if(!checkPhone(balance.mobile.value)){
		alert('手机号码有误，请重填！');
		balance.mobile.focus();
		return false;
	}
	if(!checkZipcode(balance.zip_code.value)){
		alert('邮政编码格式不正确！');
		balance.zip_code.focus();
		return false;
	}
}

//验证email格式
function isEmail(src) {
	isEmail1    = /^\w+([\.\-]\w+)*\@\w+([\.\-]\w+)*\.\w+$/;
	isEmail2    = /^.*@[^_]*$/;
    return (isEmail1.test(src) && isEmail2.test(src));
}

//验证tel格式
function checkTel(tel){
	if(!/^([0-9]{3,4}-)?[0-9]{7,8}$/.test(tel)){
		return false;
	}else{
		return true;
	}
}

//验证mobile格式
function checkPhone(phone){ 
    if(!(/^1[34578]\d{9}$/.test(phone))){ 
        return false; 
    }else{
		return true;
	}
}

//验证邮政编码格式
function checkZipcode(zipcode){ 
	var re= /^[1-9][0-9]{5}$/
	if(!re.test(zipcode)){
		return false;
	}else{
		return true;
	}
}

//结算
function check_balance(){
	if($('.icart tr').length==1){
		alert('请先添加购物车,然后再进行结算！');
		return false;
	}else{
		location.href='index.php?m=Home&c=Cart&a=balance';
	}
}

//用户注册
function user_register_check(){
	if(register.code.value==''){
		alert('请输入验证码！');
		register.code.focus();
		return false;
	}		
	if(register.username.value==''){
		alert('请输入用户名！');
		register.username.focus();
		return false;
	}	
	if(register.password.value==''){
		alert('请输入密码！');
		register.password.focus();
		return false;
	}	
	if(register.password2.value==''){
		alert('请输入确认密码！');
		register.password2.focus();
		return false;
	}
	if(register.password.value!=register.password2.value){
		alert('两次输入的密码不一致！');
		register.password2.focus();
		return false;		
	}
	if(register.email.value==''){
		alert('请输入邮箱！');
		register.email.focus();
		return false;
	}
	if(!isEmail(register.email.value)){
		alert('请输入您的有效邮箱地址 !');
		register.email.focus();
		return false;
	}	
	return true;
}

//修改密码
function reset_pwd_check(){
	if(user.oldpass.value==''){
		alert('请输入旧密码！');
		user.oldpass.focus();
		return false;
	}	
	if(user.newpass.value==''){
		alert('请输入新密码！');
		user.newpass.focus();
		return false;
	}	
	if(user.newpass2.value==''){
		alert('请输入确认密码！');
		user.newpass2.focus();
		return false;
	}	
	return true;
}

function check_del(url){  
	var mymessage=confirm("确认要删除该条记录吗？");  
	if(mymessage==true){  
		location.href=url;
	} 
} 