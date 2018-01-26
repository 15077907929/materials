<?php /* Smarty version Smarty-3.1.6, created on 2018-01-22 17:05:14
         compiled from "../shop/Home/View/Index/index.html" */ ?>
<?php /*%%SmartyHeaderCode:8466917585a5c6aba83d2a7-04579890%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c67c75aca59a6ea456b595c56778ab732f0493f7' => 
    array (
      0 => '../shop/Home/View/Index/index.html',
      1 => 1516611909,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8466917585a5c6aba83d2a7-04579890',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a5c6aba8eca5',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5c6aba8eca5')) {function content_5a5c6aba8eca5($_smarty_tpl) {?><!doctype html>
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

		
	</div>
	<div class="product">
		<h4>产品</h4>
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
	</div>
	<div class="right">
		<?php if (cookie('username')==''){?>
			<div class="login">
				<h4>用户登录</h4>
				<form class="form-horizontal" name="login">
					<table>
						<tr>
							<td height="45">用户名：</td>
							<td><input name="username" type="text" class="form-control" placeholder="请输入用户名"></td>
						</tr>
						<tr>
							<td>密码：</td>
							<td><input name="password" type="password" class="form-control" placeholder="请输入密码"></td>
						</tr>
					</table>
					<button type="button" onclick="user_login()" class="btn btn-default">登录</button><br/>
					<span>
						<a href="index.php?m=Home&c=Login&a=forget">忘记密码?</a>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="index.php?m=Home&c=Login&a=register">注册!</a>
					</span>
				</form>
			</div>	
		<?php }?>
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
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>