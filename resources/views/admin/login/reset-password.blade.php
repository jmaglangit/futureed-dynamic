@extends('admin.app')

@section('content')
	<div class="container login" ng-controller="AdminLoginController as forgot" ng-cloak>
		<div class="login-container col-md-6 col-md-offset-3">
			<div class="form-style form-narrow">
				<div class="logo-container">
					{!! Html::image('images/logo-md.png') !!}
				</div>
        <div class="adlogin-title" ng-show="!forgot.success">
          Reset Password
        </div>
        <div class="adlogin-title" ng-if="forgot.success">
          Reset Password Success
        </div>
        <div class="forgot-message" ng-if="forgot.success">
          <strong>Success!</strong><br/>
          <p>You're password has been reset</p>
          <p> You may now use your new password to login.</p>
        </div>
				
				{!! Form::open(
              array(
                    'id' => 'login_form'
                  , 'ng-if' => '!forgot.success'
              )
          ) !!}
          <div class="alert alert-danger" ng-if="forgot.errors">
          <p ng-repeat="error in forgot.errors">
            {! error !}
          </p>
        </div>
          <div class="input">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            {!! Form::password('new_pass'
                , array(
                    'placeholder' => 'Enter Password'
                    , 'ng-model' => 'forgot.new_pass'
                    , 'autocomplete' => 'off'
                )
            ) !!}
          </div>
          <div class="input pass">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            {!! Form::password('confirm_pass'
                , array(
                    'placeholder' => 'Confirm Password'
                    , 'ng-model' => 'forgot.confirm_pass'
                )
            ) !!}
          </div>

          {!! Form::hidden('reset_code', $reset_code) !!}
          {!! Form::hidden('id', $id) !!}

          {!! Form::button('Reset'
              , array(
                  'class' => 'btn btn-blue'
                  , 'ng-click' => 'forgot.adminResetPass()'
              )
          ) !!}
          {!! Form::close() !!}
          <a ng-if="forgot.success" href="{!! route('admin.login') !!}" type="button" class="btn btn-blue">Login</a>
			</div>
		</div>
	</div>
  @endsection

@section('scripts')
  {!! Html::script('/js/admin/controllers/login_controller.js') !!}
  {!! Html::script('/js/admin/services/login_service.js') !!}
  {!! Html::script('/js/admin/login.js') !!}
@stop