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
                <label class="control-label col-xs-2">Code<span class="required">*</span></label>
                <div class="col-xs-4">
                    {!! Form::text('code',''
                        , array(
                            'placeHolder' => 'Code'
                            , 'ng-model' => 'qa.details.code'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => 'true'
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
                            , 'ng-model' => 'qa.details.question_type'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['question_type'] }"
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
                            , 'ng-model' => 'qa.details.questions_text'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['questions_text'] }"
                        )
                    ) !!}
                </div>
                <label ng-if="qa.details.question_type != 'MC' && qa.details.question_type" class="control-label col-xs-2">Answer <span class="required">*</span></label>
                <div class="col-xs-4" ng-if="qa.details.question_type != 'MC' && qa.details.question_type">
                    {!! Form::text('question',''
                        , array(
                            'placeHolder' => 'Answer'
                            , 'ng-model' => 'qa.details.answer'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer'] }"
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
                            , 'ng-model' => 'qa.details.points_earned'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['points_earned'] }"
                        )
                    ) !!}
                </div>
                <label ng-if="qa.active_edit" class="control-label col-xs-2">Question Image</label>
                <div class="col-xs-4" ng-if="qa.active_edit">
                    <div class="btn btn-blue" ngf-select ngf-change="qa.upload($files)"> Choose Image... </div>
                    <span ng-if="qa.uploaded" class="label label-info upload-label">Image Uploaded...</span>
                </div>
                <div ng-if="qa.active_view && qa.details.original_image_name && qa.details.original_image_name != '0'">
                    <div class="col-xs-2"></div>
                    <div class="col-xs-4">
                        <a href="" ng-click="qa.viewImage('{!! route('admin.image.viewer') !!}')">View Question Image</a>
                    </div>
                </div>
        	</div>
            <div class="form-group">
                <label class="control-label col-xs-2">Difficulty <span class="required">*</span></label>
                <div class="col-xs-4">
                    {!! Form::text('difficulty',''
                        , array(
                            'placeHolder' => 'Difficulty'
                            , 'ng-model' => 'qa.details.difficulty'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['difficulty'] }"
                        )
                    ) !!}
                </div>
                <label class="col-xs-2 control-label">Status <span class="required">*</span></label>
                <div class="col-xs-4" ng-if="qa.active_edit">
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
                <div class="col-xs-4" ng-if="qa.active_view">
                    <label class="col-md-8" ng-if="qa.details.status == 'Enabled'">
                        <b class="success-icon">
                            <i class="margin-top-8 fa fa-check-circle-o"></i> {! module.details.status !}
                        </b>
                    </label>

                    <label class="col-md-8" ng-if="qa.details.status == 'Disabled'">
                        <b class="error-icon">
                            <i class="margin-top-8 fa fa-ban"></i> {! module.details.status !}
                        </b>
                    </label>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-2">Sequance No</label>
                <div class="col-xs-4">
                    {!! Form::text('seq_no',''
                        , array(
                            'placeHolder' => 'Sequance No'
                            , 'ng-model' => 'qa.details.seq_no'
                            , 'class' => 'form-control'
                            , 'ng-disabled' => '!qa.edit'
                            , 'ng-class' => "{ 'required-field' : qa.fields['seq_no'] }"
                        )
                    ) !!}
                </div>
            </div>
        </fieldset>
        <div class="col-xs-6 col-xs-offset-3">
        	<div class="btn-container">
                {!! Form::button('Edit'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => "qa.setActive('edit', qa.details.id)"
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
                        , 'ng-click' => "qa.setActive('view', qa.details.id)"
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

    <div id="view_image_modal" ng-show="qa.view_image" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    {! qa.details.questions_text !}
                </div>
                <div class="modal-body">
                    <div class="modal-image">
                        <img ng-src="{! qa.details.image_path !}"/>
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