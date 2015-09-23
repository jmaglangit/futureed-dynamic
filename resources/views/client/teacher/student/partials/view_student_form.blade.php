<div ng-if="teacher.active_view || teacher.active_edit">
	<div class="content-title">
		<div class="title-main-content" ng-if="teacher.active_view">
			<span>View Student</span>
		</div>
		<div class="title-main-content" ng-if="teacher.active_edit">
			<span>Edit Student</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="teacher.errors || teacher.success">
		<div class="alert alert-error" ng-if="teacher.errors">
			<p ng-repeat="error in teacher.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="teacher.success">
            <p>{! teacher.success !}</p>
        </div>
    </div>

	{!! Form::open(['class' => 'form-horizontal', 'id' => 'student_form']) !!}
		<div class="module-container">
			<div class="col-xs-12">
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
										, 'ng-model' => 'teacher.record.username'
										, 'ng-disabled' => 'true'
										, 'placeHolder' => 'Username'
									])
							!!}
						</div>
					</div>	

					<div class="form-group" ng-if="teacher.record.new_email">
						<label class="control-label col-xs-2">Email <span class="required">*</span></label>
						<div class="col-xs-4">
							<div class="input-group">
								{!! Form::text('email','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.email'
										, 'ng-disabled' => 'true'
										, 'placeHolder' => 'Email'
									])
								!!}	

								<span class="input-group-addon" ng-click="teacher.setActive(futureed.ACTIVE_EMAIL)"><i class="fa fa-pencil edit-addon"></i></span>
							</div>
						</div>

						<label class="control-label col-xs-2 text-red">Pending Email</label>
						<div class="col-xs-4">
							{!! Form::text('pending_email','',
								[
									'class' => 'form-control',
									'ng-model' => 'teacher.record.new_email',
									'ng-readonly' => 'true',
									'placeHolder' => 'Pending Email'
								])
							!!}
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
								Form::text('first_name','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.first_name'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['first_name'] }"
										, 'placeHolder' => 'First Name'
									])
							!!}
						</div>
						<label class="control-label col-xs-2">Last Name <span class="required">*</span></label>
						<div class="col-xs-4">
							{!!
								Form::text('last_name','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.last_name'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['last_name'] }"
										, 'placeHolder' => 'Last Name'
									])
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2">Gender <span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::select('gender'
									, array(
										'' => '-- Select Gender --'
										, 'Male' => 'Male'
										, 'Female' => 'Female')
									, null
									, array(
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.gender'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['gender'] }"
									)
								) !!}
						</div>

						<label class="control-label col-xs-2">City <span class="required">*</span></label>
						<div class="col-xs-4">
							{!!
								Form::text('city','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.city'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['city'] }"
										, 'placeHolder' => 'City'
									])
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2">State </label>
						<div class="col-xs-4">
							{!!
								Form::text('state','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.state'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['state'] }"
										, 'placeHolder' => 'State'
									])
							!!}
						</div>

						<label class="control-label col-xs-2">Country <span class="required">*</span></label>
						<div class="col-xs-4" ng-init="getCountries()">
							<select ng-disabled="true" name="country" class="form-control" ng-model="teacher.record.country_id">
								<option ng-selected="teacher.record.country_id == futureed.FALSE" value="">-- Select Country --</option>
								<option ng-selected="teacher.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
							</select>
						</div>						
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2">Birthday <span class="required">*</span></label>
						<div class="col-xs-6">
							<input type="hidden" id="birth_date" ng-init="teacher.setdateDropdown(teacher.record.birth_date)"/>		                        
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend class="legend-name-mid">School Information</legend>
					<div class="form-group">
						<label class="control-label col-xs-2">School Name <span class="required">*</span></label>
						<div class="col-xs-5">
							{!!
								Form::text('school_name','',
									[
										'class' => 'form-control',
										'ng-model' => 'teacher.record.school.name',
										'ng-disabled' => 'true',
										'placeHolder' => 'School Name'
									])
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2">Grade <span class="required">*</span></label>
						<div class="col-xs-5 nullable">
		                    <select ng-disabled="true" name="grade_code" class="form-control" ng-model="teacher.record.grade_code">
		                        <option value="">-- Select Level --</option>
		                        <option ng-selected="teacher.record.grade_code == grade.code" ng-repeat="grade in grades" ng-value="grade.code">{! grade.name !}</option>
		                    </select>
		                </div>
					</div>
				</fieldset>
				<div class="row margin-40-bot">
					<div class="col-xs-6 col-xs-offset-3 btn-container" ng-if="teacher.active_view">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "teacher.setActive(futureed.ACTIVE_EDIT, teacher.record.id)"
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "teacher.setActive()"
							)
						) !!}
					</div>
					<div class="col-xs-6 col-xs-offset-3 btn-container" ng-if="teacher.active_edit">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "teacher.updateDetails()"
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "teacher.setActive(futureed.ACTIVE_VIEW, teacher.record.id)"
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	{!! Form::close() !!}
</div>