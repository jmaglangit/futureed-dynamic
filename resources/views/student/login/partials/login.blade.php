<div class="login-container form-style" ng-if="login.active_login">
    {!! Form::open(array('ng-submit' => 'login.validateUser($event)')) !!}
    <div class="logo-container">
        {!! Html::image('/images/logo-md.png') !!}
    </div>

    <div class="title title-student">{!! trans('messages.student_login') !!}</div>

    <div class="alert alert-danger" ng-if="login.errors">
        <p ng-repeat="error in login.errors">
            {! error !}
        </p>
    </div>

    <div class="form-group">
        {!! Form::text('username', ''
            , array(
                'class' => 'form-control'
                , 'placeholder' => trans('messages.enter_your_username_email')
                , 'autocomplete' => 'off'
                , 'ng-model' => 'login.manual.username'
            )
        ) !!}
    </div>
    <div class="form-group">
        {!! Form::button(trans('messages.next')
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
                <i class="fa fa-facebook"></i> {!! trans('messages.sign_via_fb') !!}
            </button>
        </div>

        <div class="col-xs-6">
            <button id="btn-google" type="button" class="btn btn-google" ng-init="login.googleInit()">
                <span><img src="/images/icons/google-logo.png"/></span>
                <span>{!! trans('messages.sign_via_google') !!}</span>
            </button>
        </div>
    </div>
    {!! Form::close() !!}

    <div class="text-group">
        <small>{!! trans('messages.not_a_student') !!}</small>
        <small>{!! trans('messages.click') !!} {!! Html::link(route('client.login'), trans('messages.here')) !!} {!! trans('messages.for_parent_teacher_school') !!}</small>
    </div>

    <div class="text-group">
        <small>
            {!! Html::link(route('student.login.forgot_password'), trans('messages.forgot_your_pic_password')
                , array(
                    'class' => 'student-forgot'
                )
            ) !!}
        </small>

        <p>
            {!! Html::link(route('student.registration'), trans('messages.sign_up')
                , array(
                    'class' => 'btn btn-gold'
                )
            ) !!}
        </p>
    </div>
</div>