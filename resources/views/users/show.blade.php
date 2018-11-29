@extends('layouts.app')

@section('title', $user->name . '\'User Center')

@section('content')

<div class="row">
	<div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
		<div class="panel panel-default">
			<div class="panel-body">
				<div class="media">
					<div align="center">
						{{-- <img class="thumbnail img-responsive" src="https://lihuang.monsteredward.com/wp-content/uploads/2018/06/6739ba046017babed5850373266eaa52ab450cc041fea-zfHSvS_fw658.jpg" width="300px" height="300px"> --}}
						<img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="300px" height="300px">
					</div>

					<div class="media-body">
						<hr>
						<h4><strong>brief introduction</strong></h4>
						{{-- <p>If the dream is big enough, the fact don't count</p> --}}
						<p>{{ $user->introduction }}</p>
						<hr>
						<h4><strong>resgited in</strong></h4>
						{{-- <p>July 4th, 2018</p> --}}
						<p>{{ $user->created_at->diffForHumans() }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="col-lg-9 col-md-9 col-sm-2 col-xs-12">
		<div class="panel panel-default">
			<div class="panel-body">
				<span>
					<h1 class="panel-title pull-left" style="font-size:30px;">{{ $user->name }} <small>{{ $user->email }}</small></h1>
				</span>
			</div>
		</div>
		<hr>

		{{-- 用户发布内容 --}}
		<div class="panel panel-default">
			<div class="panel-body">
				{{-- Nothing... --}}	
				<ul class="nav nav-tabs">
					<li class="active"><a href="###">Ta 的话题</a></li>
					<li><a href="###">Ta 的回复</a></li>
				</ul>
				@include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])	
			</div>
		</div>

	</div>
</div>
@endsection
