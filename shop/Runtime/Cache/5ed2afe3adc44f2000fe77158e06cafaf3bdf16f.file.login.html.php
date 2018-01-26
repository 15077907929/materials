<?php /* Smarty version Smarty-3.1.6, created on 2018-01-24 11:13:52
         compiled from "../shop/Admin/View/Login/login.html" */ ?>
<?php /*%%SmartyHeaderCode:9260230405a67e2d664fac0-27680837%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5ed2afe3adc44f2000fe77158e06cafaf3bdf16f' => 
    array (
      0 => '../shop/Admin/View/Login/login.html',
      1 => 1516763631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9260230405a67e2d664fac0-27680837',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a67e2d66a24a',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a67e2d66a24a')) {function content_5a67e2d66a24a($_smarty_tpl) {?><!doctype html>
<html>
<head>
<meta http-equiv='content-type' content='text/html;charset=utf-8' />
<meta name='description' content=''>
<meta name='keywords' content=''>
<link rel="stylesheet" type="text/css" href="/shop/Public/Common/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/shop/Public/Common/css/base.css">
<link rel="stylesheet" type="text/css" href="/shop/Public/Admin/css/admin.css">
<script type="text/javascript" src="/shop/Public/Common/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/shop/Public/Common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/base.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/function.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/server.js"></script>
<title>商城后台管理</title>
</head>
<body>
<div class="container">
	<div class="login">
		<h5 class="hd"><b>后台管理</b></h5>
		<form class="bd" method="post" name="login" action="index.php?m=Admin&c=Login&a=loginIn">
			<table>	
				<tr>
					<td class="t">用户名：</td>
					<td><input placeholder="账 号" class="form-control" type="text" name="username" value="" /></td>
				</tr>						
				<tr>
					<td class="t">密码：</td>
					<td><input placeholder="密 码" class="form-control" type="password" name="password" value="" /></td>
				</tr>						
				<tr>
					<td><input class="form-control" type="hidden" name="action" value="login" /></td>
					<td class="sub">
						<button type="button" onclick="user_login();"  class="btn btn-default">确 认</button>
						<button type="reset" class="btn btn-default">清 除</button>
					</td>
				</tr>
			</table>
		</form>
	</div>
</div>
</body>
</html>










<?php }} ?>