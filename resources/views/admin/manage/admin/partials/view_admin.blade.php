<div ng-if="admin.active_view || admin.active_edit">
	<div class="content-title">
		<div class="title-main-content" ng-if="admin.active_view">
			<span>{!! trans('messages.admin_view_user') !!}</span>
		</div>
		<div class="title-main-content" ng-if="admin.active_edit">
			<span>{!! trans('messages.admin_edit_user') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="admin.errors || admin.success">
		<div class="alert alert-error" ng-if="admin.errors">
			<p ng-repeat="error in admin.errors track by $index" > 
				{! error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="admin.success">
			<p ng-repeat="success in admin.success track by $index" > 
				{! success !}
			</p>
		</div>
	</div>

	{!! Form::open([
			'id' => 'add_admin_form',
			'class' => 'form-horizontal'
		]) 
	!!}
	<div class="col-xs-12 search-container">
		<fieldset>
			<legend class="legend-name-mid">
				{!! trans('messages.user_credentials') !!}
			</legend>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="username">{!! trans('messages.username') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('username', '',
						[
							'placeholder' => 'trans('messages.username')'
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
				<label class="col-xs-3 control-label" id="email">{!! trans('messages.email') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					<div class="input-group">
						{!! Form::text('email', '',
							[
								'placeholder' => 'trans('messages.email')',
								'ng-model' => 'admin.record.email',
								'ng-disabled' => 'true',
								'class' => 'form-control'
							]
						) !!}

						<span class="input-group-addon" ng-click="admin.setActive('edit_email')"><i class="fa fa-pencil edit-addon"></i></span>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="role">{!! trans('messages.role') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::select('role',
						[
							'' => 'trans('messages.select_role')',
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
				<label class="col-xs-3 control-label" id="status">{!! trans('messages.status') !!} <span class="required">*</span></label>
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
				{!! trans('messages.personal_info') !!}
			</legend>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('first_name','',
						[
							'class' => 'form-control'
							, 'ng-disabled' => 'admin.active_view'
							, 'ng-model' => 'admin.record.first_name'
							, 'ng-class' => "{ 'required-field' : admin.fields['first_name'] }"
							, 'placeholder' => 'trans('messages.first_name')'
						]
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('last_name','',
						[
							'class' => 'form-control'
							, 'ng-disabled' => 'admin.active_view'
							, 'ng-model' => 'admin.record.last_name'
							, 'ng-class' => "{ 'required-field' : admin.fields['last_name'] }"
							, 'placeholder' => 'trans('messages.last_name')'
						]
					) !!}
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<div class="btn-container col-xs-6 col-xs-offset-2" ng-if="admin.active_edit">
					<div class="row form-group">		
						<div class="col-xs-6">
							{!! Form::button('trans('messages.save')'
								, array(
									'class' => 'btn btn-blue'
									, 'ng-click' => "admin.updateAdmin()"
								)
							) !!}
						</div>
						<div class="col-xs-6">
							{!! Form::button('trans('messages.cancel')'
								, array(
									'class' => 'btn btn-gold'
									, 'ng-click' => "admin.setActive(futureed.ACTIVE_VIEW, admin.record.id)"
								)
							) !!}
						</div>
					</div>

					<div class="row form-group">
						<div class="col-xs-12">
							{!! Form::button('trans('messages.reset_password')'
								, array(
									'class' => 'btn btn-blue'
									, 'ng-click' => "admin.setActive('pass')"
								)
							) !!}
						</div>
					</div>
				</div>	
				
				<div class="btn-container col-xs-8 col-xs-offset-1" ng-if="admin.active_view">
					{!! Form::button('trans('messages.edit')'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "admin.setActive(futureed.ACTIVE_EDIT, admin.record.id)"
						)
					) !!}

					{!! Form::button('trans('messages.cancel')'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "admin.setActive()"
						)
					) !!}		
				</div>
			</div>
		</fieldset>
	</div>
	{!! Form::close() !!}
</div>