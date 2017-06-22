<div ng-if="template.active_view||template.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span ng-if="template.active_view == futureed.true">{!! trans('messages.admin_view_template') !!}</span>
			<span ng-if="template.active_view == futureed.false">{!! trans('messages.admin_view_template') !!}</span>
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
					{!! Form::select('search_question_type'
						, array(
							 ''=>trans('messages.admin_select_question_type')
							, 'FIB' => trans('messages.admin_fib')
							//, 'MC' => trans('messages.admin_mc')
					 	)
					 	, null
					 	, array(
					 		'ng-disabled' => 'template.active_view',
					 		'ng-selected' => 'template.record.question_type'
					 		, 'class' => 'form-control'
					 		, 'ng-model' => 'template.record.question_type'
					 		, 'ng-class' => "{ 'required-field' : template.fields['question_type'] }"
					 		, 'placeholder' => trans('messages.email')
					 	)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.admin_operation') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::select('search_operation'
						, array(
							  ''=>trans('messages.admin_select_operation')
							, '{! futureed.ADDITION !}' => trans('messages.admin_operation_add')
							, '{! futureed.SUBTRACTION !} ' => trans('messages.admin_operation_subtract')
							//, '{! futureed.DIVISION !} ' => trans('messages.admin_operation_divide')
							, '{! futureed.MULTIPLICATION !} ' => trans('messages.admin_operation_multiply')
					 	)
					 	, null
					 	, array(
					 		'ng-disabled' => 'template.active_view'
					 		, 'class' => 'form-control'
					 		, 'ng-model' => 'template.record.operation'
					 		, 'ng-class' => "{ 'required-field' : template.fields['operation'] }"
					 		, 'placeholder' => trans('messages.email')
					 	)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.admin_question_form') !!} <span class="required">*</span></label>
				<div class="col-xs-4">
					{!! Form::select('search_question_form'
						, array(
							  ''=>trans('messages.admin_select_question_form')
							//, 'Word' => trans('messages.admin_question_form_word')
							//, 'Blank' => trans('messages.admin_question_form_blank')
							, 'Series' => trans('messages.admin_question_form_series')
					 	)
					 	, null
					 	, array(
					 		'ng-disabled' => 'template.active_view'
					 		, 'class' => 'form-control'
					 		, 'ng-model' => 'template.record.question_form'
					 		, 'ng-class' => "{ 'required-field' : template.fields['question_form'] }"
					 		, 'placeholder' => trans('messages.email')
					 	)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-2">{!! trans('messages.admin_template_text') !!} <span class="required">*</span></label>
			</div>

			<div class="form-group">
				<div class="col-xs-8" ng-model='template.record.question_type' ng-if="!template.active_view">
					<div class="col-xs-3 admin-search-module">
						{!! Form::button(trans('messages.admin_template_text_num')
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'template.actionButtons(futureed.NUMBER)'
							)
						)!!}
					</div>
					<div class="col-xs-3 admin-search-module">
						{!! Form::button('object'
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'template.actionButtons(futureed.OBJECT)'
							)
						)!!}
					</div>
					<div class="col-xs-3 admin-search-module">
						{!! Form::button(trans('messages.admin_template_text_name')
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'template.actionButtons(futureed.NAME)'
							)
						)!!}
					</div>
					<div class="col-xs-3 admin-search-module" ng-if="template.record.operation == futureed.ADDITION">
						{!! Form::button(trans('messages.addition_symbol')
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'template.actionButtons(futureed.ADDITION)'
							)
						)!!}
					</div>
					<div class="col-xs-3 admin-search-module" ng-if="template.record.operation == futureed.SUBTRACTION">
						{!! Form::button(trans('messages.subtraction_symbol')
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'template.actionButtons(futureed.SUBTRACTION)'
							)
						)!!}
					</div>
					<div class="col-xs-3 admin-search-module" ng-if="template.record.operation == futureed.MULTIPLICATION">
						{!! Form::button(trans('messages.multiply_symbol')
							,array(
								'class' => 'btn btn-blue'
								, 'ng-click' => 'template.actionButtons(futureed.MULTIPLICATION)'
							)
						)!!}
					</div>
					<div class="col-xs-2"></div>

				</div>
{{--				<label class="control-label col-xs-3">{!! trans('messages.admin_how_to_use_variables') !!} <span class="required">*</span></label>--}}
			</div>
			<div class="form-group">
				<div class="col-xs-6">
					{!! Form::textarea('admin_template_text',''
						, array(
							'ng-model' => 'template.record.question_template_format'
							, 'ng-disabled' => 'template.active_view'
							, 'class' => 'form-control disabled-textarea'
							, 'ng-class' => "{ 'required-field' : template.fields['description'] }"
							, 'rows' => '10'
						)
					) !!}
				</div>
				<div class="col-xs-1"></div>
				<div class="col-xs-4">
					{{--{!! Form::textarea('admin_template_text',''--}}
						{{--, array(--}}
							{{--'ng-model' => 'template.record.question_types'--}}
							{{--, 'ng-disabled' => 'template.active_view'--}}
							{{--, 'class' => 'form-control disabled-textarea'--}}
							{{--, 'ng-class' => "{ 'required-field' : template.fields['description'] }"--}}
							{{--, 'rows' => '10'--}}
						{{--)--}}
					{{--) !!}--}}
				</div>
			</div>

			<div class="form-group">
				<label class="col-xs-4">{!! trans('messages.admin_question_equation') !!} <span class="required">*</span></label>
			</div>

			<div class="form-group">
				<div class="col-xs-6">
					{!! Form::text('question_equation',''
						, array(
							 'ng-model' => 'template.record.question_equation'
							 , 'ng-disabled' => 'template.active_view'
							, 'class' => 'form-control'
							, 'ng-class' => "{ 'required-field' : template.fields['question_equation'] }"
						)
					) !!}
				</div>
				<div class="col-xs-2"></div>
				<div class="col-xs-4">
					{{--{!! Form::textarea('admin_template_text',''--}}
						{{--, array(--}}
							{{--'class' => 'form-control disabled-textarea'--}}
							{{--, 'rows' => '3'--}}
						{{--)--}}
					{{--) !!}--}}
				</div>
			</div>
		</fieldset>
		<fieldset>
			<div class="form-group">
				<div class="btn-container col-xs-9 col-xs-offset-2">
					{!! Form::button(trans('messages.edit')
						, array(
							'class' => 'btn btn-blue btn-small'
							, 'ng-if' => 'futureed.ACTIVE_EDIT && !template.active_update'
							, 'ng-click' => 'template.setActive(futureed.ACTIVE_EDIT,template.record.id)'
						)
					) !!}
					{!! Form::button(trans('messages.update')
						, array(
							'class' => 'btn btn-blue btn-small'
							, 'ng-if' => 'template.active_update'
							, 'ng-click' => 'template.update()'
						)
					) !!}
					{!! Form::button(trans('messages.admin_add_template_preview')
						, array(
							'class' => 'btn btn-blue btn-small'
							, 'ng-click' => 'template.preview()'
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