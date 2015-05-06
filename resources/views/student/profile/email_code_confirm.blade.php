<div class="enter-pass-con form-select-password col-xs-8 col-xs-offset-2" ng-if="email_change && !email_pass">
      {!! Form::open(array('id' => 'forgot_success_form', 'route' => 'student.login.reset_password', 'method' => 'POST')) !!}

        <div class="form_content">
          <div class="alert alert-danger" ng-if="errors">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>

          <div ng-if="show && !resent">
            <div class="roundcon">
              <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>

            <p class="text">
              <strong>Success!</strong>
              <br /> You're almost done! You should be able to receive an email that contains the confirmation code in a few minutes.
            </p>
          </div>
          
          <div ng-if="resent">
            <div class="roundcon">
              <i class="fa fa-refresh fa-5x img-rounded text-center"></i>
            </div>

            <p class="text">
              <strong>Success!</strong>
              <br /> You're almost done! You should be able to receive an email that contains the confirmation code in a few minutes.  
            </p>
          </div>
          <br/>
          <div class="form-group">
            <small>Please check your inbox or your spam folder for the email. 
            <br />The email contains a code that you need to input below.</small>
          </div>

          <div class="form-group">
            {!! Form::text('reset_code', ''
                , array(
                    'class' => 'form-control'
                    , 'placeholder' => 'Confirmation Code' 
                    , 'ng-model' => 'confirm_code'
                    , 'autocomplete' => 'off')
            ) !!}
            
            {!! Form::hidden('username', 'email', array('ng-model' => 'username')) !!}
            {!! Form::hidden('id', '', array('ng-model' => 'id')) !!}
          </div>

          <div class="btn-container">
            <a type="button" class="btn btn-maroon btn-medium" ng-click="studentValidateCode(reset_code)">PROCEED</a>
            <a type="button" ng-disabled="disabled" class="btn btn-gold btn-medium" ng-click="studentResendCode()">Resend Code</a>
          </div>
        </div>

      {!! Form::close() !!}
  </div>