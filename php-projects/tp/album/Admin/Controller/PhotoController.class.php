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
                header('Location: index.php?m=Admin&c=Index&a=index&page='.$referpage.'&flag=1');
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
            header('Location: index.php?m=Admin&c=index&act=index&page='.$referpage.'&flag=3');
        }elseif($referfunc=='album'){
            header('Location: index.php?m=Admin&c=album&a=photos&album='.$album_id.'&page='.$referpage.'&flag=3');
        }
        exit;
	}
	
	public function gallery(){
		$db=M('imgs');
        if($_GET['album'] > 0){
            $title = M('albums')->where('id='.$_GET['album'])->find()['name'];
			$where='album='.$_GET['album'];
        }else{
            $title = '所有图片';
        }
        
        @ob_clean();
        echo '<?xml version="1.0" encoding="UTF-8"?>
<simpleviewergallery 
 title="'.$title.'"
 textColor="FFFFFF"
 frameColor="FFFFFF"
 thumbPosition="BOTTOM"
 galleryStyle="MODERN"
 thumbColumns="10"
 thumbRows="1"
 showOpenButton="TRUE"
 showFullscreenButton="TRUE"
 frameWidth="10"
 maxImageWidth="1280"
 maxImageHeight="1024"
 imagePath="data/"
 thumbPath="data/"
 useFlickr="false"
 flickrUserName=""
 flickrTags=""
 languageCode="AUTO"
 languageList="">'."\n";
        $pictures = $db->where($where)->select();
        if(is_array($pictures)){
            foreach($pictures as $v){
                echo '<image imageURL="Uploads/'.mkImgLink($v['dir'],$v['pickey'],$v['ext'],'big').'" thumbURL="Uploads/'.mkImgLink($v['dir'],$v['pickey'],$v['ext'],'square').'" linkURL="Uploads/'.mkImgLink($v['dir'],$v['pickey'],$v['ext'],'orig').'" linkTarget="">
        <caption><![CDATA['.$v['name'].']]></caption>	
    </image>'."\n";
            }
        }

        echo '</simpleviewergallery>';
	}
	
	public function view(){
		$db=M('imgs');
		$res['current_nav']='album';
		$res['info']=$db->where('id='.$_GET['id'])->find();
		 if(!$res['info']){
            showInfo('您要查看的图片不存在！',false);
        }
        include_once(LIB_PATH.'Org/image.class.php');
        $imgobj = new \Image();
        $res['imginfo'] = $imgobj->GetImageInfo(APP_PATH.'Uploads/'.mkImgLink($res['info']['dir'],$res['info']['pickey'],$res['info']['ext'],'orig'));
		$res['pre']=$db->where('album='.$_GET['album'].' and id<'.$_GET['id'])->order('id desc')->find();
		$res['next']=$db->where('album='.$_GET['album'].' and id>'.$_GET['id'])->order('id asc')->find();
		$this->assign('res',$res);
		$this->display();
	}
}