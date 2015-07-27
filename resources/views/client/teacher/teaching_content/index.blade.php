@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageTeacherContentController as content" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="content.setActive()">
			<div template-directive template-url="{!! route('client.teacher.teaching_content.partials.list_content_form') !!}"></div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_teacher_content_controller.js')!!}
	{!! Html::script('/js/client/services/manage_teacher_content_service.js')!!}
	
	{!! Html::script('/js/common/validation_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/common/search_service.js')!!}
@stop