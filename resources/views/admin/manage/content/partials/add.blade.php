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
	
	<div class="col-xs-12 search-container">
		{!! Form::open(['class' => 'form-horizontal']) !!}
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.admin_module_details') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-2 control-label" id="username">{!! trans('messages.module') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('module', '',
							[
								'placeholder' => trans('messages.module'),
								'ng-disabled' => 'true',
								'ng-model' => 'content.record.module',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('subject', '',
							[
								'placeholder' => trans('messages.subject'),
								'ng-disabled' => 'true',
								'ng-model' => 'content.record.subject',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">{!! trans('messages.area') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('subject_area', '',
							[
								'placeholder' => trans('messages.area'),
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
					{!! trans('messages.teaching_content') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-4 control-label">{!! trans('messages.admin_content_code') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('code', ''
							, array(
								'placeholder' => trans('messages.admin_content_code')
								, 'ng-model' => 'content.record.code'
								, 'ng-class' => "{ 'required-field' : content.fields['code'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">{!! trans('messages.admin_teaching_module_name') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('teaching_module', ''
							, array(
								  'placeholder' => trans('messages.admin_teaching_module_name')
								, 'ng-model' => 'content.record.teaching_module'
								, 'ng-class' => "{ 'required-field' : content.fields['teaching_module'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label" id="email">{!! trans('messages.learning_style') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						<select  name="learning_style_id" ng-class="{ 'required-field' : content.fields['learning_style_id'] }" class="form-control" ng-model="content.record.learning_style_id">
							<option ng-selected="content.record.learning_style_id == futureed.FALSE" value="">{!! trans('messages.select_learning_style') !!}</option>
							<option ng-selected="content.record.learning_style_id == style.id" ng-repeat="style in content.styles" ng-value="style.id">{! style.name!}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">{!! trans('messages.admin_media_type') !!} <span class="required">*</span></label>
					<div class="col-xs-5" ng-init="content.getMediaTypes()">
						<select  name="media_type_id" ng-class="{ 'required-field' : content.fields['media_type_id'] }" class="form-control" ng-model="content.record.media_type_id">
							<option ng-selected="content.record.media_type_id == futureed.FALSE" value="">{!! trans('messages.admin_select_media') !!}</option>
							<option ng-selected="content.record.media_type_id == type.id" ng-repeat="type in content.types" ng-value="type.id">{! type.name!}</option>
						</select>
					</div>
				</div>
				<div class="form-group" ng-if="content.record.media_type_id == futureed.VIDEO">
					<label class="col-xs-4 control-label">{!! trans('messages.admin_video_type') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('content_url', ''
							, array(
								'placeholder' => trans('messages.admin_video_type')
								, 'ng-model' => 'content.record.content_url'
								, 'ng-class' => "{ 'required-field' : content.fields['content_url'] }"
								, 'class' => 'form-control'
							)
						) !!}
						<p class="help-block">
							Please check if you can see the video on the screen when you click
							<span><a href="" ng-click="content.playVideo(content.record)">Play Video.</a></span>
						</p>
					</div>
				</div>
				<div class="form-group" ng-if="content.record.media_type_id == futureed.TEXT">
					<label class="col-xs-4 control-label">{!! trans('messages.admin_content_text') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::textarea('content_text', ''
							, array(
								'placeholder' => trans('messages.admin_content_text')
								, 'ng-model' => 'content.record.content_text'
								, 'ng-class' => "{ 'required-field' : content.fields['content_text'] }"
								, 'class' => 'form-control disabled-textarea'
								, 'rows' => '5'
							)
						) !!}
					</div>
				</div>
				<div class="form-group" ng-if="content.record.media_type_id == futureed.IMAGE">
					<label class="col-xs-4 control-label">{!! trans('messages.image') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="btn btn-blue" ngf-select ngf-change="content.upload($files, content.record)"> {!! trans('messages.choose_image') !!} </div>
					</div>

					<div class="margin-top-8" ng-if="content.record.uploaded">
						<a href="" ng-click="content.removeImage(content.record)"><i class="fa fa-trash"></i></a>
					</div>
				</div>
				<div class="form-group" ng-if="content.record.uploaded">
					<div class="col-xs-4"></div>
					<div class="col-xs-5">
						<span class="col-xs-6 upload-label label label-info">{!! trans('messages.image_uploaded') !!}</span>
						<a href="" class="control-label col-xs-6" ng-click="content.viewImage(content.record)">{!! trans('messages.view_image') !!}</a>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">{!! trans('messages.description') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::textarea('description', ''
							, array(
								  'class' => 'form-control disabled-textarea'
								, 'placeholder' => trans('messages.description')
								, 'ng-model' => 'content.record.description'
								, 'ng-class' => "{ 'required-field' : content.fields['description'] }"
								, 'rows' => '5'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">{!! trans('messages.sequence_number') !!}</label>
					<div class="col-xs-5">
						{!! Form::text('seq_no', ''
							, array(
								'placeholder' => trans('messages.sequence_number')
								, 'ng-model' => 'content.record.seq_no'
								, 'ng-class' => "{ 'required-field' : content.fields['seq_no'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
	        		<label class="col-xs-4 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
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
						{!! Form::button(trans('messages.admin_add_content')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "content.add()"
							)
						) !!}

						{!! Form::button(trans('messages.cancel')
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

	<div id="content_image_modal" ng-show="content.view_image.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div class="btncon col-xs-8 col-xs-offset-4 pull-left">
                        {!! Form::button(trans('messages.close')
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

	<div id="videoModal" ng-show="content.play_video.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"> {! content.play_video.teaching_module !}</h4>
				</div>
				<div class="modal-body">
					<iframe ng-if="content.play_video.content_url"
							ng-src="{! content.play_video.content_url | trustAsResourceUrl !}"
							width="560"
							height="360"
							align="middle"
							frameborder="2"
							webkitallowfullscreen mozallowfullscreen allowfullscreen ng-cloak></iframe>
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
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