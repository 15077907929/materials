//验证数字
function check_num(num){
	var reg=/^[0-9]*$/;
	if(!reg.test(num)){
		return false;
	}else{
		return true;
	}	
}