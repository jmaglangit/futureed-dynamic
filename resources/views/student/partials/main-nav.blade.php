<header>
	<nav class="navbar navbar-default" ng-cloak>
		<div class="navcon">
			<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
			<span class="sr-only">{!! trans('messages.toggle_navigation') !!}</span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			</button>
			<a href="{!! route('student.dashboard.index') !!}">{!! Html::image('/images/logo-sm-beta.png') !!}</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
				<ul class="nav navbar-nav navbar-right">
					<li class="nav-label">{!! trans('messages.cash_points') !!}</li>
					<li class="nav-points-rewards">
						{!! Html::image('/images/icons/icon-cash-points.png', ''
							, array(
								'class' => 'nav-icon-holder'
							)
						) !!} {! user.cash_points !}</li>
					<li class="nav-label">{!! trans('messages.reward_points') !!}</li>
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
					<li class="nav-label">{!! trans('messages.welcome') !!}, {! user.first_name !}</li>
					<li class="dropdown nav-dropdown">
						<a href="" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><span class="fa fa-2x fa-bars"></span></a>
						<ul class="dropdown-menu nav-dropdown-menu" role="menu">
							<li><a href="{!! route('student.reports.index') !!}">{!! trans('messages.reports') !!}</a></li>
							<li><a href="{!! route('student.profile.index') !!}">{!! trans('messages.profile') !!}</a></li>
							<li ng-if="user.age > 13"><a href="{!! route('student.payment.index') !!}">{!! trans('messages.payment') !!}</a></li>
							<li class="divider"></li>
							<li><a ng-if="!user.impersonate" href="javascript:void(0)" ng-click="logout(user.id, futureed.STUDENT, '{!! route('student.logout') !!}')">
									<span >{!! trans('messages.logout') !!}</span>
								</a>
								<a ng-if="user.impersonate" href="javascript:void(0)" ng-click="stopImpersonate(user.user_id, '{!! route('student.logout') !!}')">
									<span>{!! trans('messages.stop_impersonating') !!}</span>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>
