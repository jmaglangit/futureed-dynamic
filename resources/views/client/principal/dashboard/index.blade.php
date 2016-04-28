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
                    <button  type="button">
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
                    <button class="btn btn-blue" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-file-text-o"></i> {!! trans('messages.export') !!}
                    </button>
                    <ul class="dropdown-menu">
                        <li><a href="{! dashboard.schoolDownload !}" ng-click="dashboard.exportReport('pdf')">PDF</a></li>
                        <li><a href="{! dashboard.schoolDownload !}" ng-click="dashboard.exportReport('xls')">Excel</a></li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="report-container">
            <ul class="nav nav-tabs report-nav" role="tablist">
                <li class="col-xs-6 active"><a ng-click="dashboard.setActive('school')" aria-controls="home" role="tab"
                                               data-toggle="tab"><i
                                class="fa fa-line-chart"></i> {!! trans('messages.overall_school_progress') !!}</a></li>
                <li class="col-xs-6"><a ng-click="dashboard.setActive('school_teacher')" aria-controls="home" role="tab"
                                        data-toggle="tab"><i
                                class="fa fa-tasks"></i> {!! trans('messages.teacher_comparison_progress') !!}</a></li>
            </ul>


            {{--School Reports--}}
            <div ng-if="dashboard.active_school">
                {{--Skills watch--}}
                <div>
                    <h3><i class="fa fa-th-list"></i> {! dashboard.report.column_header.skills_watch !}</h3>
                    <table class="table table-bordered">
                        <tr class="magenta">
                            <th class="col-xs-4">{!! trans('messages.subject') !!}</th>
                            <th class="col-xs-3">{!! trans('messages.progress') !!}</th>
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
                                dashboard.report.rows.highest_score.student_first_name !}
                            </td>
                            <td>{! dashboard.report.rows.highest_score.teacher_first_name +' '+
                                dashboard.report.rows.highest_score.teacher_first_name !}
                            </td>
                        </tr>
                        <tr class="magenta-row">
                            <th>{!! trans('messages.lowest_score') !!}</th>
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
        </div>
    </div>
</div>
