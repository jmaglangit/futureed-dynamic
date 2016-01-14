<div ng-if="qa.active_view || qa.active_edit">
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
		{!! Form::open(array('class' => 'form-horizontal')) !!}
			<fieldset>
				<legend class="legend-name-mid">
					Module Details
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-2">Module</label>
					<div class="col-xs-4">
						{!! Form::text('module',''
							, array(
								'placeHolder' => 'Module'
								, 'ng-model' => 'qa.module.name'
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
					<label class="control-label col-xs-2">Subject</label>
					<div class="col-xs-4">
						{!! Form::text('subject',''
							, array(
								'placeHolder' => 'Subject'
								, 'ng-model' => 'qa.module.subject.name'
								, 'ng-disabled' => 'true'
								, 'class' => 'form-control'
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-2">Code<span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('code',''
							, array(
								'placeHolder' => 'Code'
								, 'ng-model' => 'qa.record.code'
								, 'class' => 'form-control'
								, 'ng-disabled' => 'true'
							)
						) !!}
					</div>
					<label class="control-label col-xs-2">Area</label>
					<div class="col-xs-4">
						{!! Form::text('area',''
							, array(
								'placeHolder' => 'Area'
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
					Question Details
				</legend>
				<div class="form-group">
					<label class="control-label col-xs-3">Question <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::textarea('questions_text',''
							, array(
								'placeHolder' => 'Question'
								, 'ng-model' => 'qa.record.questions_text'
								, 'class' => 'form-control disabled-textarea'
								, 'ng-disabled' => 'qa.active_view'
								, 'ng-class' => "{ 'required-field' : qa.fields['questions_text'] }"
								, 'rows' => 5
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Question Image </label>
					<div class="col-xs-5" ng-if="qa.active_edit">
						<div class="btn btn-blue" ngf-select ngf-change="qa.upload($files, qa.record)"> Choose Image... </div>
					</div>

					<div class="margin-top-8" ng-if="qa.record.uploaded">
						<a href="" ng-click="qa.removeImage(qa.record)"><i class="fa fa-trash"></i></a>
					</div>

					<div ng-if="qa.active_view && qa.record.questions_image != 'None' && qa.record.original_image_name != '0'">
						<div class="col-xs-5 margin-top-8">
							<a href="" ng-click="qa.viewImage(qa.record)">View Image Test</a>
							<a class="pull-right" href="" ng-click="qa.confirmImageDelete(qa.record)"><i class="fa fa-trash"></i></a>
						</div>
					</div>

					<div class="col-xs-3" ng-if="qa.active_view && qa.record.questions_image == 'None'">
						<span class="upload-label label label-info">{! qa.record.questions_image !}</span>
					</div>
				</div>

				<div class="form-group" ng-if="qa.active_edit && qa.record.image != futureed.NONE && !qa.record.uploaded">
					<div class="col-xs-3"></div>
					<div ng-if="qa.active_edit && qa.record.questions_image != futureed.NONE">
						<div class="col-xs-5 margin-top-8">
							<a href="" ng-click="qa.viewImage(qa.record)">View Image</a>
							<a class="pull-right" href="" ng-click="qa.removeImage(qa.record)"><i class="fa fa-trash"></i></a>
						</div>
					</div>
				</div>

				<div class="form-group" ng-if="qa.record.uploaded">
					<div class="col-xs-3"></div>
					<div class="col-xs-5">
						<span class="col-xs-6 upload-label label label-info">Image Uploaded...</span>
						<a href="" class="control-label col-xs-6" ng-click="qa.viewImage(qa.record)">View Image</a>
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-3">Question Type <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::select('question_type'
							, array(
								'' => '-- Select Question Type --'
								, 'MC' => 'Multiple Choice'
								, 'FIB' => 'Fill in the Blanks'
								, 'O' => 'Orders'
								, 'N' => 'Provide'
								, 'GR' => 'Graph'
								, 'QUAD' => 'Quadrant'
							)
							, ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'qa.record.question_type'
								, 'ng-disabled' => 'qa.active_view'
								, 'ng-class' => "{ 'required-field' : qa.fields['question_type'] }"
							)
						) !!}
					</div>
				</div>

				<div class="form-group" ng-if="qa.record.question_type == futureed.GRAPH">
					<label class="control-label col-xs-3">Orientation <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::select('orientation'
							, array(
								'' => '-- Select Orientation --'
								, 'vertical' => 'Vertical'
								, 'horizontal' => 'Horizontal'
							)
							, ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'qa.record.orientation'
								, 'ng-disabled' => 'qa.active_view'
								, 'ng-class' => "{ 'required-field' : qa.fields['orientation'] }"
							)
						) !!}
					</div>
				</div>

				<div class="form-group"
					 ng-if="qa.record.question_type
					 && qa.record.question_type != futureed.MULTIPLECHOICE
					 && qa.record.question_type != futureed.GRAPH
					 && qa.record.question_type != futureed.QUADRANT">
					<label class="control-label col-xs-3">Answer <span class="required">*</span></label>

					<div class="col-xs-5">
						{!! Form::textarea('answer',''
							, array(
								'placeHolder' => 'Answer'
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
					<label class="control-label col-xs-3">Order <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::textarea('question_order_text',''
							, array(
								'placeHolder' => 'Order'
								, 'ng-model' => 'qa.record.question_order_text'
								, 'class' => 'form-control disabled-textarea'
								, 'ng-disabled' => 'qa.active_view'
								, 'ng-class' => "{ 'required-field' : qa.fields['question_order_text'] }"
								, 'rows' => 3
							)
						) !!}
					</div>
				</div>

				<div class="form-group">
					<label class="control-label col-xs-3">Points Earned <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('points_earned',''
							, array(
								'placeHolder' => 'Points Earned'
								, 'ng-model' => 'qa.record.points_earned'
								, 'class' => 'form-control'
								, 'ng-disabled' => 'qa.active_view'
								, 'ng-class' => "{ 'required-field' : qa.fields['points_earned'] }"
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Difficulty <span class="required">*</span></label>
					<div class="col-xs-5">
						{!! Form::text('difficulty',''
							, array(
								'placeHolder' => 'Difficulty'
								, 'ng-model' => 'qa.record.difficulty'
								, 'class' => 'form-control'
								, 'ng-disabled' => 'qa.active_view'
								, 'ng-class' => "{ 'required-field' : qa.fields['difficulty'] }"
							)
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Status <span class="required">*</span></label>
					<div class="col-xs-5" ng-if="qa.active_edit">
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
										, 'ng-model' => 'qa.record.status'
									)
								) !!}
							<span class="lbl padding-8">Disabled</span>
							</label>
						</div>
					</div>
					<div class="col-xs-5" ng-if="qa.active_view">
						<label ng-if="qa.record.status == 'Enabled'">
							<b class="success-icon">
								<i class="margin-top-8 fa fa-check-circle-o"></i> {! qa.record.status !}
							</b>
						</label>

						<label ng-if="qa.record.status == 'Disabled'">
							<b class="error-icon">
								<i class="margin-top-8 fa fa-ban"></i> {! qa.record.status !}
							</b>
						</label>
					</div>
				</div>
				<div class="form-group">
					<label class="control-label col-xs-3">Sequence No</label>
					<div class="col-xs-5">
						{!! Form::text('seq_no',''
							, array(
								'placeHolder' => 'Sequance No'
								, 'ng-model' => 'qa.record.seq_no'
								, 'class' => 'form-control'
								, 'ng-disabled' => 'qa.active_view'
								, 'ng-class' => "{ 'required-field' : qa.fields['seq_no'] }"
							)
						) !!}
					</div>
				</div>
			</fieldset>

			<fieldset>
				<div class="form-group">
				   <div class="btn-container col-xs-8 col-xs-offset-2">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "qa.setActive(futureed.ACTIVE_EDIT, qa.record.id)"
								, 'ng-if' => 'qa.active_view'
							)
						) !!}
						{!! Form::button('Update'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'qa.update()'
								, 'ng-if' => 'qa.active_edit'
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "qa.setActive(futureed.ACTIVE_VIEW, qa.record.id)"
								, 'ng-if' => 'qa.active_edit'
							)
						) !!}
						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => 'qa.setActive()'
								, 'ng-if' => 'qa.active_view'
							)
						) !!}
						{!! Form::close() !!}
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>

	<div template-directive template-url="{!! route('admin.manage.question_answer.partials.answer_list_form') !!}"></div>

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
						{!! Form::button('Close'
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

	<div id="qa_delete_image_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					Delete Image
				</div>
				<div class="modal-body">
					Are you sure you want to delete this image?
					<div class="modal-image">
						<img ng-src="{! qa.view_image.image_path !}"/>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btncon col-md-8 col-md-offset-4 pull-left">
						{!! Form::button('Yes'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'qa.deleteImage(object)'
								, 'data-dismiss' => 'modal'
							)
						) !!}

						{!! Form::button('No'
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
		<div><label class="required">*</label> required information</div>
		<div ng-if="qa.record.question_type == futureed.ORDERING  && qa.record.question_type"><label class="required">**</label> answer should be comma separated to indicate the order. </div>
	</div>
</div>