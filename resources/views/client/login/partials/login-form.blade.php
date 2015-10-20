<div ng-if="login.active_login">
	<div class="col-xs-5">
		<div class="login-container form-style form-narrow">
			<div class="title">Login to your account</div>
			
			<div class="alert alert-danger" style="text-align:left;" ng-if="login.errors">
				<p ng-repeat="error in login.errors"> 
					{! error !}
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
						'placeholder' => 'Email or Username'
						, 'ng-model' => 'login.username'
						, 'autocomplete' => 'off'
					)
				) !!}
			</div>

			<div class="input">
				<div class="icon">
					<i class="fa fa-lock"></i>
				</div>
				{!! Form::password('password'
					, array(
						'placeholder' => 'Password'
						, 'ng-model' => 'login.password'
					)
				) !!}
			</div>

			<div class="title">ROLE</div>
		
			<div class="input">
				<div class="icon">
					<i class="fa fa-group"></i>
				</div>
				{!! Form::select('role'
					, array(
						'' => '-- Select Role --'
						, 'Parent' => 'Parent'
						, 'Teacher' => 'Teacher'
						, 'Principal' => 'Principal'
					)
					, ''
					, array(
						'class' => 'form-control'
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
				{!! Form::button('Login'
					, array(
						'class' => 'btn btn-blue'
						, 'ng-click' => 'login.clientLogin()'
					)
				) !!}
			</div>

			<div class="form-group login-divider">
				<em>or</em>
			</div>

			<div class="row form-group">
				<div class="col-xs-6"> 
					<button type="button" class="btn btn-fb"
						ng-click="login.loginViaFacebook()">
							<i class="fa fa-facebook"></i> Sign in via Facebook
					</button>
				</div>

				<div class="col-xs-6"> 
					<button id="btn-google" type="button" class="btn btn-google" ng-init="login.googleInit()"> 
						<span><img src="/images/icons/google-logo.png" /></span>
						<span>Sign in with Google</span> 
					</button>
				</div>
			</div>

			<div class="text-group">
				<small>Not a Parent / Teacher / School?</small>
				<small>Click 

				{!! Html::link(
					route('student.login')
					, 'here') 
				!!}

				for Student Site
				</small>     
			</div>  

			<div class="text-group">
				<small>
					{!! Html::link(route('client.login.forgot_password'), 'Forgot your password?') !!}
				</small>  
			</div>

			<p>
				{!! Html::link(route('client.registration'), 'Sign Up'
					, array(
						'class' => 'btn btn-gold fb'
					)
				) !!}
			</p>

			{!! Form::close() !!}
		</div>
	</div>

	<div class="col-xs-7 bulletin" ng-init="getAnnouncement()">
		<h2 class="title">Bulletin Board</h2>
		<hr />
		<h4 class="announce-title">
			<i class="fa fa-clock-o"></i>
			{! display_date | date:'MMMM dd, yyyy' !}
		</h4>
		<br />
		<p>{! announce.announcement !}</p>
	</div>
</div>