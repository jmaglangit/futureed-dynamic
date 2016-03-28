@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="container class-con" ng-controller="StudentClassController as class" ng-init="checkLSP(user.id);class.updateBackground()" ng-cloak>

		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>
		
		<div ng-if="user.class">
			<div template-directive template-url="{!! route('student.partials.tips_help_bar') !!}"></div>
		</div>

		<div class="module-wrapper" ng-init="class.setCurrentClass('{!! $class_id !!}')"> 
			<div template-directive template-url="{!! route('student.class.partials.module_list') !!}"></div>
		</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_class_controller.js')!!}
	{!! Html::script('/js/student/services/student_class_service.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/student/class.js')!!}
@stop