<div ng-if="area.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_update_subject_area') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="area.errors || area.success">
		<div class="alert alert-error" ng-if="area.errors">
			<p ng-repeat="error in area.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="area.success">
			<p>{! area.success !}</p>
		</div>
	</div>

	<div class="search-container col-xs-12">
	   {!! Form::open(array('id'=> 'subject_area_details_form', 'class' => 'form-horizontal')) !!}
			<fieldset>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.admin_subject_code') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('subject_id',''
							, array(
								'placeHolder' => trans('messages.admin_subject_code')
								, 'ng-model' => 'area.record.subject_id'
								, 'ng-class' => "{ 'required-field' : area.fields['subject_id'] }"
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('subject_id',''
							, array(
								'placeHolder' => trans('messages.admin_subject_name')
								, 'ng-model' => 'area.record.subject_name'
								, 'ng-class' => "{ 'required-field' : area.fields['subject_name'] }"
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.admin_area_code') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('code',''
							, array(
								'placeHolder' => trans('messages.admin_area_code')
								, 'ng-model' => 'area.record.code'
								, 'ng-class' => "{ 'required-field' : area.fields['code'] }"
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.area') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('name',''
							, array(
								'placeHolder' => trans('messages.area')
								, 'ng-model' => 'area.record.name'
								, 'ng-class' => "{ 'required-field' : area.fields['name'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
						<label class="col-xs-3 control-label">{!! trans('messages.description') !!}</label>
						<div class="col-xs-5">
							{!! Form::textarea('description','',
							[
								'id'=> trans('messages.description')
								, 'class' => 'form-control disabled-textarea'
								, 'ng-class' => "{ 'required-field' : area.fields['description'] }"
								, 'ng-model' => 'area.record.description'
								, 'rows' => '7'
							]) !!}
						</div>
					</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
					<div class="col-xs-5 admin-view-subject-area-details">
						<div class="col-xs-6 checkbox">	                				
							<label>
								{!! Form::radio('status'
									, 'Enabled'
									, true
									, array(
										'class' => 'field'
										, 'ng-model' => 'area.record.status'
									) 
								) !!}
							<span class="lbl padding-8">{!! trans('messages.enabled') !!}</span>
							</label>
						</div>
						<div class="col-xs-6 checkbox">
							<label>
								{!! Form::radio('status'
									, 'Disabled'
									, false
									, array(
										'class' => 'field'
										, 'ng-model' => 'area.record.status'
									)
								) !!}
							<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
							</label>
						</div>
					</div>
				</div>
			</fieldset>
			<fieldset>
				<div class="form-group">
					<div class="btn-container col-xs-9 col-xs-offset-1">
						{!! Form::button(trans('messages.update')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'area.update()'
							)
						) !!}

						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "area.setActive()"
							)
						) !!}
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>