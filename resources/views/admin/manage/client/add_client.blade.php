<div ng-if="admincon.add_client">
<div class="content-title">
					<div class="title-main-content">
						<span>Add New Client</span>
					</div>
				</div>
				<div class="form-content col-xs-12">
					<div class="alert alert-error" ng-if="errors">
			            <p ng-repeat="error in profile.errors track by $index" > 
			              	{! error !}
			            </p>
			        </div>
	                <div class="alert alert-success" ng-if="success">
	                	<p>Successfully update profile.</p>
	                </div>
	                {!! Form::open(array('id'=> 'search_form', 'method' => 'POST', 'class' => 'form-horizontal')) !!}
	                <fieldset>
	                	<legend class="legend-name-mid">
	                		Personal Information
	                	</legend>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="first_name">Firstname</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('first_name',''
	                				, array(
	                					'placeHolder' => 'Firstname'
	                					, 'ng-model' => 'first_name'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="last_name">Lastname</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('last_name',''
	                				, array(
	                					'placeHolder' => 'Lastname'
	                					, 'ng-model' => 'last_name'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="first_name">Role</label>
	                		<div class="col-xs-5" ng-init="admincon.changeField('Principal')">
	                			{!! Form::select('role', 
	                				[	'' => '-- Select Role --',
		                				'Principal' => 'Principal', 
		                				'Teacher' => 'Teacher', 
		                				'Parent' => 'Parent'
		                			],null,
	                				[	  
	                				'class' => 'form-control',
	                				'ng-model' => 'admincon.role',
	                				'ng-change'=> 'admincon.changeField(admincon.role)'
	                				]	
	                			) !!}
	                		</div>
	                	</div>
	                </fieldset>
	                <fieldset>
	                	<legend class="legend-name-mid">
	                		User Credentials
	                	</legend>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="email">Email</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('email',''
	                				, array(
	                					'placeHolder' => 'Email'
	                					, 'ng-model' => 'email'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="username">Username</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('username',''
	                				, array(
	                					'placeHolder' => 'Username'
	                					, 'ng-model' => 'username'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="status">Status</label>
	                		<div class="col-xs-5">
	                			<div class="col-xs-6 checkbox">	                				
	                				<label>{!! Form::radio('example', 1, false, ['class' => 'field']) !!}
	                				<span class="lbl padding-8">Enabled</span>
	                				</label>
	                			</div>
	                			<div class="col-xs-6 checkbox">
	                				<label>{!! Form::radio('example', 1, true, ['class' => 'field']) !!}
	                				<span class="lbl padding-8">Disabled</span>
	                				</label>
	                			</div>
	                		</div>
	                	</div>
	                </fieldset>
	                <fieldset ng-if="admincon.principal || admincon.teacher || admincon.role_select">
	                	<legend class="legend-name-mid">
	                		School Information
	                	</legend>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="school_name">School Name</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('school_name',''
	                				, array(
	                					'placeHolder' => 'School Name'
	                					, 'ng-model' => 'school_name'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group" ng-if="!admincon.teacher || admincon.role_select">
	                		<label class="col-xs-2 control-label" id="school_address">School Address</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('school_address',''
	                				, array(
	                					'placeHolder' => 'School Address'
	                					, 'ng-model' => 'school_address'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group" ng-if="!admincon.teacher || admincon.role_select">
	                		<label class="col-xs-2 control-label" id="school_city">City</label>
	                		<div class="col-xs-4">
	                			{!! Form::text('school_city',''
	                				, array(
	                					'placeHolder' => 'School City'
	                					, 'ng-model' => 'school_city'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                		<label class="col-xs-2 control-label" id="school_state">State</label>
	                		<div class="col-xs-4">
	                			{!! Form::text('school_state',''
	                				, array(
	                					'placeHolder' => 'School State'
	                					, 'ng-model' => 'school_state'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group" ng-if="!admincon.teacher || admincon.role_select">
	                		<label class="col-xs-2 control-label" id="school_postal">Postal Code</label>
	                		<div class="col-xs-4">
	                			{!! Form::text('school_postal',''
	                				, array(
	                					'placeHolder' => 'Postal Code'
	                					, 'ng-model' => 'school_postal'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                		<label class="col-md-2 control-label">Country<span class="required" ng-if="register.required">*</span></label>
						      <div class="col-md-4" ng-init="getCountries()">
						        <select  name="country" class="form-control" ng-model="register.reg.country">
						          <option value="">-- Select Country --</option>
						          <option ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
						        </select>
						      </div>
	                	</div>
	                	<div class="form-group" ng-if="!admincon.teacher || admincon.role_select">
	                		<label class="col-xs-2 control-label" id="contact_person">Contact Person</label>
	                		<div class="col-xs-4">
	                			{!! Form::text('contact_person',''
	                				, array(
	                					'placeHolder' => 'Contact Person'
	                					, 'ng-model' => 'contact_person'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                		<label class="col-xs-2 control-label" id="contact_number">Contact Number</label>
	                		<div class="col-xs-4">
	                			{!! Form::text('contact_number',''
	                				, array(
	                					'placeHolder' => 'Contact Number'
	                					, 'ng-model' => 'contact_number'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                </fieldset>
	                <fieldset ng-if="admincon.teacher || admincon.principal || admincon.parent">
	                	<legend class="legend-name-mid" ng-if="!admincon.parent">
	                		Other Address Information(Optional)
	                	</legend>
	                	<legend class="legend-name-mid" ng-if="admincon.parent">
	                		Address
	                	</legend>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="school_name">School Name</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('school_name',''
	                				, array(
	                					'placeHolder' => 'School Name'
	                					, 'ng-model' => 'school_name'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="school_address">School Address</label>
	                		<div class="col-xs-5">
	                			{!! Form::text('school_address',''
	                				, array(
	                					'placeHolder' => 'School Address'
	                					, 'ng-model' => 'school_address'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="school_city">City</label>
	                		<div class="col-xs-4">
	                			{!! Form::text('school_city',''
	                				, array(
	                					'placeHolder' => 'School City'
	                					, 'ng-model' => 'school_city'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                		<label class="col-xs-2 control-label" id="school_state">State</label>
	                		<div class="col-xs-4">
	                			{!! Form::text('school_state',''
	                				, array(
	                					'placeHolder' => 'School State'
	                					, 'ng-model' => 'school_state'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                	</div>
	                	<div class="form-group">
	                		<label class="col-xs-2 control-label" id="school_postal">Postal Code</label>
	                		<div class="col-xs-4">
	                			{!! Form::text('school_postal',''
	                				, array(
	                					'placeHolder' => 'Postal Code'
	                					, 'ng-model' => 'school_postal'
	                					, 'class' => 'form-control'
	                				)
	                			) !!}
	                		</div>
	                		<label class="col-md-2 control-label">Country<span class="required" ng-if="register.required">*</span></label>
						      <div class="col-md-4" ng-init="getCountries()">
						        <select  name="country" class="form-control" ng-model="register.reg.country">
						          <option value="">-- Select Country --</option>
						          <option ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
						        </select>
						      </div>
	                	</div>
	                </fieldset>
	                <div class="btn-container col-sm-6 col-sm-offset-3">
				        <a href="#" type="button" class="btn btn-blue btn-medium">Save</a>
				        <a href="#" type="button" class="btn btn-gold btn-medium">Cancel</a>
				     </div>
				</div>
</div>