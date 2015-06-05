@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageParentInvoiceController as invoice" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="invoice.setActive('list')" >

			<div template-directive template-url="{!! route('client.parent.invoice.partials.invoice_form') !!}"></div>

		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_parent_invoice_controller.js')!!}
	{!! Html::script('/js/client/services/manage_parent_invoice_service.js')!!}
@stop