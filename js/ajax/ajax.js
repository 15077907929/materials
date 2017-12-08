function ajax_get_pre_keyword(){
	var package_name = $("select[name='package_name']").val();
	var package = package_name.split('##');
	var country = $("select[name='store_country']").val();	
	var country_arr = country.split('#');
	
	
	if(package_name == ''){
		alert('请选择应用！');
		return false;	
	}
	
	if(country == ''){
		alert('请选择国家！');
		return false;	
	}
	
	$('#get_pre_keyword').attr('disabled',true);
	
	$.ajax({
		url: 'index.php?m=Pickup&c=Ajax&a=getPreKeyword&package_name=' + package[2] + '&country=' + country_arr[0],
		type: 'get',
		beforeSend:beforeSend, //发送请求 
		success: function (json) {
			$(".load_div").css({'display':'none'});
			var json = JSON.parse(json); // 解析成json对象
			if(json.status == 1){
				$("textarea[name='pre_keyword']").val(json.keywords)
				alert(json.info);
			}else{
				alert(json.info);	
			}
			
			$('#get_keyword').attr('disabled',false);
		}
	});
}
