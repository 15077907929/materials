<?php /* Smarty version Smarty-3.1.6, created on 2018-01-23 15:10:23
         compiled from "../shop/Home/View/Public/user_nav.html" */ ?>
<?php /*%%SmartyHeaderCode:10531613185a66dfb4d99276-79608427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '68709912425efe294702845ca6299523ff000676' => 
    array (
      0 => '../shop/Home/View/Public/user_nav.html',
      1 => 1516691421,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10531613185a66dfb4d99276-79608427',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a66dfb4da26c',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a66dfb4da26c')) {function content_5a66dfb4da26c($_smarty_tpl) {?><div class="left user_nav">
	<ul>
		<li><a href="index.php?m=Home&c=User&a=index">我的资料</a></li>
		<li><a href="index.php?m=Home&c=User&a=reset_pwd">修改密码</a></li>
		<li><a href="index.php?m=Home&c=Login&a=logout">退出</a></li>
		<li><a href="index.php?m=Home&c=User&a=orderlist">产品订单</a></li>
	</ul>
</div><?php }} ?>