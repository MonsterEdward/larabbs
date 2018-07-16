@if (count($errors) > 0)
	<div class="alert alert-danger">
		<h4>Something wrong happeneds...</h4>
		<ul>
			@foreach ($errors->all() as $error)
				<li><i class="glyphicon glyphicon-remove">{{ $error }}</i></li>
			@endforeach
		</ul>
	</div>
@endif
