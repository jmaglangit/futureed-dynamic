<header>
	<nav class="navbar navbar-default" ng-cloak>
		<div class="navcon">
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">Toggle navigation</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a href="{!! route('student.dashboard.index') !!}">{!! Html::image('/images/logo-sm.png') !!}</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav ul-left">
					<li>
						<a href="" ng-click="checkClass()">Join Class</a>
					</li>
					
				</ul>

				<ul class="nav navbar-nav navbar-right">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Welcome, {! user.first_name !} <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="{!! route('student.profile.index') !!}">Profile</a></li>
							<li><a href="#">Settings</a></li>
							<li class="divider"></li>
							<li><a href="{!! route('student.logout') !!}">Logout</a></li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
