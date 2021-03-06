<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">
			{{-- Coolapsed Hamburger --}}
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
				<span class="sr-only">Toggle Navigation</span>
				<span calss="icon-bar"></span>
				<span calss="icon-bar"></span>
				<span calss="icon-bar"></span>
			</button>

			{{-- Branding Image --}}
			<a class="navbar-brand" href="{{ url('/') }}">laraBBS</a>
		</div>

		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			{{-- Left Side of Navbar --}}
			<ul class="nav navbar-nav">
				<li  class="{{ active_class(if_route('topics.index')) }}"><a href="{{ route('topics.index') }}">话题</a></li>
				<li class="{{ active_class(if_route('categories.show') && if_route_param('category', 1)) }}"><a href="{{ route('categories.show', 1) }}">分享</a></li>
				<li class="{{ active_class(if_route('categories.show') && if_route_param('category', 2)) }}"><a href="{{ route('categories.show', 2) }}">教程</a></li>
				<li class="{{ active_class(if_route('categories.show') && if_route_param('category', 3)) }}"><a href="{{ route('categories.show', 3) }}">问答</a></li>
				<li class="{{ active_class(if_route('categories.show') && if_route_param('category', 4)) }}"><a href="{{ route('categories.show', 4) }}">公告</a></li>
			</ul>

			{{-- Right Side Of Navbar --}}
			<ul class="nav navbar-nav navbar-right">
				{{-- Authentication Links --}}
				@guest	{{-- balde use this?!how?why? --}}
				<li>
					<a href="{{ route('login') }}">Login</a>
				</li>
				<li>
					<a href="{{ route('register') }}">Register</a>
				</li>
				@else
				{{-- 不求甚解, 不假思索, 照抄照搬, 仅仅是马虎粗心? --}}
				<li>
					<a href="{{ route('topics.create') }}">
						<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
					</a>
				</li>
				{{-- 消息通知标记 --}}
				<li>
					<a href="{{ route('notifications.index') }}" class="notifications-badge" style="margin-top: -2px;">
						<span class="badge badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'fade' }}" title="消息提醒">
							{{ Auth::user()->notification_count }}
						</span>
					</a>
				</li>
				<li class="dropdown">
					<a href="###" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<span class="user-avatar pull-left" style="margin-left:8px;margin-top:-5px;">
							{{-- <img src="https://lihuang.monsteredward.com/wp-content/uploads/2018/06/6739ba046017babed5850373266eaa52ab450cc041fea-zfHSvS_fw658.jpg" class="img-responsive img-circle" width="30px" height="30px"> --}}
							<img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
						</span>
						{{ Auth::user()->name }}
						<span class="caret"></span>
					</a>

					<ul class="dropdown-menu" role="menu">
						@can('manage_contents')
						<li>
							<a href="{{ url(config('administrator.uri')) }}">
								<span class="glyphicon glyphicon-dashboard" aria-hidden="true"></span>
								管理后台
							</a>
						</li>
						@endcan


						<li>
							<a href="{{ route('users.show', Auth::id()) }}">
								<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
								User Center
							</a>
						</li>

						<li>
							<a href="{{ route('users.edit', Auth::id()) }}">Edit Information</a>
						</li>

						<li>
							<a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>

							<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
								{{ csrf_field() }}
							</form>
						</li>
					</ul>
				</li>
				@endguest
			</ul>
		</div>
    </div>
</nav>
