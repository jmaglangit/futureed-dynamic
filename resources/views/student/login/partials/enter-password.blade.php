<div class="login-container form-style enter-pass-con form-select-password" ng-if="login.active_enter_password">
	<div ng-if="!locked">
		<div class="title">Please Select Your Picture Password</div>

		<div class="alert alert-danger" ng-if="login.errors">
			<p ng-repeat="error in login.errors" > 
				{! error !}
			</p>
		</div>

		<div class="form_content">
			<ul class="form_password list-unstyled list-inline">
				<li class="item col-xs-4" ng-repeat="item in image_pass" ng-click="login.selectPassword($event)">
					<img ng-src="{! item.url !}" class="login-img" alt="{! item.name !}">
					<input type="hidden" id="image_id" name="image_id" value="{! item.id !}">
				</li>
			</ul>
		</div>

		<div class="btn-container">
			{!! Form::button('Cancel'
				, array(
					'class' => 'btn btn-gold btn-medium'
					, 'ng-click' => 'login.cancelLogin()'
				)
			) !!}
		</div>
	</div>
</div>
  