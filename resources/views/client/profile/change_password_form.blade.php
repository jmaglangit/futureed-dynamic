{!! Form::open(array('id' => 'client_change_pass_form'
	, 'class' => 'form-horizontal', 'ng-if' => 'profile.active_password && !profile.password_changed'))!!}
	<div class="form-group">
		<label class="col-xs-3 control-label">Current Password <span class="required">*</span></label>
		<div class="col-xs-6">
    		{!! Form::password('password'
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'Current Password'
        			, 'ng-model' => 'profile.change.password')
        		)!!}
        </div>		
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">New Password <span class="required">*</span></label>
		<div class="col-xs-6">
    		{!! Form::password('new_password'
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'New Password'
        			, 'ng-model' => 'profile.change.new_password'
        			, 'ng-model-option' => "{debounce: {'default' : 10000} }") 
        		)!!}
        	<p class="help-block">Password must be at least 8 characters and with at least 1 number.</p>
        </div>
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">Confirm Password <span class="required">*</span></label>
		<div class="col-xs-6">
    		{!! Form::password('confirm_password'
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'Confirm Password'
        			, 'ng-model' => 'profile.change.confirm_password'
        			, 'ng-model-option' => "{debounce: {'default' : 10000} }") 
        		)!!}
        </div>		
	</div>
	<div class="btn-container">
		{!! Form::button('Save'
            , array(
                'class' => 'btn btn-blue btn-medium'
                , 'ng-click' => "profile.changeClientPassword()"
            )
        ) !!}

        {!! Form::button('Cancel'
            , array(
                'class' => 'btn btn-gold btn-medium'
                , 'ng-click' => "profile.setClientProfileActive('index')"
            )
        ) !!}
	</div>
{!! Form::close() !!}

<div ng-if="profile.active_password && profile.password_changed">
	<div class="alert alert-success">
		You have successfully changed your password.
	</div>

	<div class="btn-container">
        {!! Form::button('View Profile'
            , array(
                'class' => 'btn btn-blue btn-medium'
                , 'ng-click' => "profile.setClientProfileActive('index')"
            )
        ) !!}
	</div>
</div>