<div ng-if="grade.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_update_grade') !!}</span>
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
					<label class="col-xs-3 control-label" id="email">{!! trans('messages.admin_grade_code') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('code',''
							, array(
								 'ng-model' => 'grade.record.code'
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
								, 'ng-class' => "{ 'required-field' : grade.fields['code'] }"
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.grade') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('name',''
							, array(
								'placeHolder' => 'trans('messages.grade')'
								, 'ng-model' => 'grade.record.name'
								, 'class' => 'form-control'
								, 'ng-class' => "{ 'required-field' : grade.fields['name'] }"
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.description') !!} </label>
					<div class="col-xs-5">
						<textarea name="description" 
							ng-model="grade.record.description"
							class="form-control disabled-textarea"
							cols="50" rows="10">
						</textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.admin_group') !!} <span class="required">*</span></label>
					<div class="col-xs-5" ng-init="grade.getAgeGroup()">
						<select  name="age_group_id" class="form-control" ng-class="{ 'required-field' : grade.fields['age_group_id'] }" ng-disabled="!grade.ageGroup.length" ng-model="grade.record.age_group_id">
							<option ng-selected="grade.record.age_group_id == futureed.FALSE" value="">{!! trans('messages.admin_select_age_group') !!}</option>
							<option ng-selected="grade.record.age_group_id == age.id" ng-repeat="age in grade.ageGroup" ng-value="age.id"> {! age.name!} </option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.country') !!} <span class="required">*</span></label>
					<div class="col-xs-5" ng-init="getCountries()">
						<select  name="country_id" class="form-control" ng-class="{ 'required-field' : grade.fields['country_id'] }" ng-model="grade.record.country_id">
							<option ng-selected="grade.record.country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
							<option ng-selected="grade.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
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
										, 'ng-model' => 'grade.record.status'
									)
								) !!}
							<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
							</label>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<div class="btn-container col-xs-9 col-xs-offset-1">
						{!! Form::button('trans('messages.update')'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'grade.update()'
							)
						) !!}

						{!! Form::button('trans('messages.cancel')'
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