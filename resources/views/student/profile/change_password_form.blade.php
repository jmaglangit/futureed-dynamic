<div ng-if="profile.active_password">
	<div class="alert alert-success" ng-if="profile.password_validated && profile.password_selected && profile.password_confirmed">
		<p>Your Picture Password has been saved.</p>
		<p>You may now use this picture password in your succeeding login.</p>
	</div>

	<div class="col-xs-12 search-container" ng-if="!profile.password_confirmed">
		<div class="col-xs-12 form-select-password">
			<ul class="form_password list-unstyled list-inline">
				<li class="item col-xs-4" 
					ng-repeat="item in profile.image_pass"
					ng-class="{ 'selected' : profile.change.password_image_id == item.id }"
					ng-click="profile.highlightPassword(item.id)">
					<img ng-src="{! item.url !}" class="pass-img" alt="{! item.name !}">
				</li>
			</ul>
		</div>

		<div class="col-xs-12 btn-container">
			<div ng-if="!profile.password_validated">
				{!! Form::button('Proceed'
					, array(
						'class' => 'btn btn-maroon btn-medium'
						, 'ng-click' => 'profile.validateCurrentPassword()'
						, 'ng-if' => 'profile.change.password_image_id'
					)
				) !!}

				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "profile.setStudentProfileActive('index')"
					)
				) !!}
			</div>

			<div ng-if="profile.password_validated && !profile.password_selected">
				{!! Form::button('Proceed'
					, array(
						'class' => 'btn btn-maroon btn-medium'
						, 'ng-click' => 'profile.selectNewPassword()'
					)
				) !!}
			</div>

			<div ng-if="profile.password_validated && profile.password_selected && !profile.password_confirmed">
				{!! Form::button('Change Picture Password'
					, array(
						'class' => 'btn btn-maroon btn-medium'
						, 'ng-click' => 'profile.changePassword()'
					)
				) !!}

				{!! Form::button('Previous'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "profile.undoNewPassword()"
					)
				) !!}
			</div>
		</div>
	</div>

	<div class="col-xs-12 btn-container" ng-if="profile.password_confirmed">
		{!! Html::link(route('student.profile.index'), 'View Profile'
			, array(
				'class' => 'btn btn-gold btn-medium'
			)	
		) !!}
	</div>
</div>