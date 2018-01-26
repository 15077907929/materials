<?php /* Smarty version Smarty-3.1.6, created on 2018-01-17 16:31:48
         compiled from "../shop/Home/View/Cart/balance.html" */ ?>
<?php /*%%SmartyHeaderCode:3726325715a5efe22b921b5-93735766%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a259c672e76534bfcfed72012eebc63d52b95de7' => 
    array (
      0 => '../shop/Home/View/Cart/balance.html',
      1 => 1516177906,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3726325715a5efe22b921b5-93735766',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a5efe22c38b6',
  'variables' => 
  array (
    'user' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a5efe22c38b6')) {function content_5a5efe22c38b6($_smarty_tpl) {?><!doctype html>
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
<title>萌女郎</title>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="container">
	<div class="left">
		<div class="search">
			<h4>产品搜索</h4>
			<div class="input-group">  
				<input type="text" class="form-control"placeholder="关键字" / >  
				<span class="input-group-btn">  
					<button class="btn btn-info btn-search">查找</button>   
				</span>  
			</div>  
		</div>		

		<?php echo $_smarty_tpl->getSubTemplate ("Public/category.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		
		<div class="cart">
			<h4>购物车</h4>
			<div class="bd">
				<div class="product_num">
					购物车产品数： <?php echo cookie('total_num');?>

				</div>			
				<div class="total_price">
					总价： <?php echo cookie('total_price');?>
 $
				</div>			
				<div class="detail">
					<a href="index.php?m=Home&c=Cart&a=index">查看购物车</a>
				</div>
			</div>
		</div>	
	</div>
	<div class="main">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=Cart&a=balance">结账</a></h5>
		<form class="balance" name="balance" method="post" action="index.php?m=Home&c=Cart&a=balance">
			<table>
				<tr>
					<td width="80">用户名<font color="#f00">*</font>：</td>
					<td><?php echo cookie('username');?>
</td>
				</tr>
				<tr>
					<td>邮箱地址<font color="#f00">*</font>：</td>
					<td><input name="email" class="form-control" placeholder="请输入邮箱" type="email"></td>
				</tr>
				<tr>
					<td>国家<font color="#f00">*</font>：</td>
					<td><input name="country" class="form-control" placeholder="请输入国家" type="text"></td>
				</tr>		
				<tr>
					<td>姓名：</td>
					<td><input name="realname" value="<?php echo $_smarty_tpl->tpl_vars['user']->value['realname'];?>
" class="form-control" placeholder="请输入国家" type="text"></td>
				</tr>
				<tr>
					<td>电话：</td>
					<td><input name="tel" class="form-control" placeholder="请输入电话号码" type="text"></td>
				</tr><tr>
					<td>手机：</td>
					<td><input name="mobile" class="form-control" placeholder="请输入手机号码" type="text"></td>
				</tr>
				<tr>
					<td>邮政编码：</td>
					<td><input name="zip_code" class="form-control" placeholder="请输入邮政编码" type="text"></td>
				</tr>
				<tr>
					<td>性别：</td>
					<td>
						<input name="sex" type="radio" value="1" /> 男 &nbsp;
						<input name="sex" type="radio" value="2" /> 女
					</td>
				</tr>
				<tr>
					<td>地址：</td>
					<td><input name="address" class="form-control" placeholder="请输入地址" type="text"></td>
				</tr>
				<tr>
					<td>备注：</td>
					<td><textarea rows="5" name="note" class="form-control" ></textarea></td>
				</tr>
				<tr>
					<td></td>
					<td>
						<center><button type="submit" class="btn btn-default">提 交</button></center>	
					</td>
				</tr>
			</table>

		</form>
	</div>			
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>