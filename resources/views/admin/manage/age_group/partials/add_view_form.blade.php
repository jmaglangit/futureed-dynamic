<div ng-if="age.active_add">
	<div class="col-xs-12 search-container" ng-if="age.errors || age.success">
		<div class="alert alert-error" ng-if="age.errors">
			<p ng-repeat="error in age.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="age.success">
			<p>{! age.success !}</p>
		</div>
	</div>
	
	{!! Form::open(array('class' => 'form-horizontal')) !!}
		<div class="col-xs-12 search-container">
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.admin_add_age_group') !!}
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-3">{!! trans('messages.age') !!} <span class="required">*</span></label>
					<div class="col-xs-5" ng-init="age.getAges()">
						<select class="form-control" ng-model="age.record.age_group_id" 
							ng-class="{'required-field' : age.fields['age_group_id']}">
							<option value="">{!! trans('messages.admin_select_age') !!}</option>
							<option ng-repeat="ageinfo in age.ages" ng-value="ageinfo.id">{! ageinfo.age!}</option>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">{!! trans('messages.admin_total_points_earned') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('points_earned',''
							, array(
								'placeHolder' => trans('messages.admin_total_points_earned')
								, 'ng-model' => 'age.record.points_earned'
								, 'class' => 'form-control'
								, 'ng-class' => "{ 'required-field' : age.fields['points_earned'] }"
							)
						) !!}
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<div class="btn-container col-xs-9 col-xs-offset-1">
						{!! Form::button(trans('messages.add')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'age.add()'
							)
						) !!}

						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "age.setActive()"
							)
						) !!}
					</div>
				</div>
			</fieldset>
		</div>
	{!! Form::close() !!}
</div>