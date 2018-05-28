//登录验证函数
function user_login_check(){
	if(log.user_name.value==''){
		alert('请输入用户名！');
		log.user_name.focus();
		return false;
	}	
	if(log.user_pass.value==''){
		alert('请输入密码！');
		log.user_pass.focus();
		return false;
	}	
	if(log.code.value==''){
		alert('请输入验证码！');
		log.code.focus();
		return false;
	}
	return true;
}

//修改密码验证函数
function check_pass(){
	if(password.pass_o.value==''){
		alert("旧密码不能为空！");
		password.pass_o.focus();
		return false;
	}		
	if(password.pass_n.value==''){
		alert("新密码不能为空！");
		password.pass_n.focus();
		return false;
	}		
	if(password.pass_n.value.length<6 || password.pass_n.value.length>20){
		alert("新密码长度必须大于6位小于20位！");
		password.pass_n.focus();
		return false;
	}	
	if(password.pass_n_confirmation.value==''){
		alert("确认密码不能为空！");
		password.pass_n_confirmation.focus();
		return false;
	}		
	if(password.pass_n_confirmation.value.length<6 || password.pass_n_confirmation.value.length>20){
		alert("确认密码长度必须大于6位小于20位！");
		password.pass_n_confirmation.focus();
		return false;
	}
	if(password.pass_n.value!=password.pass_n_confirmation.value){
		alert("新密码与确认密码不相符！");
		password.pass_n.focus();
		return false;
	}	
	return true;
}

//添加分类
function check_category(){
	if(category.pid.value==''){
		alert("父级分类不能为空！");
		category.pid.focus();
		return false;
	}		
	if(category.name.value==''){
		alert("分类名称不能为空！");
		category.name.focus();
		return false;
	}	
	if(category.no_order.value!=""){
		var reg=/^[0-9]*$/;
		if(!reg.test(category.no_order.value)){
			alert('请输入数字！');
			category.no_order.focus();
			return false;
		}
	}
	return true;
}

//验证数字
function check_num(num){
	var reg=/^[0-9]*$/;
	if(!reg.test(num)){
		return false;
	}else{
		return true;
	}	
}

//确定删除
function check_del(_token,url,obj){  
	var mymessage=confirm("确认要删除该条记录吗？");  
	if(mymessage==true){  
		del(_token,url,obj);
	} 
}  

//添加文章
function check_article(){
	if(article.cate_id.value==''){
		alert("文章分类不能为空！");
		article.cate_id.focus();
		return false;
	}		
	if(article.title.value==''){
		alert("文章标题不能为空！");
		article.title.focus();
		return false;
	}	
	return true;
}

//添加链接
function check_links(){
	if(links.name.value==''){
		alert("链接名称不能为空！");
		links.name.focus();
		return false;
	}		
	if(links.url.value==''){
		alert("链接地址不能为空！");
		links.url.focus();
		return false;
	}	
	if(!check_num(links.no_order.value)){
		alert("请输入数字！");
		links.no_order.focus();
		return false;		
	}
	return true;
}

//添加导航
function check_navs(){
	if(navs.name.value==''){
		alert("导航名称不能为空！");
		navs.name.focus();
		return false;
	}		
	if(navs.url.value==''){
		alert("导航地址不能为空！");
		navs.url.focus();
		return false;
	}	
	if(!check_num(navs.no_order.value)){
		alert("请输入数字！");
		navs.no_order.focus();
		return false;		
	}
	return true;
}

//添加网站配置
function check_config(){
	if(config.title.value==''){
		alert("配置标题不能为空！");
		config.title.focus();
		return false;
	}		
	if(config.name.value==''){
		alert("配置名称不能为空！");
		config.name.focus();
		return false;
	}	
	if(!check_num(config.no_order.value)){
		alert("请输入数字！");
		config.no_order.focus();
		return false;		
	}
	return true;
}