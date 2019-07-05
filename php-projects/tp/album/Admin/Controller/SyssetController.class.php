<?php
// 本类由系统自动生成，仅供测试用途
namespace Admin\Controller;
use Think\Controller;
class SyssetController extends CommonController {
	public function index(){
		if($_POST){
            $st = $_POST['st'];
            foreach($st as $k=>$v){
                $st[$k] = trim($v);
            }
             if(empty($st['url'])){
                showInfo('网站url不能为空！',false);
            }
            if(isset($st['open_pre_resize'])){
                $st['open_pre_resize'] = 'true';
            }else{
                $st['open_pre_resize'] = 'false';
            }
            if(isset($st['demand_resize'])){
                $st['demand_resize'] = 'true';
            }else{
                $st['demand_resize'] = 'false';
            }
            if(isset($st['open_photo'])){
                $st['open_photo'] = 'true';
            }else{
                $st['open_photo'] = 'false';
            }
            if(isset($st['access_ctl'])){
                $st['access_ctl'] = 'true';
            }else{
                $st['access_ctl'] = 'false';
            }
            
            if(empty($st['resize_img_width']) || !is_numeric($st['resize_img_width'])){
                showInfo('图片宽只能为数字！',false);
            }
            if(empty($st['resize_img_height']) || !is_numeric($st['resize_img_height'])){
                showInfo('图片高只能为数字！',false);
            }
            if($st['resize_quality']<0 || $st['resize_quality']>100){
                showInfo('图片质量只能在0-100之间！',false);
            }
            if(empty($st['size_allow']) || !is_numeric($st['size_allow'])){
                showInfo('普通上传允许的图片大小只能为数字！',false);
            }
            if(empty($st['pageset']) || !is_numeric($st['pageset'])){
                showInfo('分页设置只能为数字！',false);
            }
            if(empty($st['gallery_limit']) || !is_numeric($st['gallery_limit'])){
                showInfo('幻灯片图片限制只能为数字！',false);
            }

            if(isset($st['open_watermark']) && empty($st['watermark_path'])){
                showInfo('请输入水印图片的路径！',false);
            }

            if(isset($st['open_watermark'])){
                $st['open_watermark'] = 'true';
            }else{
                $st['open_watermark'] = 'false';
            }

            if(save_setting($st)){
                showInfo('修改配置成功！',true,'index.php?m=Admin&c=Sysset&a=index');
            }else{
                showInfo('写入配置失败,请检查Conf/config_album.php文件是否可写！',false);
            }
        }else{
			$res['current_nav']='setting';
			$res['setting_nav']='index';
			$this->assign('res',$res);
			$this->display();
		}
	}
	
	public function operator(){
		$db=M('admin');
		$method = I('get.method') ? I('get.method') : 'show';
		$res['current_nav']='setting';
		$res['setting_nav']='operator';
		switch ($method) {
            case 'show':
				$res['total_num']      = $db->count();// 查询满足要求的总记录数
				$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
				$res['show']       = $Page->show();// 分页显示输出
				// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
				$res['operators'] = $db->limit($Page->firstRow.','.$Page->listRows)->select();
			break;
			case 'add':
				if($_POST){
					$data['username'] = trim($_POST['username']);
					$data['userpass'] = $_POST['userpass'];
					$data['create_time']=time();
					$new_pass_again = $_POST['passagain'];
					if(empty($data['username'])){
						showInfo('管理员名不能为空！',false);
					}
					if(empty($data['userpass'])){
						showInfo('密码不能为空！',false);
					}
					if($data['userpass'] != $new_pass_again){
						showInfo('两次密码输入不一致！',false);
					}
					$data['userpass']=md5($data['userpass']);
					if($db->add($data)){
						showInfo('管理员添加成功！',true,'index.php?m=Admin&c=Sysset&a=operator');
					}else{
						showInfo('管理员添加失败！',false);
					}
				}
			break;
			case 'edit':
				$res['info']=$db->where('id='.$_GET['id'])->find();
				if($_POST){
					if($_POST['id'] == cookie('user')['id']){
						showInfo('修改自己的密码请到修改密码选项卡中修改！',false);
					}
					$data['userpass'] = $_POST['userpass'];
					$new_pass_again = $_POST['passagain'];
					if(empty($_POST['userpass'])){
						showInfo('新密码不能为空！',false);
					}
					if($data['userpass'] != $new_pass_again){
						showInfo('两次密码输入不一致！',false);
					}
					$data['userpass']=md5($data['userpass']);
					if($db->where('id='.$_POST['id'])->save($data)){
						showInfo('管理员密码修改成功！',true,'index.php?m=Admin&c=Sysset&a=operator');
					}else{
						showInfo('管理员密码修改失败！',false);
					}
				}
			break;
			case 'del':
				if($_GET['id'] == cookie('user')['id']){
					showInfo('对不起，您不能删除你自己！',false);
				}
				if($db->where('id='.$_GET['id'])->delete()){
					showInfo('密码管理员删除成功！',true,'index.php?m=Admin&c=Sysset&a=operator');
				}else{
					showInfo('密码管理员删除失败！',false);
				}
			break;
		}
		$this->assign('res',$res);
		$this->display('operator_'.$method);		
	}
	
	public function password(){
		$db=M('admin');
		$res['current_nav']='setting';
		$res['setting_nav']='password';
		if($_POST){
			$oldpass=cookie('user')['userpass'];
            $post_oldpass = $_POST['oldpass'];
            $new_pass = $_POST['newpass'];
            $new_pass_again = $_POST['passagain'];
            if(md5($post_oldpass) != $oldpass){
                showInfo('旧密码输入错误！',false);
            }
            if(empty($new_pass)){
                showInfo('新密码不能为空！',false);
            }
            if($new_pass != $new_pass_again){
                showInfo('两次密码输入不一致！',false);
            }
            $data['userpass'] = md5($new_pass);
            if($db->where('id='.cookie('user')['id'])->save($data)){
				$user=$db->where('id='.cookie('user')['id'])->find();
                cookie('user',$user);
                showInfo('密码修改成功！',true,'index.php?m=Admin&c=Sysset&a=password');
            }else{
                showInfo('密码修改失败！',false);
            }
		}
		$this->assign('res',$res);
		$this->display();		
	}
	
	public function task(){
		$res['current_nav']='setting';
		$res['setting_nav']='task';
		$db=M('imgs');
		$res['total_num']      = $db->where('status=3')->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($res['total_num'],15);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$res['show']       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$res['tasks'] = $db->where('status=3')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('res',$res);
		$this->display();	
	}
}