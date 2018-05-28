<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>主要内容区main</title>
<link href="{{asset('Admin/css/base.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Admin/css/style.css')}}" type="text/css" rel="stylesheet" />
<script type="text/javascript" src="{{asset('Common/js/jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Admin/js/check.js')}}"></script>
</head>
<body>
<div class="main">
	<div class="breadcrumbs">
		<div class="breadcrumb">
			您的位置：<a href="{{url('admin/article')}}">文章管理</a>&nbsp;&nbsp;>&nbsp;&nbsp;文章修改
		</div>
	</div>
    <form method="post" action="{{url('admin/article/'.$field->id)}}" name="article" onsubmit="return check_article();">{{csrf_field()}}
		<input type="hidden" name="_method" value="put" />
		<table class="ftab">
			<tr>
				<td align="right" class="bggray" width="8%">&nbsp;</td>
				<td align="left">
					<span class="back_msg">
						@foreach($errors->all() as $key=>$error)
							<font color="#f00">@if(count($errors->all())>1){{$key+1}}.@endif{{$error}}</font>&nbsp;&nbsp;&nbsp;
						@endforeach
					</span>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">分类：</td>
				<td align="left">
					<select name="cate_id">
						<option value="" > ** 顶级分类 ** </option>
						@foreach($rst['cate'] as $val) 
							<option 
								@if($field->cate_id==$val->id)
									selected 
								@endif							
							value="{{$val->id}}">{{$val->name}}</option>
							@foreach($val['sub'] as $v) 
								<option 
								@if($field->cate_id==$v->id)
									selected 
								@endif
								value="{{$v->id}}">|—{{$v->name}}</option>
							@endforeach
						@endforeach
					</select>
					<em class="require"> * </em>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">文章标题：</td>
				<td align="left">
					<input type="text" name="title" value="{{$field->title}}" />
					<em class="require"> * </em>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">编辑：</td>
				<td align="left">
					<input type="text" name="editor" value="{{$field->editor}}" />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">缩略图：</td>
				<td align="left">
					<input type="text" name="thumb" value="{{$field->thumb}}" />
					<input id="file_upload" name="file_upload" type="file" multiple="true" />
					<script src="{{asset('Common/org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
					<link rel="stylesheet" type="text/css" href="{{asset('Common/org/uploadify/uploadify.css')}}" />
					<script type="text/javascript">
						$(function() {
							$('#file_upload').uploadify({
								'buttonText': '图片上传',
								'formData'     : {
									'method' : 'modify',
									'thumb_o': '{{$field->thumb}}',
								},
								'swf'      : '{{asset("Common/org/uploadify/uploadify.swf")}}',
								'uploader' : '{{url("admin/upload")}}',
								'onUploadSuccess':function(file,data,response){
									$("input[name='thumb']").val(data);
									$('#thumbImg').html("<img height='48' src='"+data+"' />");
								}
							});
						});
					</script>
					<div id="thumbImg"><img src="{{$field->thumb}}" height="48" /></div>
				</td>
			</tr>						
			<tr>
				<td align="right" class="bggray">关键词：</td>
				<td align="left">
					<input type="text" name="tag" value="{{$field->tag}}" />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">描述：</td>
				<td align="left"><textarea name="description">{{$field->description}}</textarea></td>
			</tr>
			<tr>
				<td align="right" class="bggray">文章内容：</td>
				<td>
					<script type="text/javascript" src="{{asset('Common/org/ueditor/ueditor.config.js')}}"></script>
					<script type="text/javascript" src="{{asset('Common/org/ueditor/ueditor.all.min.js')}}"> </script>
					<script type="text/javascript" src="{{asset('Common/org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
					<script id="editor" name="content" type="text/plain" style="line-height:20px;width:860px;height:360px;">{!!$field->content!!}</script>
					<script type="text/javascript">
						var ue = UE.getEditor('editor');
					</script>
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">排序：</td>
				<td align="left">
					<input type="text" name="no_order" value="{{$field->no_order}}" />
				</td>
			</tr>
			<tr>
				<td align="right" class="bggray">&nbsp;</td>
				<td align="left">
					<input name="sub" type="submit" value="提交">
					<input name="res" type="reset" value="重置">
				</td>
			</tr>
		</table>
    </form>
</body>
</html>