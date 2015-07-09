<div class="asd" ng-if="content.active_view || content.active_edit">
	<div class="col-xs-12" ng-if="content.errors || content.success">
		<div class="alert alert-error" ng-if="content.errors">
			<p ng-repeat="error in content.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="content.success">
            <p>{! content.success !}</p>
        </div>
    </div>

	<div class="module-container">
		<div class="title-main-content">
			<span>Tip Details</span>
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
								'ng-model' => 'content.record.module',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label" id="email">Displayed At <span class="required">*</span></label>
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
								, 'ng-model' => 'content.record.link_type'
								, 'ng-disabled' => 'content.active_view'
								, 'ng-class' => "{ 'required-field' : content.fields['link_type'] }"
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
								'ng-model' => 'content.record.subject',
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
								'ng-model' => 'content.record.area',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
	        		<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
	        		<div class="col-xs-4" ng-if="content.active_edit">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, true
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'content.record.status'
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
	        							, 'ng-model' => 'content.record.status'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disable</span>
	        				</label>
	        			</div>
	        		</div>
	        		<div ng-if="content.active_view">
		        		<label class="col-xs-4" ng-if="content.record.status == 'Enabled'">
		        			<b class="success-icon">
		        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! content.record.status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="content.record.status == 'Disabled'">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> {! content.record.status !}
		        			</b>
		        		</label>
	        		</div>

	        		<label class="col-xs-2 control-label">Tip Status <span class="required">*</span></label>
	        		<div>
		        		<label class="col-xs-4" ng-if="content.record.tip_status == 'Accepted'">
		        			<b class="success-icon">
		        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! content.record.tip_status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="content.record.tip_status == 'Pending'">
		        			<b class="warning-icon">
		        				<i class="margin-top-8 fa fa-exclamation-circle"></i> {! content.record.tip_status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="content.record.tip_status == 'Rejected'">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> {! content.record.tip_status !}
		        			</b>
		        		</label>
	        		</div>
	        	</div>
	        	<div class="form-group" ng-if="content.record.tip_status == 'Pending' && content.active_view">
	        		<div class="btn-container col-xs-8 col-xs-offset-2">
						{!! Form::button('Accept'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "content.acceptTip()"
							)
						) !!}

						{!! Form::button('Reject'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "content.rejectTip()"
							)
						) !!}		
					</div>
	        	</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">
					Tip Content
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label">Title <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('title', '',
							[
								'class' => 'form-control'
								, 'ng-disabled' => 'content.active_view'
								, 'ng-model' => 'content.record.title'
								, 'placeholder' => 'Title'
								, 'ng-class' => "{ 'required-field' : content.fields['title'] }"
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Description <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::textarea('content','',
							[
								'class' => 'form-control'
								, 'ng-disabled' => 'content.active_view'
								, 'ng-model' => 'content.record.content'
								, 'placeholder' => 'Description'
								, 'ng-class' => "{ 'required-field' : content.fields['content'] }"
							]
						) !!}
					</div>
				</div>
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="content.active_edit">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "content.updateContent()"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "content.setActive(futureed.ACTIVE_VIEW, content.record.id)"
							)
						) !!}
				</div>	
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="content.active_view">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "content.setActive(futureed.ACTIVE_EDIT, content.record.id)"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "content.setActive()"
							)
						) !!}		
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>