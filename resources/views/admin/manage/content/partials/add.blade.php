<div ng-if="content.active_add">
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
						{!! Form::text('module', '',
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
					<label class="col-xs-2 control-label">Area <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('subject_area', '',
							[
								'placeholder' => 'Area',
								'ng-disabled' => 'true',
								'ng-model' => 'content.record.subject_area',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">
					Teaching Module Content
				</legend>
				<div class="form-group">
					<label class="col-xs-4 control-label">Content Code <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('code', ''
							, array(
								'placeholder' => 'Content Code'
								, 'ng-model' => 'content.record.code'
								, 'ng-class' => "{ 'required-field' : content.fields['code'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">Teaching Module Name <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('teaching_module', ''
							, array(
								  'placeholder' => 'Teaching Module Name'
								, 'ng-model' => 'content.record.teaching_module'
								, 'ng-class' => "{ 'required-field' : content.fields['teaching_module'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label" id="email">Learning Style <span class="required">*</span></label>
					<div class="col-xs-5">
						<select  name="learning_style_id" ng-class="{ 'required-field' : content.fields['learning_style_id'] }" class="form-control" ng-model="content.record.learning_style_id">
							<option ng-selected="content.record.learning_style_id == futureed.FALSE" value="">-- Select Learning Style --</option>
							<option ng-selected="content.record.learning_style_id == style.id" ng-repeat="style in content.styles" ng-value="style.id">{! style.name!}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">Media Type <span class="required">*</span></label>
					<div class="col-xs-5" ng-init="content.getMediaTypes()">
						<select  name="media_type_id" ng-class="{ 'required-field' : content.fields['media_type_id'] }" class="form-control" ng-model="content.record.media_type_id">
							<option ng-selected="content.record.media_type_id == futureed.FALSE" value="">-- Select Media Type --</option>
							<option ng-selected="content.record.media_type_id == type.id" ng-repeat="type in content.types" ng-value="type.id">{! type.name!}</option>
						</select>
					</div>
				</div>
				<div class="form-group" ng-if="content.record.media_type_id == futureed.VIDEO">
					<label class="col-xs-4 control-label">Video <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('content_url', ''
							, array(
								'placeholder' => 'Content Url'
								, 'ng-model' => 'content.record.content_url'
								, 'ng-class' => "{ 'required-field' : content.fields['content_url'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group" ng-if="content.record.media_type_id == futureed.TEXT">
					<label class="col-xs-4 control-label">Content Text <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::textarea('content_text', ''
							, array(
								'placeholder' => 'Content Text'
								, 'ng-model' => 'content.record.content_text'
								, 'ng-class' => "{ 'required-field' : content.fields['content_text'] }"
								, 'class' => 'form-control disabled-textarea'
								, 'rows' => '5'
							)
						) !!}
					</div>
				</div>
				<div class="form-group" ng-if="content.record.media_type_id == futureed.IMAGE">
					<label class="col-xs-4 control-label">Image <span class="required">*</span></label>
					<div class="col-xs-5">
	                    <div class="btn btn-blue" ngf-select ngf-change="content.upload($files, content.record)"> Choose Image... </div>
					</div>

					<div class="margin-top-8" ng-if="content.record.uploaded">
	                    <a href="" ng-click="content.removeImage(content.record)"><i class="fa fa-trash"></i></a>
	                </div>
				</div>
				<div class="form-group" ng-if="content.record.uploaded">
	                <div class="col-xs-4"></div>
	                <div class="col-xs-5">
	                    <span class="col-xs-6 upload-label label label-info">Image Uploaded...</span>
	                    <a href="" class="control-label col-xs-6" ng-click="content.viewImage(content.record)">View Image</a>
	                </div>
	            </div>
				<div class="form-group">
					<label class="col-xs-4 control-label">Description <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::textarea('description', ''
							, array(
								  'class' => 'form-control disabled-textarea'
								, 'placeholder' => 'Description'
								, 'ng-model' => 'content.record.description'
								, 'ng-class' => "{ 'required-field' : content.fields['description'] }"
								, 'rows' => '5'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">Sequence Number</label>
					<div class="col-xs-5">
						{!! Form::text('seq_no', ''
							, array(
								'placeholder' => 'Sequence Number'
								, 'ng-model' => 'content.record.seq_no'
								, 'ng-class' => "{ 'required-field' : content.fields['seq_no'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
	        		<label class="col-xs-4 control-label">Status <span class="required">*</span></label>
	        		<div class="col-xs-5">
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
	        				<span class="lbl padding-8">Enabled</span>
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
	        				<span class="lbl padding-8">Disabled</span>
	        				</label>
	        			</div>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<div class="btn-container col-xs-8 col-xs-offset-2">
						{!! Form::button('Add Content'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "content.addContent()"
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
			</fieldset>
		{!! Form::close() !!}
	</div>

	<div id="view_image_modal" ng-show="content.view_image.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {! content.view_image.teaching_module !}
                </div>
                <div class="modal-body">
                    <div class="modal-image">
                        <img ng-src="{! content.view_image.image_path !}"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btncon col-md-8 col-md-offset-4 pull-left">
                        {!! Form::button('Close'
                            , array(
                                'class' => 'btn btn-gold btn-medium'
                                , 'data-dismiss' => 'modal'
                            )
                        ) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>