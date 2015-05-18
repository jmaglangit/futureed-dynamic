{!! Form::open(
  array(
    'id' => 'confirm_email_form'
    , 'ng-if' => 'profile.active_confirm_email'
  )
) !!}

<div class="enter-pass-con form-select-password col-xs-8 col-xs-offset-2">
  <div class="form_content" ng-if="!profile.email_confirmed">
      <div class="title" ng-if="!profile.resent">Email Confirmation Code Sent</div>
      <div class="title" ng-if="profile.resent">Email Confirmation Code Resent</div>
      
      <div ng-if="!profile.resent">
        <div class="roundcon">
          <i class="fa fa-check fa-5x img-rounded text-center"></i>
        </div>
        <div>
          <p class="text">
            <strong>Success!</strong>
            <br /> You're almost done! You should be able to receive an email that contains the confirmation code in a few minutes.
          </p>
        
          <div class="form-group">
            <small>Please check your inbox or your spam folder for the email. 
            <br />The email contains an email code that you need to input below.</small>
          </div>
        </div>
      </div>

      <div ng-if="profile.resent">
        <div class="roundcon">
          <i class="fa fa-refresh fa-5x img-rounded text-center"></i>
        </div>
        <div>
          <p class="text">
            <strong>Success!</strong>
            <br /> A new email code has been sent to your email account.
          </p>
        
          <div class="form-group">
            <small>Please check your inbox or your spam folder for the email. 
            <br />The email contains an email code that you need to input below.</small>
          </div>
        </div>
      </div>

      <br />
      <div class="form-group">
          {!! Form::label(null, 'Enter Email Confirmation Code:') !!}

          {!! Form::text('confirmation_code', '',
                array(
                    'class' => 'form-control'
                  , 'ng-model' => 'profile.confirmation_code'
                  , 'placeholder' => 'Confirmation Code'
                  , 'autocomplete' => 'off'
                )
          ) !!}
      </div>

        <div class="btn-container">
          {!! Form::button('Proceed'
              , array(
                      'id' => 'proceed_btn'
                  , 'class' => 'btn btn-maroon btn-medium'
                  , 'ng-click' => 'profile.confirmStudentEmailCode()'
                )
          ) !!}

          {!! Form::button('Resend Code'
              , array(
                      'class' => 'btn btn-gold btn-medium'
                  , 'ng-click' => 'profile.resendStudentEmailCode()'
              )
          ) !!}
        </div>
    </div>

  <div class="form_content" ng-if="profile.email_confirmed">
    <div class="title">Success!</div>
          <div class="form_content">
            <div class="roundcon">
                <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>

            <p class="text">
                  You have successfully confirmed your new email address.
            </p>
              {!! Form::button('View Profile'
                , array(
                    'class' => 'btn btn-gold'
                    , 'ng-click' => "profile.setStudentProfileActive('index')"
                )
            ) !!}
        </div> 
    </div>
</div>
{!! Form::close() !!}