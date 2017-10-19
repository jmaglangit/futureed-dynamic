@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
<div class="container dshbrd-con" ng-controller="StudentPaymentController as payment" ng-init="payment.updateBackground();" ng-cloak>
	<div class="form-narrow form-style">
		<div class="content-title">
			<div class="pull-left title-main-content">
				<span>{!! trans('messages.successful_payment') !!}</span>
			</div>
		</div>

		<div class="module-container">
			<div class="logo-container">
				{!! Html::image('images/logo-md.png') !!}
			</div>

			<div class="module-container">
				<p class="alert alert-success">{!! trans('messages.successful_payment_msg') !!}</p>
			</div>
		
			<div class="btn-container">
				{!! Html::link(route('student.payment.index'), trans('messages.view_payment_list')
					, array(
						'class' => 'btn btn-blue btn-medium'
					)
				) !!}
			</div>
		</div>
	</div>
</div>

@stop

@section('scripts')
	{!! Html::script('/js/student/controllers/student_payment_controller.js' . '?size=' . File::size(public_path('/js/student/controllers/student_payment_controller.js')))!!}
	{!! Html::script('/js/student/services/student_payment_service.js' . '?size=' . File::size(public_path('/js/student/services/student_payment_service.js')))!!}

	{!! Html::script('/js/common/search_service.js' . '?size=' . File::size(public_path('/js/common/search_service.js')))!!}
	{!! Html::script('/js/common/table_service.js' . '?size=' . File::size(public_path('/js/common/table_service.js')))!!}
@stop