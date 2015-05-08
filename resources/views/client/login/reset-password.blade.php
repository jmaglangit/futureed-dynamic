@extends('client.app')

@section('content')
  <div class="container login" ng-cloak>
    <div class="col-md-6 col-md-offset-1" ng-show="!success">
      <div class="form-style form-narrow">
        <div class="title">Reset Password</div>

          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>

          {!! Form::open(
              array(
                  'id' => 'reset_password_form'
                , 'ng-controller' => 'LoginController as forgot'
              )
          ) !!}
          <div class="input">
            <div class="icon">
              <i class="fa fa-unlock-alt"></i>
            </div>
            {!! Form::password('new_password'
                  , array(
                      'ng-model' => 'forgot.new_password'
                    , 'placeholder' => 'New Password'
                  )
            ) !!}
          </div>
          <div class="input">
            <div class="icon">
              <i class="fa fa-lock"></i>
            </div>
            {!! Form::password('confirm_password'
                  , array(
                      'ng-model' => 'forgot.confirm_password'
                    , 'placeholder' => 'Confirm New Password'
                  )
            ) !!}
          </div>

          {!! Form::hidden('reset_code', $reset_code) !!}
          {!! Form::hidden('id', $id) !!}

          <div class="btn-container">
            {!! Form::button('Reset'
                , array(
                  'class' => 'btn btn-blue'
                  , 'ng-click' => 'forgot.resetClientPassword()'
                )
            ) !!}
          </div>
        {!! Form::close() !!}
      </div>
    </div>

    <div class="col-md-6 col-md-offset-1" ng-if="success">
      <div class="form-style form-select-password">
        <div class="title">Success!</div>
          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>

            <p>Your password has been set.</p>
            <p> You may now use your new password to login.</p>
          
          <br />

          <div class="btn-container">
            <a class="btn btn-blue" href="{!! route('client.login') !!}">Click here to Login</a>    
          </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  {!! Html::script('/js/client/controllers/login_controller.js') !!}
  {!! Html::script('/js/client/login.js') !!}
@stop