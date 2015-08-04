<div ng-if="profile.active_rewards">
	{!! Form::open(['class' => 'form-horizontal', 'id' => 'reward-points']) !!}
	<div class="alert alert-error" ng-if="profile.errors">
			<p ng-repeat="error in profile.errors track by $index">
				{! error !}
			</p>
		</div>
	<fieldset>
		<legend>Rewards</legend>
		<div class="form-group">
			<label class="control-label col-xs-2">Points</label>
			<div class="col-xs-5">
				{!! Form::text('points', ''
                    , array(
                        'class' => 'form-control'
                        , 'placeholder' => 'Points' 
                        , 'ng-disabled' => 'true'
                        , 'ng-model' => 'profile.prof.points')
                ) !!}
			</div>
		</div>
		<div class="col-xs-12">
			<div class="panel panel-student">
				<div class="panel-heading row">
					<div class="col-xs-6">
						<h4>Description</h4>
					</div>
					<div class="col-xs-6">
						<h4>Points Earned</h4>
					</div>
				</div>
				<div class="clearfix"></div>
				<div class="panel-body">
					<div class="row" ng-if="profile.points.length == 0">
						<div class="col-xs-12">
							No Available Points
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
	<fieldset>
		<legend>Badges</legend>
		<div ng-if="profile.badges.length <=0">
			<div class="alert alert-info">No Badges Available</div>
		</div>
		<div class="col-xs-12" ng-if="profile.badges.length >= 1">
			<div class="col-xs-3" ng-repeat="badge in profile.badges">
				<img class="badge-image" ng-src="{! badge.badge_path !}">
			</div>
		</div>
	</fieldset>
	<fieldset>
		<legend>Medals</legend>
		<div>
			<div class="alert alert-info">No Medals Available</div>
		</div>
	</fieldset>
</div>