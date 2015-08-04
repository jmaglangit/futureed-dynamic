<div ng-if="qa.active_view || qa.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>View Question</span>
		</div>
	</div>
	{!! Form::open(array('id'=> 'add_question_form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) !!}
	<div class="col-xs-12 form-content">
		<div class="alert alert-error" ng-if="qa.errors">
            <p ng-repeat="error in qa.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="qa.success">
        	<p>{! qa.success !}</p>
        </div>
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
                            , 'ng-model' => 'qa.q_details.code'
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
                            , 'ng-model' => 'qa.q_details.questions_text'
                            , 'class' => 'form-control disabled-textarea'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['questions_text'] }"
                            , 'rows' => 5
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-3">Question Image </label>
                <div class="col-xs-5" ng-if="qa.active_edit">
                    <div class="btn btn-blue" ngf-select ngf-change="qa.upload($files, qa.q_details)"> Choose Image... </div>
                </div>

                <div class="margin-top-8" ng-if="qa.q_details.uploaded">
                    <a href="" ng-click="qa.removeImage(qa.q_details)"><i class="fa fa-trash"></i></a>
                </div>

                <div ng-if="qa.active_view && qa.q_details.original_image_name && qa.q_details.original_image_name != '0'">
                    <div class="col-xs-4 margin-top-8">
                        <a href="" ng-click="qa.viewImage(qa.q_details)">View Image</a>
                    </div>
                </div>
            </div>

            <div class="form-group" ng-if="qa.q_details.uploaded">
                <div class="col-xs-3"></div>
                <div class="col-xs-5">
                    <span class="col-xs-6 upload-label label label-info">Image Uploaded...</span>
                    <a href="" class="control-label col-xs-6" ng-click="qa.viewImage(qa.q_details)">View Image</a>
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
                        )
                        , ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-model' => 'qa.q_details.question_type'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['question_type'] }"
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group" ng-if="qa.q_details.question_type && qa.q_details.question_type != futureed.MULTIPLECHOICE && qa.q_details.question_type != futureed.ORDERING">
                <label class="control-label col-xs-3">Answer <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::textarea('answer',''
                        , array(
                            'placeHolder' => 'Answer'
                            , 'ng-model' => 'qa.q_details.answer'
                            , 'class' => 'form-control disabled-textarea'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer'] }"
                            , 'rows' => 3
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group" ng-if="qa.q_details.question_type == futureed.ORDERING  && qa.q_details.question_type">
                <label class="control-label col-xs-3">Order <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::textarea('question_order_text',''
                        , array(
                            'placeHolder' => 'Order'
                            , 'ng-model' => 'qa.q_details.question_order_text'
                            , 'class' => 'form-control disabled-textarea'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['question_order_text'] }"
                            , 'rows' => 3
                        )
                    ) !!}
                    <p class="help-block">Answer should be comma separated to indicate the order.</p>
                </div>
            </div>

        	<div class="form-group">
                <label class="control-label col-xs-3">Points Earned <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::text('points_earned',''
                        , array(
                            'placeHolder' => 'Points Earned'
                            , 'ng-model' => 'qa.q_details.points_earned'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => '!qa.edit'
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
                            , 'ng-model' => 'qa.q_details.difficulty'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => '!qa.edit'
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
                                    , 'ng-model' => 'qa.q_details.status'
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
                                    , 'ng-model' => 'qa.q_details.status'
                                )
                            ) !!}
                        <span class="lbl padding-8">Disabled</span>
                        </label>
                    </div>
                </div>
                <div class="col-xs-5" ng-if="qa.active_view">
                    <label ng-if="qa.q_details.status == 'Enabled'">
                        <b class="success-icon">
                            <i class="margin-top-8 fa fa-check-circle-o"></i> {! qa.q_details.status !}
                        </b>
                    </label>

                    <label ng-if="qa.q_details.status == 'Disabled'">
                        <b class="error-icon">
                            <i class="margin-top-8 fa fa-ban"></i> {! qa.q_details.status !}
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
                            , 'ng-model' => 'qa.q_details.seq_no'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['seq_no'] }"
                        )
                    ) !!}
                </div>
            </div>
        </fieldset>
        <div class="col-xs-8 col-xs-offset-2">
        	<div class="btn-container">
                {!! Form::button('Edit'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => "qa.setActive('edit', qa.q_details.id)"
                        , 'ng-if' => 'qa.active_view'
                    )
                ) !!}
        		{!! Form::button('Save'
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'qa.saveEditQuestion()'
                        , 'ng-if' => 'qa.active_edit'
	        		)
	        	) !!}
                {!! Form::button('Cancel'
                    , array(
                        'class' => 'btn btn-gold btn-medium'
                        , 'ng-click' => "qa.setActive('view', qa.q_details.id)"
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
	</div>
    <div template-directive template-url="{!! route('admin.manage.question_answer.partials.answer_list_form') !!}"></div>

    <div id="view_image_modal" ng-show="qa.view_image.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
                    <div class="btncon col-md-8 col-md-offset-4 pull-left">
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
</div>