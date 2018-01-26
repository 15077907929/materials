<?php /* Smarty version Smarty-3.1.6, created on 2018-01-23 10:25:20
         compiled from "../shop/Home/View/User/reset.html" */ ?>
<?php /*%%SmartyHeaderCode:16765819275a66982d407c09-47416297%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '67b26eaf0aab6fada88124cda14f11df10f052d8' => 
    array (
      0 => '../shop/Home/View/User/reset.html',
      1 => 1516674316,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16765819275a66982d407c09-47416297',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a66982d475df',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a66982d475df')) {function content_5a66982d475df($_smarty_tpl) {?><!doctype html>
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
<script type="text/javascript" src="/shop/Public/Home/js/function.js"></script>
<script type="text/javascript" src="/shop/Public/Home/js/server.js"></script>
<title>萌女郎</title>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="container">
	<div class="left user_nav">
		<ul>
			<li><a href="index.php?m=Home&c=User&a=index">我的资料</a></li>
			<li><a href="index.php?m=Home&c=User&a=reset_pwd">修改密码</a></li>
			<li><a href="index.php?m=Home&c=User&a=index">退出</a></li>
			<li><a href="index.php?m=Home&c=User&a=index">产品订单</a></li>
		</ul>
	</div>
	<div class="main">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=User&a=reset_pwd">修改密码</a></h5>
		<div class="user">
			<h5>修改密码</h5>
			<form class="form-horizontal" method="post" name="user" onsubmit="return reset_pwd();">
				<table>		
					<tr>
						<td>旧密码<font color="#f00">*</font>：</td>
						<td><input value="" class="form-control" type="password" name="oldpass" /></td>
					</tr>
					<tr>
						<td>新密码<font color="#f00">*</font>：</td>
						<td><input value="" class="form-control" type="password" name="newpass" /></td>
					</tr>
					<tr>
						<td>重新输入密码<font color="#f00">*</font>：</td>
						<td><input value="" class="form-control" type="password" name="newpass2" /></td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:center;"><button type="submit" class="btn btn-default">提交</button></td>
					</tr>
				</table>
			</form>
		</div>		
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>