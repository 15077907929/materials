<?php /* Smarty version Smarty-3.1.6, created on 2018-01-24 09:33:18
         compiled from "../shop/Admin/View/Login/index.html" */ ?>
<?php /*%%SmartyHeaderCode:6402920085a67e25eb737b8-55418603%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '18e10babac461ad6891b4f4487f5519aca9f0bea' => 
    array (
      0 => '../shop/Admin/View/Login/index.html',
      1 => 1516757577,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6402920085a67e25eb737b8-55418603',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a67e25ece370',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a67e25ece370')) {function content_5a67e25ece370($_smarty_tpl) {?><!doctype html>
<html>
<head>
<meta http-equiv='content-type' content='text/html;charset=utf-8' />
<meta name='description' content=''>
<meta name='keywords' content=''>
<link type="text/css" href="Public/css/bootstrap.min.css" rel="stylesheet">
<link rel='stylesheet' type='text/css' href='Public/css/base.css' />
<link rel='stylesheet' type='text/css' href='Public/css/admin.css' />
<script type="text/javascript" src="Public/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="Public/js/admin.js"></script>
<title>网站后台管理系统后台登录</title>
</head>
<body style="background:#00b4ef;">
<div class="container">
	<div class="login">
		<div class="hd"> 网站后台管理系统</div>
		<form class="bd" method="post" name="login" onsubmit="return check_login();" action="index.php?m=Admin&c=Login&a=loginIn">
			<p>管理员登录</p>
			<table>	
				<tr>
					<td class="t">管理员账号：</td>
					<td><input placeholder="账 号" class="form-control" type="text" name="username" value="" /></td>
				</tr>						
				<tr>
					<td class="t">管理员密码：</td>
					<td><input placeholder="密 码" class="form-control" type="password" name="password" value="" /></td>
				</tr>						
				<tr>
					<td class="t">输入验证码：</td>
					<td>
						<input class="form-control chknumber" type="text" name="chknumber" value="" />
						<img src="index.php?m=Admin&c=Login&a=chknumber" />
					</td>
				</tr>
				<tr>
					<td><input class="form-control" type="hidden" name="action" value="login" /></td>
					<td class="sub">
						<a href="">忘记密码？</a>
						<button type="submit" class="btn btn-default">确 认</button>
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