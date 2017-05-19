@extends('export.client.principal.index')

@section('content')
    {{--Header--}}
    <table>
        <tr>
            <td style="text-align: left; float: left;"><img src="{{ base_path().'/public/images/logo-md.png' }}"></td>
        </tr>
        <tr>
            <td></td>
        </tr>
        <tr>
            {{--temporary: for example only--}}
            {{--<td style="text-align: left">Contact Person: John Doe</td>--}}
            <td style="text-align: left">Contact Person: {{ $additional_information['principal_name'] }}</td>
        </tr>
        <tr>
            {{--temporary: for example only--}}
            {{--<td style="text-align: left">School: Tacoma Community College</td>--}}
            <td style="text-align: left">School: {{ $additional_information['school_name'] }}</td>
        </tr>
        <tr>
            <td style="text-align: left">Address: {{ $additional_information['school_address'] }}</td>
        </tr>
        <tr></tr>
    </table>
    <div>&nbsp;</div>

    {{--Contents--}}
    <div>
        <div class="export-header"><h3>{!! trans( 'messages.' . $key) !!}</h3></div>
        <div>
            <table class="export-body export-table-bordered">
                <tr class="magenta export-row">
                    <th class="export-cell" width="20%">Teacher's Name</th>
                    @foreach($column_header as $header)
                        <th class="export-cell" width="{{ $width . '%'}}">{{ $header }}</th>
                    @endforeach
                </tr>
                @if(!is_null($rows))
                    @foreach($rows as $name => $records)
                        <tr class="export-row">
                            <td class="export-cell" >{!! trans('messages.teacher') !!} {{ $name }}</td>
                            @foreach($records as $record)
                                <td class="export-cell" >{{ $record . '%' }}</td>
                            @endforeach
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="{{ count($column_header) + 1 }}"><p>{!! trans('messages.no_results') !!}</p></td>
                    </tr>
                @endif

            </table>
        </div>

    </div>
@stop