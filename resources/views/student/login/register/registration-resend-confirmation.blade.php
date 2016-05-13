<div class="login-container form-style" ng-if="login.active_resend">
    <div class="title">Enter Your Email Address</div>

    <div class="alert alert-danger" ng-if="login.errors">
        <p ng-repeat="error in login.errors" >
            {! error !}
        </p>
    </div>
    <div class="alert alert-success center" ng-if="login.resent">
        <p>Email has been sent to your inbox. Please check.</p>
    </div>
    {!! Form::open(array('id' => 'registration_success_form')) !!}
    <div class="form-group">{!! Form::label('', '') !!}
        {!! Form::text('email', '',
        array(
        'ng-model' => 'login.record.email'
        , 'placeholder' => 'Email'
        , 'autocomplete' => 'off'
        , 'class' => 'form-control')
        ) !!}</div>
    <div class="btn-container">

        {!! Form::button('Resend'
        , array(
        'class' => 'btn btn-gold btn-medium'
        , 'ng-click' => 'login.studentResendConfirmation()'
        , 'ng-if' => 'login.active_resend'
        )
        )!!}
    </div>
    <br/>
    <a href="{!! route('student.login') !!}"><i class="fa fa-home"></i> Home</a>
    {!! Form::close() !!}
</div>
