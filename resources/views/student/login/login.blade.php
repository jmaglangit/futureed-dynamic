@extends('student.app')

@section('content')
    <div class="container login student-fnt" ng-cloak>
        <div  ng-class="{ 'col-md-8 col-md-offset-2': enter_pass && !locked, 'col-md-6 col-md-offset-3': !enter_pass || locked }" >
            <div class="form-style" ng-init="checkEmail('{!! $id !!}')">
            @include('student.login.account-locked')
            @include('student.login.enter-password')

                <div ng-show="!locked && !enter_pass">
                    {!! Form::open(array('id' => 'login_form', 'ng-submit' => 'validateUser($event)')) !!}
                        <div class="logo-container">
                            {!! Html::image('/images/logo-md.png') !!}
                        </div>

                    <div class="title title-student">Student login</div>

                        <div class="alert alert-danger" ng-if="errors">
                            <p ng-repeat="error in errors" > 
                                {! error !}
                            </p>
                        </div>

                        <div class="form-group">
                            {!! Form::text('username', ''
                                , array(
                                    'class' => 'form-control'
                                    , 'placeholder' => 'Enter Your Username or Email'
                                    , 'autocomplete' => 'off'
                                    , 'ng-model' => 'username'
                                )
                            ) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::button('Next' 
                                , array(
                                    'id' => 'validate_user_btn'
                                    , 'class' => 'btn btn-maroon'
                                    , 'ng-click' => 'validateUser($event)'
                                )
                            ) !!}
                        </div>
                        <div class="form-group login-divider">
                        	<em>or</em>
                        </div>

                        <div class="row form-group" ng-controller="MediaLoginController as media">
                            <div class="col-xs-6"> 
                                <button type="button" class="btn btn-fb"
                                	ng-click="media.loginViaFacebook()">
                                		<i class="fa fa-facebook"></i> Login via Facebook
                                </button>
                            </div>

                            <div class="col-xs-6"> 
								<button id="btn-google" type="button" class="btn btn-google" ng-init="media.googleInit()"> 
									<span><img src="/images/icons/google-logo.png" /></span>
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
            </div>
        </div>
    </div>
@stop

@section('scripts')
	{!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
    {!! Html::script('https://apis.google.com/js/platform.js') !!}

    {!! Html::script('/js/student/login.js') !!} 
    {!! Html::script('/js/student/controllers/media_login_controller.js') !!} 
    {!! Html::script('/js/student/services/media_login_service.js') !!} 
@stop
