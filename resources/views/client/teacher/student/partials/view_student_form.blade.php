<div ng-if="teacher.active_view || teacher.active_edit">
	<div class="content-title">
		<div class="title-main-content" ng-if="teacher.active_view">
			<span>View Student</span>
		</div>
		<div class="title-main-content" ng-if="teacher.active_edit">
			<span>Edit Student</span>
		</div>
	</div>

	{!! Form::open(['class' => 'form-horizontal', 'id' => 'student_form']) !!}
	<div class="container">
		<div class="col-xs-10 col-xs-offset-1 margin-30-top">
			<fieldset>
				<legend class="legend-name-mid">
					User Credentials
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-2">Username <span class="required">*</span></label>
					<div class="col-xs-5">
						{!!
							Form::text('username','',
								[
									'class' => 'form-control',
									'ng-model' => 'teacher.record.username',
									'ng-disabled' => 'teacher.active_view',
									'placeHolder' => 'Username'
								])
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Email <span class="required">*</span></label>
					<div class="col-xs-5">
						{!!
							Form::text('email','',
								[
									'class' => 'form-control',
									'ng-model' => 'teacher.record.email',
									'ng-readonly' => 'true',
									'placeHolder' => 'Email'
								])
						!!}
					</div>
					<div>
						<a href="#" class="top-10">Edit Student's Email</a>
					</div>
				</div>
				<div class="form-group" ng-if="teacher.record.new_email">
					<label class="control-label col-xs-2 text-red">Pending Email</label>
					<div class="col-xs-5">
						{!!
							Form::text('pending_email','',
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
									'class' => 'form-control',
									'ng-model' => 'teacher.record.first_name',
									'ng-disabled' => 'teacher.active_view',
									'placeHolder' => 'Firstname'
								])
						!!}
					</div>
					<label class="control-label col-xs-2">Last Name <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('last_name','',
								[
									'class' => 'form-control',
									'ng-model' => 'teacher.record.last_name',
									'ng-disabled' => 'teacher.active_view',
									'placeHolder' => 'Lastname'
								])
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">City <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('city','',
								[
									'class' => 'form-control',
									'ng-model' => 'teacher.record.city',
									'ng-disabled' => 'teacher.active_view',
									'placeHolder' => 'City'
								])
						!!}
					</div>
					<label class="control-label col-xs-2">Gender <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::select('gender',['' => '-- Select Gender --', 'Male' => 'Male', 'Female' => 'Female'],null,
								[
									'class' => 'form-control',
									'ng-model' => 'teacher.record.gender',
									'ng-disabled' => 'teacher.active_view'
								])
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">State <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('state','',
								[
									'class' => 'form-control',
									'ng-model' => 'teacher.record.state',
									'ng-disabled' => 'teacher.active_view',
									'placeHolder' => 'State'
								])
						!!}
					</div>
					<label class="control-label col-xs-2">Birthday <span class="required">*</span></label>
					<div class="col-md-4">
                            <div class="dropdown">
                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
                                <div class="input-group">
                                    <input readonly="readonly" type="text" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! teacher.record.birth | date:'dd/MM/yy' !}">
                                    <input type="hidden" name="hidden_date" value="{! teacher.record.birth | date:'yyyyMMdd' !}">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </a>
                              <ul class="dropdown-menu date-dropdown-menu" role="menu" ng-if="teacher.active_edit">
                                <datetimepicker data-ng-model="teacher.record.birth" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                              </ul>
                            </div>
                        </div>
				</div>
				<div class="form-group" ng-init="getCountries()">
					<label class="control-label col-xs-2">Country <span class="required">*</span></label>
					<div class="col-md-4">
                            <select ng-disabled="true" name="country" class="form-control" ng-model="teacher.record.country_id">
                                <option value="">-- Select Country --</option>
                                <option ng-selected="teacher.record.country_id == country.id" ng-repeat="country in countries" ng-value="{! country.id !}">{! country.name!}</option>
                            </select>
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
				<div class="form-group" ng-init="getGradeLevel(teacher.record.country_id)">
					<label class="control-label col-xs-2">Grade <span class="required">*</span></label>
					<div class="col-xs-5 nullable">
                        <select ng-disabled="true" name="grade_code" class="form-control" ng-model="teacher.record.grade_code">
                            <option value="">-- Select Level --</option>
                            <option ng-selected="teacher.record.grade_code == grade.code" ng-repeat="grade in grades" ng-value="{! grade.code !}">{! grade.name !}</option>
                        </select>
                    </div>
				</div>
			</fieldset>
			<div class="col-xs-12">
				<div class="row margin-40-bot">
					<div class="col-md-6 col-md-offset-3 btn-container" ng-if="teacher.active_view">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "teacher.setActive('edit')"
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "teacher.setActive()"
							)
						) !!}
					</div>
					<div class="col-md-6 col-md-offset-3 btn-container" ng-if="teacher.active_edit">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "teacher.setActive('edit')"
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "teacher.setActive('view')"
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
	{!! Form::close() !!}
</div>