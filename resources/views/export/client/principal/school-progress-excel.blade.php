@extends('export.client.principal.index')

@section('content')
    <table class="school-excel-header">
        <tr>
            <th style="text-align: left"><img src="{{ base_path().'/public/images/logo-md.png' }}"></th>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: left"><b>{{ $additional_information['principal_name'] }}</b></td>
        </tr>
        <tr>
            <td style="text-align: left">{{ $additional_information['school_name'] }}</td>
        </tr>
        <tr>
            <td style="text-align: left">{{ $additional_information['school_address'] }}</td>
        </tr>
    </table>
    <tr>
        <td style="text-align: center;"><b>Overall School Progress</b></td>
    </tr>
    <tr></tr>
    {{--Skills watch--}}
    <tr>
        <td style="text-align: left;"><b>{{ $column_header['skills_watch'] }}</b></td>
    </tr>
    <tr style="background-color: #AC2A4E;">
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Subject</th>
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Progress</th>
    </tr>
    @if(!is_null($rows['skills_watch']['highest_skill']))
        <tr>
            <td style="text-align: center; border: 1px solid black;">{{ $rows['skills_watch']['highest_skill']['subject_name'] }}</td>
            <td style="text-align: center; border: 1px solid black;">{{ $rows['skills_watch']['highest_skill']['percent_progress'] }}%</td>
        </tr>
    @endif
    @if(!is_null($rows['skills_watch']['lowest_skill']))
        <tr>
            <td style="text-align: center; border: 1px solid black;">{{ $rows['skills_watch']['lowest_skill']['subject_name'] }}</td>
            <td style="text-align: center; border: 1px solid black;">{{ $rows['skills_watch']['lowest_skill']['percent_progress'] }}%</td>
        </tr>
    @endif
    @if(is_null($rows['skills_watch']['highest_skill']) && is_null($rows['skills_watch']['lowest_skill']))
        <tr>
            <td colspan="3" style="text-align: center; border: 1px solid black;"><p>No result...</p></td>
        </tr>
    @endif
    <tr></tr>
    {{--Class watch--}}
    <tr>
        <td><b>{{ $column_header['class_watch'] }}</b></td>
    </tr>
    <tr style="background-color: #AC2A4E;">
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Teacher</th>
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Progress</th>
    </tr>
    @if(!is_null($rows['class_watch']['highest_class']))
        <tr>
            <td style="text-align: center; border: 1px solid black;">Teacher {{ $rows['class_watch']['highest_class']['first_name']
                    .' '.$rows['class_watch']['highest_class']['last_name'] }}
            </td>
            <td style="text-align: center; border: 1px solid black;">{{ $rows['class_watch']['highest_class']['percent_progress'] }} %</td>
        </tr>
    @endif
    @if(!is_null($rows['class_watch']['lowest_class']))
        <tr>
            <td style="text-align: center; border: 1px solid black;">Teacher {{ $rows['class_watch']['lowest_class']['first_name']
                     .' '. $rows['class_watch']['lowest_class']['last_name']}}
            </td>
            <td style="text-align: center; border: 1px solid black;">{{ $rows['class_watch']['lowest_class']['percent_progress'] }}%</td>
        </tr>
    @endif
    @if(is_null($rows['class_watch']['highest_class']) && is_null($rows['class_watch']['lowest_class']))
        <tr>
            <td colspan="2" style="text-align: center; border: 1px solid black;"><p>No result...</p></td>
        </tr>
    @endif
    <tr></tr>
    {{--Student watch--}}
    <tr>
        <td><b>{{ $column_header['student_watch'] }}</b></td>
    </tr>
    <tr style="background-color: #AC2A4E;">
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Student</th>
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Status</th>
    </tr>
    @if(count($rows['student_watch']) > 0)
        @foreach($rows['student_watch'] as $student)
            <tr>
                <td style="text-align: center; border: 1px solid black;">{{ $student->first_name.' '.$student->last_name }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $student->progress }}</td>
            </tr>
        @endforeach
    @else
        <tr>
            <td colspan="2" style="text-align: center; border: 1px solid black;"><p>No result...</p></td>
        </tr>
    @endif
    <tr></tr>
    {{--Highest Lowest Scorers--}}
    <tr>
        <td><b>Scores</b></td>
    </tr>
    <tr class="magenta">
        <th></th>
        <th style="background-color: #AC2A4E;color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Student</th>
        <th style="background-color: #AC2A4E;color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Teacher</th>
    </tr>
    <tr class="magenta-row">
        <th style="background-color: #AC2A4E;color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Highest Score</th>
        <td style="text-align: center; border: 1px solid black;">{{ $rows['highest_score']['student_first_name'].' '.$rows['highest_score']['student_last_name'] }}</td>
        <td style="text-align: center; border: 1px solid black;">{{ $rows['highest_score']['teacher_first_name'].' '.$rows['highest_score']['teacher_last_name'] }}</td>
    </tr>
    <tr class="magenta-row">
        <th style="background-color: #AC2A4E;color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Lowest Score</th>
        <td style="text-align: center; border: 1px solid black;">{{ $rows['lowest_score']['student_first_name'].' '.$rows['highest_score']['student_last_name'] }}</td>
        <td style="text-align: center; border: 1px solid black;">{{ $rows['lowest_score']['teacher_first_name'].' '.$rows['highest_score']['teacher_last_name'] }}</td>
    </tr>

@stop