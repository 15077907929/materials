<?php /* Smarty version Smarty-3.1.6, created on 2018-01-26 16:44:47
         compiled from "../shop/Admin/View/Database/backup.html" */ ?>
<?php /*%%SmartyHeaderCode:14214437355a6ae9030649b0-15604243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27fc8e484c0814046ae3be573a4d515c2b1e08ea' => 
    array (
      0 => '../shop/Admin/View/Database/backup.html',
      1 => 1516956285,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14214437355a6ae9030649b0-15604243',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a6ae9030da31',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a6ae9030da31')) {function content_5a6ae9030da31($_smarty_tpl) {?><!doctype html>
<html>
<head>
<meta http-equiv='content-type' content='text/html;charset=utf-8' />
<meta name='description' content=''>
<meta name='keywords' content=''>
<link rel="stylesheet" type="text/css" href="/shop/Public/Common/css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="/shop/Public/Common/css/base.css" />
<link rel="stylesheet" type="text/css" href="/shop/Public/Admin/css/admin.css" />
<script type="text/javascript" src="/shop/Public/Common/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="/shop/Public/Common/js/jquery.cookie.js"></script>
<script type="text/javascript" src="/shop/Public/Common/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/base.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/function.js"></script>
<script type="text/javascript" src="/shop/Public/Admin/js/server.js"></script>
<title>商城后台管理</title>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="main_container clearfix">
	
	<?php echo $_smarty_tpl->getSubTemplate ("Public/left.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	
	<div class="main fr">
		<div class="backup">
			<table class="stable">
				<tr>
					<td>提示</td>
					<td></td>
				</tr>				
				<tr>
					<td colspan="2">
						服务器备份目录为backup<br/>
						对于较大的数据表，强烈建议使用分卷备份<br/>
						只有选择备份到服务器，才能使用分卷备份功能<br/>				
					</td>
				</tr>				
				<tr>
					<td colspan="2">数据备份</td>
				</tr>				
				<tr>
					<td colspan="2">备份方式</td>
				</tr>				
				<tr>
					<td><input type="radio" /> 备份全部数据</td>
					<td>备份全部数据表中的数据到一个备份文件</td>
				</tr>				
				<tr>
					<td>
						<input type="radio" /> 备份单张表数据
						<select name="" class="form-control">
							<option value="">请选择</option>
						</select>
					</td>
					<td>备份选中数据表中的数据到单独的备份文件</td>
				</tr>	
				<tr>
					<td colspan="2">选择目标位置</td>
				</tr>				
				<tr>
					<td colspan="2"><input type="radio" /> 备份到服务器</td>
				</tr>				
				<tr>
					<td colspan="2"><input type="radio" /> 备份到本地</td>
				</tr>	
				<tr>
					<td></td>
					<td><button type="button" onclick="" class="btn btn-default">备份</button></td>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>