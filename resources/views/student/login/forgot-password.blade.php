@extends('student.app')

@section('content')
  <div class="container login student-fnt" ng-cloak>
    <div class="col-md-6 col-md-offset-3">
      <div class="form-style" ng-show="!sent">
        <div class="title">Retrieve Picture Password</div>

        <div class="alert alert-danger" ng-if="errors">
          <p ng-repeat="error in errors" > 
            {! error !}
          </p>
        </div>

        {!! Form::open(array('id' => 'forgot_password_form')) !!}
          <div class="input">
            <div class="icon">
              <i class="fa fa-user"></i>
            </div>
            {!! Form::text('username', ''
                , array(
                    'class' => 'form-control'
                    , 'placeholder' => 'Username or Email'
                    , 'autocomplete' => 'off'
                    , 'ng-model' => 'username')
            ) !!}
          </div>
          <div class="btn-container">
            {!! Form::button('Send'
                , array(
                    'id' => 'forgot_password_btn'
                    , 'class' => 'btn btn-maroon btn-medium'
                    , 'ng-click' => 'studentForgotPassword()'
                )
            ) !!}

            {!! Html::link(route('student.login'), 'Cancel'
                , array(
                    'class' => 'btn btn-gold btn-medium'
                )
                , ''
            ) !!}
          </div>
        {!! Form::close() !!}
      </div>

      <div class="form-style" ng-if="sent">
      {!! Form::open(array('id' => 'redirect_form', 'method' => 'POST', 'route' => 'student.login.reset_password')) !!}
        {!! Form::hidden('id', '', array('ng-model' => 'id')) !!}
        {!! Form::hidden('reset_code', '') !!}
      {!! Form::close() !!}

      {!! Form::open(array('id' => 'forgot_success_form')) !!}
        <div class="form_content">
          <div class="title" ng-if="!resent && sent">Email Sent</div>
          <div class="title" ng-if="resent && sent">Reset Code Resent</div>

          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>


          <div ng-if="!resent && sent">
            <div class="roundcon">
              <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>

            <p class="text">
              <strong>Success!</strong>
              <br /> An email to reset your picture password has been sent to your email account. 
            </p>
          </div>

          <div ng-if="resent">
            <div class="roundcon">
              <i class="fa fa-refresh fa-5x img-rounded text-center"></i>
            </div>

            <p class="text">
              <strong>Success!</strong>
              <br /> A new email to reset your picture password has been sent to your email account. 
            </p>
          </div>

          <div class="form-group">
            <small>Please check your inbox or your spam folder for the email. 
            <br />The email contains a code that you need to input below.</small>
          </div>

            <div class="form-group">
              {!! Form::text('reset_code', ''
                , array(
                    'class' => 'form-control'
                    , 'placeholder' => 'Reset Code'
                    , 'autocomplete' => 'off'
                    , 'ng-model' => 'reset_code')
              ) !!}
            </div>
            <div class="btn-container">
              {!! Form::button('Proceed'
                  , array(
                      'id' => 'validate_code_btn'
                      , 'class' => 'btn btn-maroon btn-medium'
                      , 'ng-click' => 'studentValidateCode(reset_code)'
                  )
              ) !!}

              {!! Form::button('Resend Code'
                  , array(
                        'class' => 'btn btn-gold btn-medium'
                      , 'ng-click' => 'studentResendCode()'
                  )
              ) !!}
            </div>
            
          </div>
        {!! Form::close() !!}
      </div>

    </div>
  </div>
@endsection

@section('footer')

@section('scripts')
  
  {!! Html::script('/js/student/login.js') !!}

@stop