$(document).ready(function () {
    //ajax通过cp分组获取包名下拉列表
    $('select[name="cp"]').change(function () {
        var cp = $(this).children('option:selected').val();
        $.ajax({
            url: 'index.php?m=Home&c=Task&a=gidSelectAjax&cp=' + cp + '&type=2',
            type: 'get',
            success: function (data) {
                $('.gid_ajax').html(data);
                addlisten();
            }
        });
    });


    $('input[name="get_package_name"]').click(function () {
        var package_name_arr = $('select[name="package_name"]').children('option:selected').val().split("##");
        var game_name = package_name_arr[1];
        $('input[name="game_name"]').val(game_name);
    });
});


function addlisten() {
    //ajax通过cp分组获取包名下拉列表
    $('select[name="package_name"]').change(function () {
        var cp = $(this).children('option:selected').val();
        if (cp != '') {
            var package_name_arr = cp.split("##");
            var game_name = package_name_arr[1];
            $('input[name="game_name"]').val(game_name);
        }
    });
}

$(document).ready(function (){
	$('.score_type1').prop("checked","checked");
	$('.score_type1').click(function(){
		$('.score_rate').removeClass('hide');
		$('.country').addClass('hide');		
	});
	$('.score_type2').click(function(){
		$('.score_rate').addClass('hide');
		$('.country').removeClass('hide');
	});
});

function check_submit() {
    var game_name = $('input[name="game_name"]').val();
    var package_name_arr = $('select[name="package_name"]').children('option:selected').val().split("##");
    var game_name;
    if (package_name_arr == "") {
        alert("包名不能为空!");
        return false;
    }
    if (game_name == "") {
        alert("游戏名称不能为空!");
        $('input[name="game_name"]').focus();
        return false;
    } else {
        if (game_name != package_name_arr[1]) {
            alert("游戏名称和包名不匹配,请重新选择!");
            return false;
        }
    }
    return true;
}
