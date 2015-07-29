<div ng-if="qa.active_add">
	{!! Form::open(array('id'=> 'add_question_form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) !!}
	<div class="col-xs-12 form-content">
		<div class="alert alert-error" ng-if="qa.errors">
            <p ng-repeat="error in qa.errors track by $index" > 
              	{! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="qa.create.success">
        	<p>Successfully added new Question.</p>
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
                Add Question Details
            </legend>
            <div class="form-group">
                <label class="control-label col-xs-4">Code <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::text('code',''
                        , array(
                            'placeHolder' => 'Code'
                            , 'ng-model' => 'qa.create.code'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['code'] }"
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-4">Question <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::textarea('question',''
                        , array(
                            'placeHolder' => 'Question'
                            , 'ng-model' => 'qa.create.questions_text'
                            , 'class' => 'form-control disabled-textarea'
                            , 'ng-class' => "{ 'required-field' : qa.fields['questions_text'] }"
                            , 'rows' => 5
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-4">Question Image</label>
                <div class="col-xs-5">
                    <div class="btn btn-blue" ngf-select ngf-change="qa.upload($files, qa.create)"> Choose Image... </div>
                </div>

                <div class="margin-top-8" ng-if="qa.create.uploaded">
                    <a href="" ng-click="qa.removeImage(qa.create)"><i class="fa fa-trash"></i></a>
                </div>
            </div>
            <div class="form-group" ng-if="qa.create.uploaded">
                <div class="col-xs-4"></div>
                <div class="col-xs-5">
                    <span class="col-xs-6 upload-label label label-info">Image Uploaded...</span>
                    <a href="" class="control-label col-xs-6" ng-click="qa.viewImage(qa.create)">View Image</a>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-4">Question Type <span class="required">*</span></label>
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
                            , 'ng-model' => 'qa.create.question_type'
                            , 'ng-class' => "{ 'required-field' : qa.fields['question_type'] }"
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group" ng-if="qa.create.question_type != 'MC' && qa.create.question_type">
                <label class="control-label col-xs-4">Answer <span class="required">*</span></label>
                <div class="col-xs-5" >
                    {!! Form::textarea('answer',''
                        , array(
                            'placeHolder' => 'Answer'
                            , 'ng-model' => 'qa.create.answer'
                            , 'class' => 'form-control disabled-textarea'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer'] }"
                            , 'rows' => 5
                        )
                    ) !!}
                </div>
            </div>
        	<div class="form-group">
                <label class="control-label col-xs-4">Points Earned<span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::text('points_earned',''
                        , array(
                            'placeHolder' => 'Points Earned'
                            , 'ng-model' => 'qa.create.points_earned'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['points_earned'] }"
                        )
                    ) !!}
                </div>
                
        	</div>
            <div class="form-group">
                <label class="control-label col-xs-4">Difficulty <span class="required">*</span></label>
                <div class="col-xs-5">
                    {!! Form::text('difficulty',''
                        , array(
                            'placeHolder' => 'Difficulty'
                            , 'ng-model' => 'qa.create.difficulty'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['difficulty'] }"
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-4">Sequence No</label>
                <div class="col-xs-5">
                    {!! Form::text('seq_no',''
                        , array(
                            'placeHolder' => 'Sequence No'
                            , 'ng-model' => 'qa.create.seq_no'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['seq_no'] }"
                        )
                    ) !!}
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-4 control-label">Status <span class="required">*</span></label>
                <div class="col-xs-5">
                    <div class="col-xs-6 checkbox">                                 
                        <label>
                            {!! Form::radio('status'
                                , 'Enabled'
                                , true
                                , array(
                                    'class' => 'field'
                                    , 'ng-model' => 'qa.create.status'
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
                                    , 'ng-model' => 'qa.create.status'
                                )
                            ) !!}
                        <span class="lbl padding-8">Disabled</span>
                        </label>
                    </div>
                </div>
            </div>
        </fieldset>
        <div class="col-xs-8 col-xs-offset-2">
        	<div class="btn-container">
        		{!! Form::button('Save'
	        		, array(
	        			'class' => 'btn btn-blue btn-medium'
	        			, 'ng-click' => 'qa.addNewQuestion()'
	        		)
	        	) !!}

	        	{!! Form::button('Cancel'
	        		, array(
	        			'class' => 'btn btn-gold btn-medium'
	        			, 'ng-click' => 'qa.setActive()'
	        		)
	        	) !!}
        	</div>
        </div>
	</div>

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