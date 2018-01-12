/*左侧菜单*/
$(document).ready(function(){
	$(".left .bd ul li .first").click(function(){
		var index=$(this).parent().index();
		if($(this).next().attr("class")=="sub hide"){
			$(this).next().removeClass("hide");
			$(this).addClass('active');
			$.cookie('left_li_'+index, 'show', { expires: 7, path: '/' }); 
		}else{
			$(this).next().addClass("hide");
			$.cookie('left_li_'+index, 'hide', { expires: 7, path: '/' }); 
			$(this).removeClass('active');
		}
	});
	var len=$(".left .bd ul li").length;
	for(var i=0;i<len;i++){
		if($.cookie('left_li_'+i)=='show'){
			$('.left .bd ul li').eq(i).find(".sub").removeClass("hide");
			$('.left .bd ul li').eq(i).find('div').addClass('active');
		}
	}
});