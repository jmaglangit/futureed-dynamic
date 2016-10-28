<div>
    {{--drop down here--}}
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
    <svg class="chart-subject-area" width="450" height="300" ng-init="reports.getStudentChartSubjectArea()"></svg>
</div>