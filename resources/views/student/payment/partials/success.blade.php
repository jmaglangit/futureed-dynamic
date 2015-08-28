@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
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
				{!! Html::link(route('student.payment.index'), 'View Payment List'
					, array(
						'class' => 'btn btn-blue btn-medium'
					)
				) !!}
			</div>
		</div>
	</div>
</div>

@stop