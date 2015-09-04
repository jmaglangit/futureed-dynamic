<div ng-if="age.active_edit" class="col-xs-12" id="age-group">
	<div class="col-xs-12 success-container" ng-if="age.errors || age.success">
		<div class="alert alert-error" ng-if="age.errors">
			<p ng-repeat="error in age.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="age.success">
            <p>{! age.success !}</p>
        </div>
    </div>

	{!! Form::open(array('id'=> 'add_age_group_form', 'class' => 'form-horizontal')) !!}
	<div class="col-xs-12 form-content">
        <fieldset>
			<legend class="legend-name-mid">
				Edit Age Group
			</legend>

        	<div class="form-group">
        		<label class="control-label col-xs-3">Age <span class="required">*</span></label>
        		<div class="col-xs-5" ng-init="age.getAge()">
	        		<select  name="age_group_id" class="form-control" name="age_group_id" ng-model="age.details.age_group_id" ng-class="{'required-field' : age.fields['age_group_id']}">
		          		<option value="">-- Select Age --</option>
		          		<option ng-selected="age.details.age_group.id == ageinfo.id" ng-repeat="ageinfo in age.ages" ng-value="ageinfo.id">{! ageinfo.age!}</option>
	        		</select>
        		</div>
        	</div>
        	<div class="form-group">
        		<label class="control-label col-xs-3">Total Points Earned <span class="required">*</span></label>
        		<div class="col-xs-5">
        			{!! Form::text('points_earned',''
	    				, array(
	    					'placeHolder' => 'Total Points Earned'
	    					, 'ng-model' => 'age.details.points_earned'
	    					, 'class' => 'form-control'
	    					, 'ng-class' => "{ 'required-field' : age.fields['points_earned'] }"
	    				)
	    			) !!}
        		</div>
        	</div>
        </fieldset>
        <div class="col-xs-9 col-xs-offset-1">
        	<div class="btn-container">
        		{!! Form::button('Save'
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'age.saveAgeGroup()'
	        		)
	        	) !!}

	        	{!! Form::button('Cancel'
	        		, array(
	        			'class' => 'btn btn-gold btn-medium'
	        			, 'ng-click' => "age.setActive()"
	        		)
	        	) !!}
        	</div>
        </div>
	</div>
</div>