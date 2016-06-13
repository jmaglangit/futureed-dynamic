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
						<span><i class="fa fa-gear"></i> {!! trans('messages.admin_price_discounts') !!}</span>
					</div>
				</div>

				
				<ul class="nav nav-pills nav-admin">
					<li ng-class="{ 'active' : sale.active_subscription }">
						<a ng-click="sale.setActive(futureed.SUBSCRIPTION)" href="javascript:void(0)"><span><i class="fa fa-dollar"></i>{!! trans('messages.subscription') !!}</span></a></li>
					<li ng-class="{ 'active' : sale.active_subscription_days }">
						<a ng-click="sale.setActive(futureed.SUBSCRIPTION_DAYS)" href="javascript:void(0)"><span><i class="fa fa-calendar-o"></i>{!! trans('messages.subscription_days') !!}</span></a></li>
					<li ng-class="{ 'active' : sale.active_subscription_packages }">
						<a ng-click="sale.setActive(futureed.SUBSCRIPTION_PACKAGES)" href="javascript:void(0)"><span><i class="fa fa-archive"></i>{!! trans('messages.subscription_packages') !!}</span></a></li>
					<li ng-class="{ 'active' : sale.active_client_discount }">
						<a ng-click="sale.setActive(futureed.CLIENT_DISCOUNT)" href="javascript:void(0)"><span><i class="fa fa-tags"></i>{!! trans('messages.admin_client_discount') !!}</span></a></li>
					<li ng-class="{ 'active' : sale.active_bulk_settings }">
						<a ng-click="sale.setActive(futureed.BULK_SETTINGS)" href="javascript:void(0)"><span><i class="fa fa-database"></i>{!! trans('messages.admin_bulk_settings') !!}</span></a></li>
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