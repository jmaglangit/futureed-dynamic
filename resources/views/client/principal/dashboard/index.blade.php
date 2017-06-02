<div ng-if="user.role == futureed.PRINCIPAL" ng-controller="ManagePrincipalContentController as dashboard"
     ng-init="dashboard.setActive();" ng-cloak>


    <div ng-if="dashboard.active_purchase" class="dashboard-content" ng-cloak>

        <div class="col-xs-12 row">
            <div class="col-xs-8">
                <h5>
                    {{ trans('messages.principal_dashboard_message_1') }}
                </h5>
            </div>
            <div class="col-xs-4">
                <a class="dashboard-content-btn" href="{!! route('client.principal.teacher.index') !!}">
                    <button type="button">
                        {{ trans('messages.principal_dashboard_add_teacher') }}
                    </button>
                </a>
            </div>
        </div>

        <div class="col-xs-12 row">
            <div class="col-xs-8">
                <h5>{{ trans('messages.principal_dashboard_message_2') }}</h5>
            </div>
            <div class="col-xs-4">
                <a href="{!! route('client.principal.payment.index') !!}" class="dashboard-content-btn">
                    <button type="button">
                        {{ trans('messages.principal_dashboard_buy_seats') }}
                    </button>
                </a>
            </div>
        </div>

        <div class="clearfix"></div>

    </div>

    {{--Reports--}}
    <div ng-if="dashboard.active_report_teacher" ng-cloak>
        <div class="row client-export-button-container">
            <div ng-if="dashboard.export" class="col-xs-12">
                <div class="btn-group export-buttons pull-right">
                    <button class="btn btn-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" ng-disabled="!dashboard.validExportButton()">
                        <i class="fa fa-file-text-o"></i> {!! trans('messages.export') !!}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{! dashboard.schoolDownload !}" ng-click="dashboard.exportReport('pdf')">PDF</a>
                        </li>
                        <li><a href="{! dashboard.schoolDownload !}" ng-click="dashboard.exportReport('xls')">Excel</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="report-container">
            <ul class="nav nav-tabs report-nav" role="tablist">
                <li class="col-xs-2 active"><a ng-click="dashboard.setActive('school')" aria-controls="home" role="tab"
                                               data-toggle="tab"><i
                                class="fa fa-line-chart"></i> {!! trans('messages.overall_school_progress') !!}</a></li>
                <li class="col-xs-2"><a ng-click="dashboard.setActive('school_teacher')" aria-controls="home" role="tab"
                                        data-toggle="tab"><i
                                class="fa fa-tasks"></i> {!! trans('messages.teacher_comparison_progress') !!}</a></li>
                <li class="col-xs-2"><a ng-click="dashboard.setActive('school_teacher_progress')" aria-controls="home"
                                        role="tab"
                                        data-toggle="tab"><i
                                class="fa fa-tasks"></i> {!! trans('messages.teacher_subject_progress') !!}</a></li>
                <li class="col-xs-2"><a ng-click="dashboard.setActive('school_teacher_scores')" aria-controls="home"
                                        role="tab"
                                        data-toggle="tab"><i
                                class="fa fa-tasks"></i> {!! trans('messages.teacher_subject_scores') !!}</a></li>
                <li class="col-xs-2"><a ng-click="dashboard.setActive('school_student_progress')" aria-controls="home"
                                        role="tab"
                                        data-toggle="tab"><i
                                class="fa fa-tasks"></i> {!! trans('messages.student_subject_progress') !!}</a></li>
                <li class="col-xs-2"><a ng-click="dashboard.setActive('school_student_scores')" aria-controls="home"
                                        role="tab"
                                        data-toggle="tab"><i
                                class="fa fa-tasks"></i> {!! trans('messages.student_subject_scores') !!}</a></li>
            </ul>


            {{--School Reports--}}
            <div ng-if="dashboard.active_school">
                {{--Skills watch--}}
                <div>
                    <h3><i class="fa fa-th-list"></i> {! dashboard.report.column_header.skills_watch !}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">{!! trans('messages.subject') !!}</th>
                            <th class="col-xs-4">{!! trans_choice('messages.grade',0) !!}</th>
                            <th class="col-xs-4">{!! trans('messages.progress') !!}</th>
                        </tr>
                        <tr ng-if="dashboard.report_active_skill && dashboard.report.rows.skills_watch.highest_skill">
                            <td>{! dashboard.report.rows.skills_watch.highest_skill.subject_name !}</td>
                            <td>{! dashboard.report.rows.skills_watch.highest_skill.grade_name !}</td>
                            <td>{! dashboard.report.rows.skills_watch.highest_skill.percent_progress !}%</td>
                        </tr>
                        <tr ng-if="dashboard.report_active_skill && dashboard.report.rows.skills_watch.lowest_skill">
                            <td>{! dashboard.report.rows.skills_watch.lowest_skill.subject_name !}</td>
                            <td>{! dashboard.report.rows.skills_watch.lowest_skill.grade_name !}</td>
                            <td>{! dashboard.report.rows.skills_watch.lowest_skill.percent_progress !}%</td>
                        </tr>
                        <tr ng-if="!dashboard.report_active_skill">
                            <td colspan="2"><p>{!! trans('messages.no_records_found') !!}</p></td>
                        </tr>

                    </table>

                </div>
                {{--Class watch--}}
                <div>
                    <h3><i class="fa fa-area-chart"></i> {! dashboard.report.column_header.class_watch !}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">{!! trans('messages.teacher') !!}</th>
                            <th class="col-xs-3">{!! trans('messages.progress') !!}</th>
                        </tr>
                        <tr ng-if="dashboard.report_active_class &&  dashboard.report.rows.class_watch.highest_class">
                            <td>Teacher {! dashboard.report.rows.class_watch.highest_class.first_name
                                + ' ' + dashboard.report.rows.class_watch.highest_class.last_name !}
                            </td>
                            <td>{! dashboard.report.rows.class_watch.highest_class.percent_progress !}%</td>
                        </tr>
                        <tr ng-if="dashboard.report_active_class && dashboard.report.rows.class_watch.lowest_class">
                            <td>Teacher {! dashboard.report.rows.class_watch.lowest_class.first_name
                                + ' ' + dashboard.report.rows.class_watch.lowest_class.last_name !}
                            </td>
                            <td>{! dashboard.report.rows.class_watch.lowest_class.percent_progress !}%</td>
                        </tr>
                        <tr ng-if="!dashboard.report_active_class">
                            <td colspan="2"><p>{!! trans('messages.no_records_found') !!}</p></td>
                        </tr>
                    </table>
                </div>
                {{--Student watch--}}
                <div>
                    <h3><i class="fa fa-users"></i> {! dashboard.report.column_header.student_watch !}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">{!! trans('messages.student') !!}</th>
                            <th class="col-xs-3">{!! trans('messages.status') !!}</th>
                        </tr>
                        <tr ng-if="dashboard.report_active_student"
                            ng-repeat="student in dashboard.report.rows.student_watch">
                            <td>{! student.first_name +' '+ student.last_name !}</td>
                            <td>{! student.progress !}</td>
                        </tr>
                        <tr ng-if="!dashboard.report_active_student">
                            <td colspan="2"><p>{!! trans('messages.no_records_found') !!}</p></td>
                        </tr>
                    </table>
                </div>
                {{--Highest Lowest Scorers--}}
                <div>
                    <h3><i class="fa fa-bar-chart"></i>{!! trans('messages.scores') !!}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="report-empty-column"></th>
                            <th>{!! trans('messages.student') !!}</th>
                            <th>{!! trans('messages.teacher') !!}</th>
                        </tr>
                        <tr class="magenta-row">
                            <th>{!! trans('messages.highest_score') !!}</th>
                            <td>{! dashboard.report.rows.highest_score.student_first_name +' '+
                                dashboard.report.rows.highest_score.student_last_name !}
                            </td>
                            <td>{! dashboard.report.rows.highest_score.teacher_first_name +' '+
                                dashboard.report.rows.highest_score.teacher_last_name !}
                            </td>
                        </tr>
                        <tr class="magenta-row">
                            <th>{!! trans('messages.lowest_score') !!}</th>
                            <td>{! dashboard.report.rows.lowest_score.student_first_name +' '+
                                dashboard.report.rows.lowest_score.student_last_name !}
                            </td>
                            <td>{! dashboard.report.rows.lowest_score.teacher_first_name +' '+
                                dashboard.report.rows.lowest_score.teacher_last_name !}
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            {{--School Teacher Reports--}}
            <div ng-if="dashboard.active_school_teacher">

                <div>
                    <h3><i class="fa fa-file-text"></i> {!! trans('messages.class_progress_report') !!}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">{! dashboard.teacher_report.column_header.teacher_list !}</th>
                            <th class="col-xs-3">{! dashboard.teacher_report.column_header.progress !}</th>
                        </tr>
                        <tr ng-if="dashboard.teacher_report.rows" ng-repeat=" teacher in dashboard.teacher_report.rows">
                            <td>Teacher {! teacher.first_name +' '+ teacher.last_name !}</td>
                            <td>
                                <div class="progress-bar progress-bar-striped"
                                     ng-class="{
										'progress-bar-success' : teacher.percent_progress > futureed.REPORT_PROGRESS_PASS,
										'progress-bar-warning' : teacher.percent_progress > futureed.REPORT_PROGRESS_MEDIAN_FLOOR
										    && teacher.percent_progress <= futureed.REPORT_PROGRESS_MEDIAN_CEILING ,
										'progress-bar-danger' : teacher.percent_progress <= futureed.REPORT_PROGRESS_FAIL ,
									}"
                                     ng-style="{ 'width' : teacher.percent_progress + '%' }">{! teacher.percent_progress
                                    +'%' !}
                                </div>
                            </td>
                        </tr>
                        <tr ng-if="!dashboard.teacher_report.rows">
                            <td colspan="2"><p>{!! trans('messages.no_records_found') !!}</p></td>
                        </tr>
                    </table>
                </div>
            </div>

            {{--School Teacher Subject Progress--}}
            <div class="" ng-if="dashboard.active_school_teacher_progress">
                <div>
                    <div class="report-selector-container">
                        <div class="form-group">
                            <div class="col-xs-3"></div>
                            <div class="col-xs-6">
                                <select ng-model="dashboard.selected.teacher_progress.grade_id"
                                        ng-options="grade.id as grade.name for grade in dashboard.grades.records"
                                        ng-change="dashboard.teacherSubjectProgressReport()"
                                        class="form-control ng-pristine ng-valid ng-touched">
                                    <option value="">
                                        {!! trans('messages.select_grade') !!}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="report-teacher-title">
                        <h3><i class="fa fa-file-text"></i> {!! trans('messages.teacher_subject_progress_report') !!}
                        </h3>
                    </div>

                    <div>
                        <table class="table table-bordered"
                               width="100%">
                            <tr class="magenta">
                                <th width="20%"></th>
                                <th ng-repeat="header in dashboard.teacher_subject_progress_report.column_header">
                                    {! header !}
                                </th>
                            </tr>
                            <tr ng-if="dashboard.teacher_subject_progress_report.rows"
                                ng-repeat="(name, row) in dashboard.teacher_subject_progress_report.rows">
                                <td width="20%">
                                    Teacher {! name !}
                                </td>
                                <td ng-repeat="progress in row" width="{! dashboard.subjectColumnWidth(80) !}%">
                                    <div class="progress-bar progress-bar-striped"
                                         ng-class="{
										'progress-bar-success' : progress > futureed.REPORT_PROGRESS_PASS,
										'progress-bar-warning' : progress > futureed.REPORT_PROGRESS_MEDIAN_FLOOR
										    && progress <= futureed.REPORT_PROGRESS_MEDIAN_CEILING ,
										'progress-bar-danger' : progress <= futureed.REPORT_PROGRESS_FAIL ,
									}"
                                         ng-style="{ 'width' : progress + '%' }">
                                        {! progress + '%' !}
                                    </div>
                                </td>
                            </tr>
                            <tr ng-if="!dashboard.teacher_subject_progress_report.rows">
                                <td colspan="2"><p>{!! trans('messages.no_records_found') !!}</p></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{--School Teacher Subject Scores--}}
            <div class="" ng-if="dashboard.active_school_teacher_scores">
                <div>
                    <div class="report-selector-container">
                        <div class="form-group">
                            <div class="col-xs-3"></div>
                            <div class="col-xs-6">
                                <select ng-model="dashboard.selected.teacher_scores.grade_id"
                                        ng-options="grade.id as grade.name for grade in dashboard.grades.records"
                                        ng-change="dashboard.teacherSubjectScoresReport()"
                                        class="form-control ng-pristine ng-valid ng-touched">
                                    <option value="">
                                        {!! trans('messages.select_grade') !!}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="report-teacher-title">
                        <h3><i class="fa fa-file-text"></i> {!! trans('messages.teacher_subject_scores_report') !!}</h3>
                    </div>
                    <div>
                        <table class="table table-bordered"
                               width="100%">
                            <tr class="magenta">
                                <th width="20%"></th>
                                <th ng-repeat="header in dashboard.teacher_subject_scores_report.column_header">
                                    {! header !}
                                </th>
                            </tr>
                            <tr ng-if="dashboard.teacher_subject_scores_report.rows"
                                ng-repeat="(name, row) in dashboard.teacher_subject_scores_report.rows">
                                <td width="20%">
                                    Teacher {! name !}
                                </td>
                                <td ng-repeat="scores in row" width="{! dashboard.subjectColumnWidth(80) !}%">
                                    <div class="progress-bar progress-bar-striped"
                                         ng-class="{
										'progress-bar-success' : scores > futureed.REPORT_PROGRESS_PASS,
										'progress-bar-warning' : scores > futureed.REPORT_PROGRESS_MEDIAN_FLOOR
										    && scores <= futureed.REPORT_PROGRESS_MEDIAN_CEILING ,
										'progress-bar-danger' : scores <= futureed.REPORT_PROGRESS_FAIL ,
									}"
                                         ng-style="{ 'width' : scores + '%' }">
                                        {! scores + '%' !}
                                    </div>
                                </td>
                            </tr>
                            <tr ng-if="!dashboard.teacher_subject_scores_report.rows">
                                <td colspan="2"><p>{!! trans('messages.no_records_found') !!}</p></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{--School Student Subject Progress--}}
            <div class="" ng-if="dashboard.active_school_student_progress">
                <div>

                    <div class="report-selector-container">
                        <div class="form-group">
                            <table margin="20px" style="margin: 0px auto;">
                                <tr>
                                    <th class="report-student-selectors">
                                        <select ng-model="dashboard.selected.student_progress.subject_id"
                                                ng-options="subject.id as subject.name for subject in dashboard.subjects.records"
                                                ng-change="dashboard.studentSubjectProgressReport()"
                                                class="form-control ng-pristine ng-valid ng-touched">
                                            <option value="">
                                                {!! trans('messages.select_subject') !!}
                                            </option>
                                        </select>
                                    </th>
                                    <th class="report-student-selectors">
                                        <select ng-model="dashboard.selected.student_progress.grade_id"
                                                ng-options="grade.id as grade.name for grade in dashboard.grades.records"
                                                ng-change="dashboard.studentSubjectProgressReport()"
                                                class="form-control ng-pristine ng-valid ng-touched">
                                            <option value="">
                                                {!! trans('messages.select_grade') !!}
                                            </option>
                                        </select>
                                    </th>
                                    <th class="report-student-selectors">
                                        <select ng-model="dashboard.selected.student_progress.teacher_id"
                                                ng-options="teacher.id as dashboard.teacherName(teacher)
                                                for teacher in dashboard.teachers.records"
                                                ng-change="dashboard.studentSubjectProgressReport()"
                                                class="form-control ng-pristine ng-valid ng-touched">
                                            <option value="">
                                                {!! trans('messages.select_teacher') !!}
                                            </option>
                                        </select>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div>
                        <h3><i class="fa fa-file-text"></i> {!! trans('messages.student_subject_progress_report') !!}
                        </h3>
                    </div>

                    <div>
                        <table class="table table-bordered"
                               width="100%">
                            <tr class="magenta">
                                <th width="20%"></th>
                                <th ng-repeat="header in
                                    dashboard.student_subject_progress_report.column_header[
                                    dashboard.current_page.student_progress]"
                                    width="{! dashboard.subjectAreaColumnWidth('progress', 80) !}%">
                                    {! header !}
                                </th>
                            </tr>
                            <tr ng-if="dashboard.student_subject_progress_report.rows"
                                ng-repeat="(name, row) in
                                    dashboard.student_subject_progress_report.rows">
                                <td width="20%">
                                    Student {! name !}
                                </td>
                                <td ng-repeat="progress in row[dashboard.current_page.student_progress]">
                                    <div class="progress-bar progress-bar-striped"
                                         ng-class="{
										'progress-bar-success' : progress > futureed.REPORT_PROGRESS_PASS,
										'progress-bar-warning' : progress > futureed.REPORT_PROGRESS_MEDIAN_FLOOR
										    && progress <= futureed.REPORT_PROGRESS_MEDIAN_CEILING ,
										'progress-bar-danger' : progress <= futureed.REPORT_PROGRESS_FAIL ,
									}"
                                         ng-style="{ 'width' : progress + '%' }">
                                        {! progress + '%' !}
                                    </div>
                                </td>
                            </tr>
                            <tr ng-if="!dashboard.student_subject_progress_report.rows">
                                <td colspan="2"><p>{!! trans('messages.no_records_found') !!}</p></td>
                            </tr>
                        </table>
                    </div>

                    <div class="pull-right" ng-if="dashboard.student_subject_progress_report.rows">
                        <pagination
                                ng-model="dashboard.current_page.student_progress"
                                total-items="dashboard.number_of_pages.student_progress"
                                items-per-page="1"
                                previous-text="&lt;"
                                next-text="&gt;"
                                class="pagination">
                        </pagination>
                    </div>
                </div>
            </div>

            {{--School Student Subject Scores--}}
            <div class="" ng-if="dashboard.active_school_student_scores">
                <div>

                    <div class="report-selector-container">
                        <div class="form-group">
                            <table margin="20px" style="margin: 0px auto;">
                                <tr>
                                    <th class="report-student-selectors">
                                        <select ng-model="dashboard.selected.student_scores.subject_id"
                                                ng-options="subject.id as subject.name for subject in dashboard.subjects.records"
                                                ng-change="dashboard.studentSubjectScoresReport()"
                                                class="form-control ng-pristine ng-valid ng-touched">
                                            <option value="">
                                                {!! trans('messages.select_subject') !!}
                                            </option>
                                        </select>
                                    </th>
                                    <th class="report-student-selectors">
                                        <select ng-model="dashboard.selected.student_scores.grade_id"
                                                ng-options="grade.id as grade.name for grade in dashboard.grades.records"
                                                ng-change="dashboard.studentSubjectScoresReport()"
                                                class="form-control ng-pristine ng-valid ng-touched">
                                            <option value="">
                                                {!! trans('messages.select_grade') !!}
                                            </option>
                                        </select>
                                    </th>
                                    <th class="report-student-selectors">
                                        <select ng-model="dashboard.selected.student_scores.teacher_id"
                                                ng-options="teacher.id as dashboard.teacherName(teacher)
                                                for teacher in dashboard.teachers.records"
                                                ng-change="dashboard.studentSubjectScoresReport()"
                                                class="form-control ng-pristine ng-valid ng-touched">
                                            <option value="">
                                                {!! trans('messages.select_teacher') !!}
                                            </option>
                                        </select>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>

                    <div>
                        <h3><i class="fa fa-file-text"></i> {!! trans('messages.student_subject_scores_report') !!}
                        </h3>
                    </div>

                    <div>
                        <table class="table table-bordered"
                               width="100%">
                            <tr class="magenta">
                                <th width="20%"></th>
                                <th ng-repeat="header in
                                    dashboard.student_subject_scores_report.column_header[
                                    dashboard.current_page.student_scores]"
                                    width="{! dashboard.subjectAreaColumnWidth('scores', 80) !}%">
                                    {! header !}
                                </th>
                            </tr>
                            <tr ng-if="dashboard.student_subject_scores_report.rows"
                                ng-repeat="(name, row) in
                                    dashboard.student_subject_scores_report.rows">
                                <td width="20%">
                                    Student {! name !}
                                </td>
                                <td ng-repeat="score in row[dashboard.current_page.student_scores]">
                                    <div class="progress-bar progress-bar-striped"
                                         ng-class="{
										'progress-bar-success' : score > futureed.REPORT_PROGRESS_PASS,
										'progress-bar-warning' : score > futureed.REPORT_PROGRESS_MEDIAN_FLOOR
										    && score <= futureed.REPORT_PROGRESS_MEDIAN_CEILING ,
										'progress-bar-danger' : score <= futureed.REPORT_PROGRESS_FAIL ,
									}"
                                         ng-style="{ 'width' : score + '%' }">
                                        {! score + '%' !}
                                    </div>
                                </td>
                            </tr>
                            <tr ng-if="!dashboard.student_subject_scores_report.rows">
                                <td colspan="2"><p>{!! trans('messages.no_records_found') !!}</p></td>
                            </tr>
                        </table>
                    </div>

                    <div class="pull-right" ng-if="dashboard.student_subject_scores_report.rows">
                        <pagination
                                ng-model="dashboard.current_page.student_scores"
                                total-items="dashboard.number_of_pages.student_scores"
                                items-per-page="1"
                                previous-text="&lt;"
                                next-text="&gt;"
                                class="pagination">
                        </pagination>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
