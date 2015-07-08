@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-init="backgroundClass()" ng-controller="HelpController as help" ng-cloak>

		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="help.setActive()" ng-init="help.setRequestType({!! $request_type !!})"> 
			<div template-directive template-url="{!! route('student.help.partials.list') !!}"></div>

			<div template-directive template-url="{!! route('student.help.partials.detail') !!}"></div>
		</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_help_controller.js')!!}
	{!! Html::script('/js/student/services/student_help_service.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
@stop