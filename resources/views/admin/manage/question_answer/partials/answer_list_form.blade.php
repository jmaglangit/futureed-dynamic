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
                <label class="col-xs-4 control-label">{!! trans('messages.admin_answer_code') !!}<span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('code',''
                        , array(
                            'placeHolder' => trans('messages.admin_answer_code')
                            , 'ng-model' => 'qa.answers.record.code'
                            , 'ng-disabled' => 'qa.active_ansedit'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['code_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">{!! trans('messages.answer') !!} <span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('answer_text',''
                        , array(
                            'placeHolder' => trans('messages.answer')
                            , 'ng-model' => 'qa.answers.record.answer_text'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer_text_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">{!! trans('messages.admin_label') !!} </label>

                <div class="col-xs-5">
                    {!! Form::text('label',''
                        , array(
                            'placeHolder' => trans('messages.admin_label')
                            , 'ng-model' => 'qa.answers.record.label'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['label_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">{!! trans('messages.admin_correct_answer') !!} <span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::select('correct_answer'
                        , array(
                            '' => trans('messages.admin_select_answer')
                            , 'Yes' => trans('messages.yes')
                            , 'No' => trans('messages.no')
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
                <label class="col-xs-4 control-label">{!! trans('messages.admin_points_equivalent') !!} <span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('point_equivalent',''
                        , array(
                            'placeHolder' => trans('messages.admin_points_equivalent')
                            , 'ng-model' => 'qa.answers.record.point_equivalent'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['point_equivalent_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-4">{!! trans('messages.admin_answer_image') !!}</label>

                <div class="col-xs-5">
                    <div class="btn btn-blue" ngf-select ngf-change="qa.uploadAnswer($files, qa.answers.record)"> {!! trans('messages.choose_image') !!}
                    </div>
                </div>

                <div class="margin-top-8" ng-if="qa.answers.record.uploaded">
                    <a href="" ng-click="qa.removeImage(qa.answers.record)"><i class="fa fa-trash"></i></a>
                </div>
            </div>

            <div class="form-group" ng-if="qa.answers.record.uploaded">
                <div class="col-xs-4"></div>
                <div class="col-xs-5">
                    <span class="col-xs-6 upload-label label label-info">{!! trans('messages.image_uploaded') !!}</span>
                    <a href="" class="control-label col-xs-6" ng-click="qa.viewAnswerImage(qa.answers.record)">{!! trans('messages.view_image') !!}</a>
                </div>
            </div>

            <div class="form-group"
                 ng-if="qa.active_view
                 && !qa.answers.record.uploaded
                 && qa.answers.record.original_image_name
                 && qa.answers.record.original_image_name != '0'">
                <div class="control-label col-xs-4"></div>
                <div class="col-xs-5">
                    <a href="" ng-click="qa.viewAnswerImage(qa.answers.record)">{!! trans('messages.view_image') !!}</a>
                </div>
            </div>

            <div class="form-group">
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_anslist">
                    {!! Form::button(trans('messages.add')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.addAnswer()'
                        )
                    ) !!}
                    {!! Form::button(trans('messages.clear')
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => 'qa.clearAnswer()'
                        )
                    ) !!}
                </div>
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_ansedit">
                    {!! Form::button(trans('messages.update')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.updateAnswer()'
                        )
                    ) !!}
                    {!! Form::button(trans('messages.cancel')
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
                {!! trans('messages.admin_answer_list') !!}
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
                    <th>{!! trans('messages.code') !!}</th>
                    <th>{!! trans('messages.admin_label') !!}</th>
                    <th>{!! trans('messages.answer') !!}</th>
                    <th>{!! trans('messages.admin_correct_answer') !!}</th>
                    <th>{!! trans('messages.admin_points_equivalent') !!}</th>
                    <th ng-if="qa.answers.records.length">{!! trans_choice('messages.action', 1) !!}</th>
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
                        {!! trans('messages.no_records_found') !!}
                    </td>
                </tr>
                <tr class="odd" ng-if="qa.table.loading">
                    <td valign="top" colspan="7">
                        {!! trans('messages.loading') !!}
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
</div>

<div ng-if="qa.record.question_type == futureed.GRAPH" ng-init="qa.setAnsActive()">
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
                <label class="col-xs-4 control-label">{!! trans('messages.admin_field') !!}<span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('code',''
                        , array(
                            'placeHolder' => trans('messages.admin_field_name')
                            , 'ng-model' => 'qa.answers.record.field'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['code_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">{!! trans('messages.admin_count') !!} <span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('answer_text',''
                        , array(
                            'placeHolder' => trans('messages.admin_count')
                            , 'ng-model' => 'qa.answers.record.count'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer_text_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="control-label col-xs-4">{!! trans('messages.admin_answer_image') !!} <span class="required">*</span></label>

                <div class="col-xs-5">
                    <div class="btn btn-blue" ngf-select ngf-change="qa.uploadGraphImage($files, qa.answers.record)"> {!! trans('messages.choose_image') !!}
                    </div>
                </div>

                <div class="margin-top-8" ng-if="qa.answers.record.uploaded">
                    <a href="" ng-click="qa.removeImage(qa.answers.record)"><i class="fa fa-trash"></i></a>
                </div>
            </div>

            <div class="form-group" ng-if="qa.answers.record.uploaded">
                <div class="col-xs-4"></div>
                <div class="col-xs-5">
                    <span class="col-xs-6 upload-label label label-info">{!! trans('messages.image_uploaded') !!}</span>
                    <a href="" class="control-label col-xs-6" ng-click="qa.viewAnswerImage(qa.answers.record)">{!! trans('messages.view_image') !!}</a>
                </div>
            </div>

            <div class="form-group"
                 ng-if="qa.active_view
                 && !qa.answers.record.uploaded
                 && qa.answers.record.original_image_name
                 && qa.answers.record.original_image_name != '0'">
                <div class="control-label col-xs-4"></div>
                <div class="col-xs-5">
                    <a href="" ng-click="qa.viewAnswerImage(qa.answers.record)">{!! trans('messages.view_image') !!}</a>
                </div>
            </div>

            <div class="form-group">
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_anslist">
                    {!! Form::button(trans('messages.add')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.addAnswer()'
                        )
                    ) !!}
                    {!! Form::button(trans('messages.clear')
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => 'qa.clearAnswer()'
                        )
                    ) !!}
                </div>
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_ansedit">
                    {!! Form::button(trans('messages.update')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.updateAnswer()'
                        )
                    ) !!}
                    {!! Form::button(trans('messages.cancel')
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
                {!! trans('messages.admin_answer_list') !!}
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
                    <th>{!! trans('messages.admin_field') !!}</th>
                    <th>{!! trans('messages.image') !!}</th>
                    <th>{!! trans('messages.admin_count') !!}</th>
                    <th ng-if="qa.answers.records.answer.length">{!! trans_choice('messages.action', 1) !!}</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="record in qa.answers.records.answer">
                    <td>{! record.field !}</td>
                    <td><a href="" ng-click="qa.viewAnswerImage(record.image)">{!! trans('messages.view_image') !!}</a></td>
                    <td>{! record.count !}</td>
                    <td ng-if="qa.answers.records.answer.length">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="" ng-click="qa.setAnsActive(futureed.ACTIVE_EDIT, $index)"><span><i
                                                class="fa fa-pencil"></i></span></a>
                            </div>
                            <div class="col-xs-6">
                                <a href="" ng-click="qa.confirmAnsDelete($index)"><span><i
                                                class="fa fa-trash"></i></span></a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="odd" ng-if="!qa.answers.records.answer.length && !qa.table.loading">
                    <td valign="top" colspan="7">
                        {!! trans('messages.no_records_found') !!}
                    </td>
                </tr>
                <tr class="odd" ng-if="qa.table.loading">
                    <td valign="top" colspan="7">
                        {!! trans('messages.loading') !!}
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="pull-right" ng-if="qa.answers.records.answer.length">
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
</div>

<div ng-if="qa.record.question_type == futureed.QUADRANT" ng-init="qa.setAnsActive()">
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
    <div class="col-xs-12 search-container" ng-if="qa.answers.graph_records.answer.length == 0 || qa.active_ansedit">
        {!! Form::open(array('class' => 'form-horizontal')) !!}
        <div class="form-search">
            <div class="form-group">
                <label class="col-xs-4 control-label">{!! trans('messages.admin_x_axis') !!}<span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('code',''
                        , array(
                            'placeHolder' => trans('messages.admin_coordinate')
                            , 'ng-model' => 'qa.answers.record.x'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['code_ans'] }"
                        )
                    ) !!}
                </div>
            </div>

            <div class="form-group">
                <label class="col-xs-4 control-label">{!! trans('messages.admin_y_axis') !!}<span class="required">*</span></label>

                <div class="col-xs-5">
                    {!! Form::text('answer_text',''
                        , array(
                            'placeHolder' => trans('messages.admin_coordinate')
                            , 'ng-model' => 'qa.answers.record.y'
                            , 'class' => 'form-control'
                            , 'ng-class' => "{ 'required-field' : qa.fields['answer_text_ans'] }"
                        )
                    ) !!}
                </div>
            </div>


            <div class="form-group"
                 ng-if="qa.active_view
                 && !qa.answers.record.uploaded
                 && qa.answers.record.original_image_name
                 && qa.answers.record.original_image_name != '0'">
                <div class="control-label col-xs-4"></div>
                <div class="col-xs-5">
                    <a href="" ng-click="qa.viewAnswerImage(qa.answers.record)">{!! trans('messages.view_image') !!}</a>
                </div>
            </div>


            <div class="form-group">
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_anslist && qa.answers.graph_records.answer.length == 0">
                    {!! Form::button(trans('messages.add')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.addAnswer()'
                        )
                    ) !!}
                    {!! Form::button(trans('messages.clear')
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                            , 'ng-click' => 'qa.clearAnswer()'
                        )
                    ) !!}
                </div>
                <div class="btn-container col-xs-10 col-xs-offset-1" ng-if="qa.active_ansedit && qa.answers.graph_records.answer.length != 0">
                    {!! Form::button(trans('messages.update')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.updateAnswer()'
                        )
                    ) !!}
                    {!! Form::button(trans('messages.cancel')
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
                {!! trans('messages.admin_answer_list') !!}
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
                    <th>{!! trans('messages.admin_x_coordinates') !!}</th>
                    <th>{!! trans('messages.admin_y_coordinates') !!}</th>
                    <th ng-if="qa.record.answer.length">{!! trans_choice('messages.action', 1) !!}</th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="record in qa.answers.graph_records.answer">
                    <td>{! record.x !}</td>
                    <td>{! record.y !}</td>
                    <td ng-if="qa.answers.graph_records.answer">
                        <div class="row">
                            <div class="col-xs-6">
                                <a href="" ng-click="qa.setAnsActive(futureed.ACTIVE_EDIT, $index)"><span><i
                                                class="fa fa-pencil"></i></span></a>
                            </div>
                            <div class="col-xs-6">
                                <a href="" ng-click="qa.confirmAnsDelete($index)"><span><i
                                                class="fa fa-trash"></i></span></a>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr class="odd" ng-if="!qa.answers.graph_records.answer.length && !qa.table.loading">
                    <td valign="top" colspan="7">
                        {!! trans('messages.no_records_found') !!}
                    </td>
                </tr>
                <tr class="odd" ng-if="qa.table.loading">
                    <td valign="top" colspan="7">
                        {!! trans('messages.loading') !!}
                    </td>
                </tr>
                </tbody>
            </table>

            <div class="pull-right" ng-if="qa.answers.records.answer.length">
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
</div>

<div id="delete_answer_modal" ng-show="qa.delete.ans_confirm" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {!! trans('messages.admin_delete_answer') !!}
            </div>
            <div class="modal-body">
                {!! trans('messages.admin_delete_answer_msg') !!}
            </div>
            <div class="modal-footer">
                <div class="btncon col-md-8 col-md-offset-4 pull-left">
                    {!! Form::button(trans('messages.yes')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'qa.deleteAnswer()'
                            , 'data-dismiss' => 'modal'
                        )
                    ) !!}

                    {!! Form::button(trans('messages.no')
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