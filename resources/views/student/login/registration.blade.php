@extends('student.app')

@section('content')
<div class="container login student-fnt" ng-controller="StudentLoginController as login" ng-init="login.checkRegistration('{!! $id !!}', '{!! $registration_token !!}')">
	
	{!! Form::open(array('id' => 'process_form', 'method' => 'POST', 'route' => 'student.login.process')) !!}
        {!! Form::hidden('user_data', '') !!}
    {!! Form::close() !!}
	
	<div template-directive template-url="{!! route('student.partials.base_url') !!}"></div>

	<div template-directive template-url="{!! route('student.login.registration_form') !!}"></div>

	<div template-directive template-url="{!! route('student.login.registration_success') !!}"></div>

	<div template-directive template-url="{!! route('student.login.confirm_media') !!}"></div>

	@include('student.login.terms-and-condition')
	
	@include('student.login.privacy-policy')
</div>
@stop

@section('scripts')
	{!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
	{!! Html::script('https://apis.google.com/js/platform.js') !!}
	{!! Html::script('https://apis.google.com/js/client.js') !!}

	{!! Html::script('/js/common/validation_service.js') !!}

	{!! Html::script('/js/student/controllers/media_login_controller.js') !!}
	{!! Html::script('/js/student/services/media_login_service.js') !!} 

	{!! Html::script('/js/student/controllers/login_controller.js') !!}
	{!! Html::script('/js/student/services/login_service.js') !!}

	{!! Html::script('/js/student/login.js') !!}
@stop