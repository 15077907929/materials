<?php /* Smarty version Smarty-3.1.6, created on 2018-01-22 09:26:46
         compiled from "../shop/Home/View/Public/search.html" */ ?>
<?php /*%%SmartyHeaderCode:9232759675a653dd6442eb1-55900766%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f7b1fb5f2dbda80c1cb3c673995a0de1789e913e' => 
    array (
      0 => '../shop/Home/View/Public/search.html',
      1 => 1516584351,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9232759675a653dd6442eb1-55900766',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a653dd644b80',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a653dd644b80')) {function content_5a653dd644b80($_smarty_tpl) {?><form class="search" name="search" method="post" action="index.php?m=Home&c=Product&a=search">
	<h4>产品搜索</h4>
	<div class="input-group">  
		<input type="text" class="form-control" name="keyword" placeholder="关键字" / >  
		<span class="input-group-btn">  
			<button type="submit" class="btn btn-info btn-search">查找</button>   
		</span>  
	</div>  
</form>	<?php }} ?>