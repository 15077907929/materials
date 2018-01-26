<?php /* Smarty version Smarty-3.1.6, created on 2018-01-16 13:56:32
         compiled from "../shop/Home/View/Public/category.html" */ ?>
<?php /*%%SmartyHeaderCode:16191846475a5d9410adf004-82082198%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fde6bd41b39ce8c4eb3569e94a697e6003670b30' => 
    array (
      0 => '../shop/Home/View/Public/category.html',
      1 => 1516082143,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16191846475a5d9410adf004-82082198',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'common_arr' => 0,
    'item' => 0,
    'sub_item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a5d9410aff20',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5d9410aff20')) {function content_5a5d9410aff20($_smarty_tpl) {?><div class="category">
	<h4>产品分类</h4>
	<div class="dtree">
		<div class="hd">
			<img src="/shop/Public/Home/images/base.gif" />
		</div>
		<div class="bd">
			<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['common_arr']->value['cart_category']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
				<div class="dtreeNode">
					<a class="switch"><img src="/shop/Public/Home/images/plus.gif" /></a>
					<a class="folder"><img src="/shop/Public/Home/images/folder.gif" /></a>
					<a href=""><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
</a>
					<dl class="sub myHide">
						<?php  $_smarty_tpl->tpl_vars['sub_item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['sub_item']->_loop = false;
 $_smarty_tpl->tpl_vars['sub_key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value['sub']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['sub_item']->key => $_smarty_tpl->tpl_vars['sub_item']->value){
$_smarty_tpl->tpl_vars['sub_item']->_loop = true;
 $_smarty_tpl->tpl_vars['sub_key']->value = $_smarty_tpl->tpl_vars['sub_item']->key;
?>
						<dt>
							<img src="/shop/Public/Home/images/line.gif" />
							<img src="/shop/Public/Home/images/join.gif" />
							<img src="/shop/Public/Home/images/page.gif" />
							<a href=""><?php echo $_smarty_tpl->tpl_vars['sub_item']->value['name'];?>
</a>
						</dt>
						<?php } ?>
					</dl>
				</div>
			<?php } ?>				
		</div>
	</div>
</div><?php }} ?>