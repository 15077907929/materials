<?php /* Smarty version Smarty-3.1.6, created on 2018-01-22 09:30:45
         compiled from "../shop/Home/View/Login/login.html" */ ?>
<?php /*%%SmartyHeaderCode:10124873075a5ee46605c0f0-05797681%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9f10b7ad3c8ce044e1ea55d865e2c8f34a938591' => 
    array (
      0 => '../shop/Home/View/Login/login.html',
      1 => 1516584618,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10124873075a5ee46605c0f0-05797681',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a5ee4660d12b',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5ee4660d12b')) {function content_5a5ee4660d12b($_smarty_tpl) {?><!doctype html>
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
	<div class="main">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=Login&a=login">登录</a></h5>
		<div class="login">
			<h5>用户登录</h5>
			<form class="form-horizontal" method="post" name="login">
				<table>
					<tr>
						<td height="45">用户名：</td>
						<td><input class="form-control" placeholder="请输入用户名" type="text" name="username" /></td>
					</tr>
					<tr>
						<td>密码：</td>
						<td><input class="form-control" placeholder="请输入密码" type="password" name="password" /></td>
					</tr>
					<tr>
						<td colspan="2" height="45"><button onclick="user_login()" type="button" class="btn btn-default">登录</button></td>
					</tr>
					<tr>
						<td colspan="2"><a href="">忘记密码?</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="">注册!</a></td>
					</tr>
				</table>
			</form>
		</div>		
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>