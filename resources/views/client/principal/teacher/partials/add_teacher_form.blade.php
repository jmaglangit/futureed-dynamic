<div ng-if="teacher.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.client_add_teacher') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="teacher.errors || teacher.success">
		<div class="alert alert-error" ng-if="teacher.errors">
			<p ng-repeat="error in teacher.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="teacher.success">
			<p>
				{! teacher.success !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		{!! Form::open([
				'id' => 'add_teacher_form',
				'class' => 'form-horizontal'
			]) 
		!!}
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.user_credentials') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label" id="username">{!! trans('messages.username') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('username', ''
							, array(
								'placeholder' => trans('messages.username'),
								'ng-class' => "{ 'required-field' : teacher.fields['username']}", 
								'ng-model' => 'teacher.record.username',
								'ng-model-options' => "{ debounce : {'default' : 1000} }",
								'ng-change' => 'teacher.checkUsername(teacher.record.username, futureed.CLIENT, futureed.FALSE)',
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
					<label class="col-xs-3 control-label" id="email">{!! trans('messages.email') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('email', ''
							, array(
								'placeholder' => trans('messages.email'),
								'ng-model' => 'teacher.record.email',
								'ng-class' => "{ 'required-field' : teacher.fields['email']}", 
								'ng-model-options' => "{ debounce : {'default' : 1000} }",
								'ng-change' => 'teacher.checkEmail(teacher.record.email, futureed.CLIENT, futureed.FALSE)',
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
					{!! trans('messages.personal_info') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('first_name','',
							[
								'class' => 'form-control',
								'ng-class' => "{ 'required-field' : teacher.fields['first_name']}", 
								'ng-model' => 'teacher.record.first_name',
								'placeholder' => trans('messages.first_name')
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('last_name','',
							[
								'class' => 'form-control',
								'ng-class' => "{ 'required-field' : teacher.fields['last_name']}", 
								'ng-model' => 'teacher.record.last_name',
								'placeholder' => trans('messages.last_name')
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="btn-container col-xs-8 col-xs-offset-1">
						<button type="button" class="btn btn-blue btn-medium"
							ng-click="teacher.save('{!! route('client.registration') !!}')">
							{!! trans('messages.client_send_invitation') !!}
						</button>

						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'teacher.setActive()'
							)
						) !!}
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>