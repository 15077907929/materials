<?php /* Smarty version Smarty-3.1.6, created on 2018-01-22 14:06:09
         compiled from "../shop/Home/View/Public/header.html" */ ?>
<?php /*%%SmartyHeaderCode:8936154865a5d5422e265d2-07358034%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dc27f71db6efc2954fa317237dc856205de24a18' => 
    array (
      0 => '../shop/Home/View/Public/header.html',
      1 => 1516601166,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8936154865a5d5422e265d2-07358034',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a5d5422e3422',
  'variables' => 
  array (
    'result_arr' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5d5422e3422')) {function content_5a5d5422e3422($_smarty_tpl) {?><div class="header">
	<div class="container">
		<div class="top">
			<?php if (cookie('username')==''){?>
				<a href="index.php?m=Home&c=Login&a=register">注册</a> | <a href="index.php?m=Home&c=Login&a=login">登录</a>
			<?php }else{ ?>
				欢迎: <?php echo cookie('username');?>
 | 
				<a href="index.php?m=Home&c=User&a=index">用户空间 | 
				<a href="index.php?m=Home&c=Login&a=logout">退出</a>
			<?php }?>
		</div>
		<h1 class="logo"><a href="index.php"><img src="/shop/Public/Home/images/logo.gif" /></a></h1>
		<nav class="navbar navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<a class="navbar-brand" href="index.php">首页</a>
				</div>
				<ul class="nav navbar-nav">
					<li class="<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['Product'];?>
"><a href="index.php?m=Home&c=Product&a=index">产品</a></li>
					<li class="<?php echo $_smarty_tpl->tpl_vars['result_arr']->value['Cart'];?>
"><a href="index.php?m=Home&c=Cart&a=index">购物车</a></li>
				</ul>
			</div>
		</nav>
	</div>
</div><?php }} ?>