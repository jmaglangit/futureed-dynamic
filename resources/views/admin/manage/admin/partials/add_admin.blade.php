<div ng-if="admin.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_add_admin_user') !!}</span>
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
						array(
							'placeholder' => trans('messages.username')
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
				<label class="col-xs-3 control-label" id="email">{!! trans('messages.email') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email', '',
						array(
							'placeholder' => trans('messages.email')
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
				<label class="col-xs-3 control-label" id="role">{!! trans('messages.role') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::select('admin_role',
						[
							'' => trans('messages.select_role'),
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
				<label class="col-xs-3 control-label" id="status">{!! trans('messages.status') !!} <span class="required">*</span></label>
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
				<label class="col-xs-3 control-label">{!! trans('messages.password') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::password('password',
						[
							'class' => 'form-control'
							, 'ng-model' => 'admin.record.password'
							, 'ng-class' => "{ 'required-field' : admin.fields['password'] }"
							, 'placeholder' => trans('messages.password')
						]) 
					!!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">{!! trans('messages.confirm_password') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::password('password_c',
						[
							'class' => 'form-control'
							, 'ng-model' => 'admin.record.confirm_password'
							, 'ng-class' => "{ 'required-field' : admin.fields['password'] }"
							, 'placeholder' => trans('messages.confirm_password')
						]) 
					!!}
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
							, 'ng-model' => 'admin.record.first_name'
							, 'placeholder' => trans('messages.first_name')
							, 'ng-class' => "{ 'required-field' : admin.fields['first_name'] }"
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
							, 'ng-model' => 'admin.record.last_name'
							, 'placeholder' => trans('messages.last_name')
							, 'ng-class' => "{ 'required-field' : admin.fields['last_name'] }"
						]
					) !!}
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<div class="btn-container col-xs-8 col-xs-offset-1">
				{!! Form::button(trans('messages.save')
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "admin.saveAdmin()"
					)
				) !!}

				{!! Form::button(trans('messages.cancel')
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "admin.setActive()"
					)
				) !!}
			</div>
			</div>
		</fieldset>
	</div>
</div>