<div ng-if="help.active_view || help.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>Tip Details</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="help.errors || help.success">
		<div class="alert alert-error" ng-if="help.errors">
			<p ng-repeat="error in help.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="help.success">
            <p>{! help.success !}</p>
        </div>
    </div>
	
	<div class="form-content">
		<div class="col-xs-12">
			<div class="col-xs-6">
				<h3>{! help.record.title !}</h3>
				<p>{! help.record.created_moment !}</p>
			</div>

			<div class="col-xs-6 pull-right">
				<div class="col-xs-3 avatar-container-small">
					<img class="pull-left" ng-src="{! help.record.avatar_url !}" />
				</div>
				<div class="avatar-name-container col-xs-6"> {! help.record.name !} </div>
			</div>
		</div>

		<div class="col-xs-12">
			<hr />
		</div>

		<div class="col-xs-12">
			<div class="col-xs-12">
				<p class="text-container">{! help.record.content !}</p>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="col-xs-6"></div>
			<div class="col-xs-6">
				<p ng-if="!help.record.rating">Was the answer helpful? Please Rate.</p>
				<p ng-if="help.record.rating">You rated this: </p>
			</div>
		</div>

		<div class="col-xs-12" ng-cloak>
			<div class="col-xs-6"></div>
			<div class="col-xs-6">
				<div class="col-xs-6 rating-container">
					<span ng-repeat="i in help.record.stars track by $index">
						<img ng-if="!help.record.rating" ng-mouseover="help.changeColor($index)" ng-src="{! ($index+1 <= help.record.rating || help.hovered[$index])  && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
						<img ng-if="help.record.rating" ng-src="{! $index+1 <= help.record.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
					</span>
				</div>
				<div class="col-xs-6">
					{!! Form::button('Rate'
						, array(
							'class' => 'btn btn-blue pull-right'
							, 'ng-click' => "help.selectRate()"
							, 'ng-if' => '!help.record.rating'
							, 'ng-disabled' => '!help.hovered.length'
						)
					) !!}

					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold pull-right'
							, 'ng-click' => "help.setActive()"
							, 'ng-if' => 'help.record.rating'
						)
					) !!}
				</div>
			</div>
		</div>

		<br />
	</div>

	<div class="sticky-bottom col-xs-12" ng-if="!help.record.rating" ng-cloak>
		<div class="col-xs-6"></div>
		<div class="col-xs-6">
			<div class="col-xs-6"></div>
			<div class="col-xs-6">
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold pull-right'
						, 'ng-click' => "help.setActive()"
					)
				) !!}
			</div>
		</div>
	</div>
</div>