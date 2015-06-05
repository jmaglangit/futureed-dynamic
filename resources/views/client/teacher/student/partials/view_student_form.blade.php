<div ng-if="student.view">
	<div class="content-title">
		<div class="title-main-content" ng-if="!student.edit">
			<span>View Student</span>
		</div>
		<div class="title-main-content" ng-if="student.edit">
			<span>Edit Student</span>
		</div>
	</div>
	{!! Form::open(['class' => 'form-horizontal', 'id' => 'student_form']) !!}
	<div class="container">
		<div class="col-xs-12 margin-30-top">
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
									'ng-model' => 'student.username',
									'ng-disabled' => '!student.edit',
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
									'ng-model' => 'student.email',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'Email'
								])
						!!}
					</div>
					<div>
						<a href="#" class="top-10">Edit Student's Email</a>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2 text-red">Pending Email</label>
					<div class="col-xs-5">
						{!!
							Form::text('pending_email','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.email',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'Email'
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
					<label class="control-label col-xs-2">Firstname <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('firstname','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.firstname',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'Firstname'
								])
						!!}
					</div>
					<label class="control-label col-xs-2">Lastname <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('lastname','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.lastname',
									'ng-disabled' => '!student.edit',
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
									'ng-model' => 'student.city',
									'ng-disabled' => '!student.edit',
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
									'ng-model' => 'student.city',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'City'
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
									'ng-model' => 'student.state',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'State'
								])
						!!}
					</div>
					<label class="control-label col-xs-2">Birthday <span class="required">*</span></label>
					<div class="col-md-4">
                            <div class="dropdown">
                              <a class="dropdown-toggle" id="dropdown2" role="button" data-toggle="dropdown" data-target="#" href="#">
                                <div class="input-group">
                                    <input readonly="readonly" type="text" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! reg.birth | date:'dd/MM/yy' !}">
                                    <input type="hidden" name="hidden_date" value="{! reg.birth | date:'yyyyMMdd' !}">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </a>
                              <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <datetimepicker data-ng-model="reg.birth" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                              </ul>
                            </div>
                        </div>
				</div>
				<div class="form-group" ng-init="getCountries()">
					<label class="control-label col-xs-2">Contry <span class="required">*</span></label>
					<div class="col-md-4">
                            <select ng-disabled="!student.disabled" name="country" class="form-control" ng-model="reg.country" ng-change="getGrades(reg.country)">
                                <option value="">-- Select Country --</option>
                                <option ng-repeat="country in countries" value="{! country.name !}">{! country.name!}</option>
                            </select>
                        </div>
				</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">School Information</legend>
				<div class="form-group">
					<label class="control-label col-xs-2">School Name <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('school_name','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.school_name',
									'ng-disabled' => '!student.edit',
									'placeHolder' => 'School Name'
								])
						!!}
					</div>
				</div>
				<div class="form-group" ng-init="getGradeLevel()">
					<label class="control-label col-xs-2">Grade <span class="required">*</span></label>
					<div class="col-xs-4 nullable">
                            <select ng-disabled="!student.disabled" name="grade_code" class="form-control" ng-model="reg.grade_code">
                                <option value="">-- Select Level --</option>
                                <option ng-repeat="grade in grades.records" value="{! grade.code !}">{! grade.name !}</option>
                            </select>
                        </div><br><br>
				</div>
			</fieldset>
			<div class="col-xs-12">
				<div class="row margin-40-bot">
					<div class="col-md-6 col-md-offset-3 btn-container">
						<button class="btn btn-blue btn-medium">Edit</button>
						<button class="btn btn-gold btn-medium">Back</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>