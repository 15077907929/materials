<?php /* Smarty version Smarty-3.1.6, created on 2018-01-23 15:10:46
         compiled from "../shop/Home/View/User/index.html" */ ?>
<?php /*%%SmartyHeaderCode:8958118695a668ffabe45e6-93450142%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a2644164d621fc572dbc41bdf66a6cbe5872a41' => 
    array (
      0 => '../shop/Home/View/User/index.html',
      1 => 1516691378,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8958118695a668ffabe45e6-93450142',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a668ffac4990',
  'variables' => 
  array (
    'user' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a668ffac4990')) {function content_5a668ffac4990($_smarty_tpl) {?><!doctype html>
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
	
	<?php echo $_smarty_tpl->getSubTemplate ("Public/user_nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
	<div class="main">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=User&a=index">我的资料</a></h5>
		<div class="user">
			<h5>我的资料</h5>
			<form class="form-horizontal" method="post" name="user">
				<table>				
					<tr>
						<td>用户名<font color="#f00">*</font>：</td>
						<td><?php echo $_smarty_tpl->tpl_vars['user']->value['username'];?>
</td>
					</tr>
					<tr>
						<td>邮箱地址<font color="#f00">*</font>：</td>
						<td><input value="<?php echo $_smarty_tpl->tpl_vars['user']->value['email'];?>
" class="form-control" placeholder="请输入邮箱" type="text" name="email" /></td>
					</tr>
					<tr>
						<td>出生日期<font color="#f00">*</font>：</td>
						<td></td>
					</tr>
					<tr>
						<td>国家<font color="#f00">*</font>：</td>
						<td><input value="<?php echo $_smarty_tpl->tpl_vars['user']->value['country'];?>
" class="form-control" placeholder="请输入国家" type="text" name="country" /></td>
					</tr>
					<tr>
						<td>姓名<font color="#f00">*</font>：</td>
						<td><input value="<?php echo $_smarty_tpl->tpl_vars['user']->value['realname'];?>
" class="form-control" placeholder="请输入姓名" type="text" name="realname" /></td>
					</tr>
					<tr>
						<td>电话<font color="#f00">*</font>：</td>
						<td><input value="<?php echo $_smarty_tpl->tpl_vars['user']->value['tel'];?>
" class="form-control" placeholder="请输入电话" type="text" name="tel" /></td>
					</tr>
					<tr>
						<td>手机<font color="#f00">*</font>：</td>
						<td><input value="<?php echo $_smarty_tpl->tpl_vars['user']->value['mobile'];?>
" class="form-control" placeholder="请输入邮箱" type="text" name="mobile" /></td>
					</tr>
					<tr>
						<td>性别：</td>
						<td>
							<input type="radio" name="sex" value="1" checked />男
							<input type="radio" name="sex" value="2" />女
						</td>
					</tr>
					<tr>
						<td>我的网站：</td>
						<td><input value="<?php echo $_smarty_tpl->tpl_vars['user']->value['website'];?>
" class="form-control" placeholder="请输入我的网站" type="text" name="website" /></td>
					</tr>
					<tr>
						<td>地址：</td>
						<td><input value="<?php echo $_smarty_tpl->tpl_vars['user']->value['address'];?>
" class="form-control" placeholder="请输入地址" type="text" name="address" /></td>
					</tr>
						<tr>
						<td>简介：</td>
						<td><textarea rows="6" class="form-control" name="note"><?php echo $_smarty_tpl->tpl_vars['user']->value['note'];?>
</textarea></td>
					</tr>
					<tr>
						<td>照片：</td>
						<td><input value="<?php echo $_smarty_tpl->tpl_vars['user']->value['phote'];?>
" type="file" name="photo" /></td>
					</tr>
					<tr>
						<td></td>
						<td style="text-align:center;"><button type="button" class="btn btn-default">提交</button></td>
					</tr>
				</table>
			</form>
		</div>		
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>