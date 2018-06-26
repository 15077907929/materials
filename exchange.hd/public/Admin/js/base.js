//left导航下拉效果
function ToogleMenu(obj){
	if($(obj).parent().parent().find("dl").css("display")=="block"){
		return;
	}else{
		$('.left').find("dl").each(function(){
			if($(obj).parent().parent().find("h1").html()==$(this).prev().html()){
				$(this).slideDown();
			}else{
				$(this).slideUp();
			}
		});
	}
}