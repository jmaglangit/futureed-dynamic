@extends('export.student.index')

@section('content')
    <table style="width: 100%" cellpadding="0" cellspacing="0">

        <tr>
            <td colspan="{{ count($column_header) }}" style="text-align: center;">
                <img src="{{ base_path().'/public/images/logo-md.png' }}">
            </td>
            </td>
        </tr>
        <tr>
            <th rowspan="4">
                <img style="border: 1px solid; border-radius: 25px; border-color: "
                     src="{{ base_path().'/public/' . config('futureed.thumbnail') . '/'.$additional_information['avatar_thumbnail'] }}"
                     alt=" ">
            </th>
        </tr>
        <tr>
            <td colspan="{{ count($column_header)-1 }}">Student
                : {{ $additional_information['first_name'].' '.$additional_information['last_name'] }}</td>
        </tr>
        <tr>
            <td colspan="{{ count($column_header)-1 }}">Subject : {{ $additional_information['subject_name'] }}</td>
        </tr>
        <tr></tr>
        <tr>
            <td colspan="3" height="50px">
                <hr/>
            </td>
        </tr>
        <tr>
            <th style="width: 100%; text-align: center; border: 1px solid black;">{{ $column_header['grade_level'] }}</th>
            <th style="width: 100%; text-align: center; border: 1px solid black;">{{ $column_header['curriculum_category'] }}</th>
            <th style="width: 100%; text-align: center; border: 1px solid black;">{{ $column_header['percent_completed'] }}</th>
        </tr>
        <?php $var = '' ?>
        @foreach($rows as $row)
            <tr>
                @if( $row->grade_name === $var)
                    <td style="text-align: center; border: 1px solid black;">{{ '' }}</td>
                @else
                    <td style="text-align: center; border: 1px solid black;">{{ $row->grade_name }}</td>
                @endif
                <?php $var = $row->grade_name ?>
                <td style="text-align: center; border: 1px solid black;">{{ $row->name }}</td>
                @if($row->progress > 0)
                    <td style="text-align: center; border: 1px solid black;">{{ $row->progress }}</td>
                @else
                    <td style="text-align: center; border: 1px solid black;">{{ '' }}</td>

                @endif


            </tr>
        @endforeach

    </table>
@stop