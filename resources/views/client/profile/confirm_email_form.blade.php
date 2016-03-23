{!! Form::open(
	array(
		'id' => 'confirm_email_form'
		, 'ng-if' => 'profile.active_confirm_email'
	)
) !!}

<div class="enter-pass-con form-select-password col-xs-8 col-xs-offset-2">
	<div class="form_content" ng-if="!profile.email_confirmed">
	    <div class="title" ng-if="!profile.resent">{!! trans('messages.client_email_confirmation_code_sent') !!}</div>
	    <div class="title" ng-if="profile.resent">{!! trans('messages.client_email_confirmation_code_resent') !!}</div>

	    <div ng-if="!profile.resent">
	      <div class="roundcon">
	        <i class="fa fa-check fa-5x img-rounded text-center"></i>
	      </div>
	      <div>
	        <p class="text">
	          <strong>{!! trans('messages.success') !!}</strong>
	          <br /> {!! trans('messages.client_enter_email_code') !!}
	        </p>
	      
	        <div class="form-group">
	          <small>{!! trans('messages.forgot_check_inbox') !!}</small>
	        </div>
	      </div>
	    </div>

	    <div ng-if="profile.resent">
	      <div class="roundcon">
	        <i class="fa fa-refresh fa-5x img-rounded text-center"></i>
	      </div>
	      <div>
	        <p class="text">
	          <strong>{!! trans('messages.success') !!}</strong>
	          <br /> {!! trans('messages.client_new_email_code_sent') !!}
	        </p>
	      
	        <div class="form-group">
	          <small>{!! trans('messages.forgot_check_inbox') !!}</small>
	        </div>
	      </div>
	    </div>

	    <br />
	    <div class="form-group">
	        {!! Form::label(null, 'trans('messages.client_enter_email_confirmation_code'):') !!}

	        {!! Form::text('confirm_code', '',
	              array(
	                  'class' => 'form-control'
	                , 'ng-model' => 'profile.confirmation_code'
	                , 'placeholder' => 'trans('messages.confirm_code')'
	                , 'autocomplete' => 'off'
	              )
	        ) !!}
	    </div>

      	<div class="btn-container">
	        {!! Form::button('trans('messages.client_proceed')'
	            , array(
	                    'id' => 'proceed_btn'
	                , 'class' => 'btn btn-blue btn-medium'
	                , 'ng-click' => 'profile.confirmClientEmail()'
	              )
	        ) !!}

	        {!! Form::button('trans('messages.client_resend_code')'
	            , array(
	                    'class' => 'btn btn-gold btn-medium'
	                , 'ng-click' => 'profile.resendClientEmailCode()'
	            )
	        ) !!}
      	</div>
    </div>

	<div class="form_content" ng-if="profile.email_confirmed">
		<div class="title">{!! trans('messages.success') !!}</div>
          <div class="form_content">
            <div class="roundcon">
                <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>

            <p class="text">
                  {!! trans('messages.client_succesfully_confirmed_email_address') !!}
            </p>
            	{!! Form::button('trans('messages.view_profile')'
		            , array(
		                'class' => 'btn btn-gold'
		                , 'ng-click' => "profile.setClientProfileActive('index')"
		            )
		        ) !!}
        </div> 
    </div>
</div>


{!! Form::close() !!}