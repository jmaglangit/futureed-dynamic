@extends('export.student.index')

@section('content')
    <div class="export-report">
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
                    <td>{{ $question->answer_explanation }}</td>
                </tr>
            @endforeach
        </table>
    </div>
@stop