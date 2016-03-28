<div ng-if="admin.active_edit_pass">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.reset_password') !!}</span>
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
			'id' => 'reset_pass_form',
			'class' => 'form-horizontal'
		]) 
	!!}
	<div class="form-content col-xs-12" ng-if="!admin.reset_success">
		<div class="form-group">
			<label class="col-xs-3 control-label">{!! trans('messages.password') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::password('new_password',
						[
							'placeholder' => 'trans('messages.password')'
							, 'ng-model' => 'admin.change.new_password'
							, 'ng-class' => "{ 'required-field' : admin.fields['new_password'] }"
							, 'class' => 'form-control'
						]
					) !!}
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-3 control-label">{!! trans('messages.confirm_password') !!} <span class="required">*</span></label>
			<div class="col-xs-5">
				{!! Form::password('confirm_password',
						[
							'placeholder' => 'trans('messages.password')'
							, 'ng-model' => 'admin.change.confirm_password'
							, 'ng-class' => "{ 'required-field' : admin.fields['confirm_password'] || admin.fields['new_password'] }"
							, 'class' => 'form-control'
						]
					) !!}
			</div>
		</div>
		<div class="btn-container col-xs-7 col-xs-offset-2">
			{!! Form::button('trans('messages.reset')'
				, array(
					'class' => 'btn btn-blue btn-medium'
					, 'ng-click' => "admin.resetPassword()"
				)
			) !!}

			{!! Form::button('trans('messages.cancel')'
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
				<strong>{!! trans('messages.success') !!}</strong>
				<br/>{!! trans('messages.admin_email_sent') !!} {! admin.record.email !} {!! trans('messages.admin_with_password') !!}
			</p>

			<div class="btn-container">
				{!! Form::button('trans('messages.view_profile')',
					array(
						'class' => 'btn btn-blue'
						, 'ng-click' => 'admin.setActive(futureed.ACTIVE_VIEW, admin.record.id)'
					)
				) !!}
			</div>
		</div>
	</div>
</div>