@extends('export.client.principal.index')

@section('content')
    <table>
        <tr>
            <td style="text-align: left"><img src="{{ base_path().'/public/images/logo-md.png' }}"></td>
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
    <div style="text-align: center"><h3>Overall School Progress</h3></div>
    <div>
        {{--Skills watch--}}
        <div>
            <h3><i class="fa fa-th-list">&#xf00b;</i>{{ $column_header['skills_watch'] }}</h3>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="col-xs-4">Subject</th>
                    <th class="col-xs-3">Progress</th>
                </tr>
                @if(!is_null($rows['skills_watch']['highest_skill']))
                <tr>
                    <td>{{ $rows['skills_watch']['highest_skill']['subject_name'] }}</td>
                    <td>{{ $rows['skills_watch']['highest_skill']['percent_progress'] }}%</td>
                </tr>
                @endif
                @if(!is_null($rows['skills_watch']['lowest_skill']))
                <tr>
                    <td>{{ $rows['skills_watch']['lowest_skill']['subject_name'] }}</td>
                    <td>{{ $rows['skills_watch']['lowest_skill']['percent_progress'] }}%</td>
                </tr>
                @endif
                @if(is_null($rows['skills_watch']['highest_skill']) && is_null($rows['skills_watch']['lowest_skill']))
                <tr>
                    <td colspan="2"><p>No result...</p></td>
                </tr>
                @endif
            </table>

        </div>
        {{--Class watch--}}
        <div>
            <h3><i class="fa fa-area-chart"></i>{{ $column_header['class_watch'] }}</h3>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="col-xs-4">Teacher</th>
                    <th class="col-xs-3">Progress</th>
                </tr>
                @if(!is_null($rows['class_watch']['highest_class']))
                <tr>
                    <td>Teacher {{ $rows['class_watch']['highest_class']['first_name']
                    .' '.$rows['class_watch']['highest_class']['last_name'] }}
                    </td>
                    <td>{{ $rows['class_watch']['highest_class']['percent_progress'] }} %</td>
                </tr>
                @endif
                @if(!is_null($rows['class_watch']['lowest_class']))
                <tr>
                    <td>Teacher {{ $rows['class_watch']['lowest_class']['first_name']
                     .' '. $rows['class_watch']['lowest_class']['last_name']}}
                    </td>
                    <td>{{ $rows['class_watch']['lowest_class']['percent_progress'] }}%</td>
                </tr>
                @endif
                @if(is_null($rows['class_watch']['highest_class']) && is_null($rows['class_watch']['lowest_class']))
                    <tr>
                        <td colspan="2"><p>No result...</p></td>
                    </tr>
                @endif

            </table>
        </div>
        {{--Student watch--}}
        <div>
            <h3><i class="fa fa-users"></i>{{ $column_header['student_watch'] }}</h3>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="col-xs-4">Student</th>
                    <th class="col-xs-3">Status</th>
                </tr>
                @if(count($rows['student_watch']) > 0)
                    @foreach($rows['student_watch'] as $student)
                        <tr>
                        <td>{{ $student->first_name.' '.$student->last_name }}</td>
                        <td>{{ $student->progress }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr >
                        <td colspan="2"><p>No result...</p></td>
                    </tr>
                @endif

            </table>
        </div>
        {{--Highest Lowest Scorers--}}
        <div>
            <h3><i class="fa fa-bar-chart"></i>Scores</h3>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="report-empty-column"></th>
                    <th>Student</th>
                    <th>Teacher</th>
                </tr>
                <tr class="magenta-row">
                    <th>Highest Score</th>
                    <td>{{ $rows['highest_score']['student_first_name'].' '.$rows['highest_score']['student_last_name'] }}</td>
                    <td>{{ $rows['highest_score']['teacher_first_name'].' '.$rows['highest_score']['teacher_last_name'] }}</td>
                </tr>
                <tr class="magenta-row">
                    <th>Lowest Score</th>
                    <td>{{ $rows['lowest_score']['student_first_name'].' '.$rows['highest_score']['student_last_name'] }}</td>
                    <td>{{ $rows['lowest_score']['teacher_first_name'].' '.$rows['highest_score']['teacher_last_name'] }}</td>
                </tr>
            </table>

        </div>
    </div>


@stop