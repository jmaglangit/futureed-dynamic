<header>
	<nav class="navbar navbar-default" ng-cloak>
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a href="{!! route('admin.dashboard.index') !!}"><img ng-src="/images/logo-sm.png" /></a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li>
						<a>Welcome, {! user.first_name !}</a>
					</li>
					<li>
						<a href="{!! route('admin.logout') !!}">Logout</a>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
