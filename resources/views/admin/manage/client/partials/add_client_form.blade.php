<div ng-if="client.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Client</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="client.errors || client.success">
		<div class="alert alert-error" ng-if="client.errors">
            <p ng-repeat="error in client.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="client.success">
            <p> {! client.success !}</p>
        </div>
    </div>

	<div class="search-container col-xs-12">
		{!! Form::open(array('id'=> 'add_client_form', 'class' => 'form-horizontal')) !!}
	        <fieldset>
	        	<legend class="legend-name-mid">
	        		User Credentials
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="username">Username <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('username',''
	        				, array(
	        					'placeHolder' => 'Username'
	        					, 'ng-model' => 'client.record.username'
	        					, 'ng-class' => "{ 'required-field' : client.fields['username'] }"
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'client.checkUsername(client.record.username, futureed.CLIENT, futureed.FALSE)'
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
	        		<label class="col-xs-3 control-label" id="email">Email <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('email',''
	        				, array(
	        					'placeHolder' => 'Email'
	        					, 'ng-model' => 'client.record.email'
	        					, 'ng-class' => "{ 'required-field' : client.fields['email'] }"
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'client.checkEmail(client.record.email, futureed.CLIENT, futureed.FALSE)'
	        					, 'autocomplete' => 'off'
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
	        		<label class="col-xs-3 control-label" id="status">Status <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, false
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'client.record.status'
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
	        							, 'ng-model' => 'client.record.status'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">Disabled</span>
	        				</label>
	        			</div>
	        		</div>
	        	</div>
	        </fieldset>

	        <fieldset>
	        	<legend class="legend-name-mid">
	        		Personal Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="first_name">First Name <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('first_name',''
	        				, array(
	        					'placeHolder' => 'First Name'
	        					, 'ng-model' => 'client.record.first_name'
	        					, 'ng-class' => "{ 'required-field' : client.fields['first_name'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="last_name">Last Name <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('last_name',''
	        				, array(
	        					'placeHolder' => 'Last Name'
	        					, 'ng-model' => 'client.record.last_name'
	        					, 'ng-class' => "{ 'required-field' : client.fields['last_name'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label">Role <span class="required">*</span></label>
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
		        				'class' => 'form-control',
		        				'ng-model' => 'client.record.client_role'
		        				, 'ng-class' => "{ 'required-field' : client.fields['client_role'] }"
		        				, 'ng-change' => "client.roleChange()"
		        			  ]	
	        			) !!}
	        		</div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.record.client_role == futureed.TEACHER">
	        	<legend class="legend-name-mid">
	        		School Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label">School Name <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('school_name',''
	        				, array(
	        					'placeHolder' => 'School Name'
	        					, 'ng-model' => 'client.record.school_name'
	        					, 'ng-change' => "client.searchSchool('record')"
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_name'] }"
                        		, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        			<div class="angucomplete-holder" ng-if="client.schools">
							<ul class="col-xs-6 angucomplete-dropdown">
								<li class="angucomplete-row" ng-repeat="school in client.schools" ng-click="client.selectSchool(school)">
									{! school.name !}
								</li>
							</ul>
						</div>
	        		</div>
	        		<div class="margin-top-8"> 
		                <i ng-if="client.validation.s_loading" class="fa fa-spinner fa-spin"></i>
		                <span ng-if="client.validation.s_error" class="error-msg-con">{! client.validation.s_error !}</span>
		            </div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.record.client_role == futureed.PRINCIPAL">
	        	<legend class="legend-name-mid">
	        		School Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_name">School Name <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('school_name',''
	        				, array(
	        					'placeHolder' => 'School Name'
	        					, 'ng-model' => 'client.record.school_name'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_name'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_address">School Address <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('school_address',''
	        				, array(
	        					'placeHolder' => 'School Address'
	        					, 'ng-model' => 'client.record.school_address'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_address'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_city">City</label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_city',''
	        				, array(
	        					'placeHolder' => 'School City'
	        					, 'ng-model' => 'client.record.school_city'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_city'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div  class="form-group">
	        		<label class="col-xs-3 control-label" id="school_state">State <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_state',''
	        				, array(
	        					'placeHolder' => 'School State'
	        					, 'ng-model' => 'client.record.school_state'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_state'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_postal">Postal Code</label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_zip',''
	        				, array(
	        					'placeHolder' => 'Postal Code'
	        					, 'ng-model' => 'client.record.school_zip'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_zip'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div  class="form-group">
	        		<label class="col-xs-3 control-label">Country <span class="required">*</span></label>
				      <div class="col-xs-5" ng-init="getCountries()">
				        <select  name="school_country_id" class="form-control" ng-class="{ 'required-field' : client.fields['school_country_id'] }" ng-model="client.record.school_country_id">
				          <option ng-selected="client.record.school_country_id == futureed.FALSE" value="">-- Select Country --</option>
				          <option ng-selected="client.record.school_country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
				        </select>
				      </div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.record.client_role == futureed.PRINCIPAL">
	        	<legend class="legend-name-mid">
	        		School Contact Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="contact_person">Contact Person <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('contact_name',''
	        				, array(
	        					'placeHolder' => 'Contact Person'
	        					, 'ng-model' => 'client.record.contact_name'
	        					, 'ng-class' => "{ 'required-field' : client.fields['contact_name'] }"
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
	        					, 'ng-model' => 'client.record.contact_number'
	        					, 'ng-class' => "{ 'required-field' : client.fields['contact_number'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.record.client_role">
	        	<legend class="legend-name-mid" ng-if="client.record.client_role !== futureed.PARENT">
	        		Other Address Information (Optional)
	        	</legend>
	        	<legend class="legend-name-mid" ng-if="client.record.client_role == futureed.PARENT">
	        		Address Information
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_address">Street Address</label>
	        		<div class="col-xs-6">
	        			{!! Form::text('street_address',''
	        				, array(
	        					'placeHolder' => 'Street Address'
	        					, 'ng-model' => 'client.record.street_address'
	        					, 'ng-class' => "{ 'required-field' : client.fields['street_address'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_city">City</label>
	        		<div class="col-xs-5">
	        			{!! Form::text('city',''
	        				, array(
	        					'placeHolder' => 'City'
	        					, 'ng-model' => 'client.record.city'
	        					, 'ng-class' => "{ 'required-field' : client.fields['city'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_state">State</label>
	        		<div class="col-xs-5">
	        			{!! Form::text('state',''
	        				, array(
	        					'placeHolder' => 'State'
	        					, 'ng-model' => 'client.record.state'
	        					, 'ng-class' => "{ 'required-field' : client.fields['state'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_postal">Postal Code</label>
	        		<div class="col-xs-5">
	        			{!! Form::text('zip',''
	        				, array(
	        					'placeHolder' => 'Postal Code'
	        					, 'ng-model' => 'client.record.zip'
	        					, 'ng-class' => "{ 'required-field' : client.fields['zip'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label">Country</label>
				      <div class="col-xs-5" ng-init="getCountries()">
				        <select  name="country_id" class="form-control" ng-class="{ 'required-field' : client.fields['country_id'] }" ng-model="client.record.country_id">
				          <option ng-selected="client.record.country_id == futureed.FALSE" value="">-- Select Country --</option>
				          <option ng-selected="client.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
				        </select>
				      </div>
	        	</div>
	        </fieldset>
	        <fieldset>
		        <div class="btn-container col-xs-9 col-xs-offset-1">
		        	{!! Form::button('Save'
		        		, array(
		        			'class' => 'btn btn-blue btn-medium'
		        			, 'ng-click' => 'client.add()'
		        		)
		        	) !!}

		        	{!! Form::button('Cancel'
		        		, array(
		        			'class' => 'btn btn-gold btn-medium'
		        			, 'ng-click' => 'client.setActive()'
		        		)
		        	) !!}
			     </div>
		     </fieldset>
		{!! Form::close() !!}	
	</div>
</div>