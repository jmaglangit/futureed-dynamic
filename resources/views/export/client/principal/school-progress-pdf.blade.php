@extends('export.client.principal.index')

@section('content')
    <table>
        <tr>
            <td><img src="{{ base_path().'/public/images/logo-md.png' }}"></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td>{{ $additional_information['principal_name'] }}</td>
        </tr>
        <tr>
            <td>{{ $additional_information['school_name'] }}</td>
        </tr>
        <tr>
            <td>{{ $additional_information['school_address'] }}</td>
        </tr>
        <tr></tr>
    </table>
    <div>&nbsp;</div>
    <div><h3>Overall School Progress</h3></div>
    <div>
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


    </table>
@stop