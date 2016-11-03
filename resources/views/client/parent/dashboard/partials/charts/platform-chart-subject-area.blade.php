<div class="thumbnail">
    <div><a href="javascript:void(0)" ng-click="reports.setActive(futureed.SUBJECT_AREA)">
            {!! trans('messages.graph_link_message') !!}
        </a></div>
    {{--drop down here--}}
    <div>
        <label class="col-xs-2">{!! trans('messages.subject') !!}</label>
        <div class="col-xs-4">
            <select ng-model="reports.subject_area_subject_id"
                    ng-change="reports.getStudentChartSubjectArea(reports.subject_area_subject_id,reports.subject_area_grade_id)"
                    ng-disabled="!reports.subjects.length"
                    class="form-control">
                <option value="">{!! trans('messages.select_subject') !!}</option>
                <option ng-selected="reports.search.subject_id == subject.id"
                        ng-repeat="subject in reports.subjects" ng-value="subject.id">{! subject.name !}
                </option>
            </select>
        </div>
        <label class="col-xs-2">{!! trans('messages.school_level') !!}</label>
        <div class="col-xs-4">
            <select ng-model="reports.subject_area_grade_id"
                    ng-change="reports.getStudentChartSubjectArea(reports.subject_area_subject_id,reports.subject_area_grade_id)"
                    class="form-control">
                <option value="">{!! trans('messages.select_level') !!}</option>
                <option ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
            </select>
        </div>
    </div>
    <svg class="chart-subject-area" width="350" height="300" ng-init="reports.getStudentChartSubjectArea()"></svg>
</div>