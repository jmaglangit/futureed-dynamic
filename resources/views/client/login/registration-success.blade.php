<div class="register_users login form-style col-sm-6 col-sm-offset-3" ng-if="registered"> 
    <div ng-if="!register.confirmed">
        <div class="title">Thank you for registering to Future Lesson!</div>

        <div class="form_content">
            <div class="alert alert-danger" ng-if="errors">
              <p ng-repeat="error in errors" > 
                {! error !}
              </p>
            </div>

            <div ng-if="!register.resent">
              <div class="roundcon">
                  <i class="fa fa-check fa-5x img-rounded text-center" ></i>
              </div>

              <p class="text">
                  An email has been sent to confirm your email account.
              </p>
            </div>

            <div ng-if="register.resent">
              <div class="roundcon">
                  <i class="fa fa-refresh fa-5x img-rounded text-center"></i>
              </div>
              
              <p class="text">
                  A new confirmation code has been sent to your email account.
              </p>
            </div>

            <br />
            <small>Please check your inbox or your spam folder for the email. The email contains a confirmation code that you need to input below.</small>
            {!! Form::open(array('id' => 'registration_success_form')) !!}
                <div class="form-group" ng-if="!register.account_confirmed">
                    {!! Form::label('', 'Enter Confirmation Code:')!!}
                    
                    {!! Form::text('confirmation_code', ''
                            , array(
                                'class' => 'form-control'
                                , 'placeholder' => 'Confirmation Code'
                                , 'ng-model' => 'register.confirmation_code'
                            )
                    ) !!}
                </div>
                <div class="btn-container">
                    {!! Form::button('Confirm'
                        , array(
                              'id' => 'proceed_btn'
                            , 'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'register.confirmClientRegistration()'
                            , 'ng-if' => '!register.account_confirmed'
                        )
                    ) !!}

                    {!! Form::button('Resend'
                        , array(
                              'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => 'register.resendClientConfirmation()'
                            , 'ng-if' => '!register.account_confirmed'
                        )
                    )!!}

                    {!! Html::link(route('client.login'), 'Home'
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-if' => 'register.account_confirmed'
                        )
                    ) !!}
                </div>
            {!! Form::close() !!}
        </div>
    </div>

    <div ng-if="register.confirmed">
        <div class="title">
          <h3>Success!</h3>
        </div>

        <div class="form_content">
            <div class="roundcon">
                <i class="fa fa-check fa-5x img-rounded text-center"></i>
            </div>

            <p>
              Your email account has been successfully confirmed.
            </p>

            <h4 class="title">
                You will be receiving an email shortly by our Admin if your registration has been approved or not.
            </h4>
            <small> 
                If you have not yet receive the email, please check your inbox or your spam folder.
            </small>
            {!! Html::link(route('client.login'), 'Click here to Login'
                , array(
                    'class' => 'btn btn-blue'
                ) 
            ) !!}
        </div> 
    </div> 
</div>