<?php
//后台公用函数
function get_nav($nav){	
	switch($nav){
		case '0':
			$nav='<font color="#999999">不显示</font>';
		break;							
		case '1':
			$nav='<font color="#990000">头部主导航条</font>';
		break;						
		case '2':
			$nav='尾部导航条';
		break;						
		case '3':
			$nav='<font color="blue">都显示</font>';
		break;	
	}	
	return $nav;
}

function get_module($module){
	switch($module){
		case '0':
			$module='<font color="#f00">外部模块</font>';
		break;							
		case '1':
			$module='简介模块';
		break;						
		case '2':
			$module='文章模块';
		break;						
		case '3':
			$module='产品模块';
		break;						
		case '4':
			$module='下载模块';
		break;						
		case '5':
			$module='图片模块';
		break;						
		case '6':
			$module='招聘模块';
		break;
		case '7':
			$module='留言模块';
		break;
	}	
	return $module;
}
?>