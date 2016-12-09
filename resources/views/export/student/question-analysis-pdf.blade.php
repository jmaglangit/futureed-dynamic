@extends('export.student.index')

@section('content')
    <div class="export-report">
        {{-- add student information--}}
        <table>
            <tr class="export-logo">
                <td colspan="3">
                    <img src="{{ base_path().'/public/images/logo-md.png' }}">
                </td>
            </tr>
            <tr class="export-header">
                <td colspan="3">{!! trans('messages.student') !!} : {{ $student['name'] }}</td>
            </tr>
            <tr class="export-header">
                <td colspan="3">{!! trans_choice('messages.grade',1) !!} : {{ $student['grade'] }}</td>
            </tr>
            <tr class="export-header">
                <td colspan="3">{!! trans_choice('messages.module',1) !!} : {{ $student['module'] }}</td>
            </tr>
            <tr class="export-header">
                <td colspan="3">{!! trans('messages.subject') !!} : {{ $student['subject'] }}</td>
            </tr>
        </table>

        <table class="report-data">
            <tr>
                <th>{!! trans('messages.question') !!}</th>
                <th>{!! trans('messages.answer') !!}</th>
                <th>{!! trans('messages.image') !!}</th>
                <th><img src="{{ base_path().'/public/images/icon-tipbulb.png' }}" height="25" width="25">{!! trans('messages.tips') !!}</th>
            </tr>
            @foreach($questions as $question)
                <tr>
                    <td>{{ strip_tags($question->questions_text) }}</td>
                    <td>{{ $question->answer_status }}</td>
                    <td>
                        @if( $question->answer_status == config('futureed.answer_status_wrong') && !is_null($question->answer_status))
                            <img src="{{ config('futureed.answer_explanation_image_final') . '/' . $question->image }}">
                        @else
                            {{ '' }}
                        @endif
                    </td>
                    <td>{!!  html_entity_decode($question->answer_explanation)  !!}</td>
                </tr>
            @endforeach
        </table>
    </div>
@stop