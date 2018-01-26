<?php
//	产品控制器
namespace Home\Controller;
use Think\Controller;
class ProductController extends CommonController {
    public function index(){
		$method=(I('get.method')=='')?'list':'show';
		switch($method){
			case 'list':
				$result_arr['Product']='active';
				$p=(I('get.p')=='')?1:I('get.p');	//当前页
				$count=M('cart_product')->count();	//总记录数		
				$result_arr['products']=M('cart_product')->field('id,category,name,market_price,price,picture')->page($p.',8')->select();
				$Page=new \Think\Page($count,8);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
				$result_arr['page']=$Page->show();	// 分页显示输出			
			end;
			case 'show':
				$result_arr['category']=M('cart_category')->field('id,pid,name')->where('id='.I('get.category'))->find();
				if($result_arr['category']['pid']){
					$result_arr['category']['parent']=M('cart_category')->field('id,name')->where('id='.$result_arr['category']['pid'])->find();
				}
				$result_arr['product']=M('cart_product')->field('id,name,price,market_price,picture,content')->where('id='.I('get.id'))->find();
			end;
		}
		$this->assign('result_arr',$result_arr);
		$this->display($method);
	}
	
	public function addCart(){	//添加购物车
		$cpc_sort=(cookie('cpc_sort')=='')?0:cookie('cpc_sort');
		$data=M('cart_product')->field('id,name,price')->where('id='.I('get.id'))->find();
		if($cpc_sort==0){
			$data['num']=1;
			cookie('cpc_0',$data);
			cookie('cpc_sort',1);			
		}
		$find=false;
		for($i=0;$i<$cpc_sort;$i++){
			if(cookie('cpc_'.$i)['id']==$data['id']){
				$data['num']=cookie('cpc_'.$i)['num']+1;
				cookie('cpc_'.$i,$data);
				$find=true;
			}
		}
		if(!$find){
			$data['num']=1;
			cookie('cpc_'.$cpc_sort,$data);
			cookie('cpc_sort',$cpc_sort+1);
		}
	}
	
	public function search(){
		$keyword=I('post.keyword');
		$p=(I('get.p')=='')?1:I('get.p');	//当前页
		$count=M('cart_product')->where('name like \'%'.$keyword.'%\'')->count();	//总记录数		
		$result_arr['search']=M('cart_product')->field('id,category,name,market_price,price,picture')->where('name like \'%'.$keyword.'%\'')->page($p.',8')->select();
		$Page=new \Think\Page($count,8);	// 实例化分页类 传入总记录数和每页显示的记录数(2)
		$result_arr['page']=$Page->show();	// 分页显示输出	
		$this->assign('result_arr',$result_arr);
		$this->display('search');		
	}
}