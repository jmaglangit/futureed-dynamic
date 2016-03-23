<div ng-if="subject.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_add_subject') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="subject.errors || subject.success">
		<div class="alert alert-error" ng-if="subject.errors">
			<p ng-repeat="error in subject.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="subject.success">
			<p>{! subject.success !}</p>
		</div>
	</div>

	<div class="search-container col-xs-12">
		{!! Form::open(array('id'=> 'add_subject_form', 'class' => 'form-horizontal')) !!}
			<fieldset>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.admin_subject_code') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('code',''
							, array(
								'placeHolder' => 'trans('messages.admin_subject_code')'
								, 'ng-model' => 'subject.record.code'
								, 'ng-class' => "{ 'required-field' : subject.fields['code'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('name',''
							, array(
								'placeHolder' => 'trans('messages.admin_subject_name')'
								, 'ng-model' => 'subject.record.name'
								, 'ng-class' => "{ 'required-field' : subject.fields['name'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.description') !!}</label>
					<div class="col-xs-5">
						<textarea name="description" 
							ng-model="subject.record.description" 
							class="form-control disabled-textarea"
							ng-class="{ 'required-field' : subject.fields['description'] }" 
							cols="50" rows="10"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="col-xs-6 checkbox">	                				
							<label>
								{!! Form::radio('status'
									, 'Enabled'
									, true
									, array(
										'class' => 'field'
										, 'ng-model' => 'subject.record.status'
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
										, 'ng-model' => 'subject.record.status'
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
					<div class="btn-container col-xs-8 col-xs-offset-1">
						{!! Form::button('trans('messages.save')'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'subject.add()'
							)
						) !!}

						{!! Form::button('trans('messages.cancel')'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'subject.setActive()'
							)
						) !!}
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>