<div class="question-analysis" ng-if="reports.active_question_analysis">
    <div class="form-search magenta">
        {!! Form::open(
				[
					'id' => 'search_form',
					'class' => 'form-horizontal'
					, 'ng-submit' => 'reports.searchFnc($event)'
				]
		) !!}
        <div class="form-group">
                <label class="col-xs-2 question-analysis-filter">{!! trans('messages.subject') !!}</label>
                <div class="col-xs-2">
                    <select ng-model="reports.search.subject_id"
                            ng-change="reports.getModuleList()"
                            ng-disabled="!reports.subjects.length"
                            class="form-control">
                        <option value="">{!! trans('messages.select_subject') !!}</option>
                        <option ng-selected="reports.search.subject_id == subject.id"
                                ng-repeat="subject in reports.subjects" ng-value="subject.id">{! subject.name !}
                        </option>
                    </select>
                </div>
            <label class="col-xs-2 question-analysis-filter">{!! trans('messages.school_level') !!}</label>
            <div class="col-xs-2">
                <select ng-model="reports.search.grade_id"
                        ng-change="reports.getModuleList()"
                        class="form-control">
                    <option value="">{!! trans('messages.select_level') !!}</option>
                    <option ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
                </select>
            </div>
            <label class="col-xs-2 question-analysis-filter">{!! trans_choice('messages.module',1) !!}</label>
            <div class="col-xs-2">
                <select ng-model="reports.search.module_id"
                        ng-change="reports.getQuestionAnalysis()"
                        class="form-control">
                    <option value="">{!! trans('messages.select_module') !!}</option>
                    <option ng-repeat="module in module_countries" ng-value="module.module.id">{! module.module.name !}</option>
                </select>
            </div>
        </div>
        {!! Form::close() !!}
    </div>

    <div class="list-container table-responsive question-analysis-table" ng-cloak>
        <table id="tip-list" class="table table-striped">
            <thead>
            <tr>
                <th>{!! trans('messages.question') !!}</th>
                <th>{!! trans('messages.answer') !!}</th>
                <th><img src="/images/icon-tipbulb.png" alt="Tip Bulb" height="25" width="25"/> {!! trans('messages.tips') !!}</th>
            </tr>
            </thead>
            <tbody>
                <tr ng-repeat="question in reports.question_analysis">
                    <td class="col-md-4  text-left question-analysis-text">
                        {! question.questions_text !}
                    </td>
                    <td class="col-md-3 text-center">
                        {! question.answer_status !}
                    </td>
                    <td class="col-md-3 text-left" ng-bind-html="question.answer_explanation | trustAsHtml"></td>
                </tr>
            </tbody>

        </table>
    </div>


</div>