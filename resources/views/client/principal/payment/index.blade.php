@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
	<div class="container dshbrd-con" ng-controller="ManagePrincipalPaymentController as payment" ng-init="payment.active = '{!! $active !!}'" ng-cloak>
		<div template-directive template-url="{!! route('client.partials.base_url') !!}"></div>

		<div class="wrapr" ng-init="payment.setActive()" >
			<div class="client-nav side-nav">
				@include('client.partials.dshbrd-side-nav')			
			</div>
			<div class="client-content">
				<div template-directive template-url="{!! route('client.principal.payment.partials.payment_form') !!}"></div>
			
				<div template-directive template-url="{!! route('client.principal.payment.partials.add_payment_form') !!}"></div>

				<div template-directive template-url="{!! route('client.principal.payment.partials.view_payment_form') !!}"></div>
			</div>
			
		</div>
	</div>

@stop
	
@section('scripts')
	{!! Html::script('/js/client/controllers/manage_principal_payment_controller.js')!!}
	{!! Html::script('/js/client/services/manage_principal_payment_service.js')!!}
	{!! Html::script('/js/client/services/profile_service.js')!!}

	{!! Html::script('/js/common/search_service.js')!!}
	{!! Html::script('/js/common/table_service.js')!!}
@stop