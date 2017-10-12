<div ng-if="template.active_add == futureed.TRUE">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_add_template') !!}</span>
		</div>
	</div>

	<div class="col-xs-12 success-container" ng-if="template.errors || template.success">
		<div class="alert alert-error" ng-if="template.errors">
			<p ng-repeat="error in template.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="template.success">
			<p>{! template.success !}</p>
		</div>
	</div>

	<div class="col-xs-12 search-container">
		{!! Form::open(array('class' => 'form-horizontal')) !!}
		<fieldset>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.admin_question_type') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					<select ng-disabled="template.active_view" ng-model="template.record.question_type"
							ng-class="{ 'required-field' : template.fields['question_type'] }"
							class="form-control">
						<option ng-show="template.record.question_type == futureed.FALSE" value="">{!! trans('messages.admin_select_question_type') !!}</option>
						<option value="FIB"> {!!  trans('messages.admin_fib') !!} </option>
						{{--<option value="MC"> {!!  trans('messages.admin_mc') !!} </option>--}}
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.admin_operation') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					<select ng-disabled="template.active_view" ng-model="template.record.operation"
							ng-change="template.operationType()" ng-class="{ 'required-field' : template.fields['operation'] }"
							class="form-control">
						<option ng-show="template.record.operation == futureed.FALSE" value="">{!! trans('messages.admin_select_operation') !!}</option>
						<option ng-repeat="operation in template.question_template_operation" ng-value="operation.operation_data"> {! stringReplace(operation.operation_data) | uppercase !} </option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.admin_question_form') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					<select ng-disabled="template.active_view" ng-model="template.record.question_form"
							ng-class="{ 'required-field' : template.fields['question_form'] }"
							class="form-control">
						<option ng-show="template.record.question_form == futureed.FALSE" value="">{!! trans('messages.admin_select_question_form') !!}</option>
						{{--<option value="Word"> {!!  trans('messages.admin_question_form_word') !!} </option>--}}
						{{--<option value="Blank"> {!!  trans('messages.admin_question_form_blank') !!} </option>--}}
						<option value="Series"> {!!  trans('messages.admin_question_form_series') !!} </option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-2">{!! trans('messages.admin_template_text') !!} <span class="required">*</span></label>
			</div>

			<div class="form-group">
				<div template-directive template-url="{!! route('admin.manage.question_template.partials.question_template_variable') !!}"></div>
				{{--<label class="control-label col-xs-3">{!! trans('messages.admin_how_to_use_variables') !!} <span class="required">*</span></label>--}}
			</div>
			<div class="form-group">
				<div class="col-xs-12">
					{!! Form::textarea('search_question_template_format',''
						, array(
							'ng-model' => 'template.record.question_template_format'
							, 'class' => 'form-control disabled-textarea'
							, 'ng-class' => "{ 'required-field' : template.fields['question_template_format'] }"
							, 'rows' => '5'
							, 'id' => 'template_text'
							, 'ng-keyup' => 'template.validateTemplateText()'
						)
					) !!}
				</div>
			</div>

		</fieldset>
		<fieldset>
			<div class="form-group">
				<div class="btn-container col-xs-9 col-xs-offset-2">
					{!! Form::button(trans('messages.add')
						, array(
							'class' => 'btn btn-blue btn-small'
							, 'ng-click' => 'template.add()'
							, 'ng-show' => 'template.record.operation != Constants.FALSE'
						)
					) !!}
					{!! Form::button(trans('messages.admin_add_template_preview')
						, array(
							'class' => 'btn btn-blue btn-small'
							, 'ng-click' => 'template.questionPreview()'
							, 'ng-show' => 'template.record.operation != Constants.FALSE'
						)
					) !!}
					{!! Form::button(trans('messages.cancel')
						, array(
							'class' => 'btn btn-gold btn-small'
							, 'ng-click' => 'template.setActive()'
						)
					) !!}
				</div>
			</div>
		</fieldset>
		{!! Form::close() !!}
	</div>

	<div id="view_image_modal" ng-show="template.view_image.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{! template.view_image.teaching_module !}
				</div>
				<div class="modal-body">
					<div class="modal-image">
						<img ng-src="{! template.view_image.image_path !}"/>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
						{!! Form::button(trans('messages.close')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'data-dismiss' => 'modal'
							)
						) !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

{{--modal--}}
<div id="preview_question" class="modal fade" role="dialog">
	<div class="modal-dialog">

		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">{!! trans('messages.admin_module_preview_questions') !!}</h4>
			</div>
			<div class="modal-body">
				{{--<p>{! template.question_preview !}</p>--}}
				<div template-directive template-url="{!! route('admin.manage.question_template.partials.question_template_preview') !!}"></div>
			</div>
		</div>

	</div>
</div>