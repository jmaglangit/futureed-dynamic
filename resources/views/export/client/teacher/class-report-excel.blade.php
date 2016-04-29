@extends('export.client.teacher.index')

@section('metadata')
	<link rel="stylesheet" type="text/css" href="{{ base_path().'/public/css/futureed-client.css' }}">
@stop

@section('content')
	<table>
		<tr>
			<td colspan="6" style="text-align:left;">
				<img style="margin:0 auto;" src="{{ base_path().'/public/images/logo-md.png' }}">
			</td>
		</tr>
		<tr>
			<td colspan="6" style="text-align:left;">
				<p>{!! trans('messages.teacher') !!}: {{ $additional_information['teacher_first_name'] . ' ' . $additional_information['teacher_last_name'] }}</p>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<h3 class="export-sub-header">{!! trans('messages.client_teacher_details') !!}</h3>
			</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>{!! trans('messages.class_name') !!}</th>
			<td colspan="5">{{ $additional_information['class_name'] }}</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>{!! trans('messages.class_level') !!}</th>
			<td colspan="5">{{ $additional_information['grade_name'] }}</td>
		</tr>
	</table>
	<table>
		<tr>
			<td colspan="6">
				<h3 class="export-sub-header">{!! trans('messages.student_status') !!}</h3>
			</td>
		</tr>
		<tr>
			<th style="background-color:#AC2A4E; color:#fff;" >{!! trans('messages.student_name') !!}</th>
			<th style="background-color:#AC2A4E; color:#fff;"  colspan="5">{!! trans('messages.status') !!}</th>
		</tr>
		@foreach($rows[0]['student_progress'] as $row)
		<tr>
			<td>{{ $row->first_name . ' ' . $row->last_name }}</td>
			<td colspan="5"> {{ $row->progress }}</td>
		</tr>
		@endforeach
	</table>
	<table>
		<tr>
			<td colspan="6">
				<h3 class="export-sub-header">{!! trans('messages.student_to_watch') !!}</h3>
			</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>{!! trans('messages.struggling') !!}</th>
			<td colspan="5">{{ $rows[0]['student_watch']['struggling'] }}</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>{!! trans('messages.excelling') !!}</th>
			<td colspan="5">{{ $rows[0]['student_watch']['excelling'] }}</td>
		</tr>
	</table>
@stop