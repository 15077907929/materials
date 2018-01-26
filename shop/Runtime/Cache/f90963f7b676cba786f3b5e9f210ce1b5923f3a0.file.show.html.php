<?php /* Smarty version Smarty-3.1.6, created on 2018-01-22 09:28:23
         compiled from "../shop/Home/View/Product/show.html" */ ?>
<?php /*%%SmartyHeaderCode:18690671575a5da6ec948314-32850511%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f90963f7b676cba786f3b5e9f210ce1b5923f3a0' => 
    array (
      0 => '../shop/Home/View/Product/show.html',
      1 => 1516584502,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18690671575a5da6ec948314-32850511',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a5da6ec9b72a',
  'variables' => 
  array (
    'result_arr' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5da6ec9b72a')) {function content_5a5da6ec9b72a($_smarty_tpl) {?><!doctype html>
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
<script type="text/javascript" src="/shop/Public/Home/js/server.js"></script>
<title>萌女郎</title>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="container">
	<div class="left">
		
		<?php echo $_smarty_tpl->getSubTemplate ("Public/search.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
		

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
		<h5 class="breadcrumb">
			<a href="index.php">首页</a> -
			<?php if ($_smarty_tpl->tpl_vars['result_arr']->value['category']['parent']){?>
			<a href="index.php?m=Home&c=Product&a=index&category=<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['category']['parent']['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['category']['parent']['name'];?>
</a> -
			<?php }?>
			<a href="index.php?m=Home&c=Product&a=index&pid=<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['category']['pid'];?>
category=<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['category']['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['category']['name'];?>
</a>
		</h5>
		<div class="bd">
			<table width="100%">
				<tr>
					<td width="210"><img src="/shop/Public/Home/images/<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['product']['picture'];?>
" width="210" /></td>
					<td class="para">
						<p><b>产品分类：</b><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['category']['name'];?>
</p>
						<p><b>产品名称：</b><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['product']['name'];?>
</p>
						<p><b>市场价格：</b><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['product']['market_price'];?>
</p>
						<p><b>当前价格：</b><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['product']['price'];?>
</p>
						<p class="addcart"><button type="button" class="btn btn-default" onclick="addCart(<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['product']['id'];?>
)">添加到购物车</button></p>
					</td>
				</tr>
			</table>
			<div class="content"><?php echo $_smarty_tpl->tpl_vars['result_arr']->value['product']['content'];?>
</div>
		</div>
	</div>			
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>