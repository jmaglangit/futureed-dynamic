<div ng-if="client.active_view || client.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_client_details') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="client.errors || client.success">
		<div class="alert alert-error" ng-if="client.errors">
            <p ng-repeat="error in client.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="client.success">
            <p> 
                {! client.success !}
            </p>
        </div>
    </div>

	<div class="search-container col-xs-12">
		{!! Form::open(array('id'=> 'add_client_form', 'class' => 'form-horizontal')) !!}
	        <fieldset>
	        	<legend class="legend-name-mid">
	        		{!! trans('messages.user_credentials') !!}
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="username">{!! trans('messages.username') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('username',''
	        				, array(
	        					'placeHolder' => trans('messages.username')
	        					, 'ng-model' => 'client.record.username'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'client.checkUsername(client.record.username, futureed.CLIENT, futureed.TRUE)'
	        					, 'ng-class' => "{ 'required-field' : client.fields['username'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<div class="margin-top-8" ng-if="client.active_edit"> 
		                <i ng-if="client.validation.u_loading" class="fa fa-spinner fa-spin"></i>
		                <i ng-if="client.validation.u_success" class="fa fa-check success-color"></i>
		                <span ng-if="client.validation.u_error" class="error-msg-con">{! client.validation.u_error !}</span>
		            </div>	
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="email">{!! trans('messages.email') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('email',''
	        				, array(
	        					'placeHolder' => trans('email')
	        					, 'ng-model' => 'client.record.email'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        					, 'ng-change' => 'client.checkEmail(client.record.email, futureed.CLIENT, futureed.TRUE)'
	        					, 'ng-class' => "{ 'required-field' : client.fields['email'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        		<div class="margin-top-8" ng-if="client.active_edit"> 
		                <i ng-if="client.validation.e_loading" class="fa fa-spinner fa-spin"></i>
		                <i ng-if="client.validation.e_success" class="fa fa-check success-color"></i>
		                <span ng-if="client.validation.e_error" class="error-msg-con">{! client.validation.e_error !}</span>
		            </div>	
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="status">{!! trans('messages.status') !!} <span class="required">*</span></label>
	        		<div class="col-xs-6 admin-view-client-details" ng-if="client.active_edit">
	        			<div class="col-xs-6 checkbox">	                				
	        				<label>
	        					{!! Form::radio('status'
	        						, 'Enabled'
	        						, false
	        						, array(
	        							'class' => 'field'
	        							, 'ng-model' => 'client.record.status'
	        							, 'ng-click' => 'client.clientChangeStatus()'
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
	        							, 'ng-model' => 'client.record.status'
	        							, 'ng-click' => 'client.clientChangeStatus()'
	        						)
	        					) !!}
	        				<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
	        				</label>
	        			</div>
	        		</div>

	        		<div ng-if="client.active_view">
	        		<label class="col-xs-5" ng-if="client.record.status == 'Enabled'">
	        			<b class="success-icon">
	        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! client.record.status !}
	        			</b>
	        		</label>

	        		<label class="col-xs-5" ng-if="client.record.status == 'Disabled'">
	        			<b class="error-icon">
	        				<i class="margin-top-8 fa fa-ban"></i> {! client.record.status !}
	        			</b>
	        		</label>
	        		</div>
	        				
	        	</div>
	        </fieldset>

	        <fieldset>
	        	<legend class="legend-name-mid">
	        		{!! trans('messages.personal_info') !!}
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="first_name">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('first_name',''
	        				, array(
	        					'placeHolder' => trans('messages.first_name')
	        					, 'ng-model' => 'client.record.first_name'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['first_name'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="last_name">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('last_name',''
	        				, array(
	        					'placeHolder' => trans('messages.last_name')
	        					, 'ng-model' => 'client.record.last_name'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['last_name'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label">{!! trans('messages.role') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::select('client_role'
	        				, [	
	        					'' => trans('messages.select_role'),
	            				'Principal' => 'Principal', 
	            				'Teacher' => 'Teacher', 
	            				'Parent' => 'Parent'
	            			  ]
	            			, '' 
	            			, [	  
		        				'class' => 'form-control'
		        				, 'ng-model' => 'client.record.client_role'
		        				, 'ng-disabled' => 'true'
		        			  ]	
	        			) !!}
	        		</div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.record.client_role == futureed.TEACHER">
	        	<legend class="legend-name-mid">
	        		{!! trans('messages.school_info') !!}
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label">{!! trans('messages.school_name') !!} <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('school_name',''
	        				, array(
	        					'placeHolder' => trans('messages.school_name')
	        					, 'ng-disabled' => 'true'
	        					, 'ng-model' => 'client.record.school_name'
	        					, 'ng-change' => "client.searchSchool('edit')"
                        		, 'ng-model-options' => "{ debounce : {'default' : 500} }"
                        		, 'ng-class' => "{ 'required-field' : client.fields['school_name'] }"
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
	        		<div class="margin-top-8" ng-if="client.active_edit"> 
		                <i ng-if="client.validation.s_loading" class="fa fa-spinner fa-spin"></i>
		                <span ng-if="client.validation.s_error" class="error-msg-con">{! client.validation.s_error !}</span>
		            </div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.record.client_role == futureed.PRINCIPAL">
	        	<legend class="legend-name-mid">
	        		{!! trans('messages.school_info') !!}
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_name">{!! trans('messages.school_name') !!} <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('school_name',''
	        				, array(
	        					'placeHolder' => trans('messages.school_name')
	        					, 'ng-model' => 'client.record.school_name'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_name'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_address">{!! trans('messages.school_address') !!} <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('school_address',''
	        				, array(
	        					'placeHolder' => trans('messages.school_address')
	        					, 'ng-model' => 'client.record.school_street_address'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_address'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_city">{!! trans('messages.city') !!}</label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_city',''
	        				, array(
	        					'placeHolder' => trans('messages.school_city')
	        					, 'ng-model' => 'client.record.school_city'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_city'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_state">{!! trans('messages.state') !!} <span class="required">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_state',''
	        				, array(
	        					'placeHolder' => trans('messages.school_state')
	        					, 'ng-model' => 'client.record.school_state'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_state'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_postal">{!! trans('messages.postal_code') !!}</label>
	        		<div class="col-xs-5">
	        			{!! Form::text('school_zip',''
	        				, array(
	        					'placeHolder' => 'trans(messages.postal_code)'
	        					, 'ng-model' => 'client.record.school_zip'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_zip'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label">{!! trans('messages.country') !!} <span class="required">*</span></label>
				      <div class="col-xs-5" ng-init="getCountries()">
				        <select  name="school_country_id" class="form-control" ng-class="{ 'required-field' : client.fields['school_country_id'] }" ng-disabled="client.active_view" ng-model="client.record.school_country_id">
				          <option ng-selected="client.record.school_country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
				          <option ng-selected="client.record.school_country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
				        </select>
				      </div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.record.client_role == futureed.PRINCIPAL">
	        	<legend class="legend-name-mid">
	        		{!! trans('messages.school_info') !!}
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="contact_person">{!! trans('messages.contact_person') !!} <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('school_contact_name',''
	        				, array(
	        					'placeHolder' => trans('messages.contact_person')
	        					, 'ng-model' => 'client.record.school_contact_name'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_contact_name'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="contact_number">{!! trans('messages.contact_number') !!} <span class="required">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('school_contact_number',''
	        				, array(
	        					'placeHolder' => trans('messages.contact_number')
	        					, 'ng-model' => 'client.record.school_contact_number'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['school_contact_number'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        </fieldset>
	        <fieldset ng-if="client.record.client_role">
	        	<legend class="legend-name-mid" ng-if="client.record.client_role !== futureed.PARENT">
	        		{!! trans('messages.other_address_info') !!}
	        	</legend>
	        	<legend class="legend-name-mid" ng-if="client.record.client_role == futureed.PARENT">
	        		{!! trans('messages.address_info') !!}
	        	</legend>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_address">{!! trans('messages.street_address') !!} <span class="required" ng-if="client.record.client_role == futureed.PARENT">*</span></label>
	        		<div class="col-xs-6">
	        			{!! Form::text('street_address',''
	        				, array(
	        					'placeHolder' => trans('messages.street_address')
	        					, 'ng-model' => 'client.record.street_address'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['street_address'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_city">{!! trans('messages.city') !!} <span class="required" ng-if="client.record.client_role == futureed.PARENT">*</span></label>
	        		<div class="col-xs-5">
	        			{!! Form::text('city',''
	        				, array(
	        					'placeHolder' => trans('messages.city')
	        					, 'ng-model' => 'client.record.city'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['city'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_state">{!! trans('messages.state') !!} </label>
	        		<div class="col-xs-5">
	        			{!! Form::text('state',''
	        				, array(
	        					'placeHolder' => trans('messages.state')
	        					, 'ng-model' => 'client.record.state'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['state'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label" id="school_postal">{!! trans('messages.postal_code') !!}</label>
	        		<div class="col-xs-5">
	        			{!! Form::text('zip',''
	        				, array(
	        					'placeHolder' => trans('messages.postal_code')
	        					, 'ng-model' => 'client.record.zip'
	        					, 'ng-disabled' => 'client.active_view'
	        					, 'ng-class' => "{ 'required-field' : client.fields['zip'] }"
	        					, 'class' => 'form-control'
	        				)
	        			) !!}
	        		</div>
	        	</div>
	        	<div class="form-group">
	        		<label class="col-xs-3 control-label">{!! trans('messages.country') !!} <span class="required" ng-if="client.record.client_role == futureed.PARENT">*</span></label>
				      <div class="col-xs-5" ng-init="getCountries()">
				        <select  name="country_id" class="form-control" ng-class="{ 'required-field' : client.fields['country_id'] }" ng-disabled="client.active_view" ng-model="client.record.country_id">
				          <option ng-selected="client.record.country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
				          <option ng-selected="client.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
				        </select>
				      </div>
	        	</div>
	        </fieldset>
	        <fieldset>
		        <div class="btn-container">
		        	<div ng-if="client.active_view">
		        		<div ng-if="client.record.account_status == futureed.PENDING">
			        		{!! Form::button(trans('messages.verify')
				        		, array(
				        			'class' => 'btn btn-blue btn-medium'
				        			, 'ng-click' => "client.verifyClient()"
				        		)
				        	) !!}

				        	{!! Form::button(trans('messages.reject')
				        		, array(
				        			'class' => 'btn btn-gold btn-medium'
				        			, 'ng-click' => "client.rejectClient()"
				        		)
				        	) !!}
			        	</div>

			        	<div class="margin-10-top">
				        	{!! Form::button(trans('messages.edit')
				        		, array(
				        			'class' => 'btn btn-blue btn-medium'
				        			, 'ng-click' => "client.setActive(futureed.ACTIVE_EDIT, client.record.id)"
				        		)
				        	) !!}

				        	{!! Form::button(trans('messages.cancel')
				        		, array(
				        			'class' => 'btn btn-gold btn-medium'
				        			, 'ng-click' => 'client.setActive()'
				        		)
				        	) !!}
			        	</div>
		        	</div>

		        	<div ng-if="client.active_edit">
		        		{!! Form::button(trans('messages.save')
			        		, array(
			        			'class' => 'btn btn-blue btn-medium'
			        			, 'ng-click' => 'client.updateClientDetails()'
			        		)
			        	) !!}

			        	{!! Form::button(trans('messages.cancel')
			        		, array(
			        			'class' => 'btn btn-gold btn-medium'
			        			, 'ng-click' => "client.setActive(futureed.ACTIVE_VIEW, client.record.id)"
			        		)
			        	) !!}
		        	</div>
			     </div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>