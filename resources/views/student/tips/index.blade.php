@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-init="backgroundClass()" ng-controller="TipsController as tips" ng-cloak>

		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div ng-if="user.class_id">
			<div ng-controller="StudentClassController as class" template-directive template-url="{!! route('student.partials.tips_help_bar') !!}"></div>
		</div>
		
		<div class="wrapr" ng-init="tips.setActive()"> 
			<div ng-init="tips.setTipView('{!! $id !!}', '{!! $class_id !!}')"></div>

			<div template-directive template-url="{!! route('student.tips.partials.list') !!}"></div>

			<div template-directive template-url="{!! route('student.tips.partials.detail') !!}"></div>
		</div>
	</div>
@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_class_controller.js')!!}
	{!! Html::script('/js/student/controllers/student_tips_controller.js')!!}
	
	{!! Html::script('/js/student/services/student_class_service.js')!!}
	{!! Html::script('/js/student/services/student_tips_service.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
	{!! Html::script('/js/student/class.js')!!}
@stop