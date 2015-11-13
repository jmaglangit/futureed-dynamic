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
				<ul class="nav navbar-nav navbar-right">
					<li class="nav-label">Reward Points</li>
					<li class="nav-points-rewards">
						{!! Html::image('/images/icons/icon-reward.png', ''
							, array(
								'class' => 'nav-icon-holder'
							)
						) !!} {! user.points !}</li>
					<li class="nav-points-rewards" ng-init="getStudentBadges()">
						{!! Html::image('/images/icons/icon-badges.png', ''
							, array(
								'class' => 'nav-icon-holder'
							)
						) !!} {! badges.total !}</li>

					<li class="nav-label"></li>
					<li class="nav-label"></li>
					<li class="nav-label"></li>

					<li><img class="nav-image-holder" ng-src="{! user.thumbnail !}" /></li>
					<li class="nav-label">Welcome, {! user.first_name !}</li>
					<li class="dropdown nav-dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-2x fa-bars"></span></a>
						<ul class="dropdown-menu nav-dropdown-menu" role="menu">
							<li><a href="{!! route('student.reports.index') !!}">Reports</a></li>
							<li><a href="{!! route('student.profile.index') !!}">Profile</a></li>
							<li ng-if="user.age > 13"><a href="{!! route('student.payment.index') !!}">Payment</a></li>
							<li class="divider"></li>
							<li><a ng-if="!user.impersonate" href="javascript:void(0)" ng-click="logout(user.id, futureed.STUDENT, '{!! route('student.logout') !!}')">
									<span >Logout</span>
								</a>
								<a ng-if="user.impersonate" href="javascript:void(0)" ng-click="stopImpersonate(user.user_id, '{!! route('student.logout') !!}')">
									<span>Stop Impersonating</span>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
