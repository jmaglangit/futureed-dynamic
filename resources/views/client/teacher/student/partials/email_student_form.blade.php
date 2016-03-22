<div ng-if="teacher.active_email">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.change_student_email') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="teacher.errors || teacher.success">
		<div class="alert alert-error" ng-if="teacher.errors">
			<p ng-repeat="error in teacher.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="teacher.success">
            <p>{! teacher.success !}</p>
        </div>
    </div>

	<div class="module-container">
		{!! Form::open(['class' => 'form-horizontal', 'id' => 'change_email_form']) !!}
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.current_email') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('current_email', ''
		    			, array(
		        			'class' => 'form-control'
		        			, 'placeholder' => 'trans('messages.current_email')'
		        			, 'ng-model' => 'teacher.change.current_email'
		        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
		        			, 'ng-class' => "{ 'required-field' : teacher.fields['current_email'] || teacher.fields['email'] }"
		        			, 'ng-change' => 'teacher.validateCurrentEmail(teacher.record.email, teacher.change.current_email, futureed.STUDENT)'
		        		)
	        		)!!}
				</div>
				<div class="margin-top-8"> 
		            <i ng-if="teacher.validation.e_loading" class="fa fa-spinner fa-spin"></i>
		            <i ng-if="teacher.validation.e_success" class="fa fa-check success-color"></i>
		            <span ng-if="teacher.validation.e_error" class="error-msg-con">{! teacher.validation.e_error !}</span>
		        </div>	
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.new_email') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
		    		{!! Form::text('new_email', ''
		    			, array(
		        			'class' => 'form-control'
		        			, 'placeholder' => 'trans('messages.new_email')'
		        			, 'ng-model' => 'teacher.change.new_email'
		        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
		        			, 'ng-class' => "{ 'required-field' : teacher.fields['new_email'] }"
		        			, 'ng-change' => 'teacher.validateNewEmail(teacher.change.new_email, teacher.change.confirm_email, futureed.STUDENT)'
		        		) 
		        	) !!}
		        </div>		
		        <div class="margin-top-8"> 
		            <i ng-if="teacher.validation.n_loading" class="fa fa-spinner fa-spin"></i>
		            <i ng-if="teacher.validation.n_success" class="fa fa-check success-color"></i>
		            <span ng-if="teacher.validation.n_error" class="error-msg-con">{! teacher.validation.n_error !}</span>
		        </div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.confirm_email') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
		    		{!! Form::text('confirm_email', ''
		    			, array(
		        			'class' => 'form-control'
		        			, 'placeholder' => 'trans('messages.confirm_email')'
		        			, 'ng-model' => 'teacher.change.confirm_email'
		        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
		        			, 'ng-class' => "{ 'required-field' : teacher.fields['confirm_email'] || teacher.fields['new_email'] }"
		        			, 'ng-change' => 'teacher.confirmNewEmail(teacher.change.new_email, teacher.change.confirm_email)') 
		        		)!!}
		        </div>
		        <div class="margin-top-8"> 
		            <i ng-if="teacher.validation.c_success" class="fa fa-check success-color"></i>
		            <span ng-if="teacher.validation.c_error" class="error-msg-con">{! teacher.validation.c_error !}</span>
		        </div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.enter_your_password') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! 
						Form::password('password', 
							[
								'class' => 'form-control'
								, 'ng-model' => 'teacher.change.password'
								, 'ng-class' => "{ 'required-field' : teacher.fields['password'] }"
								, 'placeHolder' => 'trans('messages.password')'
							])
					!!}
				</div>
			</div>
			<div class="col-xs-8 col-xs-offset-1">
				<div class="btn-container">
					{!! Form::button('trans('messages.save')'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "teacher.updateEmail()"
							)
						) !!}
					{!! Form::button('trans('messages.cancel')'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "teacher.setActive(futureed.ACTIVE_VIEW, teacher.record.id)"
						)
					) !!}
				</div>
			</div>
	</div>
</div>