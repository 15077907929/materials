<?php
//会员控制器
namespace Home\Controller;
use Think\Controller;
class UserController extends CommonController {
	public function index(){
		$user=M('cart_users')->where('id='.cookie('userid'))->find();
		$this->assign('user',$user);
		$this->display();
	}
	
	public function reset_pwd(){
		$method=(I('get.method')=='')?'show':I('get.method');
		switch($method){
			case 'show':
			
			break;
			case 'ajax':
				$oldpass=I('post.oldpass');
				$user=M('cart_users')->field('id,username,password')->where('username=\''.cookie('username').'\' and password=\''.md5($oldpass).'\'')->find();
				if($user){
					$data['password']=md5(I('post.newpass'));
					if(M('cart_users')->where('username=\''.cookie('username').'\' and password=\''.md5($oldpass).'\'')->save($data)){
						$result_arr['msg']='修改密码成功!';
					}else{
						$result_arr['msg']='修改密码失败!';
					}
				}else{
					$result_arr['msg']='密码错误!';
				}
				echo json_encode($result_arr);
				exit;
			break;
		}
		$this->display();
	}
	
	public function orderlist(){
		$db=M('cart_order');
		$method=(I('get.method')=='')?'orderlist':I('get.method');
		switch($method){
			case 'orderlist':
				$result_arr=$db->select();
			break;
			case 'del':
				$id=I('get.id');
				$db->where('id='.$id)->delete();
				M('cart_order_product')->where('order_id='.$id)->delete();
				$this->redirect('index.php?m=Home&c=User&a=orderlist');
			break;			
			case 'order_detail':
				$result_arr['order']=M('cart_order_product')->where('order_id='.I('get.id'))->select();
				foreach($result_arr['order'] as $key=>&$val){
					$product=M('cart_product')->where('id='.$val['product_id'])->find();
					$val['name']=$product['name'];
					$val['price']=$product['price'];
					$val['prices']=$product['price']*$val['quantity'];
					$result_arr['total_price']+=$val['prices'];
					$result_arr['total_num']+=$val['quantity'];
				}
				$result_arr['user']=M('cart_users')->field('id,email,country,realname,tel,mobile,zip_code,sex,address,note')->where('id='.cookie('userid'))->find();
			break;			
		}
		
		// echo '<pre>';
		// print_r($result_arr);
		// echo '</pre>';
		$this->assign('result_arr',$result_arr);
		$this->display($method);		
	}
}