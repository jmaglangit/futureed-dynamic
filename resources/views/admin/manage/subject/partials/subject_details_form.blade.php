<div ng-if="subject.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>Update Subject</span>
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
					<label class="col-xs-3 control-label">Subject Code <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('code',''
							, array(
								 'ng-model' => 'subject.record.code'
								, 'ng-class' => "{ 'required-field' : subject.fields['code'] }"
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Subject <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('name',''
							, array(
								'placeHolder' => 'Subject Name'
								, 'ng-model' => 'subject.record.name'
								, 'ng-class' => "{ 'required-field' : subject.fields['name'] }"
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Description </label>
					<div class="col-xs-5">
						<textarea name="description" 
							ng-model="subject.record.description"
							class="form-control disabled-textarea"
							ng-class="{ 'required-field' : subject.fields['description'] }"
							cols="50" rows="10"></textarea>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Status <span class="required">*</span></label>
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
							<span class="lbl padding-8">Enabled</span>
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
							<span class="lbl padding-8">Disabled</span>
							</label>
						</div>
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
					<div class="btn-container col-xs-8 col-xs-offset-1">
						{!! Form::button('Update'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'subject.update()'
							)
						) !!}

						{!! Form::button('Cancel'
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