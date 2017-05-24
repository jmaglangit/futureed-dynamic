@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div id="module-cont" class="container dshbrd-con" ng-controller="ManageQuestionTempController as template" ng-cloak>

		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="template.setActive()">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.question_template.partials.list_question_template') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.question_template.partials.add_question_template') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.question_template.partials.view_question_template') !!}"></div>
		
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_question_temp_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_question_temp_service.js')!!}

	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.min.js')!!}
	{!! Html::script('//cdnjs.cloudflare.com/ajax/libs/flot/0.8.3/jquery.flot.resize.min.js')!!}
@stop
@stop