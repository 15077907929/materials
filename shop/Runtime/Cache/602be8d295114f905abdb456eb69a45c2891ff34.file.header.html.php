<?php /* Smarty version Smarty-3.1.6, created on 2018-01-24 14:43:15
         compiled from "../shop/Admin/View/Public/header.html" */ ?>
<?php /*%%SmartyHeaderCode:13256955575a6824fb984961-07491455%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '602be8d295114f905abdb456eb69a45c2891ff34' => 
    array (
      0 => '../shop/Admin/View/Public/header.html',
      1 => 1516776193,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13256955575a6824fb984961-07491455',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a6824fb999a8',
  'variables' => 
  array (
    'common_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a6824fb999a8')) {function content_5a6824fb999a8($_smarty_tpl) {?><div class="header">
	<div class="topNav">
		<ul class="clearfix">
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['common_arr']->value['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
				<li><a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
&menuid=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a></li>
			<?php } ?>	
		</ul>
	</div>
	<div class="location clearfix">
		<a href="index.php?m=Home&c=Index&a=index"><img src="/shop/Public/Admin/images/i_home.gif" /><br/>首页</a>
		<a href="index.php?m=Admin&c=Login&a=logout"><img src="/shop/Public/Admin/images/trash.gif" /><br/>登出</a>
		<span class="fr">用户：<?php echo cookie('username');?>
</span>
	</div>
</div><?php }} ?>