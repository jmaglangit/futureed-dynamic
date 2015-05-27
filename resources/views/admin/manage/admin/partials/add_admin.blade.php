<div ng-if="admin.add_admin">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Admin User</span>
		</div>
	</div>

	{!! Form::open([
			'id' => 'add_admin_form',
			'class' => 'form-horizontal'
		]) 
	!!}
	<div class="form-content col-xs-12">
		<div class="alert alert-danger" ng-if="admin.errors">
			<p ng-repeat="error in admin.errors track by $index">
				{! error !}
			</p>
		</div>
		<div class="alert alert-danger" ng-if="admin.p_error">
			<p>
				{! admin.p_error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="admin.is_success">
			<p>
				{! admin.is_success !}
			</p>
		</div>
		<fieldset>
			<legend class="legend-name-mid">
				User Credentials
			</legend>
			<div class="form-group">
				<label class="col-xs-2 control-label" id="username">Username <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('username', '',
						[
							'placeholder' => 'Username',
							'ng-model' => 'admin.reg.username',
							'ng-model-options' => "{ debounce : {'default' : 1000} }",
							'ng-change' => 'admin.checkUsernameAvailability()',
							'class' => 'form-control'
						]
					) !!}

					<div>
					<span class="error-msg-con" ng-if="admin.val.a_error">{! admin.val.a_error !}</span>
					<i class="fa fa-spinner fa-spin" ng-if="admin.a_loading"></i>
					<span ng-if="admin.a_success" class="error-msg-con success-color">Username is available.</span>
				</div>
				</div>
				<label class="col-xs-2 control-label" id="role">Role <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::select('admin_role',
						[
							'' => '-- Select Role --',
							'Admin' => 'Admin',
							'Super Admin' => 'Super Admin'
						], null,
						['ng-model' => 'admin.reg.admin_role', 'class' => 'form-control']
					)!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label" id="email">Email <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email', '',
						[
							'placeholder' => 'Email',
							'ng-model' => 'admin.reg.email',
							'ng-model-options' => "{ debounce : {'default' : 1000} }",
							'ng-change' => 'admin.checkEmailAvailability()',
							'class' => 'form-control'
						]
					) !!}

					<div>
					<span class="error-msg-con" ng-if="admin.val.b_errors">{! admin.val.b_errors !}</span>
					<i class="fa fa-spinner fa-spin" ng-if="admin.b_loading"></i>
					<span ng-if="admin.b_success" class="error-msg-con success-color">Email is available.</span>
				</div>
				</div>
				<label class="col-xs-2 control-label" id="status">Status <span class="required">*</span></label>
	                <div class="col-xs-4">
	                	<div class="col-xs-6 checkbox">	                				
	                		<label>
	                		{!! Form::radio('status','Enabled', true) 
	                				!!}
	                		<span class="lbl padding-8">Enabled</span>
	                		</label>
	                	</div>
	                	<div class="col-xs-6 checkbox">
	                		<label>
	                		{!! Form::radio('status', 'Disabled', false) 
	                		!!}
	                		<span class="lbl padding-8">Disabled</span>
	                		</label>
	                	</div>
	                </div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label">Password <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::password('password',
						[
							'class' => 'form-control',
							'ng-model' => 'admin.reg.password',
							'placeholder' => 'Password'
						]) 
					!!}
				</div>
				<label class="col-xs-2 control-label">Confirm Password <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::password('password_c',
						[
							'class' => 'form-control',
							'ng-model' => 'admin.reg.password_c',
							'placeholder' => 'Confirm Password'
						]) 
					!!}
				</div>
			</div>
		</fieldset>
		<fieldset>
			<legend class="legend-name-mid">
				Personal Information
			</legend>
			<div class="form-group">
				<label class="col-xs-2 control-label">First Name <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('first_name','',
						[
							'class' => 'form-control',
							'ng-model' => 'admin.reg.first_name',
							'placeholder' => 'First Name'
						]
					) !!}
				</div>
				<label class="col-xs-2 control-label">Last Name <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('last_name','',
						[
							'class' => 'form-control',
							'ng-model' => 'admin.reg.last_name',
							'placeholder' => 'Last Name'
						]
					) !!}
				</div>
			</div>
			<div class="btn-container col-xs-6 col-xs-offset-3">
				<button class="btn btn-blue btn-medium" id="proceed-btn" type="button" ng-click="admin.saveAdmin()">Save</button>
				<button class="btn btn-gold btn-medium" ng-click="admin.cancelAdd()">Cancel</button>
			</div>
		</fieldset>
	</div>
</div>