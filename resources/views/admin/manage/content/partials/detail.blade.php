<div class="asd" ng-if="content.active_view || content.active_edit">
	<div class="col-xs-12 success-container" ng-if="content.errors || content.success">
		<div class="alert alert-error" ng-if="content.errors">
			<p ng-repeat="error in content.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="content.success">
            <p>{! content.success !}</p>
        </div>
    </div>
	
	<div class="form-content col-xs-12">
		{!! Form::open([
				'id' => 'add_admin_form',
				'class' => 'form-horizontal'
			]) 
		!!}
			<fieldset>
				<legend class="legend-name-mid">
					Module Details
				</legend>
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
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">Content Code <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('code', ''
							, array(
								'placeholder' => 'Content Code',
								'ng-disabled' => 'true',
								'ng-model' => 'content.record.code',
								'class' => 'form-control'
							)
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
					Module Content
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label">Content Name <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('teaching_module', ''
							, array(
								  'placeholder' => 'Content Name'
								, 'ng-disabled' => 'content.active_view'
								, 'ng-model' => 'content.record.teaching_module'
								, 'ng-class' => "{ 'required-field' : content.fields['teaching_module'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Content URL <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('content_url', ''
							, array(
								'placeholder' => 'Content Url'
								, 'ng-disabled' => 'content.active_view'
								, 'ng-model' => 'content.record.content_url'
								, 'ng-class' => "{ 'required-field' : content.fields['content_url'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
					
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label" id="email">Learning Style <span class="required">*</span></label>
					<div class="col-xs-6">
						<select  name="learning_style_id" ng-disabled="content.active_view" class="form-control" ng-model="content.record.learning_style_id">
							<option ng-selected="content.record.learning_style_id == futureed.FALSE" value="">-- Select Learning Style --</option>
							<option ng-selected="content.record.learning_style_id == style.id" ng-repeat="style in content.styles" ng-value="style.id">{! style.name!}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Media Type <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('media_type_id', ''
							, array(
								'placeholder' => 'Media Type'
								, 'ng-disabled' => 'content.active_view'
								, 'ng-model' => 'content.record.media_type_id'
								, 'ng-class' => "{ 'required-field' : content.fields['media_type_id'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Description <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::textarea('description', ''
							, array(
								  'class' => 'form-control disabled-textarea'
								, 'placeholder' => 'Description'
								, 'ng-disabled' => 'content.active_view'
								, 'ng-model' => 'content.record.description'
								, 'ng-class' => "{ 'required-field' : content.fields['description'] }"
								, 'rows' => '5'
							)
						) !!}
					</div>
				</div>
	        	<div class="form-group" ng-if="content.active_view">
	        		<div class="btn-container col-xs-8 col-xs-offset-2">
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
	        	</div>
	        	<div class="form-group" ng-if="content.active_edit">
	        		<div class="btn-container col-xs-8 col-xs-offset-2">
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
	        	</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>