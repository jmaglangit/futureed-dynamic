<div ng-if="client.active_view_client || client.active_edit_client">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Client Details</span>
		</div>
	</div>

	{!! Form::open(array('id'=> 'add_client_form', 'class' => 'form-horizontal')) !!}
		<div class="form-content col-xs-12">
			<div class="alert alert-error" ng-if="client.errors">
	            <p ng-repeat="error in client.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

	        <div class="alert alert-success" ng-if="success">
	        	<p>Successfully updated this profile.</p>
	        </div>

	        <div class="alert alert-success" ng-if="client.details.verified">
	        	<p>Successfully verified this profile.</p>
	        </div>

	        <div class="alert alert-success" ng-if="client.details.rejected">
	        	<p>Successfully rejected this profile.</p>
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
	        					, 'ng-model' => 'client.details.email'
	        					, 'ng-disabled' => 'client.active_view_client'
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
	        					, 'ng-model' => 'client.details.username'
	        					, 'ng-disabled' => 'client.active_view_client'
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
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="status">Status <span class="required">*</span></label>
	        		<div class="col-xs-5" ng-if="client.active_edit_client">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, false
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'client.details.status'
	        							, 'ng-click' => 'client.clientChangeStatus()'
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
	        							, 'ng-model' => 'client.details.status'
	        							, 'ng-click' => 'client.clientChangeStatus()'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disabled</span>
	        				</label>
	        			</div>
	        		</div>

	        		<div ng-if="client.active_view_client">
	        		<label class="col-xs-5" ng-if="client.details.status == 'Enabled'">
	        			<b class="success-icon">
	        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! client.details.status !}
	        			</b>
	        		</label>

	        		<label class="col-xs-5" ng-if="client.details.status == 'Disabled'">
	        			<b class="error-icon">
	        				<i class="margin-top-8 fa fa-ban"></i> {! client.details.status !}
	        			</b>
	        		</label>
	        		</div>
	        				
	        	</div>
	        </fieldset>

	        <fieldset>
	        	<legend class="legend-name-mid">
	        		Personal Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="first_name">Firstname <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('first_name',''
	        				, array(
	        					'placeHolder' => 'Firstname'
	        					, 'ng-model' => 'client.details.first_name'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="last_name">Lastname <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('last_name',''
	        				, array(
	        					'placeHolder' => 'Lastname'
	        					, 'ng-model' => 'client.details.last_name'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">Role <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::select('client_role'
	        				, [	
	        					'' => '-- Select Role --',
	            				'Principal' => 'Principal', 
	            				'Teacher' => 'Teacher', 
	            				'Parent' => 'Parent'
	            			  ]
	            			, '' 
	            			, [	  
		        				'class' => 'form-control'
		        				, 'ng-model' => 'client.details.client_role'
		        				, 'ng-disabled' => 'client.active_view_client'
		        				, 'ng-change'=> 'client.setClientRole()'
		        			  ]	
	        			) !!}
	        		</div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.role.teacher">
	        	<legend class="legend-name-mid">
	        		School Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label">School Name <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_name',''
	        				, array(
	        					'placeHolder' => 'School Name'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'ng-model' => 'client.details.school_name'
	        					, 'ng-change' => 'client.searchSchool()'
                        		, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        			<div class="angucomplete-holder" ng-if="client.schools">
							<ul class="col-xs-5 angucomplete-dropdown">
								<li class="angucomplete-row" ng-repeat="school in client.schools" ng-click="client.selectSchool(school)">
									{! school.name !}
								</li>
							</ul>
						</div>
	        		</div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.role.principal">
	        	<legend class="legend-name-mid">
	        		School Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_name">School Name <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_name',''
	        				, array(
	        					'placeHolder' => 'School Name'
	        					, 'ng-model' => 'client.details.school_name'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_address">School Address <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_address',''
	        				, array(
	        					'placeHolder' => 'School Address'
	        					, 'ng-model' => 'client.details.school_address'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_city">City <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('school_city',''
	        				, array(
	        					'placeHolder' => 'School City'
	        					, 'ng-model' => 'client.details.school_city'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<label class="col-xs-2 control-label" id="school_state">State <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('school_state',''
	        				, array(
	        					'placeHolder' => 'School State'
	        					, 'ng-model' => 'client.details.school_state'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_postal">Postal Code <span class="required">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('school_zip',''
	        				, array(
	        					'placeHolder' => 'Postal Code'
	        					, 'ng-model' => 'client.details.school_zip'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<label class="col-md-2 control-label">Country <span class="required">*</span></label>
				      <div class="col-md-4" ng-init="getCountries()">
				        <select  name="school_country" class="form-control" ng-disabled="client.active_view_client" ng-model="client.details.school_country">
				          <option value="">-- Select Country --</option>
				          <option ng-selected="{! client.details.school_country == country.name !}" ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
				        </select>
				      </div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.role.principal">
	        	<legend class="legend-name-mid">
	        		School Contact Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="contact_person">Contact Person <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('contact_name',''
	        				, array(
	        					'placeHolder' => 'Contact Person'
	        					, 'ng-model' => 'client.details.school_contact_name'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="contact_number">Contact Number <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('contact_number',''
	        				, array(
	        					'placeHolder' => 'Contact Number'
	        					, 'ng-model' => 'client.details.school_contact_number'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.details.client_role">
	        	<legend class="legend-name-mid" ng-if="!client.role.parent">
	        		Other Address Information (Optional)
	        	</legend>
	        	<legend class="legend-name-mid" ng-if="client.role.parent">
	        		Address Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_address">Street Address <span class="required" ng-if="client.role.parent">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('street_address',''
	        				, array(
	        					'placeHolder' => 'Street Address'
	        					, 'ng-model' => 'client.details.street_address'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_city">City <span class="required" ng-if="client.role.parent">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('city',''
	        				, array(
	        					'placeHolder' => 'City'
	        					, 'ng-model' => 'client.details.city'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<label class="col-xs-2 control-label" id="school_state">State <span class="required" ng-if="client.role.parent">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('state',''
	        				, array(
	        					'placeHolder' => 'State'
	        					, 'ng-model' => 'client.details.state'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-2 control-label" id="school_postal">Postal Code <span class="required" ng-if="client.role.parent">*</span></label>
	        		<div class="col-xs-4">
	        			{!! Form::text('zip',''
	        				, array(
	        					'placeHolder' => 'Postal Code'
	        					, 'ng-model' => 'client.details.zip'
	        					, 'ng-disabled' => 'client.active_view_client'
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<label class="col-md-2 control-label">Country <span class="required" ng-if="client.role.parent">*</span></label>
				      <div class="col-md-4" ng-init="getCountries()">
				        <select  name="country" class="form-control" ng-disabled="client.active_view_client" ng-model="client.details.country">
				          <option value="">-- Select Country --</option>
				          <option ng-selected="{! client.details.country == country.name !}" ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
				        </select>
				      </div>
	        	</div>
	        </fieldset>
	        <div class="btn-container">
	        	<div ng-if="client.active_view_client">
	        		<div ng-if="client.details.account_status == 'Pending'">
		        		{!! Form::button('Verify'
			        		, array(
			        			'class' => 'btn btn-blue btn-medium'
			        			, 'ng-click' => "client.verifyClient()"
			        		)
			        	) !!}

			        	{!! Form::button('Reject'
			        		, array(
			        			'class' => 'btn btn-gold btn-medium'
			        			, 'ng-click' => "client.rejectClient()"
			        		)
			        	) !!}
		        	</div>

		        	{!! Form::button('Edit'
		        		, array(
		        			'class' => 'btn btn-blue btn-medium'
		        			, 'ng-click' => "client.setManageClientActive('edit_client')"
		        		)
		        	) !!}

		        	{!! Form::button('Cancel'
		        		, array(
		        			'class' => 'btn btn-gold btn-medium'
		        			, 'ng-click' => 'client.setManageClientActive()'
		        		)
		        	) !!}
	        	</div>

	        	<div ng-if="client.active_edit_client">
	        		{!! Form::button('Save'
		        		, array(
		        			'class' => 'btn btn-blue btn-medium'
		        			, 'ng-click' => 'client.updateClientDetails()'
		        		)
		        	) !!}

		        	{!! Form::button('Cancel'
		        		, array(
		        			'class' => 'btn btn-gold btn-medium'
		        			, 'ng-click' => "client.setManageClientActive('view_client')"
		        		)
		        	) !!}
	        	</div>
		     </div>
		</div>
	{!! Form::close() !!}
</div>