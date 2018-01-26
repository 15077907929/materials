<?php /* Smarty version Smarty-3.1.6, created on 2018-01-22 09:23:56
         compiled from "../shop/Home/View/Product/search.html" */ ?>
<?php /*%%SmartyHeaderCode:4584765835a653d018bbd58-68606006%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5555e6b248c603b2d4847b46c519b863212de7ab' => 
    array (
      0 => '../shop/Home/View/Product/search.html',
      1 => 1516584233,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4584765835a653d018bbd58-68606006',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a653d01928f1',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a653d01928f1')) {function content_5a653d01928f1($_smarty_tpl) {?><!doctype html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=utf-8">
<meta name="description" content="">
<meta name="keywords" content="">
<link type="text/css" href="/shop/Public/Common/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="/shop/Public/Common/css/base.css">
<link rel="stylesheet" type="text/css" href="/shop/Public/Home/css/home.css">
<script type="text/javascript" src="/shop/Public/Common/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/shop/Public/Common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/shop/Public/Home/js/base.js"></script>
<title>萌女郎</title>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="container">
	<div class="left">
		<div class="search">
			<h4>产品搜索</h4>
			<div class="input-group">  
				<input type="text" class="form-control"placeholder="关键字" / >  
				<span class="input-group-btn">  
					<button class="btn btn-info btn-search">查找</button>   
				</span>  
			</div>  
		</div>		

		<?php echo $_smarty_tpl->getSubTemplate ("Public/category.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		
		<div class="cart">
			<h4>购物车</h4>
			<div class="bd">
				<div class="product_num">
					购物车产品数： <?php echo cookie('total_num');?>

				</div>			
				<div class="total_price">
					总价： <?php echo cookie('total_price');?>
 $
				</div>			
				<div class="detail">
					<a href="index.php?m=Home&c=Cart&a=index">查看购物车</a>
				</div>
			</div>
		</div>	
	</div>
	<div class="iproduct">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=Product&a=search">产品搜索</a></h5>
		<div class="bd">
			<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['search']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<li>
						<div class="pic">
							<a href="index.php?m=Home&c=Product&a=index&method=show&category=<?php echo $_smarty_tpl->tpl_vars['item']->value['category'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><img src="/shop/Public/Home/images/s<?php echo $_smarty_tpl->tpl_vars['item']->value['picture'];?>
" /></a>
						</div>
						<div class="t">
							<a href="index.php?m=Home&c=Product&a=index&method=show&category=<?php echo $_smarty_tpl->tpl_vars['item']->value['category'];?>
&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
						</div>
						<div class="del">
							<del><?php echo $_smarty_tpl->tpl_vars['item']->value['market_price'];?>
 $</del>
						</div>
						<div class="price"><?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
 $</div>			
					</li>	
				<?php } ?>
			</ul>
		</div>
		<div class="page"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['page'];?>
</div>
	</div>			
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>