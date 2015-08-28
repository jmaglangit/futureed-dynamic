@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageParentContentController as content" ng-init="content.active = '{!! $active !!}'" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="content.setActive()">
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')			
			</div>
			<div class="client-content">
				<div template-directive template-url="{!! route('client.parent.teaching_content.partials.list_content_form') !!}"></div>
			</div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_parent_content_controller.js')!!}
	{!! Html::script('/js/client/services/manage_parent_content_service.js')!!}
@stop