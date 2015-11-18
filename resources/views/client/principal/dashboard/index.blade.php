<div ng-if="user.role == futureed.PRINCIPAL" ng-controller="ManagePrincipalContentController as dashboard"
     ng-init="dashboard.setActive();" ng-cloak>


    <div ng-if="!dashboard.active_report" class="dashboard-content" ng-cloak>

        <p>To get started on using Future Lesson, you need to invite a
            <a href="{!! route('client.principal.teacher.index') !!}"> teacher</a> first to manage your classes.</p>

        <p>If you have already invited a Teacher, you need to go to the
            <a href="{!! route('client.principal.payment.index') !!}"> payment</a> to buy seats for your classes.</p>
    </div>

    {{--Reports--}}
    <div ng-if="dashboard.active_report" ng-cloak>
        <div class="report-options">
            <ul class="pull-right">
                <li>
                    <button class="btn btn-blue"><i class="fa fa-save"></i> Save</button>
                </li>
                <li>
                    <button class="btn btn-blue"><i class="fa fa-file-pdf-o"></i> Export</button>
                </li>
                <li>
                    <button class="btn btn-blue"><i class="fa fa-print"></i> Print</button>
                </li>
                <li>
                    <button class="btn btn-blue"><i class="fa fa-envelope-o"></i> Email</button>
                </li>
            </ul>
        </div>

        <div class="report-container">
            <ul class="nav nav-tabs report-nav" role="tablist">
                <li class="col-xs-6 active"><a ng-click="dashboard.setActive('school')" aria-controls="home" role="tab" data-toggle="tab"><i
                                class="fa fa-line-chart"></i> Overall School Progress</a></li>
                <li class="col-xs-6"><a ng-click="dashboard.setActive('school_teacher')" aria-controls="home" role="tab" data-toggle="tab"><i
                                class="fa fa-tasks"></i> Teacher Comparison Progress</a></li>
            </ul>


           {{--School Reports--}}
            <div ng-if="dashboard.active_school" >
                {{--Skills watch--}}
                <div>
                    <h3><i class="fa fa-th-list"></i> {! dashboard.report.column_header.skills_watch !}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">Subject</th>
                            <th class="col-xs-3">Progress</th>
                        </tr>
                        <tr ng-if="dashboard.report_active_skill && dashboard.report.rows.skills_watch.highest_skill">
                            <td>{! dashboard.report.rows.skills_watch.highest_skill.subject_name !}</td>
                            <td>{! dashboard.report.rows.skills_watch.highest_skill.percent_progress !}%
                            </td>
                        </tr>
                        <tr ng-if="dashboard.report_active_skill && dashboard.report.rows.skills_watch.lowest_skill">
                            <td>{! dashboard.report.rows.skills_watch.lowest_skill.subject_name !}</td>
                            <td>{! dashboard.report.rows.skills_watch.lowest_skill.percent_progress !}%
                            </td>
                        </tr>
                        <tr ng-if="!dashboard.report_active_skill">
                            <td colspan="2"><p>No result...</p></td>
                        </tr>

                    </table>

                </div>
                {{--Class watch--}}
                <div>
                    <h3><i class="fa fa-area-chart"></i> {! dashboard.report.column_header.class_watch !}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">Teacher</th>
                            <th class="col-xs-3">Progress</th>
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
                            <td colspan="2"><p>No result...</p></td>
                        </tr>
                    </table>
                </div>
                {{--Student watch--}}
                <div>
                    <h3><i class="fa fa-users"></i> {! dashboard.report.column_header.student_watch !}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">Student</th>
                            <th class="col-xs-3">Status</th>
                        </tr>
                        <tr ng-if="dashboard.report_active_student"
                            ng-repeat="student in dashboard.report.rows.student_watch">
                            <td>{! student.first_name +' '+ student.last_name !}</td>
                            <td>{! student.progress !}</td>
                        </tr>
                        <tr ng-if="!dashboard.report_active_student">
                            <td colspan="2"><p>No result...</p></td>
                        </tr>
                    </table>
                </div>
                {{--Highest Lowest Scorers--}}
                <div>
                    <h3><i class="fa fa-bar-chart"></i>Scores</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="report-empty-column"></th>
                            <th>Student</th>
                            <th>Teacher</th>
                        </tr>
                        <tr class="magenta-row">
                            <th>Highest Score</th>
                            <td>{! dashboard.report.rows.highest_score.student_first_name +' '+
                                dashboard.report.rows.highest_score.student_first_name !}
                            </td>
                            <td>{! dashboard.report.rows.highest_score.teacher_first_name +' '+
                                dashboard.report.rows.highest_score.teacher_first_name !}
                            </td>
                        </tr>
                        <tr class="magenta-row">
                            <th>Lowest Score</th>
                            <td>{! dashboard.report.rows.lowest_score.student_first_name +' '+
                                dashboard.report.rows.lowest_score.student_first_name !}
                            </td>
                            <td>{! dashboard.report.rows.lowest_score.teacher_first_name +' '+
                                dashboard.report.rows.lowest_score.teacher_first_name !}
                            </td>
                        </tr>
                    </table>

                </div>
            </div>
            {{--School Teacher Reports--}}
            <div ng-if="dashboard.active_school_teacher">

                <div>
                    <h3><i class="fa fa-file-text"></i> Class Progress Report</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">{! dashboard.teacher_report.column_header.teacher_list !}</th>
                            <th class="col-xs-3">{! dashboard.teacher_report.column_header.progress !}</th>
                        </tr>
                        <tr ng-if="dashboard.teacher_report.rows" ng-repeat=" teacher in dashboard.teacher_report.rows">
                            <td>Teacher {! teacher.first_name +' '+ teacher.last_name !}</td>
                            <td class="report-progress"><div class="report-progress-bar report-progress-bar-success"
                                ng-style="{ 'width' : teacher.percent_progress + '%' }">{! teacher.percent_progress +'%' !}</div></td>

                        </tr>
                        <tr ng-if="!dashboard.teacher_report.rows">
                            <td colspan="2"><p>No result...</p></td>
                        </tr>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>
