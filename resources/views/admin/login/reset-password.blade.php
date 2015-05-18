@extends('admin.app')

@section('content')
	<div class="container login" ng-cloak>
		<div class="col-md-4 col-md-offset-4">
			<div class="form-style form-narrow">
				<div class="logo-container">
					{!! Html::image('images/logo-md.png') !!}
				</div>
        <div class="adlogin-title" ng-if="success">
          Reset Password
        </div>
        <div class="adlogin-title" ng-if="!success">
          Reset Password Success
        </div>
        <div class="forgot-message">
          <p>Success!</p><br/>
          <p>You're password has been reset</p>
        </div>
				<div class="alert alert-danger" ng-if="errors">
					<p ng-repeat="error in errors">
						{! error !}
					</p>
				</div>
				{!! Form::open(
              array(
                    'id' => 'login_form'
                  , 'route' => 'client.login.process'
                  , 'method' => 'POST'
                  , 'ng-if' => 'success'
              )
          ) !!}
          <div class="input">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            {!! Form::password('new_pass'
                , array(
                    'placeholder' => 'Enter Password'
                    , 'ng-model' => 'new_pass'
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
                    , 'ng-model' => 'confirm_pass'
                )
            ) !!}
          </div>

          {!! Form::hidden('user_data', ''
              , array(
                 'ng-model' => 'user_data'
              )
          ) !!}

          {!! Form::button('Login'
              , array(
                  'class' => 'btn btn-blue'
                  , 'ng-click' => 'login.clientLogin()'
              )
          ) !!}
          </form>
          <a href="{!! route('admin.login') !!}" type="button" class="btn btn-blue">Login</a>
			</div>
		</div>
	</div>