@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageParentContentController as content" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="content.setActive()">
			<div template-directive template-url="{!! route('client.parent.teaching_content.partials.list_content_form') !!}"></div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_parent_content_controller.js')!!}
	{!! Html::script('/js/client/services/manage_parent_content_service.js')!!}
@stop