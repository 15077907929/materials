<?php /* Smarty version Smarty-3.1.6, created on 2018-01-23 15:47:52
         compiled from "../shop/Home/View/User/orderlist.html" */ ?>
<?php /*%%SmartyHeaderCode:20885524855a66e09f3d3b93-09914867%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b4680ab9077c1aeb8b80524b712d1d1afae372af' => 
    array (
      0 => '../shop/Home/View/User/orderlist.html',
      1 => 1516693669,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20885524855a66e09f3d3b93-09914867',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.6',
  'unifunc' => 'content_5a66e09f41557',
  'variables' => 
  array (
    'result_arr' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5a66e09f41557')) {function content_5a66e09f41557($_smarty_tpl) {?><!doctype html>
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
<script type="text/javascript" src="/shop/Public/Home/js/function.js"></script>
<script type="text/javascript" src="/shop/Public/Home/js/server.js"></script>
<title>萌女郎</title>
</head>
<body>

<?php echo $_smarty_tpl->getSubTemplate ("Public/header.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


<div class="container">

	<?php echo $_smarty_tpl->getSubTemplate ("Public/user_nav.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


	<div class="main">
		<h5 class="breadcrumb"><a href="index.php">首页</a>-<a href="index.php?m=Home&c=User&a=orderlist">产品订单</a></h5>
		<div class="orderlist">
			<table>		
				<tr>
					<th>订单日期</th>
					<th>订购用户</th>
					<th>处理日期</th>
					<th>处理用户</th>
					<th>状态</th>
					<th>操作</th>
				</tr>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['result_arr']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>	
					<tr>
						<td><?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['item']->value['order_time']);?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['order_people'];?>
</td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['item']->value['deal_time']!=0){?>
							<?php echo date('Y-m-d',$_smarty_tpl->tpl_vars['item']->value['deal_time']);?>

							<?php }?>
						</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['deal_people'];?>
</td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['item']->value['status']==1){?>
								处理中
							<?php }elseif($_smarty_tpl->tpl_vars['item']->value['status']==2){?>
								取消
							<?php }elseif($_smarty_tpl->tpl_vars['item']->value['status']==3){?>
								完成
							<?php }?>
						</td>
						<td>
							<a href="javascript:check_del('index.php?m=Home&c=User&a=orderlist&method=del&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
')">删除</a>
							<a href="index.php?m=Home&c=User&a=orderlist&method=order_detail&id=<?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
">浏览</a>
						</td>					
					</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</div>

<?php echo $_smarty_tpl->getSubTemplate ("Public/footer.html", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>


</body>
</html><?php }} ?>