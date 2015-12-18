<div ng-if="qa.record.question_type == futureed.M_CHOICE" ng-init="qa.setAnsActive()">
    <div class="col-xs-12 search-container" ng-if="qa.answers.errors || qa.answers.success">
        <div class="alert alert-error" ng-if="qa.answers.errors">
            <p ng-repeat="error in qa.answers.errors track by $index">
                {! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="qa.answers.success">
            <p>{! qa.answers.success !}</p>
        </div>
    </div>

    <div class="col-xs-12 search-container">
        {!! Form::open(array('class' => 'form-horizontal')) !!}
        <div class="form-search">
            <div class="form-group">
                <label class="col-xs-4 control-label">Answer Code<span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('code',''
                        , array(
                            'placeHolder' => 'Answer Code'
                            , 'ng-model' => 'qa.answers.record.code'
                            , 'ng-disabled' => 'qa.active_ansedit'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['code_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Answer <span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('answer_text',''
                        , array(
                            'placeHolder' => 'Answer'
                            , 'ng-model' => 'qa.answers.record.answer_text'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer_text_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Label </label>

                <div class="col-xs-5">
                    {!! Form::text('label',''
                        , array(
                            'placeHolder' => 'Label'
                            , 'ng-model' => 'qa.answers.record.label'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['label_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Correct Answer <span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::select('correct_answer'
                        , array(
                            '' => '-- Select Answer --'
                            , 'Yes' => 'Yes'
                            , 'No' => 'No'
                        )
                        , ''
                        , array(
                            'class' => 'form-control'
                            , 'ng-model' => 'qa.answers.record.correct_answer'
                            , 'ng-class' => "{ 'required-field' : qa.fields['correct_answer_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Points Equivalent <span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('point_equivalent',''
                        , array(
                            'placeHolder' => 'Points Equivalent'
                            , 'ng-model' => 'qa.answers.record.point_equivalent'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['point_equivalent_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-4">Answer Image</label>

                <div class="col-xs-5">
                    <div class="btn btn-blue" ngf-select ngf-change="qa.uploadAnswer($files, qa.answers.record)"> Choose
                        Image...
                    </div>
                </div>

                <div class="margin-top-8" ng-if="qa.answers.record.uploaded">
                    <a href="" ng-click="qa.removeImage(qa.answers.record)"><i class="fa fa-trash"></i></a>
                </div>
            </div>

            <div class="form-group" ng-if="qa.answers.record.uploaded">
                <div class="col-xs-4"></div>
                <div class="col-xs-5">
                    <span class="col-xs-6 upload-label label label-info">Image Uploaded...</span>
                    <a href="" class="control-label col-xs-6" ng-click="qa.viewAnswerImage(qa.answers.record)">View
                        Image</a>
                </div>
            </div>

            <div class="form-group"
                 ng-if="qa.active_view
                 && !qa.answers.record.uploaded
                 && qa.answers.record.original_image_name
                 && qa.answers.record.original_image_name != '0'">
                <div class="control-label col-xs-4"></div>
                <div class="col-xs-5">
                    <a href="" ng-click="qa.viewAnswerImage(qa.answers.record)">View Image</a>
                </div>
            </div>

            <div class="form-group">
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_anslist">
                    {!! Form::button('Add'
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.addAnswer()'
                        )
                    ) !!}
                    {!! Form::button('Clear'
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => 'qa.clearAnswer()'
                        )
                    ) !!}
                </div>
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_ansedit">
                    {!! Form::button('Update'
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.updateAnswer()'
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
        {!! Form::close() !!}
    </div>

    <div class="col-xs-12 table-container">
        <div class="list-container" ng-cloak>
            <div class="col-xs-6 title-mid">
                Answer List
            </div>

            <div class="col-xs-6 size-container">
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
                        , 'ng-if' => "qa.answers.records.length"
                        , 'class' => 'form-control paginate-size pull-right'
                    )
                ) !!}
            </div>

            <table class="col-xs-12 table table-striped table-bordered">
                <thead>
                <tr>
                    <th>Code</th>
                    <th>Label</th>
                    <th>Answer</th>
                    <th>Correct Answer</th>
                    <th>Point Equivalent</th>
                    <th ng-if="qa.answers.records.length">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="record in qa.answers.records">
                    <td>{! record.code !}</td>
                    <td>{! record.label !}</td>
                    <td>{! record.answer_text !}</td>
                    <td>{! record.correct_answer !}</td>
                    <td>{! record.point_equivalent !}</td>
                    <td ng-if="qa.answers.records.length">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="" ng-click="qa.setAnsActive(futureed.ACTIVE_EDIT, record.id)"><span><i
                                                class="fa fa-pencil"></i></span></a>
                            </div>
                            <div class="col-xs-6">
                                <a href="" ng-click="qa.confirmAnsDelete(record.id)"><span><i
                                                class="fa fa-trash"></i></span></a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="odd" ng-if="!qa.answers.records.length && !qa.table.loading">
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

            <div class="pull-right" ng-if="qa.answers.records.length">
                <pagination
                        total-items="qa.table.total_items"
                        ng-model="qa.table.page"
                        max-size="3"
                        items-per-page="qa.table.size"
                        previous-text="&lt;"
                        next-text="&gt;"
                        class="pagination"
                        boundary-links="true"
                        ng-change="qa.paginateByPage()">
                </pagination>
            </div>
        </div>
    </div>

    <div id="delete_answer_modal" ng-show="qa.delete.ans_confirm" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="myLargeModalLabel" aria-hidden="true">
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
</div>

<div ng-if="qa.record.question_type == futureed.GRAPH" ng-init="qa.setAnsActive()">
    <div class="col-xs-12 search-container">
        {!! Form::open(array('class' => 'form-horizontal')) !!}
        <div class="form-search">
            <div class="form-group">
                <label class="col-xs-4 control-label">Field<span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('code',''
                        , array(
                            'placeHolder' => 'Field Name'
                            , 'ng-model' => 'qa.answers.record.field'
                            , 'ng-disabled' => 'qa.active_ansedit'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['code_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">Count <span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('answer_text',''
                        , array(
                            'placeHolder' => 'Count'
                            , 'ng-model' => 'qa.answers.record.count'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer_text_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-4">Answer Image</label>

                <div class="col-xs-5">
                    <div class="btn btn-blue" ngf-select ngf-change="qa.uploadGraphImage($files, qa.answers.record)"> Choose
                        Image...
                    </div>
                </div>

                <div class="margin-top-8" ng-if="qa.answers.record.uploaded">
                    <a href="" ng-click="qa.removeImage(qa.answers.record)"><i class="fa fa-trash"></i></a>
                </div>
            </div>

            <div class="form-group" ng-if="qa.answers.record.uploaded">
                <div class="col-xs-4"></div>
                <div class="col-xs-5">
                    <span class="col-xs-6 upload-label label label-info">Image Uploaded...</span>
                    <a href="" class="control-label col-xs-6" ng-click="qa.viewAnswerImage(qa.answers.record)">View
                        Image</a>
                </div>
            </div>

            <div class="form-group"
                 ng-if="qa.active_view
                 && !qa.answers.record.uploaded
                 && qa.answers.record.original_image_name
                 && qa.answers.record.original_image_name != '0'">
                <div class="control-label col-xs-4"></div>
                <div class="col-xs-5">
                    <a href="" ng-click="qa.viewAnswerImage(qa.answers.record)">View Image</a>
                </div>
            </div>

            <div class="form-group">
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_anslist">
                    {!! Form::button('Add'
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.addAnswer()'
                        )
                    ) !!}
                    {!! Form::button('Clear'
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => 'qa.clearAnswer()'
                        )
                    ) !!}
                </div>
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_ansedit">
                    {!! Form::button('Update'
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.updateAnswer()'
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
        {!! Form::close() !!}
    </div>
</div>