<div ng-if="profile.active_password">
	<div class="alert alert-success" ng-if="profile.password_validated && profile.password_selected && profile.password_confirmed">
		<p>Your Picture Password has been saved.</p>
		<p>You may now use this picture password in your succeeding login.</p>
	</div>

	<div class="col-md-8 col-md-offset-2" ng-if="!profile.password_confirmed">
      {!! Form::open(array('id' => 'change_password_form')) !!}
        <div class="form-select-password">
          <div class="form_content">
            <ul class="form_password list-unstyled list-inline">
              <li class="item col-xs-4" ng-repeat="item in image_pass" ng-click="profile.highlightPassword($event)">
                 <img ng-src="{! item.url !}" class="pass-img" alt="{! item.name !}">
                 <input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
              </li>
            </ul>
		  </div>
        </div>
      {!! Form::close() !!}
    </div>

    <div class="btn-container">
    	<div ng-if="!profile.password_validated">
    		{!! Form::button('Proceed'
    			, array(
    				'class' => 'btn btn-maroon btn-medium'
    				, 'ng-click' => 'profile.validateCurrentPassword()'
    				, 'ng-if' => 'profile.image_id'
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

    	<div class="btn-container" ng-if="profile.password_confirmed">
			{!! Html::link(route('student.profile.index'), 'View Profile'
				, array(
					'class' => 'btn btn-gold btn-medium'
				)	
			) !!}
		</div>
	</div>
</div>