<div ng-if="teacher.active_view || teacher.active_edit">
	<div class="content-title">
		<div class="title-main-content" ng-if="teacher.active_view">
			<span>{!! trans('messages.view_student') !!}</span>
		</div>
		<div class="title-main-content" ng-if="teacher.active_edit">
			<span>{!! trans('messages.edit_student') !!}</span>
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
						{!! trans('messages.user_credentials') !!}
					</legend>
					<div class="form-group">
						<label class="control-label col-xs-2">{!! trans('messages.username') !!} <span class="required">*</span></label>
						<div class="col-xs-4">
							{!!
								Form::text('username','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.username'
										, 'ng-disabled' => 'true'
										, 'placeHolder' => 'trans('messages.username')'
									])
							!!}
						</div>
					</div>	

					<div class="form-group">
						<label class="control-label col-xs-2">{!! trans('messages.email') !!} <span class="required">*</span></label>
						<div class="col-xs-4">
							<div class="input-group">
								{!! Form::text('email','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.email'
										, 'ng-disabled' => 'true'
										, 'placeHolder' => 'trans('messages.email')'
									])
								!!}	

								<span class="input-group-addon" ng-click="teacher.setActive(futureed.ACTIVE_EMAIL)"><i class="fa fa-pencil edit-addon"></i></span>
							</div>
						</div>

						<div ng-if="teacher.record.new_email">
							<label class="control-label col-xs-2 text-red">{!! trans('messages.pending_email') !!}</label>
							<div class="col-xs-4">
								{!! Form::text('pending_email','',
									[
										'class' => 'form-control',
										'ng-model' => 'teacher.record.new_email',
										'ng-readonly' => 'true',
										'placeHolder' => 'trans('messages.pending_email')'
									])
								!!}
							</div>
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend class="legend-name-mid">
						{!! trans('messages.personal_info') !!}
					</legend>
					<div class="form-group">
						<label class="control-label col-xs-2">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
						<div class="col-xs-4">
							{!!
								Form::text('first_name','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.first_name'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['first_name'] }"
										, 'placeHolder' => 'trans('messages.first_name')'
									])
							!!}
						</div>
						<label class="control-label col-xs-2">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
						<div class="col-xs-4">
							{!!
								Form::text('last_name','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.last_name'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['last_name'] }"
										, 'placeHolder' => 'trans('messages.last_name')'
									])
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2">{!! trans('messages.gender') !!} <span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::select('gender'
									, array(
										'' => 'trans('messages.select_gender')'
										, 'Male' => 'trans('messages.male')'
										, 'Female' => 'trans('messages.female')')
									, null
									, array(
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.gender'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['gender'] }"
									)
								) !!}
						</div>

						<label class="control-label col-xs-2">{!! trans('messages.city') !!} <span class="required">*</span></label>
						<div class="col-xs-4">
							{!!
								Form::text('city','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.city'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['city'] }"
										, 'placeHolder' => 'trans('messages.city')'
									])
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2">{!! trans('messages.state') !!} </label>
						<div class="col-xs-4">
							{!!
								Form::text('state','',
									[
										'class' => 'form-control'
										, 'ng-model' => 'teacher.record.state'
										, 'ng-disabled' => 'teacher.active_view'
										, 'ng-class' => "{ 'required-field' : teacher.fields['state'] }"
										, 'placeHolder' => 'trans('messages.state')'
									])
							!!}
						</div>

						<label class="control-label col-xs-2">{!! trans('messages.country') !!} <span class="required">*</span></label>
						<div class="col-xs-4" ng-init="getCountries()">
							<select ng-disabled="true" name="country" class="form-control" ng-model="teacher.record.country_id">
								<option ng-selected="teacher.record.country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
								<option ng-selected="teacher.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
							</select>
						</div>						
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2">{!! trans('messages.birthday') !!} <span class="required">*</span></label>
						<div class="col-xs-6">
							<input type="hidden" id="birth_date" ng-init="teacher.setdateDropdown(teacher.record.birth_date)"/>		                        
						</div>
					</div>
				</fieldset>
				<fieldset>
					<legend class="legend-name-mid">{!! trans('messages.school_info') !!}</legend>
					<div class="form-group">
						<label class="control-label col-xs-2">{!! trans('messages.school_name') !!} <span class="required">*</span></label>
						<div class="col-xs-5">
							{!!
								Form::text('school_name','',
									[
										'class' => 'form-control',
										'ng-model' => 'teacher.record.school.name',
										'ng-disabled' => 'true',
										'placeHolder' => 'trans('messages.school_name')'
									])
							!!}
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-xs-2">{!! trans('messages.grade') !!} <span class="required">*</span></label>
						<div class="col-xs-5 nullable">
		                    <select ng-disabled="true" name="grade_code" class="form-control" ng-model="teacher.record.grade_code">
		                        <option value="">{!! trans('messages.select_level') !!}</option>
		                        <option ng-selected="teacher.record.grade_code == grade.code" ng-repeat="grade in grades" ng-value="grade.code">{! grade.name !}</option>
		                    </select>
		                </div>
					</div>
				</fieldset>
				<div class="row margin-40-bot">
					<div class="col-xs-6 col-xs-offset-3 btn-container" ng-if="teacher.active_view">
						{!! Form::button('trans('messages.edit')'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "teacher.setActive(futureed.ACTIVE_EDIT, teacher.record.id)"
							)
						) !!}
						{!! Form::button('trans('messages.cancel')'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "teacher.setActive()"
							)
						) !!}
					</div>
					<div class="col-xs-6 col-xs-offset-3 btn-container" ng-if="teacher.active_edit">
						{!! Form::button('trans('messages.save')'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "teacher.updateDetails()"
							)
						) !!}
						{!! Form::button('trans('messages.cancel')'
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