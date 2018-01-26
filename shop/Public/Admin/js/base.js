//产品分类导航树
$(document).ready(function(){
	$('.dtree .switch').each(function(){
		$(this).click(function(){
			var index=$(this).parent().index();
			if($(this).parent().find('.sub').attr('class')=='sub myHide'){
				$(this).parent().find('.sub').removeClass('myHide');
				var plus=$(this).html();
				$(this).html(plus.replace('plus','minus'));
				var fold=$(this).next().html();
				$(this).next().html(fold.replace('folder.gif','folderopen.gif'));
				$.cookie('left_li_'+index, 'show', { expires: 7, path: '/' }); 
			}else{
				$(this).parent().find('.sub').addClass('myHide');
				var plus=$(this).html();
				$(this).html(plus.replace('minus','plus'));
				var fold=$(this).next().html();
				$(this).next().html(fold.replace('folderopen.gif','folder.gif'));	
				$.cookie('left_li_'+index, 'hide', { expires: 7, path: '/' }); 				
			}
		});
		var num=$(this).parent().find('.sub dt').length-1;
		var join=$(this).parent().find('.sub dt').eq(num).html();
		$(this).parent().find('.sub dt').eq(num).html(join.replace('join','joinbottom'));
	});
	var num=$('.dtree .dtreeNode').length-1;
	var plus=$('.dtree .dtreeNode').eq(num).find('.switch').html();
	$('.dtree .dtreeNode').eq(num).find('.switch').html(plus.replace('plus','plusbottom'));
	var line=$('.dtree .dtreeNode').eq(num).find('dl').html();
	var reg = new RegExp("line","g");	//g,表示全部替换。
	$('.dtree .dtreeNode').eq(num).find('dl').html(line.replace(reg,'empty'));
	var len=$(".dtreeNode").length;
	for(var i=0;i<len;i++){
		if($.cookie('left_li_'+i)=='show'){
			$('.dtreeNode').eq(i).find(".sub").removeClass("myHide");
		}
	}
});