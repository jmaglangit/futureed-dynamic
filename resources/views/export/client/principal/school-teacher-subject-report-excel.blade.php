@extends('export.client.principal.index')

@section('content')
    <table class="school-excel-header">
        <tr>
{{--            <td style="text-align: left; float: left;"><img src="{{ 'C:/Users/King/Projects/FutureEdLaravel/public/images/logo-md.png' }}"></td>--}}
            <th style="text-align: left"><img src="{{ base_path().'/public/images/logo-md.png' }}"></th>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: left"><b>Contact Person: {{ $additional_information['principal_name'] }}</b></td>
        </tr>
        <tr>
            <td style="text-align: left">School: {{ $additional_information['school_name'] }}</td>
        </tr>
        <tr>
            <td style="text-align: left">Address: {{ $additional_information['school_address'] }}</td>
        </tr>
    </table>
    <tr>
        <td style="text-align: left;"><b> {{ $title }} </b></td>
    </tr>
    <tr style="background-color: #AC2A4E;">
        <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">Teacher's Name</th>
        @foreach($column_header as $header)
            <th style="color:#fff;padding: 0 5px 0 5px; text-align: center; border: 1px solid black;">{{ $header }}</th>
        @endforeach
    </tr>
    @if(!is_null($rows))
        @foreach($rows as $name => $records)
            <tr>
                <td style="text-align: center; border: 1px solid black;">Teacher {{ $name }}</td>
                @foreach($records as $record)
                    <td style="text-align: center; border: 1px solid black;">{{ $record }}%</td>
                @endforeach
            </tr>
        @endforeach
    @endif

@stop