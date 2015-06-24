<div ng-if="grade.active_add_grade">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Grade</span>
		</div>
	</div>

	{!! Form::open(array('id'=> 'add_grade_form', 'class' => 'form-horizontal')) !!}
		<div class="form-content col-xs-12">
			<div class="alert alert-error" ng-if="grade.errors">
	            <p ng-repeat="error in grade.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

	        <div class="alert alert-success" ng-if="grade.create.success">
	        	<p>Successfully added new grade.</p>
	        </div>

	        <fieldset>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">Grade Code <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('code',''
	        				, array(
	        					'placeHolder' => 'Grade Code'
	        					, 'ng-model' => 'grade.create.code'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Grade <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('name',''
	        				, array(
	        					'placeHolder' => 'Grade Name'
	        					, 'ng-model' => 'grade.create.name'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Description </label>
	        		<div class="col-xs-5">
	        			<textarea name="description" ng-model="grade.create.description" class="form-control" cols="50" rows="10"></textarea>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-md-2 control-label">Country <span class="required">*</span></label>
		      		<div class="col-md-5" ng-init="getCountries()">
		        		<select  name="country_id" class="form-control" ng-model="grade.create.country_id">
			          		<option value="">-- Select Country --</option>
			          		<option ng-repeat="country in countries" ng-value="{! country.id !}">{! country.name!}</option>
		        		</select>
		      		</div>
		      	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, true
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'grade.create.status'
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
	        							, 'ng-model' => 'grade.create.status'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disabled</span>
	        				</label>
	        			</div>
	        		</div>
	        	</div>
	        </fieldset>
	        <div class="btn-container col-sm-7 col-sm-offset-1">
	        	{!! Form::button('Save'
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'grade.addNewGrade()'
	        		)
	        	) !!}

	        	{!! Form::button('Cancel'
	        		, array(
	        			'class' => 'btn btn-gold btn-medium'
	        			, 'ng-click' => 'grade.setManageGradeActive()'
	        		)
	        	) !!}
		     </div>
		</div>
	{!! Form::close() !!}
</div>