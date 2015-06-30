<div ng-if="student.active_change">
	<div class="content-title">
		<div class="title-main-content">
			<span>Change Student Email</span>
		</div>
	</div>
	<div class="container form-content">
		<div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index" > 
                {! error !}
            </p>
        </div>
		{!! Form::open(['class' => 'form-horizontal', 'id' => 'add_student_form']) !!}
		<div class="col-xs-12 margin-30-top">
			<div class="form-group">
				<label class="control-label col-xs-2">Current Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('current_email', ''
		    			, array(
		        			'class' => 'form-control'
		        			, 'placeholder' => 'Current Email Address'
		        			, 'ng-model' => 'student.change.current_email'
		        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
		        			, 'ng-class' => "{ 'required-field' : student.fields['current_email'] }"
		        			, 'ng-change' => 'student.validateCurrentEmail(student.detail.email, student.change.current_email, futureed.STUDENT)'
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
				<label class="control-label col-xs-2">New Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('new_email', ''
		    			, array(
		        			'class' => 'form-control'
		        			, 'placeholder' => 'New Email Address'
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
				<label class="control-label col-xs-2">Confirm Email <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('confirm_email', ''
		    			, array(
		        			'class' => 'form-control'
		        			, 'placeholder' => 'Confirm Email Address'
		        			, 'ng-model' => 'student.change.confirm_email'
		        			, 'ng-model-options' => "{ debounce: {'default' : 1000} }"
		        			, 'ng-class' => "{ 'required-field' : student.fields['confirm_email'] }"
		        			, 'ng-change' => 'student.confirmNewEmail(student.change.new_email, student.change.confirm_email)') 
		        		)!!}
				</div>
				<div class="margin-top-8"> 
		            <i ng-if="student.validation.c_success" class="fa fa-check success-color"></i>
		            <span ng-if="student.validation.c_error" class="error-msg-con">{! student.validation.c_error !}</span>
		        </div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2">Password <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::password('password',
						[
							'class' => 'form-control'
							, 'ng-model' => 'student.change.password'
							, 'placeHolder' => 'Password'
						]
					) !!}
				</div>
			</div>
			<div class="col-xs-6 col-xs-offset-3">
				<div class="btn-container">
					{!! Form::button('Change'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'student.changeEmail()'
						)
					) !!}
					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "student.setActive('view', student.detail.id)"
						)
					) !!}
				</div>
			</div>
		</div>
	</div>
</div>