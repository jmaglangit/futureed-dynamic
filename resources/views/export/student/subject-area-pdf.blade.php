@extends('export.master')

@section('content')
    <table style="width: 100%">

        <tr>
            <td colspan="{{ count($column_header) }}" style="text-align: center;"><h4>Future Lessons</h4>
            </td>
        </tr>
        <tr>
            <th rowspan="4" ><img src="{{ base_path().'/public/' . config('futureed.thumbnail') . '/'.$additional_information['avatar_thumbnail'] }}" alt=" "></th>
        </tr>
        <tr>
            <td colspan="{{ count($column_header)-1 }}">Student
                : {{ $additional_information['first_name'].' '.$additional_information['last_name'] }}</td>
        </tr>
        <tr>
            <td colspan="{{ count($column_header)-1 }}">Grade : {{ $additional_information['grade_name'] }}</td>
        </tr>
        <tr>
            <td colspan="{{ count($column_header)-1 }}">Subject : {{ $additional_information['subject_name'] }}</td>
        </tr>
        <tr>
            <td colspan="{{ floor(count($column_header)/3) }}"
                style="text-align: center;">{{ $additional_information['earned_badges'] }} Badges earned
            </td>
            <td colspan="{{ floor(count($column_header)/3) }}"
                style="text-align: center;">{{ $additional_information['earned_medals'] }} Number of medals
                earned
            </td>
            <td colspan="{{ ceil(count($column_header)/3) }}"
                style="text-align: center;">{{ $additional_information['completed_lessons'] }} Lessons
                completed
            </td>
        </tr>
        <tr>
            <td colspan="{{ floor(count($column_header)/3) }}"
                style="text-align: center;">{{ $additional_information['written_tips'] }} Tips written
            </td>
            <td colspan="{{ floor(count($column_header)/3) }}"
                style="text-align: center;">{{ $additional_information['week_hours'] }} Hours spent in last 7
                days
            </td>
            <td colspan="{{ ceil(count($column_header)/3) }}"
                style="text-align: center;">{{ $additional_information['total_hours'] }} Total hours spend
            </td>
        </tr>
        <tr>
            @foreach( $column_header as $column)
                <th style="width: 100%; text-align: center; border: 1px solid black;">{{ $column['name'] }}</th>
            @endforeach
        </tr>
        @foreach($rows as $row)
            <tr>
                <td style="text-align: center; border: 1px solid black;">{{ $row->curriculum_name }}</td>
                @for($i = 1; $i < (count($column_header)); $i++)
                    @if(empty($row->curriculum_data->toArray()))
                        <td style="text-align: center; border: 1px solid black;">{{ '' }}</td>
                    @else
                        @foreach($row->curriculum_data as $data)
                            @if($data->grade_id == $i)
                                <td style="text-align: center; border: 1px solid black;">{{ (($data->progress > 0) ? $data->progress . '%' : '')}}</td>
                            @else
                                <td style="text-align: center; border: 1px solid black;">{{ ''}}</td>
                            @endif
                        @endforeach
                    @endif
                @endfor
            </tr>
        @endforeach
    </table>
@stop

