<?php /* Smarty version Smarty-3.1.6, created on 2018-01-25 11:42:07
         compiled from "../shop/Admin/View/Menu/index.html" */ ?>
<?php /*%%SmartyHeaderCode:301903035a69520f6860c3-70961791%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'aebb43af30f26f6e4b7bf21400f6b5dc5009d7b7' => 
    array (
      0 => '../shop/Admin/View/Menu/index.html',
      1 => 1516851725,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '301903035a69520f6860c3-70961791',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'common_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a69520f6d64e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a69520f6d64e')) {function content_5a69520f6d64e($_smarty_tpl) {?><!doctype html>
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
		<div class="mainNav">
			<ul class="clearfix">
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['common_arr']->value['sub_menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<li>
						<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
&menuid=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">
							<div class="pic"><img src="/shop/Public/Admin/images/default.gif" /></div>
							<?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>

						</a>
					</li>
				<?php } ?>			
			</ul>
		</div>
	</div>
</div>
</body>
</html>










<?php }} ?>