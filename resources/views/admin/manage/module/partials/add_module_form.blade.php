<div ng-if="module.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Module</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="module.errors || module.success">
		<div class="alert alert-error" ng-if="module.errors">
			<p ng-repeat="error in module.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="module.success">
			<p>{! module.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		{!! Form::open(array('class' => 'form-horizontal')) !!}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-2">Subject <span class="required">*</span></label>
				<div class="col-xs-4" ng-init="module.getSubject()">
					<select  name="subject_id" class="form-control" name="subject_id" 
						ng-model="module.record.subject_id" 
						ng-change="module.setSubject()" 
						ng-class="{'required-field' : module.fields['subject_id']}">
						<option value="">-- Select Subject --</option>
						<option ng-repeat="subject in module.subjects" ng-value="subject.id">{! subject.name!}</option>
					</select>
				</div>
				<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
				<div class="col-xs-4">
					<div class="col-xs-6 checkbox">	                				
						<label>
							{!! Form::radio('status'
								, 'Enabled'
								, true
								, array(
									'class' => 'field'
									, 'ng-model' => 'module.record.status'
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
									, 'ng-model' => 'module.record.status'
								)
							) !!}
						<span class="lbl padding-8">Disabled</span>
						</label>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2">Area <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('area',''
						, array(
							'placeHolder' => 'Area'
							, 'ng-model' => 'module.record.area'
							, 'ng-disabled' => '!module.record.subject_id'
							, 'class' => 'form-control'
							, 'ng-change' => "module.searchArea()"
							, 'ng-class' => "{ 'required-field' : module.fields['subject_area_id'] }"
							, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
						)
					) !!}
					<div class="angucomplete-holder" ng-if="module.areas">
						<ul class="col-xs-6 angucomplete-dropdown">
							<li class="angucomplete-row" ng-repeat="area in module.areas" ng-click="module.selectArea(area)">
								{! area.name !}
							</li>
						</ul>
					</div>
					<div class="margin-top-8 center-err"> 
						<i ng-if="module.validation.s_loading" class="fa fa-spinner fa-spin"></i>
						<span ng-if="module.validation.s_error" class="error-msg-con">{! module.validation.s_error !}</span>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-2">Image </label>
					<div class="col-xs-3">
						<div class="btn btn-blue" ngf-select ngf-change="module.upload($files, module.record)"> Choose Image... </div>
					</div>

					<div class="margin-top-8" ng-if="module.record.uploaded">
						<a href="" ng-click="module.removeImage(module.record)"><i class="fa fa-trash"></i></a>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2">Code <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('code',''
						, array(
							'placeHolder' => 'Code'
							, 'ng-model' => 'module.record.code'
							, 'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : module.fields['code'] }"
						)
					) !!}
				</div>
				<div class="col-xs-6" ng-if="module.record.uploaded">
					<div class="col-xs-2"></div>
					<span class="col-xs-5 upload-label label label-info">Image Uploaded...</span>
					<a href="" class="control-label col-xs-5" ng-click="module.viewImage(module.record)">View Image</a>
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2">Module <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('module',''
						, array(
							'placeHolder' => 'Module'
							, 'ng-model' => 'module.record.name'
							, 'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : module.fields['name'] }"
						)
					) !!}
				</div>
				<label class="control-label col-xs-3">Points to Unlock <span class="required">*</span></label>
				<div class="col-xs-3">
					{!! Form::text('points_to_unlock',''
						, array(
							'placeHolder' => 'Points to Unlock'
							, 'ng-model' => 'module.record.points_to_unlock'
							, 'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : module.fields['points_to_unlock'] }"
						)
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-2">Description <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::textarea('description',''
						, array(
							'placeHolder' => 'Description'
							, 'ng-model' => 'module.record.description'
							, 'class' => 'form-control disabled-textarea'
							, 'ng-class' => "{ 'required-field' : module.fields['description'] }"
							, 'rows' => '5'
						)
					) !!}
				</div>
				<label class="control-label col-xs-3">Points to Finish <span class="required">*</span></label>
				<div class="col-xs-3">
					{!! Form::text('points_to_finish',''
						, array(
							'placeHolder' => 'Points to Finish'
							, 'ng-model' => 'module.record.points_to_finish'
							, 'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : module.fields['points_to_finish'] }"
						)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">Common Core Area <span class="required">*</span></label>
				<div class="col-xs-3"></div>

				<label class="control-label col-xs-3">Common Core URL <span class="required">*</span></label>
				<div class="col-xs-3"></div>
			</div>

			<div class="form-group">
				<div class="col-xs-1"></div>
				<div class="col-xs-5">
					{!! Form::text('common_core_area',''
						, array(
							'placeHolder' => 'Common Core Area'
							, 'ng-model' => 'module.record.common_core_area'
							, 'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : module.fields['common_core_area'] }"
						)
					) !!}
				</div>

				<div class="col-xs-1"></div>
				<div class="col-xs-5">
					{!! Form::text('common_core_url',''
						, array(
							'placeHolder' => 'Common Core URL'
							, 'ng-model' => 'module.record.common_core_url'
							, 'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : module.fields['common_core_url'] }"
						)
					) !!}
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<div class="btn-container col-xs-9 col-xs-offset-2">
					{!! Form::button('Save'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => 'module.add()'
						)
					) !!}

					{!! Form::button('Cancel'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => 'module.setActive()'
						)
					) !!}
				</div>
			</div>
		</fieldset>
		{!! Form::close() !!}
	</div>

	<div id="view_image_modal" ng-show="module.view_image.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{! module.view_image.teaching_module !}
				</div>
				<div class="modal-body">
					<div class="modal-image">
						<img ng-src="{! module.view_image.image_path !}"/>
					</div>
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