{!! Form::open(
	array(
		  'id' => 'change_email_form'
		, 'class' => 'form-horizontal'
		, 'ng-if' => 'profile.active_edit_email'
	)
) !!}
	<div class="form-group">
		<label class="col-xs-3 control-label">{!! trans('messages.current_email') !!} <span class="required">*</span></label>
		<div class="col-xs-5">
    		{!! Form::text('current_email', ''
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'trans('messages.current_email')'
                    , 'ng-class' => "{ 'required-field' : profile.fields['current_email'] }"
        			, 'ng-model' => 'profile.change.current_email'
        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
        			, 'ng-change' => 'profile.validateCurrentClientEmail()')
        		)!!}
        </div>	
        <div class="margin-top-8"> 
            <i ng-if="profile.validation.e_loading" class="fa fa-spinner fa-spin"></i>
            <i ng-if="profile.validation.e_success" class="fa fa-check success-color"></i>
            <span ng-if="profile.validation.e_error" class="error-msg-con">{! profile.validation.e_error !}</span>
        </div>		
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">{!! trans('messages.new_email') !!} <span class="required">*</span></label>
		<div class="col-xs-5">
    		{!! Form::text('new_email', ''
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'trans('messages.new_email')'
                    , 'ng-class' => "{ 'required-field' : profile.fields['new_email'] }"
        			, 'ng-model' => 'profile.change.new_email'
        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
        			, 'ng-change' => 'profile.validateNewClientEmail()') 
        		)!!}
        </div>		
        <div class="margin-top-8"> 
            <i ng-if="profile.validation.n_loading" class="fa fa-spinner fa-spin"></i>
            <i ng-if="profile.validation.n_success" class="fa fa-check success-color"></i>
            <span ng-if="profile.validation.n_error" class="error-msg-con">{! profile.validation.n_error !}</span>
        </div>	
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">{!! trans('messages.confirm_email') !!} <span class="required">*</span></label>
		<div class="col-xs-5">
    		{!! Form::text('confirm_email', ''
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'trans('messages.confirm_email')'
        			, 'ng-model' => 'profile.change.confirm_email'
                    , 'ng-class' => "{ 'required-field' : profile.fields['confirm_email'] }"
        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
        			, 'ng-change' => 'profile.confirmNewEmail()') 
        		)!!}
        </div>
        <div class="margin-top-8"> 
            <i ng-if="profile.validation.c_success" class="fa fa-check success-color"></i>
            <span ng-if="profile.validation.c_error" class="error-msg-con">{! profile.validation.c_error !}</span>
        </div>	
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">{!! trans('messages.password') !!} <span class="required">*</span></label>
		<div class="col-xs-5">
    		{!! Form::password('password'
    			, array(
        			'class' => 'form-control'
                    , 'ng-class' => "{ 'required-field' : profile.fields['password'] }"
        			, 'placeholder' => 'trans('messages.password')'
        			, 'ng-model' => 'profile.change.password') 
        		)!!}
        </div>		
	</div>
	<div class="btn-container">
		{!! Form::button('trans('messages.save')'
            , array(
                'class' => 'btn btn-blue btn-medium'
                , 'ng-click' => "profile.changeClientEmail()"
            )
        ) !!}

        {!! Form::button('trans('messages.cancel')'
            , array(
                'class' => 'btn btn-gold btn-medium'
                , 'ng-click' => "profile.setClientProfileActive('index')"
            )
        ) !!}
	</div>
{!! Form::close() !!}