<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$field->name}} - blog</title>
<meta name="keywords" content="{{Config::get('web.keywords')}}" />
<meta name="description" content="{{Config::get('web.description')}}" />
<link href="{{asset('Home/css/templatemo_style.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Home/css/s3slider.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('Home/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('Home/js/s3Slider.js')}}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#slider').s3Slider({
            timeOut: 1600
        });
    });
</script>
</head>
<body>
<div id="templatemo_wrapper">

	@include('Home/Common/header')
	
	@include('Home/Common/left')
	
    <div id="templatemo_right_column">
        <div id="templatemo_main">
			@foreach($data as $key=>$val)
            <div class="post_section">
                <span class="comment"><a href="javascript:void(0);">{{$val->view}}</a></span>
                <h2><a href="{{url('art/'.$val->id)}}">{{$val->title}}</a></h2>
				{{date('F d, Y',$val->addtime)}} | <strong>Author:</strong> {{$val->editor}} | <strong>Category:</strong> 
				<a href="javascript:void(0);">{{$val->cate_name}}</a>
                <img style="max-width:420px;" src="{{asset($val->thumb)}}" alt="{{$val->title}}" />
                <div class="desc">{{$val->description}}</div>
              <a href="{{url('art/'.$val->id)}}">Continue reading...</a>
            </div>
			@endforeach
		</div>
		<div class="cleaner"></div>
	</div> 
	<div class="cleaner_h20"></div>
	
	@include('Home/Common/footer')
	
    <div class="cleaner"></div>
</div>
</body>
</html>