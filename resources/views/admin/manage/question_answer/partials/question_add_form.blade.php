<div ng-if="qa.active_add">
	<div class="content-title">
		<div class="title-main-content">
			<span>Add Question</span>
		</div>
	</div>
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
            </div>
            <div class="form-group">
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
            <div class="form-group">
                <label class="control-label col-xs-2">Code <span class="required">*</span></label>
                <div class="col-xs-4">
                    {!! Form::text('code',''
                        , array(
                            'placeHolder' => 'Code'
                            , 'ng-model' => 'qa.create.code'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['code'] }"
                        )
                    ) !!}
                </div>
                <label class="control-label col-xs-2">Sequence No</label>
                <div class="col-xs-4">
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
                <label class="control-label col-xs-2">Question <span class="required">*</span></label>
                <div class="col-xs-4">
                    {!! Form::text('question',''
                        , array(
                            'placeHolder' => 'Question'
                            , 'ng-model' => 'qa.create.questions_text'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['questions_text'] }"
                        )
                    ) !!}
                </div>
                <label class="control-label col-xs-2">Question Type<span class="required">*</span></label>
                <div class="col-xs-4">
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
        	<div class="form-group">
                <label class="control-label col-xs-2">Points Earned<span class="required">*</span></label>
                <div class="col-xs-4">
                    {!! Form::text('points_earned',''
                        , array(
                            'placeHolder' => 'Points Earned'
                            , 'ng-model' => 'qa.create.points_earned'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['points_earned'] }"
                        )
                    ) !!}
                </div>
                <label ng-if="qa.create.question_type != 'MC' && qa.create.question_type" class="control-label col-xs-2">Answer <span class="required">*</span></label>
                <div class="col-xs-4" ng-if="qa.create.question_type != 'MC' && qa.create.question_type">
                    {!! Form::text('answer',''
                        , array(
                            'placeHolder' => 'Answer'
                            , 'ng-model' => 'qa.create.answer'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer'] }"
                        )
                    ) !!}
                </div>
        	</div>
            <div class="form-group">
                <label class="control-label col-xs-2">Difficulty <span class="required">*</span></label>
                <div class="col-xs-4">
                    {!! Form::text('difficulty',''
                        , array(
                            'placeHolder' => 'Difficulty'
                            , 'ng-model' => 'qa.create.difficulty'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['difficulty'] }"
                        )
                    ) !!}
                </div>
                <label class="control-label col-xs-2">Question Image</label>
                <div class="col-xs-4">
                    <div class="btn btn-blue" ngf-select ngf-change="qa.upload($files, qa.create)"> Choose Image... </div>
                    <span ng-if="qa.create.uploaded" class="label label-info upload-label">Image Uploaded...</span>
                </div>
            </div>
            <div class="form-group">
                <label class="col-xs-2 control-label">Status <span class="required">*</span></label>
                <div class="col-xs-4">
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
        <div class="col-xs-6 col-xs-offset-3">
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
</div>