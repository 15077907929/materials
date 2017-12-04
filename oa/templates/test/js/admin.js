//登录页面js效果
$(document).ready(function(){
	$(".login_form .info p").click(function(){
		$(this).css("border","1px solid #7eadd9");
	});
	$(".login_form .info p select").blur(function(){
		$(this).parent().css("border","1px solid #B5B8C8");
	});
	$(".login_form .info input").blur(function(){
		if($(this).val()==''){
			$(this).parent().css("border","1px solid #dd7870");
			$(this).next().removeClass("hide");
		}else{
			$(this).parent().css("border","1px solid #B5B8C8");
			$(this).next().addClass("hide");
		}
	});
});

$(document).ready(function(){
	$(".login_form .info p .must").mouseover(function(){
		$(this).next().removeClass("hide");
	});	
	$(".login_form .info p .must").mouseout(function(){
		$(this).next().addClass("hide");
	});
});

//登录验证数据的完整性以及提示哪些需要填写
function check(form){
	$(".login_form .info input").each(function(){
		if($(this).val()==''){
			$(this).next().removeClass("hide");
		}
	});
	if(form.username.value==""||form.username.value==""||form.chknumber.value==""){
		return false;
	}else{
		return true;
	}	
}

//toolbar菜单js效果
$(document).ready(function(){
	$(".toolbar ul li").mouseover(function(){
		$(this).find($(".subMenu")).removeClass("hide");
	});
	$(".toolbar ul li").mouseout(function(){
		$(this).find($(".subMenu")).addClass("hide");
	});
});