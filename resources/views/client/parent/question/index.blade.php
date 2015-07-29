@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageParentQuestionController as question" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="question.setActive()">
			<div template-directive template-url="{!! route('client.parent.question.partials.list') !!}"></div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_parent_question_controller.js')!!}
	{!! Html::script('/js/client/services/manage_parent_question_service.js')!!}
@stop