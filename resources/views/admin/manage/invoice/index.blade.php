@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManageInvoiceController as invoice" ng-cloak>

		<div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')
			</div>
			<div class="client-content" template-directive template-url="{!! route('admin.manage.invoice.partials.invoice_list') !!}"></div>
			<div class="client-content" template-directive template-url="{!! route('admin.manage.invoice.partials.view_invoice') !!}"></div>
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/manage_invoice_controller.js')!!}
	{!! Html::script('/js/admin/services/manage_invoice_service.js')!!}
@stop