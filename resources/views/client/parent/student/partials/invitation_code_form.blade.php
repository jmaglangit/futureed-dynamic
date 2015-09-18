<div ng-if="student.active_invite">
	<div class="content-title">
		<div class="title-main-content">
			<span>Invitation Code</span>
		</div>
	</div>
	<div class="col-xs-12 form-content">
		<div class="alert alert-error" ng-if="student.errors">
            <p ng-repeat="error in student.errors track by $index" > 
                {! error !}
            </p>
        </div>
        {!! Form::open(['class' => 'form-horizontal', 'ng-submit' => 'student.submitCode($event)']) !!}
	        <div class="col-xs-12">
	        	<div class="form-group">
	        		<label class="control-label col-xs-3">Invitation Code <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('invitation_code', '',
							[
								'class' => 'form-control'
								, 'ng-model' => 'student.record.invitation_code'
								, 'ng-class' => "{ 'required-field' : student.fields['invitation_code'] }"
								, 'placeholder' => 'Invitation Code'
							]
						) !!}
	        		</div>

	        		<div class="col-xs-3">
	        			{!! Form::button('Proceed'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'student.submitCode($event)'
								, 'ng-if' => '!student.record.id'
							)
						) !!}
					</div>
	        	</div>

	        	<div class="form-group btn-container" ng-if="student.record.id">
	        		<div class="col-xs-9 col-xs-offset-1">
	        			{!! Form::button('Proceed'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'student.submitCode($event)'
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'student.setActive(futureed.ACTIVE_VIEW, student.record.id)'
							)
						) !!}
	        		</div>
	        	</div>

	        	<hr />
	        	
	        	<div class="form-group invitation-code">
	        		<p>The student you have added will be receiving an email containing the code.</p>
	        		<p>Please get this code from the student and input it on the field above.</p>
	        	</div>
	        </div>
	    {!! Form::close() !!}
	</div>
</div>