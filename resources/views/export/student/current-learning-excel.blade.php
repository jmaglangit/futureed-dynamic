@extends('export.master')

@section('content')
    <table>

        <tr><td></td>
            <td colspan="3" style="align: middle;">
                <img src="{{ base_path().'/public/images/logo-md.png' }}">
            </td>
        </tr>
        <tr></tr>
        <tr>
            <th valign="middle"><img src="{{ base_path().'/public/' . config('futureed.thumbnail') . '/'.$additional_information['avatar_thumbnail'] }}" alt=" "></th>
        </tr>
        <tr>
            <td>Student
                : {{ $additional_information['first_name'].' '.$additional_information['last_name'] }}</td>
        </tr>
        <tr>
            <td>Subject : {{ $additional_information['subject_name'] }}</td>
        </tr>
        {{-- Column Headers --}}
        <tr>
            <th style="width: 100px; text-align: center; border: 1px solid black;">{{ $column_header['grade_level'] }}</th>
            <th style="width: 100px; text-align: center; border: 1px solid black;">{{ $column_header['curriculum_category'] }}</th>
            <th style="width: 100px; text-align: center; border: 1px solid black;">{{ $column_header['percent_completed'] }}</th>
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