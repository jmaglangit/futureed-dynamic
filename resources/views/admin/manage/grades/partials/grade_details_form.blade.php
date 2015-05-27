<div ng-if="grade.active_grade_details">
	<div class="content-title">
		<div class="title-main-content">
			<span>Update Grade</span>
		</div>
	</div>

	{!! Form::open(array('id'=> 'add_grade_form', 'class' => 'form-horizontal')) !!}
		<div class="form-content col-xs-12">
			<div class="alert alert-error" ng-if="grade.errors">
	            <p ng-repeat="error in grade.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

	        <div class="alert alert-success" ng-if="grade.details.success">
	        	<p>Successfully updated this grade.</p>
	        </div>

	        <fieldset>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">Grade Code <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('code',''
	        				, array(
	        					 'ng-model' => 'grade.details.code'
	        					, 'ng-disabled' => 'true'
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
	        					'placeHolder' => 'Grade'
	        					, 'ng-model' => 'grade.details.name'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Description </label>
	        		<div class="col-xs-5">
	        			<textarea name="description" ng-model="grade.details.description" class="form-control" cols="50" rows="10"></textarea>
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-md-2 control-label">Country <span class="required">*</span></label>
		      		<div class="col-md-5" ng-init="getCountries()">
		        		<select  name="country_id" class="form-control" ng-model="grade.details.country_id">
			          		<option ng-selected="true" value="">-- Select Country --</option>
			          		<option ng-selected="{! country.id == grade.details.country_id !}" ng-repeat="country in countries" value="{! country.id !}">{! country.name!}</option>
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
	        							, 'ng-model' => 'grade.details.status'
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
	        							, 'ng-model' => 'grade.details.status'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disabled</span>
	        				</label>
	        			</div>
	        		</div>
	        	</div>
	        </fieldset>
	        <div class="btn-container col-sm-7 col-sm-offset-1">
	        	{!! Form::button('Update'
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'grade.updateGradeDetails()'
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