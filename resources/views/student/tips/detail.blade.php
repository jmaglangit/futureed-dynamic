<div ng-if="tips.active_view || tips.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>Tip Details</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="tips.errors || tips.success">
		<div class="alert alert-error" ng-if="tips.errors">
			<p ng-repeat="error in tips.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="tips.success">
            <p>{! tips.success !}</p>
        </div>
    </div>
	
	<div class="form-content">
		<div class="col-xs-12">
			<div class="col-xs-6">
				<h3>{! tips.record.title !}</h3>
				<p>{! tips.record.created_moment !}</p>
			</div>

			<div class="col-xs-6 pull-right">
				<div class="col-xs-3 avatar-container-small">
					<img class="pull-left" ng-src="{! tips.record.avatar_url !}" />
				</div>
				<div class="avatar-name-container col-xs-6"> {! tips.record.name !} </div>
			</div>
		</div>

		<div class="col-xs-12">
			<hr />
		</div>

		<div class="col-xs-12">
			<div class="col-xs-12">
				<p class="text-container">{! tips.record.content !}</p>
			</div>
		</div>

		<div class="col-xs-12">
			<div class="col-xs-6"></div>
			<div class="col-xs-6">
				<p ng-if="!tips.record.rating">Was the answer helpful? Please Rate.</p>
				<p ng-if="tips.record.rating">You rated this: </p>
			</div>
		</div>

		<div class="col-xs-12" ng-cloak>
			<div class="col-xs-6"></div>
			<div class="col-xs-6">
				<div class="col-xs-6 rating-container">
					<span ng-repeat="i in tips.record.stars track by $index">
						<img ng-if="!tips.record.rating" ng-mouseover="tips.changeColor($index)" ng-src="{! ($index+1 <= tips.record.rating || tips.hovered[$index])  && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
						<img ng-if="tips.record.rating" ng-src="{! $index+1 <= tips.record.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
					</span>
				</div>
				<div class="col-xs-6">
					{!! Form::button('Rate'
						, array(
							'class' => 'btn btn-blue pull-right'
							, 'ng-click' => "tips.selectRate()"
							, 'ng-if' => '!tips.record.rating'
							, 'ng-disabled' => '!tips.hovered.length'
						)
					) !!}

					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold pull-right'
							, 'ng-click' => "tips.setActive()"
							, 'ng-if' => 'tips.record.rating'
						)
					) !!}
				</div>
			</div>
		</div>

		<br />
	</div>

	<div class="sticky-bottom col-xs-12" ng-if="!tips.record.rating" ng-cloak>
		<div class="col-xs-6"></div>
		<div class="col-xs-6">
			<div class="col-xs-6"></div>
			<div class="col-xs-6">
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold pull-right'
						, 'ng-click' => "tips.setActive()"
					)
				) !!}
			</div>
		</div>
	</div>
</div>