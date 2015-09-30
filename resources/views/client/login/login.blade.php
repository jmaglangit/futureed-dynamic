@extends('client.app')

@section('content')
<div class="container login" ng-controller="LoginController as login" 
	ng-init="login.initMediaIds('{!! env('FB_APP_ID') !!}', '{!! env('GL_CLIENT_ID') !!}')" ng-cloak>
	
	{!! Form::open(array('id' => 'process_form', 'method' => 'POST', 'route' => 'client.login.process')) !!}
		{!! Form::hidden('user_data', '') !!}
	{!! Form::close() !!}

	<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
	
	<div template-directive template-url="{!! route('client.login.login_form') !!}"></div>

	<div template-directive template-url="{!! route('client.login.confirm_media') !!}"></div>
</div>
@endsection

@section('scripts')
	{!! Html::script('//connect.facebook.net/en_US/sdk.js') !!}
	{!! Html::script('https://apis.google.com/js/platform.js') !!}
	{!! Html::script('https://apis.google.com/js/client.js') !!}

	{!! Html::script('/js/common/validation_service.js') !!}

	{!! Html::script('/js/student/controllers/media_login_controller.js') !!}
	{!! Html::script('/js/student/services/media_login_service.js') !!}

	{!! Html::script('/js/client/controllers/login_controller.js') !!}
	{!! Html::script('/js/client/services/login_service.js') !!}

	{!! Html::script('/js/client/services/profile_service.js') !!}
@stop