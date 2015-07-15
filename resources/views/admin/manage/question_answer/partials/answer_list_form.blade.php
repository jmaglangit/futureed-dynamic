<div ng-if="qa.qa_details.question_type == 'MC'" ng-init="qa.setAnsActive()">
        <div ng-if="qa.active_anslist">
        {!! Form::open(array('id'=> 'add_answer_form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) !!}
            <div class="col-xs-12 form-content">
                <div class="alert alert-error" ng-if="qa.answers.errors">
                    <p ng-repeat="error in qa.answers.errors track by $index" > 
                        {! error !}
                    </p>
                </div>

                <div class="alert alert-success" ng-if="qa.answers.success">
                    <p>{! qa.answers.success !}</p>
                </div>
                <fieldset>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Answer Code<span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::text('code',''
                                , array(
                                    'placeHolder' => 'Answer Code'
                                    , 'ng-model' => 'qa.answers.code'
                                    , 'class' => 'form-control'
                                    , 'ng-class' => "{ 'required-field' : qa.fields['code_ans'] }"
                                )
                            ) !!}
                        </div>
                        <label class="control-label col-xs-2">Answer Image</label>
                        <div class="col-xs-4">
                              <div style="position:relative;">
                                <a class='btn btn-primary btn-semi-large' href='javascript:;'>
                                    Choose File...
                                    <input ng-model="qa.answers.image" id="q_image" type="file" class="img-input" name="file_source" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
                                </a>
                                <center><span class='label label-info' id="upload-file-info"></span></center>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Answer <span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::text('answer_text',''
                                , array(
                                    'placeHolder' => 'Answer'
                                    , 'ng-model' => 'qa.answers.answer_text'
                                    , 'class' => 'form-control'
                                    , 'ng-class' => "{ 'required-field' : qa.fields['answer_text_ans'] }"
                                )
                            ) !!}
                        </div>
                        <label class="col-xs-2 control-label">Points Equivalent <span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::text('point_equivalent',''
                                , array(
                                    'placeHolder' => 'Points Equivalent'
                                    , 'ng-model' => 'qa.answers.point_equivalent'
                                    , 'class' => 'form-control'
                                    , 'ng-class' => "{ 'required-field' : qa.fields['point_equivalent_ans'] }"
                                )
                            ) !!}
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-xs-2 control-label">Correct Answer <span class="required">*</span></label>
                        <div class="col-xs-4">
                            {!! Form::select('correct_answer'
                                , array(
                                    '' => '-- Select Answer --'
                                    , 'Yes' => 'Yes'
                                    , 'No' => 'No'
                                )
                                , ''
                                , array(
                                    'class' => 'form-control'
                                    , 'ng-model' => 'qa.answers.correct_answer'
                                    , 'ng-class' => "{ 'required-field' : qa.fields['correct_answer_ans'] }"
                                )
                            ) !!}
                        </div>
                    </div>
                </fieldset>
                <div class="col-xs-6 col-xs-offset-3">
                    <div class="btn-container">
                        {!! Form::button('Add'
                            , array(
                                'class' => 'btn btn-blue btn-medium'
                                , 'ng-click' => 'qa.addAnswer()'
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
            {!! Form::close() !!}
        </div>
    <div ng-if="qa.active_ansedit">
        {!! Form::open(array('id'=> 'add_answer_form', 'class' => 'form-horizontal', 'enctype' => 'multipart/form-data')) !!}
            <div class="col-xs-12 form-content">
            <div class="alert alert-error" ng-if="qa.answers.errors">
                <p ng-repeat="error in qa.answers.errors track by $index" > 
                    {! error !}
                </p>
            </div>

            <div class="alert alert-success" ng-if="qa.answers.success">
                <p>{! qa.answers.success !}</p>
            </div>
            <fieldset>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Answer Code<span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::text('code',''
                            , array(
                                'placeHolder' => 'Answer Code'
                                , 'ng-model' => 'qa.ansdetails.code'
                                , 'class' => 'form-control'
                                , 'ng-class' => "{ 'required-field' : qa.fields['code_ans'] }"
                            )
                        ) !!}
                    </div>
                    <label class="control-label col-xs-2">Question Image</label>
                    <div class="col-xs-4">
                          <div style="position:relative;">
                            <a class='btn btn-primary btn-semi-large' href='javascript:;'>
                                Choose File...
                                <input ng-model="qa.answers.image" id="q_image" type="file" class="img-input" name="file_source" size="40"  onchange='$("#upload-file-info").html($(this).val());'>
                            </a>
                            <center><span class='label label-info' id="upload-file-info"></span></center>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Answer <span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::text('answer_text',''
                            , array(
                                'placeHolder' => 'Answer'
                                , 'ng-model' => 'qa.ansdetails.answer_text'
                                , 'class' => 'form-control'
                                , 'ng-class' => "{ 'required-field' : qa.fields['answer_text_ans'] }"
                            )
                        ) !!}
                    </div>
                    <label class="col-xs-2 control-label">Points Equivalent <span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::text('point_equivalent',''
                            , array(
                                'placeHolder' => 'Points Equivalent'
                                , 'ng-model' => 'qa.ansdetails.point_equivalent'
                                , 'class' => 'form-control'
                                , 'ng-class' => "{ 'required-field' : qa.fields['point_equivalent_ans'] }"
                            )
                        ) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-2 control-label">Correct Answer <span class="required">*</span></label>
                    <div class="col-xs-4">
                        {!! Form::select('correct_answer'
                            , array(
                                '' => '-- Select Answer --'
                                , 'Yes' => 'Yes'
                                , 'No' => 'No'
                            )
                            , ''
                            , array(
                                'class' => 'form-control'
                                , 'ng-model' => 'qa.ansdetails.correct_answer'
                                , 'ng-class' => "{ 'required-field' : qa.fields['correct_answer_ans'] }"
                            )
                        ) !!}
                    </div>
                </div>
            </fieldset>
            <div class="col-xs-6 col-xs-offset-3">
                <div class="btn-container">
                    {!! Form::button('Save'
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.saveAnswer()'
                        )
                    ) !!}
                    {!! Form::button('Cancel'
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => 'qa.setAnsActive()'
                        )
                    ) !!}
                </div>
            </div>
        </div>
    </div>
<div class="col-xs-12 table-container">
        <div class="title-mid">
            Answer List
        </div>

        <div class="list-container" ng-cloak>
            <div class="size-container">
                {!! Form::select('size'
                    , array(
                          '10' => '10'
                        , '20' => '20'
                        , '50' => '50'
                        , '100' => '100'
                    )
                    , '10'
                    , array(
                        'ng-model' => 'qa.table.size'
                        , 'ng-change' => 'qa.paginateBySize()'
                        , 'ng-if' => "qa.ans_records.length"
                        , 'class' => 'form-control paginate-size pull-right'
                    )
                ) !!}
            </div>

            <div class="clearfix"></div>
            <div class="table-responsive">
                <table id="tip-list" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Answer</th>
                            <th>Answer Image</th>
                            <th>Correct Answer</th>
                            <th>Point Equivalent</th>
                            <th ng-if="qa.ans_records.length">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="ansInfo in qa.ans_records">
                            <td>{! ansInfo.code !}</td>
                            <td>{! ansInfo.answer_text !}</td>
                            <td></td>
                            <td>{! ansInfo.correct_answer !}</td>
                            <td>{! ansInfo.point_equivalent !}</td>
                            <td ng-if="qa.ans_records.length">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <a href="" ng-click="qa.setAnsActive(futureed.ACTIVE_EDIT, ansInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
                                    </div>
                                    <div class="col-xs-6">
                                        <a href="" ng-click="qa.confirmAnsDelete(ansInfo.id)"><span><i class="fa fa-trash"></i></span></a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr class="odd" ng-if="!qa.ans_records.length && !qa.table.loading">
                            <td valign="top" colspan="7">
                                No records found
                            </td>
                        </tr>
                        <tr class="odd" ng-if="qa.table.loading">
                            <td valign="top" colspan="7">
                                Loading...
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="pull-right" ng-if="qa.ans_records.length">
                <pagination 
                    total-items="qa.table.total_items" 
                    ng-model="qa.table.page"
                    max-size="3"
                    items-per-page="qa.table.size" 
                    previous-text = "&lt;"
                    next-text="&gt;"
                    class="pagination" 
                    boundary-links="true"
                    ng-change="qa.paginateByPage()">
                </pagination>
            </div>
        </div>
    </div>
<div id="delete_answer_modal" ng-show="qa.delete.ans_confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            Delete Answer
        </div>
        <div class="modal-body">
            Are you sure you want to delete this Answer?
        </div>
        <div class="modal-footer">
            <div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('Yes'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => 'qa.deleteAnswer()'
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