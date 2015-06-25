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
	<div class="container form-content">
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
									'class' => 'form-control'
									, 'ng-model' => 'student.detail.username'
									, 'ng-disabled' => '!student.edit'
									, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        						, 'ng-change' => 'student.checkUsernameAvailability()'
									, 'placeHolder' => 'Username'
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
					<div class="col-xs-5">
						{!!
							Form::text('email','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.detail.email',
									'ng-disabled' => 'true',
									'placeHolder' => 'Email'
								])
						!!}
					</div>
					<div>
						<a href="#" class="top-10" ng-click="student.setActive('change')">Edit Student's Email</a>
					</div>
				</div>
				<div class="form-group" ng-if="student.detail.new_email">
					<label class="control-label col-xs-2 text-red">Pending Email</label>
					<div class="col-xs-5">
						{!!
							Form::text('pending_email','',
								[
									'class' => 'form-control',
									'ng-model' => 'student.detail.new_email',
									'ng-disabled' => 'true',
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
									'ng-model' => 'student.detail.first_name',
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
									'ng-model' => 'student.detail.last_name',
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
									'ng-model' => 'student.detail.city',
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
									'ng-model' => 'student.detail.gender',
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
									'ng-model' => 'student.detail.state',
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
                                    <input readonly="readonly" type="text" name="birth_date" placeholder="DD/MM/YY" class="form-control" value="{! student.detail.birth_date | date:'dd/MM/yy' !}">
                                    <input type="hidden" name="hidden_date" value="{! student.detail.birth_date | date:'yyyyMMdd' !}">
                                    <span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
                                </div>
                              </a>
                              <ul class="dropdown-menu date-dropdown-menu" role="menu" aria-labelledby="dLabel">
                                <datetimepicker data-ng-model="student.detail.birth_date" data-before-render="beforeDateRender($dates)" data-datetimepicker-config="{ dropdownSelector: '#dropdown2', startView:'day', minView:'day' }"/>
                              </ul>
                            </div>
                        </div>
				</div>
				<div class="form-group" ng-init="getCountries()">
					<label class="control-label col-xs-2">Country <span class="required">*</span></label>
					<div class="col-md-4">
                            <select ng-disabled="!student.edit" name="country_id" 
									id="country" 
									class="form-control" 
									ng-model="student.detail.country_id" 
									ng-change="student.getCountryId()">
		                        <option value="">-- Select Country --</option>
		                        <option ng-repeat="country in countries" ng-selected="student.detail.country_id == country.id" value="{! country.id !}">{! country.name!}</option>
		                    </select>
                        </div>
				</div>
			</fieldset>
			<div class="col-xs-12">
				<div class="row margin-150-bot">
					<div class="login-container col-md-6 col-md-offset-3 btn-container">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-if' => '!student.edit'
								, 'ng-click' => "student.setActive('edit', student.detail.id)"
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
								, 'ng-click' => "student.setActive('view', student.detail.id)"
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>