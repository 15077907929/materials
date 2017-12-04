<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $this->ftpl_var['school_name'];?>--<?php echo $this->ftpl_var['sitetitle'];?></title>
<meta name="keywords" content="<?php echo $this->ftpl_var['keywords'];?>" />
<meta name="description" content="<?php echo $this->ftpl_var['description'];?>" />
<link type="text/css" rel="stylesheet" href="templates/<?php echo $this->ftpl_var['style'];?>/css/base.css" />
<link type="text/css" rel="stylesheet" href="templates/<?php echo $this->ftpl_var['style'];?>/css/style.css" />
<script type="text/javascript" src="templates/<?php echo $this->ftpl_var['style'];?>/js/jquery-3.2.1.min.js"></script>
<script type="text/javascript" src="templates/<?php echo $this->ftpl_var['style'];?>/js/admin.js"></script>
</head>
<body>
<div class="login_mask"></div>
<form onsubmit="return check(login_form);" name="login_form" action="index.php?filename=login&action=login" method="post" class="login_form">
	<div class="hd">
		<p>
			<?php echo $this->ftpl_var['school_name'];?>--<?php echo $this->ftpl_var['sitetitle'];?>
			<span class="slideup"></span>
			<span class="close"></span>
		</p>
		<div class="pic"><img src="templates/<?php echo $this->ftpl_var['style'];?>/images/systemBanner.jpg" /></div>
	</div>
	<div class="bd">
		<div class="tit">
			<ul class="clearfix">
				<li class="on"><a href="">用户登录</a></li>
				<li><a href="">关于本系统</a></li>
			</ul>
		</div>
		<div class="info">
			<ul>
				<li>
					<table>
						<tr>
							<td>账号：</td>
							<td>
								<p class="username">
									<input type="text" name="username" value="" />
									<span class="must hide"></span>
									<span class="notes hide">该输入项为必选项</span>
								</p>
							</td>
						</tr>	
						<tr>
							<td>密码：</td>
							<td>
								<p class="password">
									<input type="password" name="password" value="" />
									<span class="must hide"></span>
									<span class="notes hide">该输入项为必选项</span>
								</p>
							</td>
						</tr>	
						<tr>
							<td>验证码：</td>
							<td>
								<p class="chknumber">
									<input type="text" name="chknumber" value="" />
									<span class="must hide"></span>
									<span class="notes hide">该输入项为必选项</span>
									<img class="fr" src="chknumber.php" />
								</p>
							</td>
						</tr>	
						<tr>
							<td>有效期：</td>
							<td>
								<p class="cookietime">
									<select name="cookietime">
										<option value="">浏览器进程</option>
										<option value="">一周</option>
										<option value="">一星期</option>
									</select>
								</p>
							</td>
						</tr>	
						<tr>
							<td></td>
							<td class="notes">请输入已经通过审核的用户名与密码进行登陆！---[<a href="">点击注册</a>]</td>
						</tr>
					</table>
				</li>
				<li class="hide">
					<div class=""><?php echo $this->ftpl_var['school_name'];?>--<?php echo $this->ftpl_var['sitetitle'];?> 技术支持</div>
				</li>
			</ul>
		</div>
		<div class="sub"><input type="submit" value="登录" /></div>
	</div>
</form>
</body>
</html>














