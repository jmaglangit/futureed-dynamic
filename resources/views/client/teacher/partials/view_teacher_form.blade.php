<div ng-if="!teacher.client_list && teacher.view_form">
	<div class="content-title">
		<div class="title-main-content">
			<span ng-show="teacher.view">View Teacher</span>
			<span ng-show="teacher.edit">Edit Teacher</span>
		</div>
	</div>

	{!! Form::open(array('id'=> 'add_client_form', 'class' => 'form-horizontal')) !!}
		<div class="form-content col-xs-12">
			<div class="alert alert-error" ng-if="client.errors">
	            <p ng-repeat="error in client.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

	        <div class="alert alert-success" ng-if="client.create.success">
	        	<p>Successfully added new client user.</p>
	        </div>
	        <fieldset>
	        	<legend class="legend-name-mid">
	        		User Credentials
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="email">Email <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('email',''
	        				, array(
	        					'placeHolder' => 'Email'
	        					, 'ng-model' => 'teacher.teacherdata.user.email'
	        					, 'ng-disabled' => 'true'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'client.checkEmailAvailability()'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<div class="margin-top-8"> 
		                <i ng-if="client.validation.e_loading" class="fa fa-spinner fa-spin"></i>
		                <i ng-if="client.validation.e_success" class="fa fa-check success-color"></i>
		                <span ng-if="client.validation.e_error" class="error-msg-con">{! client.validation.e_error !}</span>
		            </div>	
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="username">Username <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('username',''
	        				, array(
	        					'placeHolder' => 'Username'
	        					, 'ng-model' => 'teacher.teacherdata.user.username'
	        					, 'ng-disabled' => 'true'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'client.checkUsernameAvailability()'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<div class="margin-top-8"> 
		                <i ng-if="client.validation.u_loading" class="fa fa-spinner fa-spin"></i>
		                <i ng-if="client.validation.u_success" class="fa fa-check success-color"></i>
		                <span ng-if="client.validation.u_error" class="error-msg-con">{! client.validation.u_error !}</span>
		            </div>
	        	</div>
	        </fieldset>

	        <fieldset>
	        	<legend class="legend-name-mid">
	        		Personal Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="first_name">Firstname <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('first_name',''
	        				, array(
	        					'placeHolder' => 'Firstname'
	        					, 'ng-disabled' => '!teacher.edit'
	        					, 'ng-model' => 'teacher.teacherdata.first_name'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>

	        		<label class="col-xs-2 control-label" id="last_name">Lastname <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('last_name',''
	        				, array(
	        					'placeHolder' => 'Lastname'
	        					, 'ng-disabled' => '!teacher.edit'
	        					, 'ng-model' => 'teacher.teacherdata.last_name'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        </fieldset>
	        <fieldset>
	        	<legend class="legend-name-mid">
	        		Other Address Information (Optional)
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_address">Street Address <span class="required" ng-if="client.role.parent">*</span></label>
	        		<div class="col-xs-10">
	        			{!! Form::text('street_address',''
	        				, array(
	        					'placeHolder' => 'Street Address'
	        					, 'ng-disabled' => '!teacher.edit'
	        					, 'ng-model' => 'teacher.teacherdata.street_address'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_city">City <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('city',''
	        				, array(
	        					'placeHolder' => 'City'
	        					, 'ng-disabled' => '!teacher.edit'
	        					, 'ng-model' => 'teacher.teacherdata.city'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<label class="col-xs-2 control-label" id="school_state">State <span class="required" >*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('state',''
	        				, array(
	        					'placeHolder' => 'State'
	        					, 'ng-disabled' => '!teacher.edit'
	        					, 'ng-model' => 'teacher.teacherdata.state'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_postal">Postal Code <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('zip',''
	        				, array(
	        					'placeHolder' => 'Postal Code'
	        					, 'ng-disabled' => '!teacher.edit'
	        					, 'ng-model' => 'teacher.teacherdata.zip'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<label class="col-md-2 control-label">Country <span class="required">*</span></label>
				      <div class="col-md-4" ng-init="getCountries()">
				        <select  name="country" class="form-control" ng-model="teacher.teacherdata.country" ng-disabled="!teacher.edit">
				          <option value="">-- Select Country --</option>
				          <option ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
				        </select>
				      </div>
	        	</div>
	        </fieldset>
	        <div class="btn-container col-sm-6 col-sm-offset-3">
		        <a href="" type="button" class="btn btn-blue btn-medium" ng-if="!teacher.teacher_save" ng-click="teacher.setActive('edit')">Edit</a>
		        <a href="" type="button" class="btn btn-blue btn-medium" ng-if="teacher.teacher_save" ng-click="client.createNewClient()">Save</a>
		        <a href="" type="button" class="btn btn-gold btn-medium" ng-click="teacher.setActive('list')">Cancel</a>
		     </div>
		</div>
	{!! Form::close() !!}
	<div class="col-xs-12 table-container.top-margin" ng-show="teacher.view">
		<div class="list-container" ng-cloak>
			<table id="client-list" datatable="ng" class="table table-striped table-hover dt-responsive">
			<thead>
		        <tr>
		            <th>Class Handled</th>
		            <th># of Students</th>
		            <th>Grade</th>
		        </tr>
	        </thead>
	        <tbody>
		        <tr ng-repeat="a in client.clients">
		            <td>{! a.first_name !} {! a.last_name !}</td>
		            <td>{! a.user.email !}</td>
		            <td>{! a.client_role !}</td>
		        </tr>
	        </tbody>

			</table>
		</div>
	</div>
</div>