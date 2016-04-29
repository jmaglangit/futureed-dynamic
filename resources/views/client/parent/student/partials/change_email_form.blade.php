<div ng-if="student.active_change">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.change_student_email') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors">
		<div class="alert alert-error">
			<p ng-repeat="error in student.errors track by $index" > 
				{! error !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		{!! Form::open(['class' => 'form-horizontal', 'id' => 'add_student_form']) !!}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.current_email') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('current_email', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => trans('messages.current_email')
							, 'ng-model' => 'student.change.current_email'
							, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
							, 'ng-class' => "{ 'required-field' : student.fields['current_email'] || student.fields['email'] }"
							, 'ng-change' => 'student.validateCurrentEmail(student.record.email, student.change.current_email, futureed.STUDENT)'
						)
					)!!}
				</div>
				<div class="margin-top-8"> 
					<i ng-if="student.validation.e_loading" class="fa fa-spinner fa-spin"></i>
					<i ng-if="student.validation.e_success" class="fa fa-check success-color"></i>
					<span ng-if="student.validation.e_error" class="error-msg-con">{! student.validation.e_error !}</span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.new_email') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('new_email', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => trans('messages.new_email')
							, 'ng-model' => 'student.change.new_email'
							, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
							, 'ng-class' => "{ 'required-field' : student.fields['new_email'] }"
							, 'ng-change' => 'student.validateNewEmail(student.change.new_email, student.change.confirm_email, futureed.STUDENT)'
						) 
					) !!}
				</div>
				<div class="margin-top-8"> 
					<i ng-if="student.validation.n_loading" class="fa fa-spinner fa-spin"></i>
					<i ng-if="student.validation.n_success" class="fa fa-check success-color"></i>
					<span ng-if="student.validation.n_error" class="error-msg-con">{! student.validation.n_error !}</span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.confirm_email') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('confirm_email', ''
						, array(
							'class' => 'form-control'
							, 'placeholder' => trans('messages.confirm_email')
							, 'ng-model' => 'student.change.confirm_email'
							, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
							, 'ng-class' => "{ 'required-field' : student.fields['confirm_email'] || student.fields['new_email'] }"
							, 'ng-change' => 'student.confirmNewEmail(student.change.new_email, student.change.confirm_email)') 
						)!!}
				</div>
				<div class="margin-top-8"> 
					<i ng-if="student.validation.c_success" class="fa fa-check success-color"></i>
					<span ng-if="student.validation.c_error" class="error-msg-con">{! student.validation.c_error !}</span>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.password') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::password('password',
						[
							'class' => 'form-control'
							, 'ng-model' => 'student.change.password'
							, 'ng-class' => "{ 'required-field' : student.fields['password'] }"
							, 'placeHolder' => trans('messages.password')
						]
					) !!}
				</div>
			</div>
			<div class="form-group">
				<div class="btn-container col-xs-8 col-xs-offset-1">
					{!! Form::button(trans('messages.change')
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'student.changeEmail()'
						)
					) !!}
					{!! Form::button(trans('messages.cancel')
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "student.setActive(futureed.ACTIVE_VIEW, student.record.id)"
						)
					) !!}
				</div>
			</div>
		</fieldset>
	</div>
</div>