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
		<div class="alert alert-error" ng-if="admin.errors">
			<p ng-repeat="error in admin.errors track by $index">
				{! error !}
			</p>
		</div>
		<div class="form-group">
			<label class="col-xs-3 control-label">Password <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::password('new_password',
						[
							'placeholder' => 'Password'
							, 'ng-model' => 'admin.change.new_password'
							, 'ng-class' => "{ 'required-field' : admin.fields['new_password'] }"
							, 'class' => 'form-control'
						]
					) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-3 control-label">Confirm Password <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::password('confirm_password',
						[
							'placeholder' => 'Password'
							, 'ng-model' => 'admin.change.confirm_password'
							, 'ng-class' => "{ 'required-field' : admin.fields['confirm_password'] }"
							, 'class' => 'form-control'
						]
					) !!}
			</div>
		</div>
		<div class="btn-container col-xs-7 col-xs-offset-2">
			{!! Form::button('Reset'
				, array(
					'class' => 'btn btn-blue btn-medium'
					, 'ng-click' => "admin.resetPassword()"
				)
			) !!}

			{!! Form::button('Cancel'
				, array(
					'class' => 'btn btn-gold btn-medium'
					, 'ng-click' => "admin.setActive(futureed.ACTIVE_VIEW, admin.record.id)"
				)
			) !!}
		</div>
	</div>
	<div class="col-xs-6 col-xs-offset-3" ng-if="admin.reset_success">
		<div class="form-style form-narrow">
			<div class="logo-container">
				<div class="roundcon">					
					<span><i class="fa fa-5x fa-check"></i></span>
				</div>
			</div>
			<p class="text">
				<strong>Success!</strong>
				<br/>An email has been sent to {! admin.record.email !} with the password that you have set.
			</p>

			<div class="btn-container">
				{!! Form::button('View Profile',
					array(
						'class' => 'btn btn-blue'
						, 'ng-click' => 'admin.setActive(futureed.ACTIVE_VIEW, admin.record.id)'
					)
				) !!}
			</div>
		</div>
	</div>
</div>