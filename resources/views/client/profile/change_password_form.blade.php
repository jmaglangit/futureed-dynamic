{!! Form::open(array('id' => 'client_change_pass_form'
	, 'class' => 'form-horizontal', 'ng-if' => 'profile.active_password && !profile.password_changed'))!!}
	<div class="form-group">
		<label class="col-xs-3 control-label">{!! trans('messages.current_password') !!} <span class="required">*</span></label>
		<div class="col-xs-6">
    		{!! Form::password('password'
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'trans('messages.current_password')'
        			, 'ng-model' => 'profile.change.password')
        		)!!}
        </div>		
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">{!! trans('messages.new_password') !!} <span class="required">*</span></label>
		<div class="col-xs-6">
    		{!! Form::password('new_password'
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'trans('messages.new_password')'
        			, 'ng-model' => 'profile.change.new_password'
        			, 'ng-model-option' => "{debounce: {'default' : 10000} }") 
        		)!!}
        	<p class="help-block">{!! trans('messages.password_limit') !!}</p>
        </div>
	</div>
	<div class="form-group">
		<label class="col-xs-3 control-label">{!! trans('messages.confirm_password') !!} <span class="required">*</span></label>
		<div class="col-xs-6">
    		{!! Form::password('confirm_password'
    			, array(
        			'class' => 'form-control'
        			, 'placeholder' => 'trans('messages.confirm_password')'
        			, 'ng-model' => 'profile.change.confirm_password'
        			, 'ng-model-option' => "{debounce: {'default' : 10000} }") 
        		)!!}
        </div>		
	</div>
	<div class="btn-container">
		{!! Form::button('trans('messages.save')'
            , array(
                'class' => 'btn btn-blue btn-medium'
                , 'ng-click' => "profile.changeClientPassword()"
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

<div ng-if="profile.active_password && profile.password_changed">
	<div class="alert alert-success">
		{!! trans('messages.client_successfully_change_password') !!}
	</div>

	<div class="btn-container">
        {!! Form::button('trans('messages.view_profile') !!}'
            , array(
                'class' => 'btn btn-blue btn-medium'
                , 'ng-click' => "profile.setClientProfileActive('index')"
            )
        ) !!}
	</div>
</div>