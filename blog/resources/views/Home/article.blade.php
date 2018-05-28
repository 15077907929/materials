<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>blog</title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="{{asset('Home/css/templatemo_style.css')}}" rel="stylesheet" type="text/css" />
</head>
<body>
<div id="templatemo_wrapper">

	@include('Home/Common/header')
	
	@include('Home/Common/left')
	
    <div id="templatemo_right_column">
		<div id="templatemo_main">
        <h2>About Us</h2>
            <p align="justify">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent aliquam velit a magna sodales quis elementum ipsum auctor. Ut at metus leo, et dictum sem</p>
            <div class="cleaner_h30"></div>
            <div class="service_box">
                <h4>Lorem ipsum dolor sit amet</h4>
                <div class="left">
                    <a href="#"><img src="{{asset('Home/images/chart1.png')}}" alt="chart 1" /></a>               
				</div>
			<div class="right">
				<p align="justify">Curabitur ullamcorper neque et justo aliquet at pretium orci  scelerisque. Mauris sodales tristique dignissim. Phasellus ut augue  nibh. <a href="#">Aliquam vel libero</a> sit amet mauris posuere ullamcorper  sollicitudin ac eros. Vestibulum auctor euismod mi et tincidunt. </p>
			</div>
                <div class="cleaner"></div>
                	<ol>
                        <li>Fusce fringilla, dui sed blandit luctus, arcu augue pellentesque</li>
                  		<li>Sed fermentum arcu in enim euismod quis lobortis </li>
                        <li>Class aptent taciti sociosqu ad litora torquent </li>
                        <li>Praesent libero nisi, pellentesque in sagittis ac</li>
                        <li>Nunc eget erat urna. <a href="#">Sed ac ante lacus</a>, eu scelerisque urna</li>
					</ol>
                <div class="cleaner"></div>
            </div>
            <div class="service_box">
				<h4>Morbi sed nulla ac est cursus suscipit</h4>
                <div class="left">
					<a href="#"><img src="{{asset('Home/images/chart2.png')}}" alt="chart 2" /></a>             
				</div>
          		<div class="right">
                    <p align="justify">Phasellus diam orci, rhoncus sed condimentum et, sodales vel leo. Nunc  dignissim quam a nisi placerat gravida. Suspendisse potenti. <a href="#">Curabitur  suscipit lacus</a> vestibulum mi accumsan bibendum. Vivamus gravida, dui  eget tincidunt rutrum, ante justo malesuada lacus.</p>
				</div>
                <div class="cleaner"></div>
				<ol>
					<li>Praesent libero nisi, pellentesque in sagittis ac</li>
					<li>Nunc eget erat urna. Sed ac ante lacus, eu scelerisque urna</li>                
					<li>Fusce fringilla, dui sed blandit luctus, <a href="#">arcu augue pellentesque</a></li>
				  <li>Sed fermentum arcu in enim euismod quis lobortis </li>
					<li>Class aptent taciti sociosqu ad litora torquent </li>
				</ol>
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