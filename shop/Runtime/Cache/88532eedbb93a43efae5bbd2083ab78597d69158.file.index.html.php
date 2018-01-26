<?php /* Smarty version Smarty-3.1.6, created on 2018-01-16 14:26:46
         compiled from "../shop/Home/View/Product/index.html" */ ?>
<?php /*%%SmartyHeaderCode:9002255585a5d54e655ec76-74045759%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '88532eedbb93a43efae5bbd2083ab78597d69158' => 
    array (
      0 => '../shop/Home/View/Product/index.html',
      1 => 1516084001,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9002255585a5d54e655ec76-74045759',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a5d54e65e6e5',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5d54e65e6e5')) {function content_5a5d54e65e6e5($_smarty_tpl) {?><!doctype html>
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
					购物车产品数 0
				</div>			
				<div class="total_price">
					总价 0 $
				</div>			
				<div class="detail">
					查看购物车
				</div>
			</div>
		</div>	
	</div>
	<div class="iproduct">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=Product&a=index">产品</a></h5>
		<div class="bd">
			<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<li>
						<div class="pic">
							<a href=""><img src="/shop/Public/Home/images/<?php echo $_smarty_tpl->tpl_vars['item']->value['picture'];?>
" /></a>
						</div>
						<div class="t">
							<a href=""><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
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