<?php
//	购物车控制器
namespace Home\Controller;
use Think\Controller;
class CartController extends CommonController {
    public function index(){
		$result_arr['Cart']='active';
		$method=(I('get.method')=='')?'list':I('get.method');
		switch($method){
			case 'del':
				cookie('cpc_'.I('get.sort_num'),null);
			end;
			case 'edit':
				foreach($_POST as $key=>$val){
					$update_arr=array(
						'sort_num'=>$key,
						'id'=>cookie('cpc_'.$key)['id'],
						'name'=>cookie('cpc_'.$key)['name'],
						'price'=>cookie('cpc_'.$key)['price'],
						'num'=>$val,
						'prices'=>cookie('cpc_'.$key)['price']*$val,
					);
					cookie('cpc_'.$key,$update_arr);
				}
			end;
		}
		$cpc_sort=cookie('cpc_sort');
		for($i=0;$i<$cpc_sort;$i++){
			if(cookie('cpc_'.$i)){
				$result_arr['data'][]=array(
					'sort_num'=>$i,
					'id'=>cookie('cpc_'.$i)['id'],
					'name'=>cookie('cpc_'.$i)['name'],
					'price'=>cookie('cpc_'.$i)['price'],
					'num'=>cookie('cpc_'.$i)['num'],
					'prices'=>cookie('cpc_'.$i)['price']*cookie('cpc_'.$i)['num'],
				);
				$result_arr['total_num']+=cookie('cpc_'.$i)['num'];
			}
		}
		foreach($result_arr['data'] as $key=>$val){
			$result_arr['total_price']+=$val['prices'];
		}
		cookie('total_num',$result_arr['total_num']);
		cookie('total_price',$result_arr['total_price']);
		$this->assign('result_arr',$result_arr);
		$this->display();
	}
	
	public function balance(){
		if(!cookie('username')){
			$this->redirect('Login/login');
		}
		$method=(I('get.method')=='')?'show':I('get.method');
		switch($method){
			case 'show':
				$result_arr['user']=M('cart_users')->field('id,email,country,realname,tel,mobile,zip_code,sex,address,note')->where('id='.cookie('userid'))->find();
			break;
			case 'save':
				//保存用户信息
				$data['email']=$_POST['email'];
				$data['country']=$_POST['country'];
				$data['realname']=$_POST['realname'];
				$data['tel']=$_POST['tel'];
				$data['mobile']=$_POST['mobile'];
				$data['zip_code']=$_POST['zip_code'];
				$data['sex']=$_POST['sex'];
				$data['address']=$_POST['address'];
				$data['note']=$_POST['note'];
				M('cart_users')->where('id='.cookie('userid'))->save($data);	
				//保存订单信息
				$o_id=M('cart_order')->field('id')->order('id desc')->limit(1)->find();	
				if(empty($o_id)){	
					$order_id=1;
				}else{
					$order_id=$o_id['id']+1;
				}
				$order['id']=$order_id;
				$order['order_time']=time();
				$order['order_people']=cookie('username');
				$order['status']=1;
				M('cart_order')->add($order);
				cookie('order_id',$order_id);
				//保存订单所对应的产品
				$cpc_sort=cookie('cpc_sort');
				for($i=0;$i<$cpc_sort;$i++){
					if(cookie('cpc_'.$i)){
						$info['order_id']=$order_id;
						$info['product_id']=cookie('cpc_'.$i)['id'];
						$info['quantity']=cookie('cpc_'.$i)['num'];
						M('cart_order_product')->add($info);
						cookie('cpc_'.$i,null);
					}
				}
				cookie('cpc_sort',null);
				cookie('total_num',0);
				cookie('total_price',0);
				$this->redirect('index.php?m=Home&c=Cart&a=balance&method=info');
			break;
			case 'info':
				$result_arr['order']=M('cart_order_product')->where('order_id='.cookie('order_id'))->select();
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