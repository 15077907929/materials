<?php /* Smarty version Smarty-3.1.6, created on 2018-01-24 15:30:24
         compiled from "../shop/Admin/View/Public/left.html" */ ?>
<?php /*%%SmartyHeaderCode:2124790895a68255143b8c1-30284856%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c96f4cd94b41876e6183826bf480a975f954da49' => 
    array (
      0 => '../shop/Admin/View/Public/left.html',
      1 => 1516779021,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2124790895a68255143b8c1-30284856',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a68255145e95',
  'variables' => 
  array (
    'common_arr' => 0,
    'item' => 0,
    'sub_item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a68255145e95')) {function content_5a68255145e95($_smarty_tpl) {?><div class="left fl">
		<div class="dtree">
			<div class="hd">
				<img src="/shop/Public/Home/images/base.gif" />Panel
			</div>
			<div class="bd">
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['common_arr']->value['menu']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<div class="dtreeNode">
						<a class="switch"><img src="/shop/Public/Home/images/plus.gif" /></a>
						<a class="folder"><img src="/shop/Public/Home/images/folder.gif" /></a>
						<a href="<?php echo $_smarty_tpl->tpl_vars['item']->value['url'];?>
&menuid=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['item']->value['name'];?>
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
								<a href="<?php echo $_smarty_tpl->tpl_vars['sub_item']->value['url'];?>
&menuid=<?php echo $_smarty_tpl->tpl_vars['sub_item']->value['id'];?>
"><?php echo $_smarty_tpl->tpl_vars['sub_item']->value['name'];?>
</a>
							</dt>
							<?php } ?>
						</dl>
					</div>
				<?php } ?>				
			</div>		
		</div>
	</div><?php }} ?>