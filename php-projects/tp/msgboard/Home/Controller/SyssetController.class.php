<?php
// 本类由系统自动生成，仅供测试用途
namespace Home\Controller;
use Think\Controller;
class SyssetController extends CommonController {
    public function index(){
		$res['pages']=['5','8','10','15','20','25'];
		$res['jgs']=['20','40','60','120','240','360'];
		$pageUrl='index.php?m=Home&c=Sysset&a=index';
		if($_POST){
			$res['ac']='gb_set';
			if(empty($_POST['ifauditing'])){
				$_POST['ifauditing']=0;
			}
			$conf='<?php return array('."\n";
			$conf .= '\'gb_name\' => \''.$_POST['gb_name'].'\','."\n";
			$conf .= '\'gb_logo\' => \''.$_POST['gb_logo'].'\','."\n";
			$conf .= '\'index_url\' => \''.$_POST['index_url'].'\','."\n";
			$conf .= '\'page\' => '.$_POST['pageT'].','."\n";
			$conf .= '\'timejg\' => \''.$_POST['timejgT'].'\','."\n";
			$conf .= '\'replyadmtit\' => \''.$_POST['replyadmtit'].'\','."\n";
			$conf .= '\'ifauditing\' => '.$_POST['ifauditing'].','."\n";
			$conf .= ');'."\n";
			// write the conf file
			$filenum = fopen(APP_PATH.'/Home/Conf/config.php','w');
			ftruncate($filenum, 0);
			fwrite($filenum, $conf);
			fclose($filenum);
			$res['msg']='设置已保存，请稍候……<br><a href="'.$pageUrl.'">如果浏览器没有自动返回，请点击此处返回</a>';
			$res['msg'].='<meta http-equiv="refresh" content="2; url='.$pageUrl.'">';			
		}
		$this->assign('res',$res);
		$this->display($method);
	}
	
	public function password(){
		$db=M('admin');
		if($_POST){
			$res['ac']='modify';
			$data['pwd']=md5($_POST['pwd']);
			if($db->where('pwd=\''.md5($_POST['opwd']).'\' and id=1')->save($data)){
				$res['msg']='修改成功，请稍候……<br><a href="'.$pageUrl.'">如果浏览器没有自动返回，请点击此处返回</a>';
				$res['msg'].='<meta http-equiv="refresh" content="2; url='.$pageUrl.'" />';
			}else{
				$res['msg']='操作失败！原始密码不正确，正在返回……<br><a href="'.$pageUrl.'">如果浏览器没有自动返回，请点击此处返回</a>';
				$res['msg'].='<meta http-equiv="refresh" content="2; url='.$pageUrl.'" />';
			}
		}
		$this->assign('res',$res);
		$this->display($method);	
	}
}