//后台登录
function user_login(){
	if(user_login_check()){
		$('.login button').attr('disabled',true);
		var username=login.username.value;
		var password=login.password.value;
		$.ajax({
			url : "index.php?m=Admin&c=Login&a=loginIn&method=ajax",
			type : 'post',
			data:{username:username,password:password},
			success : function(json){
				var json = JSON.parse(json); // 解析成json对象
				if(json.status==1){
					location.href='index.php?m=Admin&c=Index&a=index';
				}else{
					alert(json.msg);
				}
				$('.login button').attr('disabled',false);
			}
		});
	}
}
