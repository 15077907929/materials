<div class="left fl">
	<ul>
		<li>
			<h1><a onclick="ToogleMenu(this);" href="javascript:void(0);">网站栏目</a></h1>
			<dl>
				<dt><a href="{{url('admin/cate/create')}}" class="@if($cur_nav=='cate_add') active @endif">添加栏目</a></dt>
				<dt><a href="{{url('admin/cate')}}" class="@if($cur_nav=='cate_list') active @endif">栏目管理</a></dt>
			</dl>
		</li>
		<li>
			<h1><a onclick="ToogleMenu(this);" href="javascript:void(0);">产品管理</a></h1>
			<dl class="hide">
				<dt><a href="./goods_sort.html">产品分类</a></dt>
				<dt><a href="./goods_add.html">添加产品</a></dt>
				<dt><a href="./goods_list.html">产品列表</a></dt>
			</dl>
		</li>
		<li>
			<h1><a onclick="ToogleMenu(this);" href="javascript:void(0);">订单管理</a></h1>
			<dl class="hide">
				<dt><a href="./order_1.html">待处理订单</a></dt>
				<dt><a href="./order_2.html">处理中订单</a></dt>
				<dt><a href="./order_3.html">已发货订单</a></dt>
				<dt><a href="./order_4.html">已完成订单</a></dt>
			</dl>
		</li>
		<li>
			<h1><a onclick="ToogleMenu(this);" href="javascript:void(0);">会员管理</a></h1>
			<dl class="hide">
				<dt><a href="./mem_reg.html">注册设置</a></dt>
				<dt><a href="./mem_chk.html">审核设置</a></dt>
				<dt><a href="./mem_add.html">添加会员</a></dt>
				<dt><a href="./mem_list.html">会员管理</a></dt>
			</dl>
		</li>
		<li>
			<h1><a onclick="ToogleMenu(this);" href="javascript:void(0);">系统设置</a></h1>
			<dl class="hide">
				<dt><a href="./sys.html">网站设置</a></dt>
				<dt><a href="./admin.html">管理员设置</a></dt>
				<dt><a href="javascript:void(0)">模板设置</a></dt>
			</dl>
		</li>
		<li>
			<h1><a onclick="ToogleMenu(this);" href="javascript:void(0);">其它设置</a></h1>
			<dl class="hide">
				<dt><a href="javascript:void(0)">友情连接</a></dt>
				<dt><a href="javascript:void(0)">在线留言</a></dt>
				<dt><a href="javascript:void(0)">网站投票</a></dt>
				<dt><a href="javascript:void(0)">邮箱设置</a></dt>
				<dt><a href="javascript:void(0)">图片上传</a></dt>
			</dl>
		</li>
	</ul>
</div>