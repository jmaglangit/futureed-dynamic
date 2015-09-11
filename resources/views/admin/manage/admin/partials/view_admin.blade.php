<div ng-if="admin.active_view || admin.active_edit">
	<div class="content-title">
		<div class="title-main-content" ng-if="admin.active_view">
			<span>View Admin User</span>
		</div>
		<div class="title-main-content" ng-if="admin.active_edit">
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
						[
							'placeholder' => 'Username'
							, 'ng-disabled' => 'admin.active_view'
							, 'ng-model' => 'admin.record.username'
							, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
							, 'ng-class' => "{ 'required-field' : admin.fields['username'] }"
							, 'ng-change' => 'admin.checkUsername(admin.record.username, futureed.ADMIN, futureed.TRUE)'
							, 'class' => 'form-control'
						]
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
						[
							'placeholder' => 'Email',
							'ng-model' => 'admin.record.email',
							'ng-disabled' => 'true',
							'class' => 'form-control'
						]
					) !!}
				</div>
				<div class="col-xs-2">
					<a href="" ng-click="admin.setActive('edit_email')" class="edit-email">Edit Email</a>
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
						],'{! admin.record.admin_role !}',
						[  
							  'ng-model' => 'admin.record.admin_role'
							, 'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : admin.fields['admin_role'] }"
							, 'ng-disabled' => 'admin.active_view']
					)!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="status">Status <span class="required">*</span></label>
	                <div class="col-xs-5" ng-if="admin.active_edit">
	                	<div class="col-xs-6 checkbox">	                				
	                		<label>
	                		{!! Form::radio('status'
	                			,'Enabled'
	                			, false
	                			, array(
	                				'ng-model' => 'admin.record.status'
	                				, 'ng-click' => 'admin.adminChangeStatus()'
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
	                				, 'ng-click' => 'admin.adminChangeStatus()'
	                			)
	                		) !!}
	                		<span class="lbl padding-8">{! futureed.DISABLED !}</span>
	                		</label>
	                	</div>
	                </div>
	                <div class="col-xs-3" ng-if="admin.active_view">
	                	<label ng-if="admin.record.status == futureed.ENABLED">
	                		<b class="success-icon">
	                			<i class="margin-top-8 fa fa-check-circle-o"></i> {! admin.record.status !}
	                		</b>
	                	</label>

	                	<label ng-if="admin.record.status == futureed.DISABLED">
	                		<b class="error-icon">
	                			<i class="margin-top-8 fa fa-ban"></i> {! admin.record.status !}
	                		</b>
	                	</label>
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
							, 'ng-disabled' => 'admin.active_view'
							, 'ng-model' => 'admin.record.first_name'
							, 'ng-class' => "{ 'required-field' : admin.fields['first_name'] }"
							, 'placeholder' => 'First Name'
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
							, 'ng-disabled' => 'admin.active_view'
							, 'ng-model' => 'admin.record.last_name'
							, 'ng-class' => "{ 'required-field' : admin.fields['last_name'] }"
							, 'placeholder' => 'Last Name'
						]
					) !!}
				</div>
			</div>
			<div class="btn-container col-xs-6 col-xs-offset-2" ng-if="admin.active_edit">
				<div class="row form-group">		
					<div class="col-xs-6">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue'
								, 'ng-click' => "admin.updateAdmin()"
							)
						) !!}
					</div>
					<div class="col-xs-6">
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold'
								, 'ng-click' => "admin.setActive(futureed.ACTIVE_VIEW, admin.record.id)"
							)
						) !!}
					</div>
				</div>

				<div class="row form-group">
					<div class="col-xs-12">
						{!! Form::button('Reset Password'
							, array(
								'class' => 'btn btn-blue'
								, 'ng-click' => "admin.setActive('pass')"
							)
						) !!}
					</div>
				</div>
			</div>	
			<div class="btn-container col-xs-8 col-xs-offset-1" ng-if="admin.active_view">
					{!! Form::button('Edit'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "admin.setActive(futureed.ACTIVE_EDIT, admin.record.id)"
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
	{!! Form::close() !!}
</div>