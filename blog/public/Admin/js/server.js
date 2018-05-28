function change_pass(){
	if(check_pass()){
		var _token=password._token.value;
		var method="pass";
		var pass_n=password.pass_n.value;
		var pass_n_confirmation=password.pass_n_confirmation.value;
		var pass_o=password.pass_o.value;
		$("form[name='password'] input[type='button']").attr("disabled",true);
		$.ajax({
			url : "/admin/basic_set/password",
			type : 'post',
			data:{_token:_token,method:method,pass_n:pass_n,pass_n_confirmation:pass_n_confirmation,pass_o:pass_o},
			success : function(json){
				var json = JSON.parse(json); // 解析成json对象
				if(json.state==1){
					$(".back_msg").html("<font color='green'>"+json.msg+"</font>");
				}else{
					$(".back_msg").html("<font color='#f00'>"+json.msg+"</font>");
				}
				$("form[name='password'] input[type='button']").attr("disabled",false);
			}
		});
	}	
}

function change_order(obj,id){
	var _token=category._token.value;
	var no_order=$(obj).val();
	if(no_order==""){
		alert('分类排序不能为空！');
		setTimeout(function(){$(obj).focus();},100);
		return false;
	}else{
		if(!check_num(no_order)){
			alert('请输入数字！');
			setTimeout(function(){$(obj).focus();},100);
			return false;
		}		
	}
	$.post(
		"/admin/basic_set/category/change_order",
		{'_token':_token,'id':id,'no_order':no_order},
		function(data){
			if(data.status==1){
				layer.alert(data.msg,{icon:6});
			}else if(data.status==2){
				alert(data.msg);
				$(obj).focus();
			}else{
				layer.alert(data.msg,{icon:5});
			}
		}
	)
}

function change_links_order(obj,id){
	var _token=link._token.value;
	var no_order=$(obj).val();
	if(no_order==""){
		alert('分类排序不能为空！');
		setTimeout(function(){$(obj).focus();},100);
		return false;
	}else{
		if(!check_num(no_order)){
			alert('请输入数字！');
			setTimeout(function(){$(obj).focus();},100);
			return false;
		}		
	}
	$.post(
		"/admin/links/change_order",
		{'_token':_token,'id':id,'no_order':no_order},
		function(data){
			if(data.status==1){
				layer.alert(data.msg,{icon:6});
			}else if(data.status==2){
				alert(data.msg);
				$(obj).focus();
			}else{
				layer.alert(data.msg,{icon:5});
			}
		}
	)
}

function change_articles_order(obj,id){
	var _token=article._token.value;
	var no_order=$(obj).val();
	if(no_order==""){
		alert('分类排序不能为空！');
		setTimeout(function(){$(obj).focus();},100);
		return false;
	}else{
		if(!check_num(no_order)){
			alert('请输入数字！');
			setTimeout(function(){$(obj).focus();},100);
			return false;
		}		
	}
	$.post(
		"/admin/article/change_order",
		{'_token':_token,'id':id,'no_order':no_order},
		function(data){
			if(data.status==1){
				layer.alert(data.msg,{icon:6});
			}else if(data.status==2){
				alert(data.msg);
				$(obj).focus();
			}else{
				layer.alert(data.msg,{icon:5});
			}
		}
	)
}

function change_navs_order(obj,id){
	var _token=nav._token.value;
	var no_order=$(obj).val();
	if(no_order==""){
		alert('分类排序不能为空！');
		setTimeout(function(){$(obj).focus();},100);
		return false;
	}else{
		if(!check_num(no_order)){
			alert('请输入数字！');
			setTimeout(function(){$(obj).focus();},100);
			return false;
		}		
	}
	$.post(
		"/admin/navs/change_order",
		{'_token':_token,'id':id,'no_order':no_order},
		function(data){
			if(data.status==1){
				layer.alert(data.msg,{icon:6});
			}else if(data.status==2){
				alert(data.msg);
				$(obj).focus();
			}else{
				layer.alert(data.msg,{icon:5});
			}
		}
	)
}

function change_config_order(obj,id){
	var _token=config._token.value;
	var no_order=$(obj).val();
	if(no_order==""){
		alert('分类排序不能为空！');
		setTimeout(function(){$(obj).focus();},100);
		return false;
	}else{
		if(!check_num(no_order)){
			alert('请输入数字！');
			setTimeout(function(){$(obj).focus();},100);
			return false;
		}		
	}
	$.post(
		"/admin/config/change_order",
		{'_token':_token,'id':id,'no_order':no_order},
		function(data){
			if(data.status==1){
				layer.alert(data.msg,{icon:6});
			}else if(data.status==2){
				alert(data.msg);
				$(obj).focus();
			}else{
				layer.alert(data.msg,{icon:5});
			}
		}
	)
}

function del(_token,url,obj){  
	$.post(
		url,
		{'_token':_token,'_method':'delete'},
		function(data){
			if(data.status==1){
				$(obj).parent().parent().remove();
				layer.alert(data.msg,{icon:6});
			}else{
				layer.alert(data.msg,{icon:5});
			}
		}
	)
}  
