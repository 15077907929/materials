//添加购物车
function addCart(id){
	$('.addcart button').attr('disabled',true);
	$.ajax({
		url: 'index.php?m=Home&c=Product&a=addCart&id='+id,
		type: 'get',
		success: function (json) {
			$('.addcart button').attr('disabled',false);
			window.location.href='index.php?m=Home&c=Cart&a=index'; 
		}
	});
}

//会员登录
function user_login(){
	var username=login.username.value;
	var password=login.password.value;
	if(username==''){
		alert('请输入用户名！');
		return;
	}	
	if(password==''){
		alert('请输入密码！');
		return;
	}
	$('.login button').attr('disabled',true);
	$.ajax({
		url: 'index.php?m=Home&c=Login&a=loginIn&username='+username+'&password='+password,
		type: 'get',
		success: function (json) {
			var json = JSON.parse(json); // 解析成json对象
			if(json.state==0){
				alert(json.info);
			}else if(json.state==1){
				window.location.href='index.php?m=Home&c=Login&a=logined'; 
			}
			$('.login button').attr('disabled',false);
		}
	});
}

//会员注册
function user_register(){
	if(user_register_check()){
		$('.register button').attr('disabled',true);
		var code=register.code.value;
		var username=register.username.value;
		var password=register.password.value;
		var email=register.email.value;
		var sex=register.sex.value;
		$.ajax({
			url : "index.php?m=Home&c=Login&a=register&method=ajax",
			type : 'post',
			data:{code:code,username:username,password:password,email:email,sex:sex},
			success : function(json){
				var json = JSON.parse(json); // 解析成json对象
				alert(json.msg);
				$('.register button').attr('disabled',false);
			}
		});
	}
}

//忘记密码
function user_forget(){
	var username=forget.username.value;
	if(username==''){
		alert('请输入用户名！');
		forget.username.focus();
		return;
	}	
	$.ajax({
		url: 'index.php?m=Home&c=Login&a=forget&method=ajax&username='+username,
		type: 'get',
		success: function (json) {
			var json = JSON.parse(json); // 解析成json对象
			alert(json.msg);
			$('.forget button').attr('disabled',false);
		}
	});
}

//修改密码
function reset_pwd(){
	if(reset_pwd_check()){
		$('.user button').attr('disabled',true);
		var oldpass=user.oldpass.value;
		var newpass=user.newpass.value;
		$.ajax({
			url : "index.php?m=Home&c=User&a=reset_pwd&method=ajax",
			type : 'post',
			data:{oldpass:oldpass,newpass:newpass},
			success : function(json){
				var json = JSON.parse(json); // 解析成json对象
				alert(json.msg);
				$('.user button').attr('disabled',false);
			}
		});
	}else{
		return false;
	}
}