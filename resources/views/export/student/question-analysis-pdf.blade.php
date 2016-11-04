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
                <th>{{ 'Question' }}</th>
                <th>{{ 'Answer' }}</th>
                <th>{{ 'Tips' }}</th>
            </tr>
            @foreach($questions as $question)
                <tr>
                    <td>{{ $question->questions_text }}</td>
                    <td>{{ $question->answer_status }}</td>
                    <td>{!!  html_entity_decode($question->answer_explanation)  !!}</td>
                </tr>
            @endforeach
        </table>
    </div>
@stop