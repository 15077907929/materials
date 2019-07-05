<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
use Admin\Model\AlbumsModel;
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
	
	public function bat(){
		$db=M('imgs');
		$action = $_POST['do_action'];
        $pics = $_POST['picture'];
        $referfunc = $_GET['referf'];
        $referpage = $_GET['referp'];
        $album_id = $_GET['album'];
        if(!is_array($pics)){
            if($referfunc=='default'){
                header('Location: index.php?act=all&page='.$referpage.'&flag=1');
            }elseif($referfunc=='album'){
                header('Location: index.php?m=Admin&c=Album&a=photos&album='.$album_id.'&page='.$referpage.'&flag=1');
            }
            exit;
        }
        if($action == 'delete'){
            foreach($pics as $v){
                $find = $db->where('id='.$v)->find();
                if($find){
                    delpicfile($find['dir'],$find['pickey'],$find['ext']);
                    AlbumsModel::remove_cover($v);
                    $db->where('id='.$v)->delete();
                }
            }
        }elseif($action == 'move'){
            $album = intval($_POST['albums']);
            if(!$album || $album == '-1'){
                 header('Location: index.php?m=Admin&c=Album&a=photos&album='.$album_id.'&page='.$referpage.'&flag=2');
                 exit;
            }
            
            foreach($pics as $v){
                $find = $db->where('id='.$v)->find();
                if($find){
                    AlbumsModel::remove_cover($v);
                    AlbumsModel::update_pic($v,$find['name'],$album);
                }
            }
        }
        if($referfunc=='default'){
            header('Location: index.php?act=all&page='.$referpage.'&flag=3');
        }elseif($referfunc=='album'){
            header('Location: index.php?m=Admin&c=album&a=photos&album='.$album_id.'&page='.$referpage.'&flag=3');
        }
        exit;
	}
}