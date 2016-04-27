<div class="login-container form-style" ng-if="login.active_login">
    {!! Form::open(array('ng-submit' => 'login.validateUser($event)')) !!}
    <div class="logo-container">
        {!! Html::image('/images/logo-md-beta.png') !!}
    </div>

    <div class="title title-student">Student Login</div>

    <div class="alert alert-danger" ng-if="login.errors">
        <p ng-repeat="error in login.errors">
            {! error !}
        </p>
    </div>

    <div class="form-group">
        {!! Form::text('username', ''
            , array(
                'class' => 'form-control'
                , 'placeholder' => 'Enter Your Username or Email'
                , 'autocomplete' => 'off'
                , 'ng-model' => 'login.manual.username'
            )
        ) !!}
    </div>
    <div class="form-group">
        {!! Form::button('Next'
            , array(
                'id' => 'validate_user_btn'
                , 'class' => 'btn btn-maroon'
                , 'ng-click' => 'login.validateUser($event)'
            )
        ) !!}
    </div>

    <div class="form-group login-divider">
        <em>or</em>
    </div>

    <div class="row form-group">
        <div class="col-xs-6">
            <button type="button" class="btn btn-fb"
                    ng-click="login.loginViaFacebook()">
                <i class="fa fa-facebook"></i> Sign in via Facebook
            </button>
        </div>

        <div class="col-xs-6">
            <button id="btn-google" type="button" class="btn btn-google" ng-init="login.googleInit()">
                <span><img src="/images/icons/google-logo.png"/></span>
                <span>Sign in with Google</span>
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="text-group">
        <small>Not a Student?</small>
        <small>Click {!! Html::link(route('client.login'), 'here') !!} for Parent / Teacher / School Site</small>
    </div>

    <div class="text-group">
        <small>
            {!! Html::link(route('student.login.forgot_password'), 'Forgot your picture password?'
                , array(
                    'class' => 'student-forgot'
                )
            ) !!}
        </small>

        <p>
            {!! Html::link(route('student.registration'), 'Sign Up'
                , array(
                    'class' => 'btn btn-gold'
                )
            ) !!}
        </p>
    </div>
</div>