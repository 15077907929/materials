<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class PhotoController extends CommonController {
	public function resize(){
		$db=M('imgs');
		$album = intval($_GET['album']);
        set_time_limit(0);
        ignore_user_abort(true);
		
        if(!C('demand_resize')){
            $tmppics = $db->where('status=3')->select();
            if($tmppics){
                foreach($tmppics as $v){
                    generatepic($v['dir'],$v['pickey'],$v['ext']);
					$v['status']=1;
                    $db->where('id='.$v['id'])->save($v);
                }
            }
        }
        echo 'alert("图片处理完成！");window.location.href="index.php?m=Admin&c=Album&a=photos&album='.$album.'";';
	}
}