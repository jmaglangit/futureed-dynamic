<div ng-if="student.active_view">
	<div class="content-title">
		<div class="title-main-content" ng-if="!student.edit">
			<span>View Student</span>
		</div>
		<div class="title-main-content" ng-if="student.edit">
			<span>Edit Student</span>
		</div>
	</div>

	{!! Form::open(['class' => 'form-horizontal', 'id' => 'student_form']) !!}
		<div class="col-xs-12 form-content">
			<div class="alert alert-error" ng-if="student.errors">
	            <p ng-repeat="error in student.errors track by $index" > 
	              	{! error !}
	            </p>
	        </div>

	        <div class="alert alert-success" ng-if="student.success">
	        	<p>Successfully edited student.</p>
	        </div>

	        <div class="alert alert-success" ng-if="student.e_success">
	        	<p>{! student.e_success !}</p>
	        </div>

			<fieldset>
				<legend class="legend-name-mid">
					User Credentials
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-2">Username <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('username','',
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.username'
									, 'ng-disabled' => '!student.edit'
									, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        						, 'ng-change' => 'student.checkUsername(student.record.username, futureed.STUDENT, futureed.TRUE)'
									, 'placeholder' => 'Username'
								])
						!!}
					</div>

					<div class="margin-top-8"> 
		                <i ng-if="student.validation.u_loading" class="fa fa-spinner fa-spin"></i>
		                <i ng-if="student.validation.u_success" class="fa fa-check success-color"></i>
		                <span ng-if="student.validation.u_error" class="error-msg-con">{! student.validation.u_error !}</span>
		            </div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-2">Email <span class="required">*</span></label>
					<div class="col-xs-4">
						<div class="input-group">
							{!! Form::text('email','',
									[
										'class' => 'form-control',
										'ng-model' => 'student.record.email',
										'ng-disabled' => 'true',
										'placeHolder' => 'Email'
									])
							!!}

							<span class="input-group-addon" ng-click="student.setActive('change')"><i class="fa fa-pencil edit-addon"></i></span>
						</div>
					</div>

					<div ng-if="student.record.new_email">
						<label class="control-label col-xs-2 text-red">Pending Email</label>
						<div class="col-xs-5">
							{!!
								Form::text('pending_email','asd',
									[
										'class' => 'form-control',
										'ng-model' => 'student.record.new_email',
										'ng-disabled' => 'true',
										'placeHolder' => 'Email'
									])
							!!}
						</div>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<legend class="legend-name-mid">
					Personal Information
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-2">First Name <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('firstname','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.record.first_name',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'First Name'
								])
						!!}
					</div>
					<label class="control-label col-xs-2">Last Name <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('lastname','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.record.last_name',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'Last Name'
								])
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Birthday <span class="required">*</span></label>
					<div class="col-xs-8 bdate-dropdown">
	                    <input type="hidden" id="birth_date">
	                </div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Gender <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::select('gender',['' => '-- Select Gender --', 'Male' => 'Male', 'Female' => 'Female'],null,
								[
									'class' => 'form-control',
									'ng-model' => 'student.record.gender',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'City'
								])
						!!}
					</div>
					<label class="control-label col-xs-2">City <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('city','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.record.city',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'City'
								])
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">State</label>
					<div class="col-xs-4">
						{!!
							Form::text('state','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.record.state',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'State'
								])
						!!}
					</div>
					<label class="control-label col-xs-2">Country <span class="required">*</span></label>
					<div class="col-xs-4" ng-init="getCountries()">
	                    <select ng-disabled="!student.edit" name="country_id" 
								id="country" 
								class="form-control" 
								ng-model="student.record.country_id" 
								ng-change="student.getCountryId()">
	                        <option ng-selected="student.record.country_id == futureed.FALSE" value="">-- Select Country --</option>
	                        <option ng-selected="student.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
	                    </select>
	                </div>
				</div>

				<div class="form-group">
					<div class="col-xs-9 col-xs-offset-2 btn-container">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-if' => '!student.edit'
								, 'ng-click' => "student.setActive('edit', student.record.id)"
								, 'ng-show' => '!student.edit_form'
							)
						) !!}
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-if' => 'student.edit_form'
								, 'ng-click' => "student.saveStudent()"
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-if' => '!student.edit'
								, 'ng-click' => "student.setActive('list')"
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-if' => 'student.edit'
								, 'ng-click' => "student.setActive('view', student.record.id)"
							)
						) !!}
					</div>
				</div>

				<div class="form-group"></div>
			</fieldset>
		</div>
	{!! Form::close() !!}
</div>