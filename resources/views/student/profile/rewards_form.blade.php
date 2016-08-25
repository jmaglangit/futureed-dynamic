<div ng-if="profile.active_rewards">
	{!! Form::open(['class' => 'form-horizontal', 'id' => 'reward-points']) !!}
	<div class="alert alert-error" ng-if="profile.errors">
			<p ng-repeat="error in profile.errors track by $index">
				{! error !}
			</p>
		</div>
	<fieldset class="reward-set">
		<legend>{!! trans('messages.rewards') !!}</legend>
		<div class="form-group">
			<label class="control-label col-xs-2">{!! trans('messages.points') !!}</label>
			<div class="col-xs-5">
				{!! Form::text('points', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => trans('messages.points')
                        , 'ng-disabled' => 'true'
                        , 'ng-value' => '(profile.prof.points - profile.prof.points_used)')
                ) !!}
			</div>
		</div>
		<div class="col-xs-12">
			<div class="panel panel-student">
				<div class="panel-heading row">
					<div class="col-xs-6">
						<h4>{!! trans('messages.description') !!}</h4>
					</div>
					<div class="col-xs-6">
						<h4>{!! trans('messages.admin_points_earned') !!}</h4>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="panel-body">
					<div class="row" ng-if="profile.points.length == 0">
						<div class="col-xs-12">
							{!! trans('messages.no_available_points') !!}
						</div>
					</div>
					<div class="row" ng-repeat="point in profile.points">
						<div class="col-xs-6">
							{! point.description !}
						</div>
						<div class="col-xs-6">
							{! point.points_earned !}
						</div>
					</div>
				</div>
			</div>
		</div>
	</fieldset>
	<fieldset class="reward-set">
		<legend>{!! trans('messages.badge') !!}</legend>
		<div ng-if="profile.badges.length <=0">
			<div class="alert alert-info">{!! trans('messages.no_available_badges') !!}</div>
		</div>
		<div class="col-xs-12" ng-if="profile.badges.length >= 1">
			<div class="col-xs-3" ng-repeat="badge in profile.badges">
				<img class="badge-image" ng-src="{! badge.badge_path !}">
			</div>
		</div>
	</fieldset>
	<fieldset class="reward-set">
		<legend>{!! trans('messages.medals') !!}</legend>
		<div ng-if="profile.point_level.length <= 0">
			<div class="alert alert-info">{!! trans('messages.no_available_medals') !!}</div>
		</div>
		<div ng-if="profile.point_level.length >= 1">
			<ul class="medals">
				<li class="pull-left" ng-repeat="medal in profile.point_level">
					<img ng-src="../images/medals/{! medal.filename !}" />
				</li>
			<ul>
		</div>
	</fieldset>
</div>