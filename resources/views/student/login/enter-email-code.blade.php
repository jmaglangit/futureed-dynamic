@extends('student.app')

@section('content')
	<div class="container login" ng-cloak>
		<div class="login-container form-style">
			<div class="form_content">
				<div class="title">
					<h3>{!! trans('messages.confirm_email') !!}</h3>
				</div>

				<div class="roundcon">
					<i class="fa fa-exclamation fa-5x img-rounded text-center"></i>
				</div>
				
				<h3>{!! trans('messages.confirm_email_msg') !!}:</h3>
				
				<div class="col-md-6 col-md-offset-3">
					<ul class="list-step">
						<li>
							<p>{!! trans('messages.please_login') !!}</p>
						</li>
						<li>
							<p>{!! trans('messages.go_to_my_profile') !!}</p>
						</li>
						<li>
							<p>{!! trans('messages.click_confirm_email') !!}</p>
						</li>
					</ul>
				</div>

				<div class="btn-container">
					<a href="{!! route('student.profile.index') !!}" class="btn btn-gold btn-large"><i class="fa fa-home"></i> {!! trans('messages.forgot_home') !!} </a>
				</div>
			</div>
		</div>
	</div>
@endsection