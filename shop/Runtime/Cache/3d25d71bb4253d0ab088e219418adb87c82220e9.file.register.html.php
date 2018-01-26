<?php /* Smarty version Smarty-3.1.6, created on 2018-01-22 16:53:25
         compiled from "../shop/Home/View/Login/register.html" */ ?>
<?php /*%%SmartyHeaderCode:11047693685a657fc069d820-40147383%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3d25d71bb4253d0ab088e219418adb87c82220e9' => 
    array (
      0 => '../shop/Home/View/Login/register.html',
      1 => 1516611202,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11047693685a657fc069d820-40147383',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a657fc06ee3f',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a657fc06ee3f')) {function content_5a657fc06ee3f($_smarty_tpl) {?><!doctype html>
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
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=Login&a=register">注册</a></h5>
		<div class="register">
			<h5>用户注册</h5>
			<form class="form-horizontal" method="post" name="register">
				<table>
					<tr>
						<td>验证码<font color="#f00">*</font>：</td>
						<td>
							<input class="form-control" placeholder="请输入验证码" type="text" name="code" />
							<img src="index.php?m=Home&c=Login&a=code" />
						</td>
					</tr>					
					<tr>
						<td>用户名<font color="#f00">*</font>：</td>
						<td><input class="form-control" placeholder="请输入用户名" type="text" name="username" /></td>
					</tr>
					<tr>
						<td>密码<font color="#f00">*</font>：</td>
						<td><input class="form-control" placeholder="请输入密码" type="password" name="password" /></td>
					</tr>
					<tr>
						<td>重新输入密码<font color="#f00">*</font>：</td>
						<td><input class="form-control" placeholder="请输入确认密码" type="password" name="password2" /></td>
					</tr>
					<tr>
						<td>邮箱地址<font color="#f00">*</font>：</td>
						<td><input class="form-control" placeholder="请输入邮箱" type="text" name="email" /></td>
					</tr>
					<tr>
						<td>性别：</td>
						<td>
							<input type="radio" name="sex" value="1" checked />男
							<input type="radio" name="sex" value="2" />女
						</td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:center;"><button onclick="user_register()" type="button" class="btn btn-default">注册</button></td>
					</tr>
				</table>
			</form>
		</div>		
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>