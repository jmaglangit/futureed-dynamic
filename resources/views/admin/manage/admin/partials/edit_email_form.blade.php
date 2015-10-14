<div ng-if="admin.active_edit_email">
	<div class="content-title">
		<div class="title-main-content">
			<span>Edit Email Address</span>
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

	{!! Form::open(
		array(
			  'id' => 'edit_email_form'
			, 'class' => 'form-horizontal'
		)
	) !!}
	<div class="search-container col-xs-12">
		<fieldset>
			<div class="form-group">
				<label class="col-xs-3 control-label">New Email Address <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('new_email', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => 'New Email Address'
							, 'ng-model' => 'admin.change.new_email'
							, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
							, 'ng-class' => "{ 'required-field' : admin.fields['new_email'] }"
							, 'ng-change' => 'admin.validateNewEmail(admin.change.new_email, admin.change.confirm_email, futureed.ADMIN)'
						) 
					)!!}
				</div>		
				<div class="margin-top-8"> 
					<i ng-if="admin.validation.n_loading" class="fa fa-spinner fa-spin"></i>
					<i ng-if="admin.validation.n_success" class="fa fa-check success-color"></i>
					<span ng-if="admin.validation.n_error" class="error-msg-con">{! admin.validation.n_error !}</span>
				</div>	
			</div>

			<div class="form-group">
				<label class="col-xs-3 control-label">Confirm Email Address <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('confirm_email', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => 'Confirm Email Address'
							, 'ng-model' => 'admin.change.confirm_email'
							, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
							, 'ng-class' => "{ 'required-field' : admin.fields['confirm_email'] || admin.fields['new_email'] }"
							, 'ng-change' => 'admin.confirmNewEmail(admin.change.new_email, admin.change.confirm_email)'
						) 
					) !!}
				</div>
				<div style="margin-top: 7px;"> 
					<i ng-if="admin.validation.c_success" class="fa fa-check success-color"></i>
					<span ng-if="admin.validation.c_error" class="error-msg-con">{! admin.validation.c_error !}</span>
				</div>	
			</div>
		</fieldset>

		<fieldset>
			<div class="btn-container col-xs-7 col-xs-offset-2">
				{!! Form::button('Save'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => "admin.changeAdminEmail()"
					)
				) !!}

				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "admin.setActive(futureed.ACTIVE_VIEW, admin.record.id)"
					)
				) !!}
			</div>
		</fieldset>
	</div>
	{!! Form::close() !!}
</div>