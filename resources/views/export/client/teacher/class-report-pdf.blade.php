@extends('export.client.teacher.index')

@section('metadata')
	<link rel="stylesheet" type="text/css" href="{{ base_path().'/public//css/futureed-client.css' }}">
@stop

@section('content')
	<div>
		<img src="{{ base_path().'/public/images/logo-md.png' }}">
		<p>{!! trans('messages.teacher') !!}: {{ $additional_information['teacher_first_name'] . ' ' . $additional_information['teacher_last_name'] }}</p>
	</div>

	<h3 class="export-sub-header">{!! trans('messages.client_teacher_details') !!}</h3>
	<table class="export-table export-table-bordered"> 
		<tr class="magenta-row class-report">
			<th>{!! trans('messages.class_name') !!}</th>
			<td>{{ $additional_information['class_name'] }}</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>{!! trans('messages.class_level') !!}</th>
			<td>{{ $additional_information['grade_name'] }}</td>
		</tr>
	</table>

	<h3 class="export-sub-header">{!! trans('messages.student_status') !!}</h3>
	<table class="export-table export-table-bordered">
		<tr class="magenta">
			<th>{!! trans('messages.student_name') !!}</th>
			<th>{!! trans('messages.status') !!}</th>
		</tr>
		@foreach($rows[0]['student_progress'] as $row)
		<tr>
			<td>{{ $row->first_name . ' ' . $row->last_name }}</td>
			<td>{{ $row->progress }}</td>
		</tr>
		@endforeach
	</table>

	<h3 class="export-sub-header">{!! trans('messages.student_to_watch') !!}</h3>
	<table class="export-table export-table-bordered">
		<tr class="magenta-row class-report">
			<th>{!! trans('messages.struggling') !!}</th>
			<td>{{ $rows[0]['student_watch']['struggling'] }}</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>{!! trans('messages.excelling') !!}</th>
			<td>{{ $rows[0]['student_watch']['excelling'] }}</td>
		</tr>
	</table>
@stop