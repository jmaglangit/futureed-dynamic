<div ng-if="admin.active_add">
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
		<div class="alert alert-error" ng-if="admin.errors">
			<p ng-repeat="error in admin.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="admin.success">
			<p ng-repeat="success in admin.success track by $index">
				{! success !}
			</p>
		</div>

		<fieldset>
			<legend class="legend-name-mid">
				User Credentials
			</legend>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="username">Username <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('username', '',
						array(
							'placeholder' => 'Username'
							, 'autocomplete' => 'off'
							, 'ng-model' => 'admin.record.username'
							, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
							, 'ng-class' => "{ 'required-field' : admin.fields['username'] }"
							, 'ng-change' => 'admin.checkUsername(admin.record.username, futureed.ADMIN, futureed.FALSE)'
							, 'class' => 'form-control'
						)
					) !!}
				</div>
				<div class="margin-top-8"> 
	                <i ng-if="admin.validation.u_loading" class="fa fa-spinner fa-spin"></i>
	                <i ng-if="admin.validation.u_success" class="fa fa-check success-color"></i>
	                <span ng-if="admin.validation.u_error" class="error-msg-con">{! admin.validation.u_error !}</span>
	            </div>	
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="email">Email <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email', '',
						array(
							'placeholder' => 'Email'
							, 'autocomplete' => 'off'
							, 'ng-model' => 'admin.record.email'
							, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
							, 'ng-class' => "{ 'required-field' : admin.fields['email'] }"
							, 'ng-change' => 'admin.checkEmail(admin.record.email, futureed.ADMIN, futureed.FALSE)'
							, 'class' => 'form-control'
						)
					) !!}
				</div>
				<div class="margin-top-8"> 
	                <i ng-if="admin.validation.e_loading" class="fa fa-spinner fa-spin"></i>
	                <i ng-if="admin.validation.e_success" class="fa fa-check success-color"></i>
	                <span ng-if="admin.validation.e_error" class="error-msg-con">{! admin.validation.e_error !}</span>
	            </div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="role">Role <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::select('admin_role',
						[
							'' => '-- Select Role --',
							'Admin' => 'Admin',
							'Super Admin' => 'Super Admin'
						], null,
						['ng-model' => 'admin.record.admin_role'
							, 'ng-class' => "{ 'required-field' : admin.fields['admin_role'] }"
							, 'class' => 'form-control']
					)!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="status">Status <span class="required">*</span></label>
	                <div class="col-xs-4">
	                	<div class="col-xs-6 checkbox">	                				
	                		<label>
	                		{!! Form::radio('status'
	                			,'Enabled'
	                			, true
	                			, array(
	                				'ng-model' => 'admin.record.status'
	                			)
	                		) !!}
	                		<span class="lbl padding-8">{! futureed.ENABLED !}</span>
	                		</label>
	                	</div>
	                	<div class="col-xs-6 checkbox">
	                		<label>
	                		{!! Form::radio('status'
	                			,'Disabled'
	                			, false
	                			, array(
	                				'ng-model' => 'admin.record.status'
	                			)
	                		) !!}
	                		<span class="lbl padding-8">{! futureed.DISABLED !}</span>
	                		</label>
	                	</div>
	                </div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">Password <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::password('password',
						[
							'class' => 'form-control'
							, 'ng-model' => 'admin.record.password'
							, 'ng-class' => "{ 'required-field' : admin.fields['password'] }"
							, 'placeholder' => 'Password'
						]) 
					!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">Confirm Password <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::password('password_c',
						[
							'class' => 'form-control'
							, 'ng-model' => 'admin.record.confirm_password'
							, 'ng-class' => "{ 'required-field' : admin.fields['password'] }"
							, 'placeholder' => 'Confirm Password'
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
				<label class="col-xs-3 control-label">First Name <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('first_name','',
						[
							'class' => 'form-control'
							, 'ng-model' => 'admin.record.first_name'
							, 'placeholder' => 'First Name'
							, 'ng-class' => "{ 'required-field' : admin.fields['first_name'] }"
						]
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">Last Name <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('last_name','',
						[
							'class' => 'form-control'
							, 'ng-model' => 'admin.record.last_name'
							, 'placeholder' => 'Last Name'
							, 'ng-class' => "{ 'required-field' : admin.fields['last_name'] }"
						]
					) !!}
				</div>
			</div>
			<div class="btn-container col-xs-8 col-xs-offset-1">
				{!! Form::button('Save'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "admin.saveAdmin()"
					)
				) !!}

				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "admin.setActive()"
					)
				) !!}
			</div>
		</fieldset>
	</div>
</div>