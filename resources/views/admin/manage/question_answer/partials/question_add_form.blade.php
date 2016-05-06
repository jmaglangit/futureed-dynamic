<div ng-if="qa.active_add">
	<div class="col-xs-12 success-container" ng-if="qa.errors || qa.success">
		<div class="alert alert-error" ng-if="qa.errors">
			<p ng-repeat="error in qa.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="qa.success">
			<p>{! qa.success !}</p>
		</div>
	</div>
	
	<div class="col-xs-12 search-container">
		{!! Form::open(array('id'=> 'add_question_form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) !!}
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.admin_module_details') !!}
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-2">{!! trans_choice('messages.module', 1) !!}</label>
					<div class="col-xs-4">
						{!! Form::text('module',''
							, array(
								'placeHolder' => trans_choice('messages.module', 1)
								, 'ng-model' => 'qa.module.name'
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>

					<label class="control-label col-xs-2">{!! trans('messages.subject') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('subject',''
							, array(
								'placeHolder' => trans('messages.subject')
								, 'ng-model' => 'qa.module.subject.name'
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">{!! trans('messages.area') !!}</label>
					<div class="col-xs-4">
						{!! Form::text('area',''
							, array(
								'placeHolder' => trans('messages.area')
								, 'ng-model' => 'qa.module.area'
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
			</fieldset>

			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.admin_question_details') !!}
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-4">{!! trans('messages.code') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('code',''
							, array(
								'placeHolder' => trans('messages.code')
								, 'ng-model' => 'qa.record.code'
								, 'class' => 'form-control'
								, 'ng-class' => "{ 'required-field' : qa.fields['code'] }"
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">{!! trans('messages.question') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::textarea('question',''
							, array(
								'placeHolder' => trans('messages.question')
								, 'ng-model' => 'qa.record.questions_text'
								, 'class' => 'form-control disabled-textarea'
								, 'ng-class' => "{ 'required-field' : qa.fields['questions_text'] }"
								, 'rows' => 5
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">{!! trans('messages.admin_question_image') !!}</label>
					<div class="col-xs-5">
						<div class="btn btn-blue" ngf-select ngf-change="qa.upload($files, qa.record)"> {!! trans('messages.choose_image') !!} </div>
					</div>

					<div class="margin-top-8" ng-if="qa.record.uploaded">
						<a href="" ng-click="qa.removeImage(qa.record)"><i class="fa fa-trash"></i></a>
					</div>
				</div>
				<div class="form-group" ng-if="qa.record.uploaded">
					<div class="col-xs-4"></div>
					<div class="col-xs-5">
						<span class="col-xs-6 upload-label label label-info">{!! trans('messages.image_uploaded') !!}</span>
						<a href="" class="control-label col-xs-6" ng-click="qa.viewImage(qa.record)">{!! trans('messages.view_image') !!}</a>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">{!! trans('messages.admin_question_type') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::select('question_type'
							, array(
								'' => trans('messages.admin_select_question_type')
								, 'MC' => trans('messages.admin_mc')
								, 'FIB' => trans('messages.admin_fib')
								, 'O' => trans('messages.admin_order')
								, 'N' => trans('messages.admin_provide')
								, 'GR' => trans('messages.admin_graph')
								, 'QUAD' => trans('messages.admin_quadrant')
							)
							, ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'qa.record.question_type'
								, 'ng-class' => "{ 'required-field' : qa.fields['question_type'] }"
							)
						) !!}
					</div>
				</div>

				<div class="form-group"
					 ng-if="qa.record.question_type
					 && qa.record.question_type != futureed.MULTIPLECHOICE
					 && qa.record.question_type != futureed.ORDERING
					 && qa.record.question_type != futureed.GRAPH
					 && qa.record.question_type != futureed.QUADRANT">
					<label class="control-label col-xs-4">{!! trans('messages.answer') !!} <span class="required">*</span></label>

					<div class="col-xs-5">
						{!! Form::textarea('answer',''
							, array(
								'placeHolder' => trans('messages.answer')
								, 'ng-model' => 'qa.record.answer'
								, 'class' => 'form-control disabled-textarea'
								, 'ng-class' => "{ 'required-field' : qa.fields['answer'] }"
								, 'rows' => 3
							)
						) !!}
					</div>
				</div>

				<div class="form-group" ng-if="qa.record.question_type == futureed.GRAPH">
					<label class="control-label col-xs-4">{!! trans('messages.admin_orientation') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::select('orientation'
							, array(
								'' => trans('messages.admin_select_orientation')
								, 'vertical' => trans('messages.admin_vertical')
								, 'horizontal' => trans('messages.admin_horizontal')
							)
							, ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'qa.record.orientation'
								, 'ng-class' => "{ 'required-field' : qa.fields['orientation'] }"
							)
						) !!}
					</div>
				</div>

				<div class="form-group"
					 ng-if="qa.record.question_type
					 && qa.record.question_type != futureed.FILLINBLANK
					 && qa.record.question_type != futureed.MULTIPLECHOICE
					 && qa.record.question_type != futureed.GRAPH
					 && qa.record.question_type != futureed.QUADRANT">
					<label class="control-label col-xs-4">{!! trans('messages.answer') !!} <span class="required">*</span></label>

					<div class="col-xs-5">
						{!! Form::textarea('answer',''
							, array(
								'placeHolder' => trans('messages.answer')
								, 'ng-model' => 'qa.record.answer'
								, 'class' => 'form-control disabled-textarea'
								, 'ng-disabled' => 'qa.active_view'
								, 'ng-class' => "{ 'required-field' : qa.fields['answer'] }"
								, 'rows' => 3
							)
						) !!}
					</div>
				</div>

				<div class="form-group" ng-if="qa.record.question_type == futureed.ORDERING  && qa.record.question_type">
					<label class="control-label col-xs-4">{!! trans('messages.answer') !!} <span class="required">**</span></label>
					<div class="col-xs-5">
						{!! Form::textarea('question_order_text',''
							, array(
								'placeHolder' => trans('messages.admin_order')
								, 'ng-model' => 'qa.record.question_order_text'
								, 'class' => 'form-control disabled-textarea'
								, 'ng-class' => "{ 'required-field' : qa.fields['question_order_text'] }"
								, 'rows' => 3
							)
						) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-4">{!! trans('messages.admin_points_earned') !!}<span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('points_earned',''
							, array(
								'placeHolder' => trans('messages.admin_points_earned')
								, 'ng-model' => 'qa.record.points_earned'
								, 'class' => 'form-control'
								, 'ng-class' => "{ 'required-field' : qa.fields['points_earned'] }"
							)
						) !!}
					</div>
					
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">{!! trans('messages.difficulty') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('difficulty',''
							, array(
								'placeHolder' => trans('messages.difficulty')
								, 'ng-model' => 'qa.record.difficulty'
								, 'class' => 'form-control'
								, 'ng-class' => "{ 'required-field' : qa.fields['difficulty'] }"
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-4">{!! trans('messages.sequence_no') !!}</label>
					<div class="col-xs-5">
						{!! Form::text('seq_no',''
							, array(
								'placeHolder' => trans('messages.sequence_no')
								, 'ng-model' => 'qa.record.seq_no'
								, 'class' => 'form-control'
								, 'ng-class' => "{ 'required-field' : qa.fields['seq_no'] }"
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-4 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
					<div class="col-xs-5">
						<div class="col-xs-6 checkbox">                                 
							<label>
								{!! Form::radio('status'
									, 'Enabled'
									, true
									, array(
										'class' => 'field'
										, 'ng-model' => 'qa.record.status'
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
										, 'ng-model' => 'qa.record.status'
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
					<div class="btn-container col-xs-8 col-xs-offset-2">
						{!! Form::button(trans('messages.save')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'qa.add()'
							)
						) !!}

						{!! Form::button(trans('messages.cancel')
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'qa.setActive()'
							)
						) !!}
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>

	<div id="qa_image_modal" ng-show="qa.view_image.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					{! qa.view_image.questions_text !}
				</div>
				<div class="modal-body">
					<div class="modal-image">
						<img ng-src="{! qa.view_image.image_path !}"/>
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
	<br>
	<div class="footnotes">
		<div><label class="required">*</label> {!! trans('messages.admin_question_required_info') !!}</div>
		<div ng-if="qa.record.question_type == futureed.ORDERING  && qa.record.question_type"><label class="required">**</label> {!! trans('messages.admin_question_instruction_msg') !!} </div>
	</div>
</div>