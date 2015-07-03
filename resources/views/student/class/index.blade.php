@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')

	<div ng-controller="StudentClassController as class" ng-cloak>

		<div ng-init="backgroundClass()" template-directive template-url="{!! route('student.class.partials.dashbrd-side-nav') !!}"></div>

	</div>
  
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_class_controller.js')!!}
	{!! Html::script('/js/student/services/student_class_service.js')!!}
@stop