<div ng-if="grade.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Grade</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="grade.errors || grade.success">
		<div class="alert alert-error" ng-if="grade.errors">
			<p ng-repeat="error in grade.errors track by $index" > 
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="grade.success">
			<p> 
				{! grade.success !}
			</p>
		</div>
	</div>

	<div class="search-container col-xs-12">
		{!! Form::open(array('id'=> 'add_grade_form', 'class' => 'form-horizontal')) !!}
			<fieldset>
				<div class="form-group">
					<label class="col-xs-3 control-label" id="email">Grade Code <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('code',''
							, array(
								'placeHolder' => 'Grade Code'
								, 'ng-model' => 'grade.record.code'
								, 'ng-class' => "{ 'required-field' : grade.fields['code'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Grade <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('name',''
							, array(
								'placeHolder' => 'Grade Name'
								, 'ng-model' => 'grade.record.name'
								, 'ng-class' => "{ 'required-field' : grade.fields['name'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Description </label>
					<div class="col-xs-5">
						<textarea name="description" 
							ng-model="grade.record.description" 
							class="form-control disabled-textarea" cols="50" rows="10"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label"> Group <span class="required">*</span></label>
					<div class="col-md-5" ng-init="grade.getAgeGroup()">
						<select  name="age_group_id" class="form-control" ng-class="{ 'required-field' : grade.fields['age_group_id'] }" ng-disabled="!grade.ageGroup.length" ng-model="grade.record.age_group_id">
							<option value="">-- Select Age Group --</option>
							<option ng-repeat="age in grade.ageGroup" ng-value="age.id"> {! age.name!} </option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Country <span class="required">*</span></label>
					<div class="col-md-5" ng-init="getCountries()">
						<select  name="country_id" class="form-control" ng-class="{ 'required-field' : grade.fields['country_id'] }" ng-model="grade.record.country_id">
							<option value="">-- Select Country --</option>
							<option ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Status <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="col-xs-6 checkbox">	                				
							<label>
								{!! Form::radio('status'
									, 'Enabled'
									, true
									, array(
										'class' => 'field'
										, 'ng-model' => 'grade.record.status'
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
										, 'ng-model' => 'grade.record.status'
									)
								) !!}
							<span class="lbl padding-8">Disabled</span>
							</label>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<div class="btn-container col-xs-9 col-xs-offset-1">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'grade.add()'
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'grade.setActive()'
							)
						) !!}
					 </div>
				</div>
			</fieldset>
		</div>
	{!! Form::close() !!}
</div>