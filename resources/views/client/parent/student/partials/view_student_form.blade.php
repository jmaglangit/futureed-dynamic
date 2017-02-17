<div ng-if="student.active_view || student.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_student_details') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="student.errors || student.success">
		<div class="alert alert-error" ng-if="student.errors">
			<p ng-repeat="error in student.errors track by $index" > 
				{! error !}
			</p>
		</div>
		<div class="alert alert-success" ng-if="student.success">
			<p> 
				{! student.success !}
			</p>
		</div>
	</div>

	{!! Form::open(['class' => 'form-horizontal', 'id' => 'student_form']) !!}
		<div class="col-xs-12 search-container">
			<fieldset>
				<legend class="legend">
					{!! trans('messages.user_credentials') !!}
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-2">{!! trans('messages.username') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('username','',
								[
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : student.fields['username'] }"
									, 'ng-model' => 'student.record.username'
									, 'ng-disabled' => 'student.active_view'
									, 'ng-model-options' => "{ debounce : {'default' : 1000} }"
	        						, 'ng-change' => 'student.checkUsername(student.record.username, futureed.STUDENT, futureed.TRUE)'
									, 'placeholder' => trans('messages.username')
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
					<label class="control-label col-xs-2">{!! trans('messages.email') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						<div class="input-group">
							{!! Form::text('email','',
									[
										'class' => 'form-control',
										'ng-model' => 'student.record.email',
										'ng-disabled' => 'true',
										'placeHolder' => trans('messages.email')
									])
							!!}

							<span class="input-group-addon" ng-click="student.setActive('change', student.record.id)"><i class="fa fa-pencil edit-addon"></i></span>
						</div>
					</div>

					<div ng-if="student.record.new_email">
						<label class="control-label col-xs-2 text-red">{!! trans('messages.pending_email') !!}</label>
						<div class="col-xs-4">
							{!!
								Form::text('pending_email','',
									[
										'class' => 'form-control',
										'ng-model' => 'student.record.new_email',
										'ng-disabled' => 'true',
										'placeHolder' => trans('messages.email')
									])
							!!}
						</div>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<legend class="legend">
					{!! trans('messages.personal_info') !!}
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-2">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('firstname','',
								[
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : student.fields['first_name'] }"
									, 'ng-model' => 'student.record.first_name'
									, 'ng-disabled' => 'student.active_view'
									, 'placeHolder' => trans('messages.first_name')
								])
						!!}
					</div>
					<label class="control-label col-xs-2">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('lastname','',
								[
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : student.fields['last_name'] }"
									, 'ng-model' => 'student.record.last_name'
									, 'ng-disabled' => 'student.active_view'
									, 'placeHolder' => trans('messages.last_name')
								])
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">{!! trans('messages.birthday') !!} <span class="required">*</span></label>
					<div class="col-xs-8 bdate-dropdown">
	                    <input type="hidden" id="birth_date">
	                </div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">{!! trans('messages.gender') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::select('gender',['' => trans('messages.select_gender'), 'Male' => trans('messages.male'), 'Female' => trans('messages.female')],null,
								[
									'class' => 'form-control'
									, 'ng-model' => 'student.record.gender'
									, 'ng-disabled' => 'student.active_view'
									, 'ng-class' => "{ 'required-field' : student.fields['gender'] }"
									, 'placeHolder' => trans('messages.gender')
								])
						!!}
					</div>
					<label class="control-label col-xs-2">{!! trans('messages.city') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!!
							Form::text('city','',
								[
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : student.fields['city'] }"
									, 'ng-model' => 'student.record.city'
									, 'ng-disabled' => 'student.active_view'
									, 'placeHolder' => trans('messages.city')
								])
						!!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">{!! trans('messages.state') !!}</label>
					<div class="col-xs-4">
						{!!
							Form::text('state','',
								[
									'class' => 'form-control'
									, 'ng-class' => "{ 'required-field' : student.fields['state'] }"
									, 'ng-model' => 'student.record.state'
									, 'ng-disabled' => 'student.active_view'
									, 'placeHolder' => trans('messages.state')
								])
						!!}
					</div>
					<label class="control-label col-xs-2">{!! trans('messages.country') !!} <span class="required">*</span></label>
					<div class="col-xs-4" ng-init="getCountries()">
	                    <select ng-disabled="student.active_view" name="country_id" 
								id="country" 
								class="form-control" 
								ng-class="{ 'required-field' : student.fields['country_id'] }"
								ng-model="student.record.country_id" 
								ng-change="student.getCountryId()">
	                        <option ng-selected="student.record.country_id == futureed.FALSE" value="">{!! trans('messages.select_country') !!}</option>
	                        <option ng-selected="student.record.country_id == country.id" ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
	                    </select>
	                </div>
				</div>

	        	<div class="form-group" ng-if="student.active_view && student.record.parent && student.record.parent.status == futureed.DISABLED" ng-cloak> 
					<div class="col-xs-9 col-xs-offset-2 btn-container">
	        			<a href="javascript:void(0)" class="btn btn-blue btn-medium"
	        				ng-click="student.setActive('invite')">{!! trans('messages.confirm_invitation') !!}</a>
	        		</div>
	        	</div>

				<div class="form-group">
					<div class="col-xs-9 col-xs-offset-2 btn-container">
						{!! Form::button(trans('messages.edit')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-if' => 'student.active_view'
								, 'ng-click' => "student.setActive(futureed.ACTIVE_EDIT, student.record.id)"
							)
						) !!}
						{!! Form::button(trans('messages.update')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-if' => 'student.active_edit'
								, 'ng-click' => "student.saveStudent()"
							)
						) !!}
						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gray btn-medium'
								, 'ng-if' => 'student.active_view'
								, 'ng-click' => "student.setActive(futureed.ACTIVE_LIST)"
							)
						) !!}
						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gray btn-medium'
								, 'ng-if' => 'student.active_edit'
								, 'ng-click' => "student.setActive(futureed.ACTIVE_VIEW, student.record.id)"
							)
						) !!}
					</div>
				</div>

				<div class="form-group"></div>
			</fieldset>
		</div>
	{!! Form::close() !!}
</div>