<?php /* Smarty version Smarty-3.1.6, created on 2018-01-26 15:46:29
         compiled from "../shop/Admin/View/Conf/config.html" */ ?>
<?php /*%%SmartyHeaderCode:2925941585a6ad90e7d07a1-70863966%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c84847a268b34cb9fa9d534ce8f69bb08a117f5' => 
    array (
      0 => '../shop/Admin/View/Conf/config.html',
      1 => 1516952784,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2925941585a6ad90e7d07a1-70863966',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a6ad90e84201',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a6ad90e84201')) {function content_5a6ad90e84201($_smarty_tpl) {?><!doctype html>
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
		<div class="config">
			<table class="stable">
				<tr>
					<td></td>
					<td></td>
				</tr>				
				<tr>
					<td><b>系统：</b></td>
					<td></td>
				</tr>				
				<tr>
					<td>网站地址：</td>
					<td><input placeholder="网站地址" class="form-control" name="" type="text" /></td>
				</tr>				
				<tr>
					<td>邮件地址：</td>
					<td><input placeholder="邮件地址" class="form-control" name="" type="text" /></td>
				</tr>				
				<tr>
					<td><b>编辑器：</b></td>
					<td></td>
				</tr>				
				<tr>
					<td>编辑器宽度：</td>
					<td><input placeholder="编辑器宽度" class="form-control" name="" type="text" /></td>
				</tr>				
				<tr>
					<td>编辑器高度：</td>
					<td><input placeholder="编辑器高度" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td><b>用户：</b></td>
					<td></td>
				</tr>				
				<tr>
					<td>用户小图片宽度：</td>
					<td><input placeholder="用户小图片宽度" class="form-control" name="" type="text" /></td>
				</tr>				
				<tr>
					<td>用户小图片高度：</td>
					<td><input placeholder="用户小图片高度" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td><b>菜单：</b></td>
					<td></td>
				</tr>				
				<tr>
					<td>菜单小图片宽度：</td>
					<td><input placeholder="菜单小图片宽度" class="form-control" name="" type="text" /></td>
				</tr>				
				<tr>
					<td>菜单小图片高度：</td>
					<td><input placeholder="菜单小图片高度" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td><b>产品：</b></td>
					<td></td>
				</tr>				
				<tr>
					<td>货币服务：</td>
					<td>
						<select class="form-control" name="">
							<option></option>
						</select>
					</td>
				</tr>				
				<tr>
					<td>产品图片宽度：</td>
					<td><input placeholder="产品图片宽度" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td>产品图片高度：</td>
					<td><input placeholder="产品图片高度" class="form-control" name="" type="text" /></td>
				</tr>		
				<tr>
					<td>产品小图片宽度：</td>
					<td><input placeholder="产品小图片宽度" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td>产品小图片高度：</td>
					<td><input placeholder="产品小图片高度" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td>翻页每页显示条数：</td>
					<td><input placeholder="翻页每页显示条数" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td>上传文件大小：</td>
					<td><input placeholder="上传文件大小" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td><b>模块：</b></td>
					<td></td>
				</tr>				
				<tr>
					<td>模块显示条数：</td>
					<td><input placeholder="模块显示条数" class="form-control" name="" type="text" /></td>
				</tr>
				<tr>
					<td></td>
					<td><button type="button" onclick="" class="btn btn-default">Submit</button></td>
				</tr>
			</table>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>