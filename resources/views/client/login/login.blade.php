@extends('client.app')

@section('content')

  <div class="container login" ng-cloak>
    <div class="col-md-5 col-md-offset-1">
      <div class="form-style form-narrow">
      	<!-- ERROR -->
      	<div style="display:none;">
	      	<div class="title">Account Locked</div>
	        <div class="form_content">
	          <div style="width:120px; margin:0 auto 30px;">
	          <i class="fa fa-lock fa-5x img-rounded text-center" style="background:#e8e8e8; border-radius:200px; padding:20px; width:120px;"></i>
	          </div>
	
	          <p>Your account has been locked due to maximum attempt of invalid login.</p>
	          <p>Please <a href="#">click here</a> to redirect you to the steps to reset your picture password.</p>
	        </div>
      	</div>
        <div class="title">Login to your account</div>
          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>
          {!! Form::open(
              array(
                    'id' => 'login_form'
                  , 'route' => 'client.login.process'
                  , 'method' => 'POST'
                  , 'ng-controller' => 'LoginController as login'
              )
          ) !!}
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {!! Form::text('login', ''
                , array(
                    'placeholder' => 'Email or Username'
                    , 'ng-model' => 'login.username'
                    , 'autocomplete' => 'off'
                )
            ) !!}
          </div>
          <div class="input pass">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            {!! Form::password('password'
                , array(
                    'placeholder' => 'Password'
                    , 'ng-model' => 'login.password'
                )
            ) !!}
          </div>

          <div class="title">ROLE</div>
          <div class="input">
            <div class="icon">
              <i class="fa fa-group"></i>
            </div>
            {!! Form::select('role'
                , array(
                    '' => '-- Select Role --'
                    , 'Parent' => 'Parent'
                    , 'Teacher' => 'Teacher'
                    , 'Principal' => 'Principal')
                , ''
                , array(
                    'class' => 'form-control'
                    , 'ng-model' => 'login.role'
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
          
          <div class="text-group">
            <small>Not a Parent / Teacher / School?</small>
            <small>Click 

                {!! Html::link(
                    route('student.login')
                    , 'here') 
                !!}

                 for Student Site
            </small>     
          </div>  

          <div class="text-group">
            <small>
              {!! Html::link(route('client.login.forgot_password'), 'Forgot your password?') !!}
            </small>  
          </div>

          <p>
            {!! Html::link(route('client.registration'), 'Sign Up'
                , array(
                    'class' => 'btn btn-gold fb'
                )
            ) !!}
          </p>

        {!! Form::close() !!}
      </div>
    </div>
    <div style="font:normal 14px/20px Arial;" class="col-md-6 bulletin">
      <h2 class="title">Bulletin Board</h2>
      <hr />
      <h4>
          <i class="fa fa-clock-o"></i>
          {! display_date | date:'MMMM dd, yyyy' !}
      </h4>
        <br />
        Lorem ipsum dolor sit amet, consectetur adipiscing elit.
        Nunc luctus libero ac enim faucibus pellentesque.
        Mauris eleifend tincidunt luctus. Suspendisse at nulla condimentum, rutrum leo at, molestie est.
        Sed leo arcu, posuere sed diam ac, pretium efficitur sem. 
        Donec mattis eros metus, nec ultricies sapien interdum.
    </div>
  </div>
@endsection

@section('scripts')

  {!! Html::script('/js/client/controllers/login_controller.js') !!}

@stop