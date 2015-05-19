{!! Form::open(
	array(
		  'id' => 'change_email_form'
		, 'class' => 'form-horizontal'
		, 'ng-if' => 'profile.active_edit_email'
	)
) !!}
	<div class="form-group">
		<label class="col-xs-3 control-label">Current Email Address <span class="required">*</span></label>
		<div class="col-xs-5">
    		{!! Form::text('current_email', ''
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'Current Email Address'
        			, 'ng-model' => 'profile.change.current_email'
        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
        			, 'ng-change' => 'profile.validateCurrentClientEmail()')
        		)!!}
        </div>	
        <div style="margin-top: 7px;"> 
            <i ng-if="profile.e_loading" class="fa fa-spinner fa-spin"></i>
            <i ng-if="profile.e_success" class="fa fa-check success-color"></i>
            <span ng-if="profile.e_error" class="error-msg-con">{! profile.e_error !}</span>
        </div>		
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">New Email Address <span class="required">*</span></label>
		<div class="col-xs-5">
    		{!! Form::text('new_email', ''
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'New Email Address'
        			, 'ng-model' => 'profile.change.new_email'
        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
        			, 'ng-change' => 'profile.validateNewClientEmail()') 
        		)!!}
        </div>		
        <div style="margin-top: 7px;"> 
            <i ng-if="profile.n_loading" class="fa fa-spinner fa-spin"></i>
            <i ng-if="profile.n_success" class="fa fa-check success-color"></i>
            <span ng-if="profile.n_error" class="error-msg-con">{! profile.n_error !}</span>
        </div>	
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">Confirm Email Address <span class="required">*</span></label>
		<div class="col-xs-5">
    		{!! Form::text('confirm_email', ''
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'Confirm Email Address'
        			, 'ng-model' => 'profile.change.confirm_email'
        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
        			, 'ng-change' => 'profile.confirmNewEmail()') 
        		)!!}
        </div>
        <div style="margin-top: 7px;"> 
            <i ng-if="profile.c_success" class="fa fa-check success-color"></i>
            <span ng-if="profile.c_error" class="error-msg-con">{! profile.c_error !}</span>
        </div>	
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">Password <span class="required">*</span></label>
		<div class="col-xs-5">
    		{!! Form::password('password'
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'Password'
        			, 'ng-model' => 'profile.change.password') 
        		)!!}
        </div>		
	</div>
	<div class="btn-container">
		{!! Form::button('Save'
            , array(
                'class' => 'btn btn-gold btn-medium'
                , 'ng-click' => "profile.changeClientEmail()"
            )
        ) !!}

        {!! Form::button('Cancel'
            , array(
                'class' => 'btn btn-blue btn-medium'
                , 'ng-click' => "profile.setClientProfileActive('index')"
            )
        ) !!}
	</div>
{!! Form::close() !!}