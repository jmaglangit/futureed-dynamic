{!! Form::open(
	array(
		'id' => 'edit_email_form'
		, 'class' => 'form-horizontal'
		, 'ng-if' => 'profile.active_edit_email'
	)
)!!}
	<div ng-if="!profile.select_password">
		<div class="form-group">
			<label class="col-xs-3 control-label">
				{!! trans('messages.current_email') !!}
				<span class="required">*</span>
			</label>
			<div class="col-xs-5">
				{!! Form::text('current_email', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.current_email')
						, 'ng-model' => 'profile.change.current_email'
						, 'ng-class' => "{ 'required-field' : profile.fields['current_email'] }"
						, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
						, 'ng-change' => "profile.validateStudentCurrentEmail()"
					)
				)!!}
			</div>
			<div style="margin-top: 7px;">
				<i ng-if="profile.validation.e_loading" class="fa fa-spinner fa-spin"></i>
				<i ng-if="profile.validation.e_success" class="fa fa-check success-color"></i>
				<span ng-if="profile.validation.e_error" class="error-msg-con">{! profile.validation.e_error !}</span>
			</div>
		</div>
		<div class="form-group">
			<label class="col-xs-3 control-label">
				{!! trans('messages.new_email') !!}
				<span class="required">*</span>
			</label>
			<div class="col-xs-5">
				{!! Form::text('new_email', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.new_email')
						, 'ng-model' => 'profile.change.new_email'
						, 'ng-class' => "{ 'required-field' : profile.fields['new_email'] }"
						, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
						, 'ng-change' => "profile.validateStudentNewEmail()"
					)
				)!!}
			</div>
			<div style="margin-top: 7px;">
				<i ng-if="profile.validation.n_loading" class="fa fa-spinner fa-spin"></i>
				<i ng-if="profile.validation.n_success" class="fa fa-check success-color"></i>
				<span ng-if="profile.validation.n_error" class="error-msg-con"> {! profile.validation.n_error !}</span>
			</div>
		</div>						
		<div class="form-group">
			<label class="col-xs-3 control-label">
				{!! trans('messages.confirm_email') !!}
				<span class="required">*</span>
			</label>
			<div class="col-xs-5">
				{!! Form::text('confirm_email', ''
					, array(
						'class' => 'form-control'
						, 'placeholder' => trans('messages.confirm_email')
						, 'ng-model' => 'profile.change.confirm_email'
						, 'ng-class' => "{ 'required-field' : profile.fields['confirm_email'] }"
						, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
						, 'ng-change' => "profile.confirmStudentNewEmail()"
					)
				)!!}
			</div>
			<div style="margin-top: 7px;">
				<i ng-if="profile.validation.c_loading" class="fa fa-spinner fa-spin"></i>
				<i ng-if="profile.validation.c_success" class="fa fa-check success-color"></i>
				<span ng-if="profile.validation.c_error" class="error-msg-con"> {! profile.validation.c_error !}</span>
			</div>
		</div>
		<br />
		<div class="form-group">
			<div class="btn-container">
				{!! Form::button(trans('messages.next')
					, array(
						'class' => 'btn btn-maroon btn-medium'
						, 'ng-click' => 'profile.selectPicturePassword()'
					)
				) !!}

				{!! Form::button(trans('messages.cancel')
					, array(
						'class' => 'btn btn-gold btn-medium'
						, 'ng-click' => "profile.setStudentProfileActive('index')"
					)
				) !!}
			</div>
		</div>
	</div>

	<div ng-if="profile.select_password">		
		<div class="enter-pass-con form-select-password col-xs-8 col-xs-offset-2"> 
			<div class="title title-student">{!! trans('messages.student_select_pic_password') !!}</div>
			
			<div class="form_content">
				<ul class="form_password list-unstyled list-inline">
					<li class="item" 
						ng-repeat="item in profile.image_pass" 
						ng-click="profile.highlightPassword(item.id)"
						ng-class="{ 'selected' : profile.change.password_image_id == item.id }">
					 	<img class="pass-img" ng-src="{! item.url !}" alt="{! item.name !}">
					</li>
				</ul>
			</div>
		</div>
		<div class="btn-container">
			{!! Form::button(trans('messages.save')
				, array(
					'class' => 'btn btn-maroon btn-medium'
					, 'ng-click' => 'profile.changeStudentEmail()'
				)
			) !!}

			{!! Form::button(trans('messages.previous')
				, array(
					'class' => 'btn btn-gold btn-medium'
					, 'ng-click' => 'profile.backToEditEmail()'
				)
			) !!}
		</div>
	</div>				
{!! Form::close() !!}