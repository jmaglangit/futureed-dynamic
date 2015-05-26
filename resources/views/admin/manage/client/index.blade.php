@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageClientController as client" ng-cloak>
  		
  		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				<div template-directive template-url="{!! route('admin.manage.client.partials.side_nav') !!}"></div>
			</div>	        

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.list_client_form') !!}"></div>

			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.add_client_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.client_details_form') !!}"></div>
			
			<div class="client-content" template-directive template-url="{!! route('admin.manage.client.partials.edit_email_form') !!}"></div>	
		</div>		
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/constants/manage_client_constants.js')!!}
	{!! Html::script('/js/admin/manage_client.js')!!}
	{!! Html::script('/js/admin/controllers/manage_client_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_client_service.js')!!}
@stop