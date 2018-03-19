function update_time(s){
    setTimeout(function(){
        var f = Math.floor(s/60);
        var m = s%60;
        $('#timed').html('  倒计时 ' +f+ ':'+m +' &nbsp; &nbsp; ');
        if( s === 0){
            score_submit();
        }else {
            update_time(--s);
        }
    }, 1000);
}

function set_score(n, v){
	ans['v'+n] = n+v;
    if(n >= total){
        score_submit();
    }else{
        if( n%3===0) save_archive();    // 每答三题存个档
        view_qs(n + 1);
    }
}

function check_del(url){  
	var mymessage=confirm("确认要删除该条记录吗？");  
	if(mymessage==true){  
		location.href=url;
	} 
}  