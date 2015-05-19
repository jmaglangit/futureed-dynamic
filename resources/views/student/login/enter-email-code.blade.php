@extends('student.app')

@section('content')
  <div class="container login" ng-controller="ProfileController as profile" ng-cloak>
    <div template-directive template-url="{!! route('student.partials.base_url') !!}"></div>

    <div class="col-md-6 col-md-offset-1 form-style">
      {!! Form::open(
          array(
            'id' => 'confirm_email_form'
          )
      )!!}

      <div class="form_content" ng-if="!profile.email_confirmed">
        <div class="title" ng-if="!profile.resent">Email Confirmation Code Sent</div>
        <div class="title" ng-if="profile.resent">Email Confirmation Code Resent</div>

        <div class="alert alert-danger" ng-if="profile.errors">
            <p ng-repeat="error in profile.errors track by $index" > 
                {! error !}
            </p>
        </div>

        <div ng-if="!profile.resent">
          <div class="roundcon">
            <i class="fa fa-check fa-5x img-rounded text-center"></i>
          </div>
          <div>
            <p class="text">
              <strong>Success!</strong>
              <br /> Please enter the email code to confirm your new email address.
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

            {!! Form::hidden('new_email', $email) !!}
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
          {!! Html::link(route('student.profile.index'), 'View Profile'
            , array(
                'class' => 'btn btn-gold'
            )
        ) !!}
      </div> 
    </div>
    {!! Form::close() !!}
  </div>
</div>
@endsection

@section('scripts')
  {!! Html::script('/js/student/controllers/profile_controller.js') !!}
  {!! Html::script('/js/student/profile.js') !!}
@stop