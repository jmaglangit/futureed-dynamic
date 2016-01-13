@extends('admin.app')

@section('navbar')
	@include('admin.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="SalesController as sale" 
		ng-init="sale.setActive()" ng-cloak>
		<div class="wrapr">
			<div class="client-nav side-nav">
				@include('admin.partials.dshbrd-side-nav')				
			</div>
			<div class="client-content">
				<div class="content-title">
					<div class="title-main-content">
						<span><i class="fa fa-gear"></i> Price & Discounts</span>
					</div>
				</div>

				
				<ul class="nav nav-pills nav-admin">
					<li ng-class="{ 'active' : sale.active_price_settings }">
						<a ng-click="sale.setActive('price_settings')" href="javascript:void(0)"><span><i class="fa fa-dollar"></i>Price Settings</span></a></li>
					<li ng-class="{ 'active' : sale.active_client_discount }">
						<a ng-click="sale.setActive('client_discount')" href="javascript:void(0)"><span><i class="fa fa-tags"></i>Client Discount</span></a></li>
					<li ng-class="{ 'active' : sale.active_bulk_settings }">
						<a ng-click="sale.setActive('bulk_settings')" href="javascript:void(0)"><span><i class="fa fa-database"></i>Percentage Settings</span></a></li>
				</ul>
					
				<div ng-if="sale.active_price_settings" ng-controller="ManagePriceController as price" ng-init="price.setActive()" 
					template-directive template-url="{!! route('admin.manage.price.partials.price_settings') !!}"></div>

				<div ng-if="sale.active_client_discount" ng-controller="ManageDiscountController as discount" ng-init="discount.setActive()" 
					template-directive template-url="{!! route('admin.manage.price.partials.client_discount') !!}"></div>
				
				<div ng-if="sale.active_bulk_settings" ng-controller="ManageBulkController as bulk" ng-init="bulk.setActive()" 
					template-directive template-url="{!! route('admin.manage.price.partials.bulk_discount') !!}"></div>

			</div>
		</div>
	</div>
@stop
	
@section('scripts')
	{!! Html::script('/js/admin/controllers/sales_controller.js')!!}
	{!! Html::script('/js/admin/services/sales_service.js')!!}

	{!! Html::script('/js/admin/controllers/manage_price_controller.js')!!}
	{!! Html::script('/js/admin/controllers/manage_discount_controller.js')!!}
	{!! Html::script('/js/admin/controllers/manage_bulk_controller.js')!!}
	
	{!! Html::script('/js/common/table_service.js')!!}
@stop