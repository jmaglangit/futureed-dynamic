<div ng-if="teacher.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Teacher</span>
		</div>
	</div>

	<div class="form-content col-xs-12">
		<div class="alert alert-danger" ng-if="teacher.errors">
			<p ng-repeat="error in teacher.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="teacher.success">
			<p>
				{! teacher.success !}
			</p>
		</div>

			{!! Form::open([
					'id' => 'add_teacher_form',
					'class' => 'form-horizontal'
				]) 
			!!}
		<fieldset>
			<legend class="legend-name-mid">
				User Credentials
			</legend>
			<div class="form-group">
				<label class="col-xs-3 control-label" id="username">Username <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('username', ''
						, array(
							'placeholder' => 'Username',
							'ng-class' => "{ 'required-field' : teacher.fields['username']}", 
							'ng-model' => 'teacher.record.username',
							'ng-model-options' => "{ debounce : {'default' : 1000} }",
							'ng-change' => 'teacher.checkUsernameAvailability()',
							'autocomplete' => 'off',
							'class' => 'form-control'
						)
					) !!}
				</div>
				<div class="margin-top-8">
					<span class="error-msg-con" ng-if="teacher.validation.u_error">{! teacher.validation.u_error !}</span>
					<i class="fa fa-spinner fa-spin" ng-if="teacher.validation.u_loading"></i>
					<i ng-if="teacher.validation.u_success" class="fa fa-check success-color"></i>
				</div>
			</div>
			<div class="form-group">				
				<label class="col-xs-3 control-label" id="email">Email <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email', ''
						, array(
							'placeholder' => 'Email',
							'ng-model' => 'teacher.record.email',
							'ng-class' => "{ 'required-field' : teacher.fields['email']}", 
							'ng-model-options' => "{ debounce : {'default' : 1000} }",
							'ng-change' => 'teacher.checkEmailAvailability()',
							'autocomplete' => 'off',
							'class' => 'form-control'
						)
					) !!}
				</div>
				<div class="margin-top-8">
					<span class="error-msg-con" ng-if="teacher.validation.e_error">{! teacher.validation.e_error !}</span>
					<i class="fa fa-spinner fa-spin" ng-if="teacher.validation.e_loading"></i>
					<i ng-if="teacher.validation.e_success" class="fa fa-check success-color"></i>
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
							'class' => 'form-control',
							'ng-class' => "{ 'required-field' : teacher.fields['first_name']}", 
							'ng-model' => 'teacher.record.first_name',
							'placeholder' => 'First Name'
						]
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-3 control-label">Last Name <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('last_name','',
						[
							'class' => 'form-control',
							'ng-class' => "{ 'required-field' : teacher.fields['last_name']}", 
							'ng-model' => 'teacher.record.last_name',
							'placeholder' => 'Last Name'
						]
					) !!}
				</div>
			</div>
			<div class="btn-container col-xs-6 col-xs-offset-2">
				{!! Form::button('Send Invitation'
					, array(
						'class' => 'btn btn-blue btn-medium'
						, 'ng-click' => 'teacher.save()'
					)
				) !!}
				{!! Form::button('Cancel'
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => 'teacher.setActive()'
					)
				) !!}
			</div>
		</fieldset>
	</div>
</div>