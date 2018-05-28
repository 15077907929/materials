function showTr(){
	var type=$("input[name=field_type]:checked").val();
	if(type==3){
		$(".field_value").show();
	}else{
		$(".field_value").hide();
	}
}