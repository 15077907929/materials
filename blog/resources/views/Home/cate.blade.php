<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{$field->name}} - blog</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="{{asset('Home/css/templatemo_style.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('Home/css/style.css')}}" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="{{asset('Home/js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('Home/js/piroBox.1_2.js')}}"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$().piroBox({
			my_speed: 600, //animation speed
			bg_alpha: 0.5, //background opacity
			radius: 4, //caption rounded corner
			scrollImage : false, // true == image follows the page, false == image remains in the same open position
			pirobox_next : 'piro_next', // Nav buttons -> piro_next == inside piroBox , piro_next_out == outside piroBox
			pirobox_prev : 'piro_prev',// Nav buttons -> piro_prev == inside piroBox , piro_prev_out == outside piroBox
			close_all : '.piro_close',// add class .piro_overlay(with comma)if you want overlay click close piroBox
			slideShow : 'slideshow', // just delete slideshow between '' if you don't want it.
			slideSpeed : 4 //slideshow duration in seconds(3 to 6 Recommended)
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
            <h2>二级分类</h2>
            <div id="gallery">
                <ul>
					@foreach($sub_cate as $key=>$val)
                    <li>
                        <div class="left">
                            <a href="{{asset('Home/images/gallery/image_06_b.jpg')}}" class="pirobox" title="{{$val->title}}">
								<img src="{{asset($val->thumb)}}" alt="{{$val->title}}" />
							</a>
                        </div>
                        <div class="right">
                            <h5>{{$val->name}}</h5>
                            <p>{{$val->title}}</p>
                            <div class="button"><a href="{{url('arts/'.$val->id)}}">浏览文章</a></div>
                        </div>
                        <div class="cleaner"></div>
                    </li>
					@endforeach
                </ul>
            </div>
        </div> 
        <div class="cleaner"></div>
    </div>  
  	<div class="cleaner_h20"></div>
	
	@include('Home/Common/footer')
	
    <div class="cleaner"></div>
</div> 
</body>
</html>