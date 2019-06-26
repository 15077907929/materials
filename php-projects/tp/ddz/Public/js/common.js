//公用
function sound(object,name){
	document.getElementById(object).innerHTML = dd_code('[wmp]'+name+'[/wmp]');
}
function copy_url(){
	if(window.clipboardData.setData('text',document.location.href.replace('room_ddz','guest')))	//ie
		alert('复制成功！Ctrl + v 把地址发送给好友');
}