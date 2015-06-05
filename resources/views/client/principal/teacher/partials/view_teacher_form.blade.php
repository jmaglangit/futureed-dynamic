<div ng-if="teacher.active_view || teacher.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span ng-show="teacher.active_view">View Teacher</span>
			<span ng-show="teacher.active_edit">Edit Teacher</span>
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
	        		<div class="col-xs-4">
	        			{!! Form::text('email',''
	        				, array(
	        					'placeHolder' => 'Email'
	        					, 'ng-model' => 'teacher.record.user.email'
	        					, 'ng-disabled' => 'true'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'client.checkEmailAvailability()'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="username">Username <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('username',''
	        				, array(
	        					'placeHolder' => 'Username'
	        					, 'ng-model' => 'teacher.record.user.username'
	        					, 'ng-disabled' => 'true'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'client.checkUsernameAvailability()'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        </fieldset>

	        <fieldset>
	        	<legend class="legend-name-mid">
	        		Personal Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="first_name">First Name <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('first_name',''
	        				, array(
	        					'placeHolder' => 'Firstname'
	        					, 'ng-disabled' => 'teacher.active_view'
	        					, 'ng-model' => 'teacher.record.first_name'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>

	        		<label class="col-xs-2 control-label" id="last_name">Last Name <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('last_name',''
	        				, array(
	        					'placeHolder' => 'Lastname'
	        					, 'ng-disabled' => 'teacher.active_view'
	        					, 'ng-model' => 'teacher.record.last_name'
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
	        		<div class="col-xs-6">
	        			{!! Form::text('street_address',''
	        				, array(
	        					'placeHolder' => 'Street Address'
	        					, 'ng-disabled' => 'teacher.active_view'
	        					, 'ng-model' => 'teacher.record.street_address'
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
	        					, 'ng-disabled' => 'teacher.active_view'
	        					, 'ng-model' => 'teacher.record.city'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<label class="col-xs-2 control-label" id="school_state">State <span class="required" >*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('state',''
	        				, array(
	        					'placeHolder' => 'State'
	        					, 'ng-disabled' => 'teacher.active_view'
	        					, 'ng-model' => 'teacher.record.state'
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
	        					, 'ng-disabled' => 'teacher.active_view'
	        					, 'ng-model' => 'teacher.record.zip'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<label class="col-md-2 control-label">Country <span class="required">*</span></label>
				      <div class="col-md-4" ng-init="getCountries()">
				        <select  name="country" class="form-control" ng-model="teacher.record.country" ng-disabled="teacher.active_view">
				          <option value="">-- Select Country --</option>
				          <option ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
				        </select>
				      </div>
	        	</div>
	        </fieldset>
	        <div class="btn-container col-sm-6 col-sm-offset-3">
	        	<div ng-if="teacher.active_view">
	        		{!! Form::button('Edit'
	        			, array(
	        				'class' => 'btn btn-blue btn-medium'
	        				, 'ng-click' => "teacher.setActive('edit', teacher.record.id)"
	        			)
	        		) !!}

	        		{!! Form::button('Cancel'
	        			, array(
	        				'class' => 'btn btn-gold btn-medium'
	        				, 'ng-click' => "teacher.setActive('list')"
	        			)
	        		) !!}
	        	</div>
	        	<div ng-if="teacher.active_edit">
	        		{!! Form::button('Save'
	        			, array(
	        				'class' => 'btn btn-blue btn-medium'
	        				, 'ng-click' => "teacher.update()"
	        			)
	        		) !!}

	        		{!! Form::button('Cancel'
	        			, array(
	        				'class' => 'btn btn-gold btn-medium'
	        				, 'ng-click' => "teacher.setActive('view', teacher.record.id)"
	        			)
	        		) !!}
	        	</div>
		     </div>
		</div>
	{!! Form::close() !!}
	
	<div class="col-xs-12 table-container" ng-if="teacher.active_view">
		<div class="list-container" ng-cloak>
			<div class="size-container">
				{!! Form::select('size'
					, array(
						  '10' => '10'
						, '20' => '20'
						, '50' => '50'
						, '100' => '100'
					)
					, '10'
					, array(
						'ng-model' => 'teacher.table.size'
						, 'ng-change' => 'teacher.paginateBySize()'
						, 'ng-if' => "teacher.records.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table id="class-list" class="table table-striped table-bordered">
				<thead>
			        <tr>
			            <th class="column-medium">Class Handled</th>
			            <th>Number of Students</th>
			            <th>Grade</th>
			        </tr>
		        </thead>
		        <tbody>
			        <tr ng-repeat="a in teacher.clients">
			            <td>{! a.first_name !} {! a.last_name !}</td>
			            <td>{! a.user.email !}</td>
			            <td>{! a.client_role !}</td>
			        </tr>
			        <tr class="odd" ng-if="!teacher.records.length && !teacher.table.loading">
			        	<td valign="top" colspan="4" class="dataTables_empty">
			        		No records found
			        	</td>
			        </tr>
		        </tbody>
			</table>

			<div class="pull-right" ng-if="teacher.records.length">
				<pagination 
					total-items="teacher.table.total_items" 
					ng-model="teacher.table.page"
					max-size="3"
					items-per-page="teacher.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="teacher.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>