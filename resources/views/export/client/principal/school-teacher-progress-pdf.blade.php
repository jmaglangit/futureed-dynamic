@extends('export.client.principal.index')

@section('metadata')
        <!-- Bootstrap core CSS -->
{!! Html::style('//maxcdn.bootstrapcdn.com/bootstrap/3.3.4/css/bootstrap.min.css'); !!}
        <!-- Fonts -->
{!! Html::style('//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css'); !!}
{!! Html::style('//fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,500italic,700,700italic'); !!}

        <!-- Custom styles for this template -->
{!! Html::style('/css/datetimepicker.css') !!}
{{--{!! Html::style('/css/futureed.css'); !!}--}}

{!! Html::style('/css/futureed-client.css') !!}
{!! Html::style('/css/angucomplete.css') !!}
{!! Html::style('/css/datatables.bootstrap.min.css') !!}
@stop

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
            <td style="text-align: left">{{ $additional_information['principal_name'] }}</td>
        </tr>
        <tr>
            <td style="text-align: left">{{ $additional_information['school_name'] }}</td>
        </tr>
        <tr>
            <td style="text-align: left">{{ $additional_information['school_address'] }}</td>
        </tr>
        <tr></tr>
    </table>
    <div>&nbsp;</div>

    {{--Contents--}}
    <div>
        <div class="export-header"><h3>Teacher Comparison Progress</h3></div>
        <div>
            <div class="export-sub-header"><h3>Class Progress Report</h3></div>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="col-xs-4">{{ $column_header['teacher_list'] }}</th>
                    <th class="col-xs-3">{{ $column_header['progress'] }}</th>
                </tr>
                @if(count($rows) > 0 )
                    @foreach($rows as $teacher)
                        <tr>
                            <td>Teacher {{ $teacher['first_name'].' ' . $teacher['last_name'] }}</td>
                            <td>{{ $teacher['percent_progress'].'%' }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr >
                        <td colspan="2"><p>No result...</p></td>
                    </tr >
                @endif


            </table>
        </div>

    </div>
@stop