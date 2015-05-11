@extends('client.app')

@section('content')
  <div class="container login" ng-controller="LoginController as forgot" ng-cloak>
  
    <div class="col-md-6 col-md-offset-1 form-style">
      {!! Form::open(
          array(
              'id' => 'redirect_form'
              , 'route' => 'client.login.reset_password'
              , 'method' => 'POST'
          ) 
      ) !!}

          {!! Form::hidden('id', '') !!}
          {!! Form::hidden('email', $email) !!}
          {!! Form::hidden('reset_code', '') !!}

      {!! Form::close() !!}
      
      <div class="form_content">
        <div class="title" ng-if="!resent">Email Sent</div>
        <div class="title" ng-if="resent">Code Resent</div>

        <div class="alert alert-danger" ng-if="errors">
          <p ng-repeat="error in errors" > 
            {! error !}
          </p>
        </div>

        {!! Form::open(
            array(
                  'id' => 'forgot_success_form'
            )
        ) !!} 
        <div ng-if="!resent">
          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
          <div>
            <p class="text">
              <strong>Success!</strong>
              <br /> An email to reset your password has been sent to your email account.
            </p>
          
            <br />
            <div class="form-group">
              <small>Please check your inbox or your spam folder for the email. 
              <br />The email contains a code that you need to input below.</small>
            </div>
          </div>
        </div>

          <p ng-if="resent">
            A new code has been sent to your email.
          </p>
          <div class="form-group">
            {!! Form::label(null, 'Enter Code:') !!}

            {!! Form::text('reset_code', '',
                  array(
                      'class' => 'form-control'
                    , 'ng-model' => 'forgot.reset_code'
                    , 'placeholder' => 'Reset Code'
                    , 'autocomplete' => 'off'
                  )
            ) !!}
          </div>

          <div class="btn-container">
              {!! Form::button('Proceed'
                  , array(
                        'id' => 'proceed_btn'
                      , 'class' => 'btn btn-blue btn-medium'
                      , 'ng-click' => 'forgot.clientValidateCode(forgot.reset_code)'
                  )
              ) !!}

              {!! Form::button('Resend Code'
                  , array(
                        'class' => 'btn btn-gold btn-medium'
                      , 'ng-click' => 'forgot.clientResendCode()'
                  )
              ) !!}
          </div>
          {!! Form::close() !!}
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
  {!! Html::script('/js/client/controllers/login_controller.js') !!}
  {!! Html::script('/js/client/login.js') !!}
@stop