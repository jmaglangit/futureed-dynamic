<div ng-if="teacher.active_view || teacher.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.client_teacher_details') !!}</span>
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

	<div class="search-container col-xs-12">
		{!! Form::open(array('id'=> 'update_teacher_form', 'class' => 'form-horizontal')) !!}
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.user_credentials') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-2 control-label">{!! trans('messages.username') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('username',''
							, array(
								'placeHolder' => 'trans('messages.username')'
								, 'ng-model' => 'teacher.record.user.username'
								, 'ng-class' => "{ 'required-field' : teacher.fields['username'] }"
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">{!! trans('messages.email') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('email',''
							, array(
								'placeHolder' => 'trans('messages.email')'
								, 'ng-model' => 'teacher.record.user.email'
								, 'ng-class' => "{ 'required-field' : teacher.fields['email'] }"
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
			</fieldset>

			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.personal_info') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-2 control-label" id="first_name">{!! trans('messages.first_name') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('first_name',''
							, array(
								'placeholder' => 'trans('messages.first_name')'
								, 'ng-disabled' => 'teacher.active_view'
								, 'ng-model' => 'teacher.record.first_name'
								, 'ng-class' => "{ 'required-field' : teacher.fields['first_name'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>

					<label class="col-xs-2 control-label" id="last_name">{!! trans('messages.last_name') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('last_name',''
							, array(
								'placeholder' => 'trans('messages.last_name')'
								, 'ng-disabled' => 'teacher.active_view'
								, 'ng-model' => 'teacher.record.last_name'
								, 'ng-class' => "{ 'required-field' : teacher.fields['last_name'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
			</fieldset>

			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.other_address_info') !!}
				</legend>
				<div class="form-group">
					<label class="col-xs-2 control-label" id="school_address">{!! trans('messages.street_address') !!}</label>
					<div class="col-xs-6">
						{!! Form::text('street_address',''
							, array(
								'placeHolder' => 'trans('messages.street_address')'
								, 'ng-disabled' => 'teacher.active_view'
								, 'ng-model' => 'teacher.record.street_address'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label" id="school_city">{!! trans('messages.city') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('city',''
							, array(
								'placeHolder' => 'trans('messages.city')'
								, 'ng-disabled' => 'teacher.active_view'
								, 'ng-model' => 'teacher.record.city'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
					<label class="col-xs-2 control-label" id="school_state">{!! trans('messages.state') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('state',''
							, array(
								'placeHolder' => 'trans('messages.state')'
								, 'ng-disabled' => 'teacher.active_view'
								, 'ng-model' => 'teacher.record.state'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label" id="school_postal">{!! trans('messages.postal_code') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('zip',''
							, array(
								'placeHolder' => 'trans('messages.postal_code')'
								, 'ng-disabled' => 'teacher.active_view'
								, 'ng-model' => 'teacher.record.zip'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
					<label class="col-xs-2 control-label">{!! trans('messages.country') !!}</label>
					  <div class="col-xs-4" ng-init="getCountries()">
						<select  name="country" class="form-control" ng-model="teacher.record.country_id" ng-disabled="teacher.active_view">
						  <option ng-selected="futureed.FALSE == teacher.record.country_id" value="">{!! trans('messages.select_country') !!}</option>
						  <option ng-selected="country.id == teacher.record.country_id" 
									ng-repeat="country in countries" ng-value="country.id">{! country.name!}</option>
						</select>
					  </div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<div class="btn-container col-xs-8 col-xs-offset-2">
						<div ng-if="teacher.active_view">
							{!! Form::button('{!! trans('messages.edit') !!}'
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => "teacher.setActive('edit', teacher.record.id)"
								)
							) !!}

							{!! Form::button('{!! trans('messages.cancel') !!}'
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => "teacher.setActive('list')"
								)
							) !!}
						</div>
						<div ng-if="teacher.active_edit">
							{!! Form::button('{!! trans('messages.save') !!}'
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => "teacher.update()"
								)
							) !!}

							{!! Form::button('{!! trans('messages.cancel') !!}'
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => "teacher.setActive('view', teacher.record.id)"
								)
							) !!}
						</div>
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
	
	<div class="col-xs-12 table-container" ng-if="teacher.active_view">
		<div class="list-container" ng-cloak>
			<div class="col-xs-6 title-mid">
				{!! trans('messages.class_list') !!}
			</div>

			<div class="col-xs-6 size-container">
				{!! Form::select('size'
					, array(
						  '10' => '10'
						, '20' => '20'
						, '50' => '50'
						, '100' => '100'
					)
					, '10'
					, array(
						'ng-model' => 'teacher.table.size'
						, 'ng-change' => 'teacher.paginateBySize()'
						, 'ng-if' => "teacher.classes.length"
						, 'class' => 'form-control paginate-size pull-right'
					)
				) !!}
			</div>

			<table class="col-xs-12 table table-striped table-bordered">
				<thead>
					<tr>
						<th>{!! trans('messages.class_handled') !!}</th>
						<th>{!! trans('messages.number_of_students') !!}</th>
						<th>{!! trans('messages.grade') !!}</th>
					</tr>
				</thead>
				<tbody>
					<tr ng-repeat="class in teacher.classes">
						<td>{! class.name !}</td>
						<td>{! class.seats_taken !}</td>
						<td>{! class.grade.name !}</td>
					</tr>
					<tr class="odd" ng-if="!teacher.classes.length && !teacher.table.loading">
						<td valign="top" colspan="4">
							{!! trans('messages.no_records_found') !!}
						</td>
					</tr>
				</tbody>
			</table>

			<div class="pull-right" ng-if="teacher.classes.length">
				<pagination 
					total-items="teacher.table.total_items" 
					ng-model="teacher.table.page"
					max-size="3"
					items-per-page="teacher.table.size" 
					previous-text = "&lt;"
					next-text="&gt;"
					class="pagination" 
					boundary-links="true"
					ng-change="teacher.paginateByPage()">
				</pagination>
			</div>
		</div>
	</div>
</div>