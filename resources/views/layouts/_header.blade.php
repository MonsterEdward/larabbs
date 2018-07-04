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
			<a class="nvabar-brand" href="{{ url('/') }}">laraBBS</a>
		</div>

		<div class="collapse navbar-collapse" id="app-navbar-collapse">
			{{-- Left Side of Navbar --}}
			<ul class="nav navbar-nav">
				
			</ul>

			{{-- Right Side Of Navbar --}}
			<ul class="nav navbar-nav navbar-right">
				{{-- Authentication Links --}}
				@guest	{{-- balde use this?!how?why? --}}
				<li><a href="{{ route('login') }}">Login</a></li>
				<li><a href="{{ route('register') }}">Register</a></li>
				@else
				<li class="dropdown">
					<a href="###" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<span class="user-avatar pull-left" style="margin-left:8px;margin-top:-5px;"><img src="https://lihuang.monsteredward.com/wp-content/uploads/2018/06/6739ba046017babed5850373266eaa52ab450cc041fea-zfHSvS_fw658.jpg" class="img-responsive img-circle" width="30px" height="30px"></span>
						{{ Auth::user()->name }}<span class="caret"></span>
					</a>

					<ul class="dropdown-menu" role="menu">
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
