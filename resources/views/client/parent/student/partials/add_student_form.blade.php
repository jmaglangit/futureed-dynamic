<div ng-if="student.add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Student</span>
		</div>
	</div>
	<div class="container">
		{!! Form::open(['class' => 'form-horizontal', 'id' => 'add_student_form']) !!}
		<div class="col-xs-10 col-xs-offset-1 margin-top-60">
			<div class="form-group" ng-init="student.existActive('old')">
				<div class="col-xs-3">
					{!! Form::radio('status'
						,'exist'
						, true
						, array(
							'ng-model' => 'student.is_exist',
							'ng-click' => "student.existActive('old')"
							)
						) !!}
					<span class="lbl padding-8">Existing Student</span>
				</div>
				<label class="control-label col-xs-2">Email <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('email', '',
						[
							'class' => 'form-control',
							'ng-model' => 'student.email',
							'placeHolder' => 'Email',
							'ng-disabled' => 'student.exist'
						]
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="col-xs-offset-3 col-xs-2 control-label">Invitation Code <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::text('code', '',
						[
							'class' => 'form-control',
							'ng-model' => 'student.code',
							'placeHolder' => 'Invitaion Code',
							'ng-disabled' => 'student.exist'
						]
					) !!}
				</div>
				<div class="col-xs-3 btn-container">
					<button class="btn btn-blue btn-medium bottom-5"><span><i class="fa fa-plus-square"></i></span> Add</button>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-3">
					{!! Form::radio('status'
						,'not-exist'
						, true
						, array(
							'ng-model' => 'student.is_exist',
							'ng-click' => "student.existActive('new')"
							)
						) !!}
					<span class="lbl padding-8">New Student</span>
				</div>
			</div>
			<div class="form-group">
				<div class="col-xs-10 col-xs-offset-1">
					<fieldset>
						<legend class="legend-name-mid">Login Credentials</legend>
						<div class="form-group">
							<label class="col-xs-2 control-label">Username <span class="required">*</span></label>
							<div class="col-xs-5">
								{!! Form::text('username', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.code',
										'placeHolder' => 'Username',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-2 control-label">Email <span class="required">*</span></label>
							<div class="col-xs-5">
								{!! Form::text('email', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.email',
										'placeHolder' => 'Email',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
						</div>
					</fieldset>
					<fieldset>
						<legend class="legend-name-mid">Personal Information</legend>
						<div class="form-group">
							<label class="col-xs-2 control-label">Firstname <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('firstname', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.email',
										'placeHolder' => 'Firstname',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
							<label class="col-xs-2 control-label">Lastname <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('lastname', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.email',
										'placeHolder' => 'Lastname',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
						</div>
						<div class="form-group">
							<label class="col-xs-2 control-label">Gender <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::select('gender',
									['' => '-- Select Gender --',
									'male'=> 'Male', 
									'female' => 'female']
									,null,
									['class' => 'form-control', 
									'ng-model' => 'student.reg.gender',
									'ng-disabled' => '!student.exist']) 
								!!}
							</div>
						</div>
						<div class="form-group">
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
						<div class="form-group">
							<label class="control-label col-xs-2">City <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('city', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.email',
										'placeHolder' => 'City',
										'ng-disabled' => '!student.exist'
									]
								) !!}
							</div>
						</div>
						<div class="form-group">
							<label class="control-label col-xs-2">City <span class="required">*</span></label>
							<div class="col-xs-4">
								{!! Form::text('state', '',
									[
										'class' => 'form-control',
										'ng-model' => 'student.email',
										'placeHolder' => 'State',
										'ng-disabled' => '!student.exist'
									]
								) !!}
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
					<div class="btn-container">
						<div class="col-xs-4 div-right margin-40-bot">
							<button class="btn btn-blue btn-medium"><span><i class="fa fa-plus-square"></i></span> Add</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>