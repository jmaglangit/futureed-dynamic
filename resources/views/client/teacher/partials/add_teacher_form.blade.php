<div ng-if="teacher.add_form && !teacher.client_list && !teacher.view_form">
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
		<div class="alert alert-danger" ng-if="teacher.p_error">
			<p>
				{! teacher.p_error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="admin.is_success">
			<p>
				{! teacher.is_success !}
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
				<label class="col-xs-2 control-label" id="email">Email <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email', '',
						[
							'placeholder' => 'Email',
							'ng-model' => 'teacher.reg.email',
							'ng-model-options' => "{ debounce : {'default' : 1000} }",
							'ng-change' => 'teacher.checkEmailAvailability()',
							'class' => 'form-control'
						]
					) !!}

					<div>
					<span class="error-msg-con" ng-if="teacher.val.b_errors">{! teacher.val.b_errors !}</span>
					<i class="fa fa-spinner fa-spin" ng-if="teacher.b_loading"></i>
					<span ng-if="teacher.b_success" class="error-msg-con success-color">Email is available.</span>
				</div>
				</div>
				<label class="col-xs-2 control-label" id="username">Username <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('username', '',
						[
							'placeholder' => 'Username',
							'ng-model' => 'teacher.reg.username',
							'ng-model-options' => "{ debounce : {'default' : 1000} }",
							'ng-change' => 'teacher.checkUsernameAvailability()',
							'class' => 'form-control'
						]
					) !!}

					<div>
					<span class="error-msg-con" ng-if="teacher.val.a_error">{! teacher.val.a_error !}</span>
					<i class="fa fa-spinner fa-spin" ng-if="teacher.a_loading"></i>
					<span ng-if="teacher.a_success" class="error-msg-con success-color">Username is available.</span>
				</div>
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
							'ng-model' => 'teacher.reg.first_name',
							'placeholder' => 'First Name'
						]
					) !!}
				</div>
				<label class="col-xs-2 control-label">Last Name <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('last_name','',
						[
							'class' => 'form-control',
							'ng-model' => 'teacher.reg.last_name',
							'placeholder' => 'Last Name'
						]
					) !!}
				</div>
			</div>
			<div class="btn-container col-xs-6 col-xs-offset-3">
				<button class="btn btn-blue btn-medium" id="proceed-btn" type="button" ng-click="teacher.saveTeacher()">Save</button>
				<button class="btn btn-gold btn-medium" type="button" ng-click="teacher.setActive(list)">Cancel</button>
			</div>
		</fieldset>
	</div>
</div>