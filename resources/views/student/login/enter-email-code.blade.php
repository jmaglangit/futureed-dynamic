@extends('student.app')

@section('content')
<div class="container login" ng-cloak>

	<div class="col-md-9 col-md-offset-2 form-style">
		{!! Form::open(
			array(
				'id' => 'confirm_email_form'
			)
		)!!}
			<div class="form_content">
				<div class="title">
					<h3>Confirming Email Address</h3>
				</div>

				<div class="roundcon">
					<i class="fa fa-exclamation fa-5x img-rounded text-center"></i>
				</div>
				
				<h3>To confirm your new Email Address, follow these steps:</h3>
				
				<div class="col-md-6 col-md-offset-3">
					<ul class="list-step">
						<li>
							<p>Please Login</p>
						</li>
						<li>
							<p>Go to My Profile</p>
						</li>
						<li>
							<p>Click on Confirm Email Address</p>
						</li>
					</ul>
				</div>

				<div class="btn-container">
					<a href="{!! route('student.profile.index') !!}" class="btn btn-gold btn-large"><i class="fa fa-home"></i> Home </a>
				</div>
			</div>
		{!! Form::close() !!}
	</div>
</div>
@endsection

@section('scripts')

@stop