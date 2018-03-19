function create_key(tel){
	$(".msg").html( "正在处理...");
	$("form[name='get_key'] input[type='button']").attr("disabled", true);
	$.ajax({
		url: "index.php?m=Home&c=Login&a=get_key",
		data: "action=create&tel="+tel,
		success: function (json) {
			var json = JSON.parse(json); // 解析成json对象
			if(json.status == 1){	//口令获取成功，跳转登录页面
				alert(json.msg);
				location.href='index.php?m=Home&c=Login&a=login';
			}else if(json.status == -2){
				alert(json.msg);
			}else{
				alert(json.msg);
			}
		},error: function (e, o) {
			alert("网络错误");
		},complete: function () {
			$(".msg").html("");
			$("form[name='get_key'] input[type='button']").removeAttr("disabled");
		}
	});
}

function get_s(){	// 获取倒计时秒数
    $.ajax({
        url: 'index.php?m=Home&c=Index&a=index&method=get_s',
        success: function (json) {
			var json = JSON.parse(json); // 解析成json对象
            if( json.status == 1){
                update_time(json.s);
            }else{
                $('.msg').html('-_-! 开始本地倒计时');
                update_time(40*60);
            }
        }, error: function (e, o) {
            $('.msg').html(' 网络错误，开始本地倒计时 ');
            update_time(40*60);
        }, complete: function () {  }
    });
}

function score_submit(){
    $('#message').html(' 正在提交，请稍候......');
    $.ajax({
        url: 'index.php?m=Home&c=Index&a=index&method=save_archive&sub=1',
        type: 'post',
        success: function (json) {
			var json = JSON.parse(json); // 解析成json对象
            if( json.status === 1){
                alert('提交成功，结束！');
                location.href='index.php?m=Home&c=Login&a=logout';
            }else{
                alert(json.msg);
                $('#message').html(json.msg);
            }
        }, error: function (e, o) {
            $('#message').html(' 网络错误，请再点一下答案重试 ');
            is_submit = false;
            console.log(e);
            console.log(o);
        }, complete: function () {}
    });
}