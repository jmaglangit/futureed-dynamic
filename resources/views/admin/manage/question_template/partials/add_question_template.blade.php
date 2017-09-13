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
				<div class="col-xs-8">
					<div class="admin-search-module" ng-if="template.record.operation == futureed.ADDITION">
						<div class="col-xs-4 admin-search-module">
							{!! Form::button(trans('messages.addends_one')
								,array(
									 'class' => 'btn btn-blue'
									, 'name' => 'btn_addends1'
									, 'ng-click' => 'template.actionButtons(futureed.ADDENDS1)'
								)
							)!!}
						</div>
						<div class="col-xs-4 admin-search-module">
							{!! Form::button(trans('messages.addends_two')
								,array(
									 'class' => 'btn btn-blue'
									, 'name' => 'btn_addends2'
									, 'ng-click' => 'template.actionButtons(futureed.ADDENDS2)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.SUBTRACTION">
						<div class="col-xs-4 admin-search-module">
							{!! Form::button(trans('messages.minuend')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_minuend'
									, 'ng-click' => 'template.actionButtons(futureed.MINUEND)'
								)
							)!!}
						</div>
						<div class="col-xs-4 admin-search-module">
							{!! Form::button(trans('messages.subtrahend')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_subtrahend'
									, 'ng-click' => 'template.actionButtons(futureed.SUBTRAHEND)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.MULTIPLICATION">
						<div class="col-xs-4 admin-search-module">
							{!! Form::button(trans('messages.multiplicand')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_multiplicand'
									, 'ng-click' => 'template.actionButtons(futureed.MULTIPLICAND)'
								)
							)!!}
						</div>
						<div class="col-xs-4 admin-search-module">
							{!! Form::button(trans('messages.multiplier')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_multiplier'
									, 'ng-click' => 'template.actionButtons(futureed.MULTIPLIER)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.DIVISION">
						<div class="col-xs-4 admin-search-module">
							{!! Form::button(trans('messages.dividend')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_dividend'
									, 'ng-click' => 'template.actionButtons(futureed.DIVIDEND)'
								)
							)!!}
						</div>
						<div class="col-xs-4 admin-search-module">
							{!! Form::button(trans('messages.divisor')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_divisor'
									, 'ng-click' => 'template.actionButtons(futureed.DIVISOR)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_ADDITION">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_fraction')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_fraction_addition'
									, 'ng-click' => 'template.actionButtons(futureed.FRACTION_ADDITION)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_fraction')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_fraction_subtraction'
									, 'ng-click' => 'template.actionButtons(futureed.FRACTION_SUBTRACTION)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_MULTIPLICATION">
						<div class="col-xs-6 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_fraction')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_fraction_multiplication'
									, 'ng-click' => 'template.actionButtons(futureed.FRACTION_MULTIPLICATION)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_DIVISION">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_fraction')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_fraction_division'
									, 'ng-click' => 'template.actionButtons(futureed.FRACTION_DIVISION)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_ADDITION_BUTTERFLY">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_fraction')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_fraction_addition_butterfly'
									, 'ng-click' => 'template.actionButtons(futureed.FRACTION_ADDITION_BUTTERFLY)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION_BUTTERFLY">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_fraction')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_fraction_subtraction_butterfly'
									, 'ng-click' => 'template.actionButtons(futureed.FRACTION_SUBTRACTION_BUTTERFLY)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_ADDITION_WHOLE">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_fraction')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_fraction_addition_whole'
									, 'ng-click' => 'template.actionButtons(futureed.FRACTION_ADDITION_WHOLE)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.FRACTION_SUBTRACTION_WHOLE">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_fraction')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_fraction_subtraction_whole'
									, 'ng-click' => 'template.actionButtons(futureed.FRACTION_SUBTRACTION_WHOLE)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_SORT_SMALL">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_integer')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_sort_small'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_SORT_SMALL)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_SORT_LARGE">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_integer')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_sort_large'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_SORT_LARGE)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_ADDITION">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_integer')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_addition'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_ADDITION)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_CONVERT_NUMBER">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_integer')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_convert_number'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_CONVERT_NUMBER)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_DECIMAL">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_integer')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_decimal'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_DECIMAL)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_EXPANDED_DECIMAL">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_integer')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_expanded_decimal'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_EXPANDED_DECIMAL)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_EXTENDED">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_integer')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_extended'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_EXTENDED)'
								)
							)!!}
						</div>
					</div>

					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_COUNTING">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_integer')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_counting'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_COUNTING)'
								)
							)!!}
						</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_IDENTIFY">
						<div class="col-xs-6 admin-search-module">
							{!! Form::button(trans('messages.admin_template_integer_random_digit')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_random_digit'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_RANDOM_DIGIT)'
								)
							)!!}
						</div>
						<div class="col-xs-6 admin-search-module">
							{!! Form::button(trans('messages.admin_template_integer_random_number')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_random_number'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_RANDOM_NUMBER)'
								)
							)!!}
						</div>
					</div>

					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_ROUNDING_NUMBER">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_word')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_random_word'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_RANDOM_WORD)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_ROUNDING_NUMBER">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.admin_template_add_number')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_random_number'
									, 'ng-click' => 'template.actionButtons(futureed.INTEGER_RANDOM_NUMBER)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_REGROUP">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.number_one')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_number1'
									, 'ng-click' => 'template.actionButtons(futureed.NUMBER1)'
								)
							)!!}
						</div>
					</div>
					<div class="admin-search-module" ng-if="template.record.operation == futureed.INTEGER_REGROUP">
						<div class="col-xs-5 admin-search-module">
							{!! Form::button(trans('messages.number_two')
								,array(
									'class' => 'btn btn-blue'
									, 'name' => 'btn_integer_number2'
									, 'ng-click' => 'template.actionButtons(futureed.NUMBER2)'
								)
							)!!}
						</div>
					</div>
					<div class="col-xs-2"></div>
					
				</div>
				{{--<label class="control-label col-xs-3">{!! trans('messages.admin_how_to_use_variables') !!} <span class="required">*</span></label>--}}
			</div>
			<div class="form-group">
				<div class="col-xs-12" onclick="validateTemplateText()">
					{!! Form::textarea('search_question_template_format',''
						, array(
							'ng-model' => 'template.record.question_template_format'
							, 'class' => 'form-control disabled-textarea'
							, 'ng-class' => "{ 'required-field' : template.fields['question_template_format'] }"
							, 'rows' => '5'
							, 'id' => 'template_text'
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
				<p>{! template.question_preview !}</p>
			</div>
		</div>

	</div>
</div>