<div class="enter-pass-con form-select-password col-xs-8 col-xs-offset-2" ng-if="email_change && !email_pass">
      {!! Form::open(array('id' => 'forgot_success_form', 'route' => 'student.login.reset_password', 'method' => 'POST')) !!}

        <div class="form_content">
          <div class="alert alert-danger" ng-if="errors && !ec_error">
            <p ng-repeat="error in errors" > 
              {! error !}
            </p>
          </div>
          <div class="alert alert-danger" ng-if="!errors && ec_error">
            <p> 
              {! ec_error !}
            </p>
          </div>

          <div ng-if="show && !resent">
            <div class="roundcon">
              <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>

            <p class="text" ng-if="!success">
              <strong>Success!</strong>
              <br /> You're almost done! You should be able to receive an email that contains the confirmation code in a few minutes.
            </p>
            <p class="text" ng-if="success">
              <strong>Success!</strong>
              <br/>You have successfully changed your email. This email will be used for your succeeding logins and
              notifications will be sent in this new email.
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
          <div ng-if="!success">
            <div class="form-group">
              <small>Please check your inbox or your spam folder for the email. 
              <br />The email contains a code that you need to input below.</small>
            </div>

            <div class="form-group">
              {!! Form::text('confirm_code', ''
                  , array(
                      'class' => 'form-control'
                      , 'id' => 'confirm_code'
                      , 'placeholder' => 'Confirmation Code' 
                      , 'ng-model' => 'confirm_code'
                      , 'autocomplete' => 'off')
              ) !!}
              
              {!! Form::hidden('username', '{!user.email!}', array('ng-model' => 'username')) !!}
              {!! Form::hidden('id', '{!user.id!}', array('ng-model' => 'id')) !!}
            </div>

            <div class="btn-container">
              <a type="button" class="btn btn-maroon btn-medium" ng-click="emailValidateCode(confirm_code)">PROCEED</a>
              <a type="button" ng-disabled="disabled" class="btn btn-gold btn-medium" ng-click="emailResendCode()">Resend Code</a>
            </div>
          </div>          
        </div>

      {!! Form::close() !!}
  </div>