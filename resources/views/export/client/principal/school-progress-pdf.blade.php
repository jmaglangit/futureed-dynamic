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
    <div class="export-header"><h3>{!! trans('messages.overall_school_progress') !!}</h3></div>
    <div>
        {{--Skills watch--}}
        <div>
            <h3 class="export-sub-header">{{ $column_header['skills_watch'] }}</h3>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="col-xs-4">{!! trans('messages.subject') !!}</th>
                    <th class="col-xs-3">{!! trans('messages.progress') !!}</th>
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
                        <td colspan="2"><p>{!! trans('messages.no_results') !!}</p></td>
                    </tr>
                @endif
            </table>

        </div>
        {{--Class watch--}}
        <div>
            <h3 class="export-sub-header">{{ $column_header['class_watch'] }}</h3>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="col-xs-4">{!! trans('messages.teacher') !!}</th>
                    <th class="col-xs-3">{!! trans('messages.progress') !!}</th>
                </tr>
                @if(!is_null($rows['class_watch']['highest_class']))
                    <tr>
                        <td>{!! trans('messages.teacher') !!} {{ $rows['class_watch']['highest_class']['first_name']
                    .' '.$rows['class_watch']['highest_class']['last_name'] }}
                        </td>
                        <td>{{ $rows['class_watch']['highest_class']['percent_progress'] }} %</td>
                    </tr>
                @endif
                @if(!is_null($rows['class_watch']['lowest_class']))
                    <tr>
                        <td>{!! trans('messages.teacher') !!} {{ $rows['class_watch']['lowest_class']['first_name']
                     .' '. $rows['class_watch']['lowest_class']['last_name']}}
                        </td>
                        <td>{{ $rows['class_watch']['lowest_class']['percent_progress'] }}%</td>
                    </tr>
                @endif
                @if(is_null($rows['class_watch']['highest_class']) && is_null($rows['class_watch']['lowest_class']))
                    <tr>
                        <td colspan="2"><p>{!! trans('messages.no_results') !!}</p></td>
                    </tr>
                @endif

            </table>
        </div>
        {{--Student watch--}}
        <div>
            <h3 class="export-sub-header">{{ $column_header['student_watch'] }}</h3>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="col-xs-4">{!! trans('messages.student') !!}</th>
                    <th class="col-xs-3">{!! trans('messages.status') !!}</th>
                </tr>
                @if(count($rows['student_watch']) > 0)
                    @foreach($rows['student_watch'] as $student)
                        <tr>
                            <td>{{ $student->first_name.' '.$student->last_name }}</td>
                            <td>{{ $student->progress }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="2"><p>{!! trans('messages.no_result') !!}</p></td>
                    </tr>
                @endif

            </table>
        </div>
        {{--Highest Lowest Scorers--}}
        <div>
            <h3 class="export-sub-header">{!! trans('messages.scores') !!}</h3>
            <table class="export-table export-table-bordered">
                <tr class="magenta">
                    <th class="report-empty-column"></th>
                    <th>{!! trans('messages.student') !!}</th>
                    <th>{!! trans('messages.teacher') !!}</th>
                </tr>
                <tr class="magenta-row">
                    <th>{!! trans('messages.highest_score') !!}</th>
                    <td>{{ $rows['highest_score']['student_first_name'].' '.$rows['highest_score']['student_last_name'] }}</td>
                    <td>{{ $rows['highest_score']['teacher_first_name'].' '.$rows['highest_score']['teacher_last_name'] }}</td>
                </tr>
                <tr class="magenta-row">
                    <th>{!! trans('messages.lowest_score') !!}</th>
                    <td>{{ $rows['lowest_score']['student_first_name'].' '.$rows['highest_score']['student_last_name'] }}</td>
                    <td>{{ $rows['lowest_score']['teacher_first_name'].' '.$rows['highest_score']['teacher_last_name'] }}</td>
                </tr>
            </table>

        </div>
    </div>


@stop