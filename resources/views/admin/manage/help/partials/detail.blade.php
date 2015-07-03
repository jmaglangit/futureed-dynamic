<div ng-if="help.active_view || help.active_edit">
	<div class="col-xs-12" ng-if="help.errors || help.success">
		<div class="alert alert-error" ng-if="help.errors">
			<p ng-repeat="error in help.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="help.success">
            <p>{! help.success !}</p>
        </div>
    </div>

	<div class="module-container">
		<div class="title-main-content">
			<span>Help Request Detail</span>
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
								'ng-model' => 'help.record.module',
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
								, 'ng-model' => 'help.record.link_type'
								, 'ng-disabled' => 'help.active_view'
								, 'ng-class' => "{ 'required-field' : help.fields['link_type'] }"
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
								'ng-model' => 'help.record.subject',
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
								'ng-model' => 'help.record.area',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
	        		<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
	        		<div class="col-xs-4" ng-if="help.active_edit">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, true
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'help.record.status'
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
	        							, 'ng-model' => 'help.record.status'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disable</span>
	        				</label>
	        			</div>
	        		</div>
	        		<div ng-if="help.active_view">
		        		<label class="col-xs-4" ng-if="help.record.status == 'Enabled'">
		        			<b class="success-icon">
		        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! help.record.status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="help.record.status == 'Disabled'">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> {! help.record.status !}
		        			</b>
		        		</label>
	        		</div>

	        		<label class="col-xs-2 control-label">Request Status <span class="required">*</span></label>
	        		<div>
		        		<label class="col-xs-4" ng-if="help.record.request_status == 'Accepted'">
		        			<b class="success-icon">
		        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! help.record.request_status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="help.record.request_status == 'Pending'">
		        			<b class="warning-icon">
		        				<i class="margin-top-8 fa fa-exclamation-circle"></i> {! help.record.request_status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="help.record.request_status == 'Rejected'">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> {! help.record.request_status !}
		        			</b>
		        		</label>
	        		</div>
	        	</div>
	        	<div class="form-group" ng-if="help.record.request_status == 'Pending' && help.active_view">
	        		<div class="btn-container col-xs-8 col-xs-offset-2">
						{!! Form::button('Accept'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "help.acceptHelp()"
							)
						) !!}

						{!! Form::button('Reject'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "help.rejectHelp()"
							)
						) !!}		
					</div>
	        	</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">
					Request Content
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label">Help Request Title <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('title', '',
							[
								'class' => 'form-control',
								'ng-disabled' => 'help.active_view',
								'ng-model' => 'help.record.title',
								'placeholder' => 'Title'
								, 'ng-class' => "{ 'required-field' : help.fields['title'] }"
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Description <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::textarea('content','',
							[
								'class' => 'form-control',
								'ng-disabled' => 'help.active_view',
								'ng-model' => 'help.record.content',
								'placeholder' => 'Description'
								, 'ng-class' => "{ 'required-field' : help.fields['content'] }"
							]
						) !!}
					</div>
				</div>
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="help.active_edit">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "help.updateHelp()"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "help.setActive(futureed.ACTIVE_VIEW, help.record.id)"
							)
						) !!}
				</div>	
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="help.active_view">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "help.setActive(futureed.ACTIVE_EDIT, help.record.id)"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "help.setActive()"
							)
						) !!}		
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>