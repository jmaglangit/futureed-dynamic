<div ng-if="help.active_view || help.active_edit">
	<div class="col-xs-12 success-container" ng-if="help.errors || help.success">
		<div class="alert alert-error" ng-if="help.errors">
			<p ng-repeat="error in help.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="help.success">
            <p>{! help.success !}</p>
        </div>
    </div>

	<div class="search-container col-xs-12">
		{!! Form::open([
				'id' => 'add_admin_form',
				'class' => 'form-horizontal'
			]) 
		!!}
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.admin_request_details') !!}
				</legend>
				<div class="form-group">
					<div ng-if="help.record.link_type != futureed.GENERAL">
						<label class="col-xs-2 control-label" id="username">{!! trans('messages.module') !!} <span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('username', '',
								[
									'placeholder' => 'trans('messages.module')',
									'ng-disabled' => 'true',
									'ng-model' => 'help.record.module',
									'class' => 'form-control'
								]
							) !!}
						</div>
					</div>
					<label class="col-xs-2 control-label" id="email">{!! trans('messages.type') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::select('link_type'
							, array(
								'' => 'trans('messages.admin_select_type')'
								, 'General' => 'trans('messages.general')'
								, 'Content' => 'trans('messages.content')'
								, 'Question' => 'trans('messages.question')'
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
				<div class="form-group" ng-if="help.record.link_type != futureed.GENERAL">
					<label class="col-xs-2 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('subject', '',
							[
								'placeholder' => 'trans('messages.subject')',
								'ng-disabled' => 'true',
								'ng-model' => 'help.record.subject',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label">{!! trans('messages.area') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('area', '',
							[
								'placeholder' => 'trans('messages.area')',
								'ng-disabled' => 'true',
								'ng-model' => 'help.record.area',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
	        		<label class="col-xs-2 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
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
	        				<span class="lbl padding-8">{!! trans('messages.enabled') !!}</span>
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
	        				<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
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

	        		<label class="col-xs-2 control-label">{!! trans('messages.admin_help_request_status') !!} <span class="required">*</span></label>
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
						{!! Form::button('trans('messages.accept')'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "help.acceptHelp()"
							)
						) !!}

						{!! Form::button('trans('messages.reject')'
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
					{!! trans('messages.admin_request_content') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.admin_help_request_title') !!} <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('title', '',
							[
								'class' => 'form-control',
								'ng-disabled' => 'help.active_view',
								'ng-model' => 'help.record.title',
								'placeholder' => 'trans('messages.title')'
								, 'ng-class' => "{ 'required-field' : help.fields['title'] }"
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.description') !!} <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::textarea('content','',
							[
								'class' => 'form-control disabled-textarea',
								'ng-disabled' => 'help.active_view',
								'ng-model' => 'help.record.content',
								'placeholder' => 'trans('messages.description')'
								, 'ng-class' => "{ 'required-field' : help.fields['content'] }"
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.created_by') !!}:</label>
					<div class="col-xs-6">
						{!! Form::text('created_by','',
							[
								'class' => 'form-control',
								'ng-disabled' => 'true',
								'ng-model' => 'help.record.name',
								'placeholder' => 'trans('messages.created_by')'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="help.active_edit">
							{!! Form::button('trans('messages.save')'
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => "help.updateHelp()"
								)
							) !!}

							{!! Form::button('trans('messages.cancel')'
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => "help.setActive(futureed.ACTIVE_VIEW, help.record.id)"
								)
							) !!}
					</div>	
					<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="help.active_view">
							{!! Form::button('trans('messages.edit')'
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => "help.setActive(futureed.ACTIVE_EDIT, help.record.id)"
								)
							) !!}

							{!! Form::button('trans('messages.cancel')'
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => "help.setActive()"
								)
							) !!}		
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>