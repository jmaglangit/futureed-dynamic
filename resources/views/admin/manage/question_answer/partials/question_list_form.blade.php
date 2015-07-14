<div ng-if="qa.active_list">
<div class="col-xs-12" ng-if="qa.errors || qa.success">
        <div class="alert alert-error" ng-if="qa.errors">
            <p ng-repeat="error in qa.errors track by $index">
                {! error !}
            </p>
        </div>

        <div class="alert alert-success" ng-if="qa.success">
            <p>{! qa.success !}</p>
        </div>
    </div>
<div class="col-xs-12">
        <div class="title-mid">
            Search
        </div>

        <div class="form-search">
            {!! Form::open(
                    [
                        'id' => 'search_form',
                        'class' => 'form-horizontal'
                        , 'ng-submit' => 'qa.searchFnc($event)'
                    ]
            ) !!}
                <div class="form-group">
                    <label class="control-label col-xs-3">Question Type</label>
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
                                , 'ng-model' => 'qa.search.question_type'
                            )
                        ) !!}
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-xs-3">Question Text</label>
                    <div class="col-xs-5">
                        {!! Form::text('questions_text', ''
                            , array(
                                'class' => 'form-control'
                                , 'ng-model' => 'qa.search.questions_text'
                                , 'placeholder' => 'Question Text'
                            )
                        ) !!}
                    </div>
                    <div class="col-xs-2">
                        {!! Form::button('Search'
                            ,array(
                                'class' => 'btn btn-blue'
                                , 'ng-click' => 'qa.searchFnc($event)'
                            )
                        )!!}
                    </div>
                    <div class="col-xs-2">
                        {!! Form::button('Clear'
                            ,array(
                                'class' => 'btn btn-gold'
                                , 'ng-click' => 'qa.clearFnc($event)'
                            )
                        )!!}
                    </div>
                </div>
            {!! Form::close() !!}
        </div>
    </div>

<div class="col-xs-12">
    <button class="btn btn-blue btn-small content-btn" ng-click="qa.setActive('add')">
        <i class="fa fa-plus-square"></i> Add Q & A
    </button>

    <div class="title-mid">
        Question & Answer List
    </div>

    <div class="list-container">
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
                    , 'ng-if' => "qa.qa_records.length"
                    , 'class' => 'form-control paginate-size pull-right'
                )
            ) !!}
        </div>

        <div class="clearfix"></div>
        <div class="table-responsive" ng-cloak>
            <table id="qa-list" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>Code</th>
                        <th>Question Text</th>
                        <th>Question Image</th>
                        <th>Question Type</th>
                        <th>Difficulty</th>
                        <th>Sequence No</th>
                        <th>Points Earned</th>
                        <th ng-if="qa.qa_records.length">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr ng-repeat="qaInfo in qa.qa_records">
                        <td>{! qaInfo.code !}</td>
                        <td>{! qaInfo.questions_text !}</td>
                        <td><img src=""></td>
                        <td>{! qaInfo.question_type !}</td>
                        <td>{! qaInfo.difficulty !}</td>
                        <td>{! qaInfo.seq_no !}</td>
                        <td>{! qaInfo.points_earned !}</td>
                        <td ng-if="qa.qa_records.length">
                            <div class="row">
                                <div class="col-xs-4">
                                    <a href="" ng-click="qa.setActive(futureed.ACTIVE_VIEW, qaInfo.id)"><span><i class="fa fa-eye"></i></span></a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="" ng-click="qa.setActive(futureed.ACTIVE_EDIT, qaInfo.id)"><span><i class="fa fa-pencil"></i></span></a>
                                </div>
                                <div class="col-xs-4">
                                    <a href="" ng-click="qa.confirmDelete(qaInfo.id)"><span><i class="fa fa-trash"></i></span></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <tr class="odd" ng-if="!qa.qa_records.length">
                        <td valign="top" colspan="7">
                            No records found
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="pull-right" ng-if="qa.qa_records.length">
                <pagination 
                    total-items="qa.table.total_items" 
                    ng-model="qa.table.pqa"
                    max-size="3"
                    items-per-pqa="qa.table.size" 
                    previous-text = "&lt;"
                    next-text="&gt;"
                    class="pagination" 
                    boundary-links="true"
                    ng-change="qa.paginateByPqa()">
                </pagination>
            </div>
        </div>
    </div>
</div>

<div id="delete_question_modal" ng-show="qa.delete.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            Delete Question
        </div>
        <div class="modal-body">
            Are you sure you want to delete this Question?
        </div>
        <div class="modal-footer">
            <div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('Yes'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => 'qa.deleteQuestion()'
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