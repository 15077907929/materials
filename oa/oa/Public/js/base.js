//头部菜单
$(document).ready(function(){
	$('.header_nav ul li').each(function(){
		$(this).mouseover(function(){
			$(this).find('.sub_nav').removeClass('hide');
		});		
		$(this).mouseout(function(){
			$(this).find('.sub_nav').addClass('hide');
		});
	});
});

$(document).ready(function(){
	$('.header_nav ul li dt').each(function(){
		$(this).mouseover(function(){
			$(this).find('.third_nav').removeClass('hide');
		});		
		$(this).mouseout(function(){
			$(this).find('.third_nav').addClass('hide');
		});
	});
});

//教务管理
$(document).ready(function(){
	$('.lists .l_hd ul li:nth-child(1)').addClass('on');
	$('.lists .l_hd ul li').mouseover(function(){
		$('.lists .l_hd ul li').removeClass('on');
		$(this).addClass('on');
		var cur=$(this).index()+1;
		$('.lists .l_bd ul li').css('display','none');
		$('.lists .l_bd ul li:nth-child('+cur+')').css('display','block');
	});
});