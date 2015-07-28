@extends('student.app')

@section('content')
    <div class="container login student-fnt" ng-cloak>
        <div  ng-class="{ 'col-md-8 col-md-offset-2': enter_pass && !locked, 'col-md-6 col-md-offset-3': !enter_pass || locked }" >
            <div class="form-style" ng-init="checkEmail('{!! $email !!}')">
            @include('student.login.account-locked')
            @include('student.login.enter-password')

                <div ng-show="!locked && !enter_pass">
                    {!! Form::open(array('id' => 'login_form')) !!}
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
                                    , 'ng-click' => 'validateUser()'
                                )
                            ) !!}
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

{!! Html::script('/js/student/login.js') !!} 

@stop
