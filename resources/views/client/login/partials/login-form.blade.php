<div ng-if="login.active_login">
	<div class="col-xs-5">
		<div class="login-container form-style">
			<div class="pull-right">
				@include('common.language-option')
			</div>
			<div class="title">{!! trans('messages.login_to_your_account') !!}</div>
			
			<div class="alert alert-danger" style="text-align:center;" ng-if="login.errors">
				<p ng-repeat="error in login.errors"> 
					{! error !}
				</p>
			</div>

		    <div class="alert alert-danger" ng-if="login.error_msg">
		        <p ng-repeat="error_msg in login.error_msg.message">
		            {! error_msg !}
		        </p>
		    </div>

			{!! Form::open(
				array(
					'id' => 'login_form'
					, 'route' => 'client.login.process'
					, 'method' => 'POST'
				)
			) !!}
			<div class="input">
				<div class="icon">
					<i class="fa fa-user"></i>
				</div>
				{!! Form::text('login', ''
					, array(
						'placeholder' => trans('messages.email_or_username')
						, 'ng-model' => 'login.username'
						, 'autocomplete' => 'off'
						, 'class' => 'font-size-16'
					)
				) !!}
			</div>

			<div class="input">
				<div class="icon">
					<i class="fa fa-lock"></i>
				</div>
				{!! Form::password('password'
					, array(
						'placeholder' => trans('messages.password')
						, 'ng-model' => 'login.password'
						, 'class' => 'font-size-16'
					)
				) !!}
			</div>

			<div class="title">{!! trans('messages.role') !!}</div>
		
			<div class="input">
				<div class="icon">
					<i class="fa fa-group"></i>
				</div>
				{!! Form::select('role'
					, array(
						'' => trans('messages.select_role')
						, 'Parent' => trans('messages.parent')
						, 'Teacher' => trans('messages.teacher')
						, 'Principal' => trans('messages.principal')
					)
					, ''
					, array(
						'class' => 'form-control font-size-16'
						, 'ng-model' => 'login.role'
					)
				) !!}
			</div>

			{!! Form::hidden('user_data', ''
				, array(
					'ng-model' => 'user_data'
				)
			) !!}
		
			<div class="form-group">
				{!! Form::button(trans('messages.login')
					, array(
						'class' => 'btn btn-blue'
						, 'ng-click' => 'login.clientLogin()'
					)
				) !!}
			</div>

			<div class="form-group login-divider">
				<em>{!! trans('messages.or') !!}</em>
			</div>

			<div class="row form-group">
				<div class="col-xs-6"> 
					<button type="button" class="btn btn-fb"
						ng-click="login.loginViaFacebook()">
							<i class="fa fa-facebook"></i> {!! trans('messages.sign_via_fb') !!}
					</button>
				</div>

				<div class="col-xs-6"> 
					<button id="btn-google" type="button" class="btn btn-google" ng-init="login.googleInit()"> 
						<span><img src="/images/icons/google-logo.png" /></span>
						<span>{!! trans('messages.sign_via_google') !!}</span> 
					</button>
				</div>
			</div>

			<div class="text-group">
				<small>{!! trans('messages.client_not_a_client') !!}</small>
				<small>{!! trans('messages.click') !!} 

				{!! Html::link(
					route('student.login')
					, trans('messages.here'))
				!!}

				{!! trans('messages.for_student_site') !!}
				</small>     
			</div>  

			<div class="text-group">
				<small>
					{!! Html::link(route('client.login.forgot_password'), trans('messages.forgot_your_password')) !!}
				</small>  
			</div>

			<p>
				{!! Html::link(route('client.registration'), trans('messages.sign_up')
					, array(
						'class' => 'btn btn-gold'
					)
				) !!}
			</p>

			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-7 bulletin" ng-init="getAnnouncement()">
		<h2 class="title">{!! trans('messages.client_bulletin_board') !!}</h2>
		<hr />
		<h4 class="announce-title">
			<i class="fa fa-clock-o"></i>
			{! display_date | date:'MMMM dd, yyyy' !}
		</h4>
		<br />
		<p>{! announce.announcement !}</p>
	</div>
</div>