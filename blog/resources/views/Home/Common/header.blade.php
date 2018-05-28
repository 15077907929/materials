<div id="templatemo_menu">
	<ul>
		@foreach($navs as $key=>$val)
		<li><a href="{{url($val->url)}}" class="@if($val->id==$cur_id) current @endif">{{$val->name}}</a></li>
		@endforeach
	</ul>	
</div>