@extends('export.client.principal.index')


@section('content')
    {{--Header--}}
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
    <div>&nbsp;</div>
    <tr>
        <td style="text-align: center;"><b>Overall School Progress</b></td>
    </tr>
    <tr></tr>
    {{--Class report--}}
    <tr>
        <td style="text-align: left;"><b>Teacher Comparison Progress</b></td>
    </tr>
    <tr style="background-color: #AC2A4E;">
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">{{ $column_header['teacher_list'] }}</th>
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">{{ $column_header['progress'] }}</th>
    </tr>
    @if(count($rows) > 0 )
        @foreach($rows as $teacher)
            <tr>
                <td style="text-align: center; border: 1px solid black;">Teacher {{ $teacher['first_name'].' ' . $teacher['last_name'] }}</td>
                <td style="text-align: center; border: 1px solid black;">{{ $teacher['percent_progress'].'%' }}</td>
            </tr>
        @endforeach
    @else
        <tr >
            <td colspan="2" style="text-align: center; border: 1px solid black;"><p>No result...</p></td>
        </tr >
    @endif

    {{--Contents--}}
    {{--<div>--}}
        {{--<div class="export-header"><h3>Teacher Comparison Progress</h3></div>--}}
        {{--<div>--}}
            {{--<div class="export-sub-header"><h3>Class Progress Report</h3></div>--}}
            {{--<table class="export-table export-table-bordered">--}}
                {{--<tr class="magenta">--}}
                    {{--<th class="col-xs-4">{{ $column_header['teacher_list'] }}</th>--}}
                    {{--<th class="col-xs-3">{{ $column_header['progress'] }}</th>--}}
                {{--</tr>--}}
                {{--@if(count($rows) > 0 )--}}
                    {{--@foreach($rows as $teacher)--}}
                        {{--<tr>--}}
                            {{--<td>Teacher {{ $teacher['first_name'].' ' . $teacher['last_name'] }}</td>--}}
                            {{--<td>{{ $teacher['percent_progress'].'%' }}</td>--}}
                        {{--</tr>--}}
                    {{--@endforeach--}}
                {{--@else--}}
                    {{--<tr >--}}
                        {{--<td colspan="2"><p>No result...</p></td>--}}
                    {{--</tr >--}}
                {{--@endif--}}


            {{--</table>--}}
        {{--</div>--}}

    {{--</div>--}}
@stop