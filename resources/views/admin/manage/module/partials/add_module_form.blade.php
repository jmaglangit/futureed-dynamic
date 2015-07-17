<div ng-if="module.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Module</span>
		</div>
	</div>
	{!! Form::open(array('id'=> 'add_module_form', 'class' => 'form-horizontal')) !!}
	<div class="col-xs-12 form-content">
		<div class="alert alert-error" ng-if="module.errors">
            <p ng-repeat="error in module.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="module.create.success">
        	<p>Successfully added new module.</p>
        </div>
        <fieldset>
        	<div class="form-group">
        		<label class="control-label col-xs-2">Subject <span class="required">*</span></label>
        		<div class="col-xs-4" ng-init="module.getSubject()">
	        		<select  name="subject_id" class="form-control" name="subject_id" ng-model="module.create.subject_id" ng-change="module.setSubject('create')" ng-class="{'required-field' : module.fields['subject_id']}">
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
        							, 'ng-model' => 'module.create.status'
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
        							, 'ng-model' => 'module.create.status'
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
        					, 'ng-model' => 'module.create.area'
        					, 'ng-disabled' => '!module.area_field'
        					, 'class' => 'form-control'
        					, 'ng-change' => "module.searchArea('create')"
	        				, 'ng-class' => "{ 'required-field' : module.fields['subject_area_id'] }"
                        	, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
        				)
        			) !!}
        			<div class="angucomplete-holder" ng-if="module.areas">
						<ul class="col-md-6 angucomplete-dropdown">
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
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-2">Code <span class="required">*</span></label>
        		<div class="col-xs-4">
        			{!! Form::text('code',''
        				, array(
        					'placeHolder' => 'Code'
        					, 'ng-model' => 'module.create.code'
        					, 'class' => 'form-control'
        					, 'ng-class' => "{ 'required-field' : module.fields['code'] }"
        				)
        			) !!}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-2">Module <span class="required">*</span></label>
        		<div class="col-xs-4">
        			{!! Form::text('module',''
        				, array(
        					'placeHolder' => 'Module'
        					, 'ng-model' => 'module.create.name'
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
        					, 'ng-model' => 'module.create.points_to_unlock'
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
        					, 'ng-model' => 'module.create.description'
        					, 'class' => 'form-control'
        					, 'style' => 'resize:vertical'
        					, 'ng-class' => "{ 'required-field' : module.fields['description'] }"
        				)
        			) !!}
        		</div>
        		<label class="control-label col-xs-3">Points to Finish <span class="required">*</span></label>
        		<div class="col-xs-3">
        			{!! Form::text('points_to_finish',''
        				, array(
        					'placeHolder' => 'Points to Finish'
        					, 'ng-model' => 'module.create.points_to_finish'
        					, 'class' => 'form-control'
        					, 'ng-class' => "{ 'required-field' : module.fields['points_to_finish'] }"
        				)
        			) !!}
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-3">Common Core Area <span class="required">*</span></label>
        		<div class="col-xs-3">
        			{!! Form::text('common_core_area',''
        				, array(
        					'placeHolder' => 'Common Core Area'
        					, 'ng-model' => 'module.create.common_core_area'
        					, 'class' => 'form-control'
        					, 'ng-class' => "{ 'required-field' : module.fields['common_core_area'] }"
        				)
        			) !!}
        		</div>
        		<label class="control-label col-xs-3">Common Core URL <span class="required">*</span></label>
        		<div class="col-xs-3">
        			{!! Form::text('common_core_url',''
        				, array(
        					'placeHolder' => 'Common Core URL'
        					, 'ng-model' => 'module.create.common_core_url'
        					, 'class' => 'form-control'
        					, 'ng-class' => "{ 'required-field' : module.fields['common_core_url'] }"
        				)
        			) !!}
        		</div>
        	</div>
        </fieldset>
        <div class="col-xs-6 col-xs-offset-3">
        	<div class="btn-container">
        		{!! Form::button('Save'
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'module.addNewModule()'
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
	</div>
</div>