<div ng-if="admin.view_admin && !admin.reset_pass">
	<div class="content-title">
		<div class="title-main-content" ng-if="!admin.edit_admin">
			<span>View Admin User</span>
		</div>
		<div class="title-main-content" ng-if="admin.edit_admin">
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
		<div class="alert alert-error" ng-if="admin.r_error">
			<p>
				{! r_error !}
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
							'ng-disabled' => '!admin.edit',
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
				<label class="col-xs-2 control-label" id="role">Role <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::select('role',
						[
							'' => '-- Select Role --',
							'Admin' => 'Admin',
							'Super Admin' => 'Super Admin'
						],'{! admin.admininfo.admin_role !}',
						['ng-model' => 'admin.admininfo.admin_role', 'class' => 'form-control', 'ng-disabled' => '!admin.edit']
					)!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-2 control-label" id="email">Email <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email', '',
						[
							'placeholder' => 'Email',
							'ng-model' => 'admin.admininfo.user.email',
							'ng-disabled' => 'true',
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
					<a href="#" class="admin-edit">Edit Email</a>	
				</div>

				<label class="col-xs-2 control-label" id="status">Status <span class="required">*</span></label>
	                <div class="col-xs-4" ng-if="admin.edit">
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
	                <div class="col-xs-4" ng-if="!admin.edit">
	                	<div ng-show="admin.admininfo.user.status == 'Enabled'">
	                		<span style="color:green;"><b><i class="fa fa-check-circle-o"></i> {! admin.admininfo.user.status !}</b></span>
	                	</div>
	                	<div ng-show="admin.admininfo.user.status == 'Disabled'">
	                		<span style="color:green;"><b><i class="fa fa-ban"></i> {! admin.admininfo.user.status !}</b></span>
	                	</div>
	                </div>
			</div>
			<div class="form-group" ng-show="admin.admininfo.new_email != null">
				<label class="col-xs-2 control-label required" id="email">Pending Email</label>
				<div class="col-xs-4">
					{!! Form::text('email', '',
						[
							'placeholder' => 'Email',
							'ng-model' => 'admin.admininfo.user.new_email',
							'ng-disabled' => 'true',
							'ng-model-options' => "{ debounce : {'default' : 1000} }",
							'ng-change' => 'admin.checkEmailAvailability()',
							'class' => 'form-control'
						]
					) !!}
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
					{!! Form::text('firstname','',
						[
							'class' => 'form-control',
							'ng-disabled' => '!admin.edit',
							'ng-model' => 'admin.admininfo.first_name',
							'placeholder' => 'First Name'
						]
					) !!}
				</div>
				<label class="col-xs-2 control-label">Last Name <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('lastname','',
						[
							'class' => 'form-control',
							'ng-disabled' => '!admin.edit',
							'ng-model' => 'admin.admininfo.last_name',
							'placeholder' => 'Last Name'
						]
					) !!}
				</div>
			</div>
			<div class="btn-container col-xs-12">
				<div class="row">
					<div class="col-xs-4" ng-if="admin.edit" >
						<button class="btn btn-success" type="button" ng-click="admin.setActive('pass')">reset password</button>
					</div>
					<div class="col-xs-4"  ng-if="!admin.edit" >
						<button class="btn btn-blue" ng-click="admin.setActive('edit')">edit</button>
					</div>				
					<div class="col-xs-4"  ng-if="admin.edit" >
						<button class="btn btn-blue" ng-click="admin.editAdmin()">Save</button>	
					</div>
					<div class="col-xs-4">
						<button class="btn btn-gold" ng-click="admin.setActive('view')">Cancel</button>
					</div>
				</div>				
			</div>
		</fieldset>
	</div>
</div>