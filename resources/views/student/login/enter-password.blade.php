<div class="enter-pass-con form-select-password" ng-if="enter_pass">
	<div ng-if="!locked">
		<div class="title">Please Select Your Picture Password</div>

		<div class="alert alert-danger" ng-if="errors">
			<p ng-repeat="error in errors" > 
				{! error !}
			</p>
		</div>

		{!! Form::open(array('id' => 'password_form', 'method' => 'POST', 'route' => 'student.login.process')) !!}
			<div class="form_content">
				<ul class="form_password list-unstyled list-inline">
					<li class="item col-xs-4" ng-repeat="item in image_pass" ng-click="selectPassword($event)">
						<img ng-src="{! item.url !}" class="login-img" alt="{! item.name !}">
						<input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
					</li>
				</ul>
			</div>
			<input type="hidden" name="user_data" />

			<div class="btn-container">
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => 'cancelLogin()'
					)
				) !!}
			</div>
		{!! Form::close() !!}
	</div>
</div>
  