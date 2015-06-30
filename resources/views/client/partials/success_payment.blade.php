@extends('client.app')

@section('navbar')
	@include('client.partials.main-nav')
@stop

@section('content')
<div class="container dshbrd-con" ng-cloak>
	<div class="form-narrow form-style">
		<div class="content-title">
			<div class="pull-left title-main-content">
				<span>Successful Payment</span>
			</div>
		</div>

		<div class="module-container">
			<div class="logo-container">
				{!! Html::image('images/logo-md.png') !!}
			</div>

			<div class="module-container">
				<p class="alert alert-success">You have successfully completed the payment process.</p>
			</div>
		
			<div class="btn-container">
			{!! Html::link(route('client.principal.payment.index'), 'View Payment List'
				, array(
					'class' => 'btn btn-blue btn-medium'
					, 'ng-if' => "user.role == 'Principal'"
				)
			) !!}

			{!! Html::link(route('client.parent.payment.index'), 'View Payment List'
				, array(
					'class' => 'btn btn-blue btn-medium'
					, 'ng-if' => "user.role == 'Parent'"
				)
			) !!}

			</div>
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