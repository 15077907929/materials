<?php /* Smarty version Smarty-3.1.6, created on 2018-01-22 09:29:17
         compiled from "../shop/Home/View/Cart/index.html" */ ?>
<?php /*%%SmartyHeaderCode:7510096345a5d9a03e2eb44-11013783%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c176111c7ecd8341e0840ad2aba26531f1e630b3' => 
    array (
      0 => '../shop/Home/View/Cart/index.html',
      1 => 1516584555,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7510096345a5d9a03e2eb44-11013783',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a5d9a03e936d',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5d9a03e936d')) {function content_5a5d9a03e936d($_smarty_tpl) {?><!doctype html>
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
<script type="text/javascript" src="/shop/Public/Home/js/function.js"></script>
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
	<div class="icart">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=Cart&a=index">购物车</a></h5>
		<form class="bd" name="cart" method="post" action="index.php?m=Home&c=Cart&a=index&method=edit">
			<table>
				<tr>
					<th>产品名称</th>
					<th>数量</th>
					<th>价格</th>
					<th>总价格</th>
					<th></th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>	
					<tr>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</td>
						<td width="72"><input name="<?php echo $_smarty_tpl->tpl_vars['item']->value['sort_num'];?>
" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['item']->value['num'];?>
" type="text" /></td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['price'];?>
 $</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['prices'];?>
 $</td>
						<td><a href="index.php?m=Home&c=Cart&a=index&method=del&sort_num=<?php echo $_smarty_tpl->tpl_vars['item']->value['sort_num'];?>
">删除</a></td>					
					</tr>
				<?php } ?>
			</table>
			<div class="total">
				<span class="num">产品数量：<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['total_num'];?>
 , </span>
				<span class="price">总价：<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['total_price'];?>
 $ </span>
			</div>
			<center>
				<button type="submit" class="btn btn-default">修 改</button>
				<button type="button" onclick="check_balance()" class="btn btn-default">结 算</button>			
			</center>
		</form>
	</div>			
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>