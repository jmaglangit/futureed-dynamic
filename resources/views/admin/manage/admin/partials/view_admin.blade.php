<div ng-if="admin.active_view_admin || admin.active_edit_admin">
	<div class="content-title">
		<div class="title-main-content" ng-if="admin.active_view_admin">
			<span>View Admin User</span>
		</div>
		<div class="title-main-content" ng-if="admin.active_edit_admin">
			<span>Edit Admin User</span>
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
		<div class="alert alert-success" ng-if="admin.is_success">
			<p>
				{! admin.admininfo.success !}
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
						[
							'placeholder' => 'Username',
							'ng-disabled' => 'admin.active_view_admin',
							'ng-model' => 'admin.admininfo.user.username',
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
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="email">Email <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email', '',
						[
							'placeholder' => 'Email',
							'ng-model' => 'admin.admininfo.user.email',
							'ng-disabled' => 'true',
							'class' => 'form-control'
						]
					) !!}
				</div>
				<div class="col-xs-2">
					<a href="" ng-click="admin.setManageAdminActive('edit_email')" class="edit-email">Edit Email</a>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="role">Role <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::select('role',
						[
							'' => '-- Select Role --',
							'Admin' => 'Admin',
							'Super Admin' => 'Super Admin'
						],'{! admin.admininfo.admin_role !}',
						['ng-model' => 'admin.admininfo.admin_role', 'class' => 'form-control', 'ng-disabled' => 'admin.active_view_admin']
					)!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="status">Status <span class="required">*</span></label>
	                <div class="col-xs-4" ng-if="admin.active_edit_admin">
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
	                <div class="col-xs-3" ng-if="admin.active_view_admin">
	                	<div ng-show="admin.admininfo.user.status == 'Enabled'">
	                		<span style="color:green;"><b><i class="fa fa-check-circle-o"></i> {! admin.admininfo.user.status !}</b></span>
	                	</div>
	                	<div ng-show="admin.admininfo.user.status == 'Disabled'">
	                		<span style="color:green;"><b><i class="fa fa-ban"></i> {! admin.admininfo.user.status !}</b></span>
	                	</div>
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
					{!! Form::text('firstname','',
						[
							'class' => 'form-control',
							'ng-disabled' => 'admin.active_view_admin',
							'ng-model' => 'admin.admininfo.first_name',
							'placeholder' => 'First Name'
						]
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">First Name <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('firstname','',
						[
							'class' => 'form-control',
							'ng-disabled' => 'admin.active_view_admin',
							'ng-model' => 'admin.admininfo.first_name',
							'placeholder' => 'First Name'
						]
					) !!}
				</div>
			</div>
			<div class="btn-container col-xs-6 col-xs-offset-2" ng-if="admin.active_edit_admin">
				<div class="row">		
					<div class="col-xs-6"   >
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue'
								, 'ng-click' => "admin.editAdmin()"
							)
						) !!}
					</div>
					<div class="col-xs-6">
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold'
								, 'ng-click' => "admin.setManageAdminActive('view')"
							)
						) !!}
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12">
						{!! Form::button('Reset Password'
							, array(
								'class' => 'btn btn-blue'
								, 'ng-click' => "admin.setManageAdminActive('pass')"
							)
						) !!}
					</div>
				</div>
			</div>	
			<div class="btn-container col-xs-8 col-xs-offset-1" ng-if="admin.active_view_admin">
					{!! Form::button('Edit'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "admin.setManageAdminActive('edit')"
						)
					) !!}

					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "admin.setManageAdminActive()"
						)
					) !!}		
			</div>
		</fieldset>
	</div>
	{!! Form::close() !!}
</div>