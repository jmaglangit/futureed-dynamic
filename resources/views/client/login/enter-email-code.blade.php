@extends('client.app')

@section('content')
	<div class="container login" ng-cloak>

		<div class="client-container form-style">
			<div class="form_content">
				<div class="title">{!! trans('messages.confirm_email') !!}</div>

				<div class="roundcon">
					<i class="fa fa-check fa-5x img-rounded text-center"></i>
				</div>
				<div>
					<p class="text">
						{!! trans('messages.client_login_proceed_my_profile') !!}
					</p>
				</div>

				<div class="btn-container">
					<a href="{!! route('client.profile.index') !!}" class="btn btn-blue btn-large"><i class="fa fa-home"></i> {!! trans('messages.forgot_home') !!} </a>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')

@stop