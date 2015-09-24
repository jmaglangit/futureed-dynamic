@extends('student.app')

@section('content')
    <div class="container login student-fnt" ng-controller="StudentLoginController as login" ng-cloak>
            
        {!! Form::open(array('id' => 'media_form', 'method' => 'POST', 'route' => 'student.login.process')) !!}
            {!! Form::hidden('user_data', '') !!}
        {!! Form::close() !!}

        <div ng-init="checkEmail('{!! $id !!}');">

            <div template-directive template-url="{!! route('student.login.confirm_media') !!}"></div>

            <div template-directive template-url="{!! route('student.login.enter_password') !!}"></div>

            <div template-directive template-url="{!! route('student.login.index_form') !!}"></div>
        </div>
    </div>
@stop

@section('scripts')
    {!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
    {!! Html::script('https://apis.google.com/js/platform.js') !!}

    {!! Html::script('/js/student/controllers/media_login_controller.js') !!}
    {!! Html::script('/js/student/services/media_login_service.js') !!} 

	{!! Html::script('/js/student/controllers/login_controller.js') !!}
    {!! Html::script('/js/student/services/login_service.js') !!}

    {!! Html::script('/js/student/login.js') !!} 
@stop
