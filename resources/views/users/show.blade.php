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

						<hr>
						<h4><strong>最后活跃</strong></h4>
						<p title="{{  $user->last_actived_at }}">{{ $user->last_actived_at->diffForHumans() }}</p>
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
                    <li class="{{ active_class(if_query('tab', null)) }}">
                        <a href="{{ route('users.show', $user->id) }}">Ta 的话题</a>
                    </li>
                    <li class="{{ active_class(if_query('tab', 'replies')) }}">
                        <a href="{{ route('users.show', [$user->id, 'tab' => 'replies']) }}">Ta 的回复</a>
                    </li>
                </ul>
				{{-- recent() 方法在数据模型基类 app/Models/Model.php 中定义，并且使用了 本地作用域 的方式进行定义，我们的 Reply 模型，就如代码生成器所生成的数据模型一样，统一继承了此类方法： https://laravel-china.org/docs/laravel/5.5/eloquent/1332#local-scopes --}}
                @if (if_query('tab', 'replies'))
                    @include('users._replies', ['replies' => $user->replies()->with('topic')->recent()->paginate(5)])
                @else
                    @include('users._topics', ['topics' => $user->topics()->recent()->paginate(5)])
                @endif
			</div>
		</div>

	</div>
</div>
@endsection
