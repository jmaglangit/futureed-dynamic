<div ng-if="student.active_invite">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.email_parent_added_student_msg3') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
			<p ng-repeat="error in student.errors track by $index" > 
				{! error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="student.success">
			<p> 
				{! student.success !}
			</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
        {!! Form::open(['class' => 'form-horizontal', 'ng-submit' => 'student.submitCode($event)']) !!}
	        <fieldset>
	        	<div class="form-group">
	        		<label class="control-label col-xs-3">{!! trans('messages.email_parent_added_student_msg3') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('invitation_code', '',
							[
								'class' => 'form-control'
								, 'ng-model' => 'student.record.invitation_code'
								, 'ng-class' => "{ 'required-field' : student.fields['invitation_code'] }"
								, 'placeholder' => trans('messages.email_parent_added_student_msg3')
							]
						) !!}
	        		</div>
	        	</div>

	        	<div class="form-group btn-container">
	        		<div class="col-xs-9 col-xs-offset-1">
	        			{!! Form::button(trans('messages.client_proceed')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'student.submitCode($event)'
							)
						) !!}

						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gray btn-medium'
								, 'ng-if' => 'student.record.id'
								, 'ng-click' => 'student.setActive(futureed.ACTIVE_VIEW, student.record.id)'
							)
						) !!}

						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-if' => '!student.record.id'
								, 'ng-click' => 'student.setActive(futureed.ACTIVE_LIST)'
							)
						) !!}
	        		</div>
	        	</div>

	        	<hr />
	        	
	        	<div class="form-group invitation-code">
	        		<p>{!! trans('messages.client_invitation_msg1') !!}</p>
	        		<p>{!! trans('messages.client_invitation_msg2') !!}</p>
	        		<p ng-if="!student.record.id">{!! trans('messages.client_invitation_msg3') !!}</p>
	        	</div>
	        </fieldset>
	    {!! Form::close() !!}
	</div>
</div>