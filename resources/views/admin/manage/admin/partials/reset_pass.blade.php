<div ng-if="admin.active_edit_pass">
	<div class="content-title">
		<div class="title-main-content">
			<span>Reset Password</span>
		</div>
	</div>
	{!! Form::open([
			'id' => 'reset_pass_form',
			'class' => 'form-horizontal'
		]) 
	!!}
	<div class="form-content col-xs-12" ng-if="!admin.reset_success">
		<div class="alert alert-danger" ng-if="admin.errors">
			<p ng-repeat="error in admin.errors track by $index">
				{! error !}
			</p>
		</div>
		<div class="alert alert-danger" ng-if="admin.r_error">
			<p>
				{! admin.r_error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="admin.is_success">
			<p>
				{! admin.is_success !}
			</p>
		</div>
		<div class="form-group">
			<label class="col-xs-2 control-label">Password <span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::password('password',
						[
							'placeholder' => 'Password',
							'ng-model' => 'admin.password',
							'class' => 'form-control'
						]
					) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-2 control-label">Confirm Password <span class="required">*</span></label>
			<div class="col-xs-4">
				{!! Form::password('password',
						[
							'placeholder' => 'Password',
							'ng-model' => 'admin.password_c',
							'class' => 'form-control'
						]
					) !!}
			</div>
		</div>
		<div class="btn-container">
			{!! Form::button('Reset'
				, array(
					'class' => 'btn btn-blue btn-medium'
					, 'ng-click' => "admin.resetPass()"
				)
			) !!}

			{!! Form::button('Cancel'
				, array(
					'class' => 'btn btn-gold btn-medium'
					, 'ng-click' => "admin.setManageAdminActive('view')"
				)
			) !!}
		</div>
	</div>
	<div class="col-xs-6 col-xs-offset-3" ng-if="admin.reset_success">
		<div class="form-style form-narrow">
			<div class="logo-container">
				<div class="roundcon">					
					<span><i class="fa fa-check-circle-o" style="font-size:5em;"></i></span>
				</div>
			</div>
			<p class="text">
				<strong>Success!</strong>
				<br/>An email has been sent to {! admin.admininfo.user.email !} with the password that you have set.
			</p>
		</div>
	</div>
</div>