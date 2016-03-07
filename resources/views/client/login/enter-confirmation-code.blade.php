@extends('client.app')

@section('content')
    <div class="container login" ng-controller="LoginController as login"
         ng-init="login.setRegistrationStatus('{!! $email !!}','{!! $code !!}')" ng-cloak>

        {!! Form::open(array('id' => 'process_form', 'method' => 'POST', 'route' => 'client.login.process')) !!}
            {!! Form::hidden('user_data', '') !!}
        {!! Form::close() !!}

        <div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

        <div class="client-container form-style">

            <div ng-if="!login.confirmed">
                <div class="title">Confirm Your Email Address</div>

                <div class="alert alert-danger" ng-if="login.errors">
                    <p ng-repeat="error in login.errors">
                        {! error !}
                    </p>
                </div>

                <div class="form_content">

                    <div ng-if="!login.resent">
                        <div class="roundcon" ng-if="!login.errors">
                            <i class="fa fa-check fa-5x img-rounded text-center"></i>
                        </div>
                        <div class="roundcon" ng-if="login.errors">
                            <i class="fa fa-close fa-5x img-rounded text-center"></i>
                        </div>

                    </div>

                    <div ng-if="login.resent">
                        <div class="roundcon">
                            <i class="fa fa-refresh fa-5x img-rounded text-center"></i>
                        </div>

                        <p>
                            A new confirmation code has been sent to your email account.
                        </p>
                        <small>Please check your inbox or your spam folder for the email. The email contains a
                            confirmation code that you need to input below.
                        </small>
                    </div>

                </div>
            </div>


            <div ng-if="login.confirmed">
                <div class="title">
                    <h3>Success!</h3>
                </div>

                <div class="form_content">
                    <div class="roundcon">
                        <i class="fa fa-check fa-5x img-rounded text-center"></i>
                    </div>

                    <p>Your email account has been successfully confirmed.</p>

                </div>
            </div>
        </div>
    </div>
    </div>
@endsection

@section('scripts')
    {!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
    {!! Html::script('https://apis.google.com/js/platform.js') !!}
    {!! Html::script('https://apis.google.com/js/client.js') !!}

    {!! Html::script('/js/common/validation_service.js')!!}

    {!! Html::script('/js/student/controllers/media_login_controller.js') !!}
    {!! Html::script('/js/student/services/media_login_service.js') !!}

    {!! Html::script('/js/client/controllers/login_controller.js') !!}
    {!! Html::script('/js/client/services/login_service.js') !!}
    {!! Html::script('/js/client/services/profile_service.js') !!}
    {!! Html::script('/js/client/login.js') !!}
@stop