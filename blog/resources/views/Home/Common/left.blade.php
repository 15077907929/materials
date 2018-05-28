<div id="templatemo_left_column">
	<div id="templatemo_header">
		<div id="site_title">
			<h1><a href="">Clean <strong>Blog</strong><span>Free HTML-CSS Template</span></a></h1>
		</div>
	</div> 
	<div id="templatemo_sidebar">
		<div id="templatemo_rss">
			<a href="#">SUBSCRIBE NOW <br /><span>to our rss feed</span></a>
		</div>
		<h4>Categories</h4>
		<ul class="templatemo_list">
			<li><a href="">Curabitur sed</a></li>
			<li><a href="">Praesent adipiscing</a></li>
			<li><a href="">Duis sed justo</a></li>
			<li><a href="">Mauris vulputate</a></li>
			<li><a href="#">Nam auctor</a></li>
			<li><a href="#">Aliquam quam</a></li>
		</ul>
		<div class="cleaner_h40"></div>
		<h4>Friends</h4>
		<ul class="templatemo_list">
			@foreach($links as $key=>$val)
			<li><a href="{{url($val->url)}}">{{$val->name}}</a></li>
			@endforeach
		</ul>
	</div>
</div>