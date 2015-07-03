<div ng-if="answer.active_view || answer.active_edit">
	<div class="col-xs-12" ng-if="answer.errors || answer.success">
		<div class="alert alert-error" ng-if="answer.errors">
			<p ng-repeat="error in answer.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="answer.success">
            <p>{! answer.success !}</p>
        </div>
    </div>

	<div class="module-container">
		<div class="title-main-content">
			<span>Help Answer Detail</span>
		</div>
	</div>

	<div class="form-content col-xs-12">
		{!! Form::open([
				'id' => 'add_admin_form',
				'class' => 'form-horizontal'
			]) 
		!!}
			<fieldset>
				<div class="form-group">
					<label class="col-xs-2 control-label" id="username">Module <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('username', '',
							[
								'placeholder' => 'Module',
								'ng-disabled' => 'true',
								'ng-model' => 'answer.record.module',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label" id="email">Type <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::select('link_type'
							, array(
								'' => '-- Select Type --'
								, 'General' => 'General'
								, 'Content' => 'Content'
								, 'Question' => 'Question'
							)
							, ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'answer.record.link_type'
								, 'ng-disabled' => 'true'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Subject <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('subject', '',
							[
								'placeholder' => 'Subject',
								'ng-disabled' => 'true',
								'ng-model' => 'answer.record.subject',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label">Area <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('area', '',
							[
								'placeholder' => 'Area',
								'ng-disabled' => 'true',
								'ng-model' => 'answer.record.area',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
	        		<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
	        		<div class="col-xs-4" ng-if="answer.active_edit">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, true
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'answer.record.status'
	        						) 
	        					) !!}
	        				<span class="lbl padding-8">Enable</span>
	        				</label>
	        			</div>
	        			<div class="col-xs-6 checkbox">
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Disabled'
	        						, false
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'answer.record.status'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disable</span>
	        				</label>
	        			</div>
	        		</div>
	        		<div ng-if="answer.active_view">
		        		<label class="col-xs-4" ng-if="answer.record.status == 'Enabled'">
		        			<b class="success-icon">
		        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! answer.record.status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="answer.record.status !== 'Enabled'">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> {! answer.record.status !}
		        			</b>
		        		</label>
	        		</div>

	        		<label class="col-xs-3 control-label">Request Answer Status <span class="required">*</span></label>
	        		<div>
		        		<label class="col-xs-3" ng-if="answer.record.request_answer_status == 'Accepted'">
		        			<b class="success-icon">
		        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! answer.record.request_answer_status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-3" ng-if="answer.record.request_answer_status == 'Pending'">
		        			<b class="warning-icon">
		        				<i class="margin-top-8 fa fa-exclamation-circle"></i> {! answer.record.request_answer_status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-3" ng-if="answer.record.request_answer_status == 'Rejected'">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> {! answer.record.request_answer_status !}
		        			</b>
		        		</label>
	        		</div>
	        	</div>
	        	<div class="form-group" ng-if="answer.record.request_answer_status == 'Pending' && answer.active_view">
	        		<div class="btn-container col-xs-8 col-xs-offset-2">
						{!! Form::button('Accept'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "answer.acceptAnswer()"
							)
						) !!}

						{!! Form::button('Reject'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "answer.rejectAnswer()"
							)
						) !!}		
					</div>
	        	</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">
					Answer Content
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label">Help Request Title <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('title', '',
							[
								'class' => 'form-control',
								'ng-disabled' => 'true',
								'ng-model' => 'answer.record.title',
								'placeholder' => 'Title'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Answer <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::textarea('content','',
							[
								'class' => 'form-control',
								'ng-disabled' => 'answer.active_view',
								'ng-model' => 'answer.record.content',
								'placeholder' => 'Description'
							]
						) !!}
					</div>
				</div>
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="answer.active_edit">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "answer.updateHelpAnswer()"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "answer.setActive(futureed.ACTIVE_VIEW, answer.record.id)"
							)
						) !!}
				</div>	
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="answer.active_view">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "answer.setActive(futureed.ACTIVE_EDIT, answer.record.id)"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "answer.setActive()"
							)
						) !!}		
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>