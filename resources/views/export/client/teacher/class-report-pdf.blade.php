@extends('export.client.teacher.index')

@section('metadata')
	<link rel="stylesheet" type="text/css" href="{{ base_path().'/public//css/futureed-client.css' }}">
@stop

@section('content')
	<div>
		<img src="{{ base_path().'/public/images/logo-md.png' }}">
		<p>Teacher: {{ $additional_information['teacher_first_name'] . ' ' . $additional_information['teacher_last_name'] }}</p>
	</div>

	<h3 class="export-sub-header">Teacher Details</h3>
	<table class="export-table export-table-bordered"> 
		<tr class="magenta-row class-report">
			<th>Class Name</th>
			<td>{{ $additional_information['class_name'] }}</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>Class Level</th>
			<td>{{ $additional_information['grade_name'] }}</td>
		</tr>
	</table>

	<h3 class="export-sub-header">Student Status</h3>
	<table class="export-table export-table-bordered">
		<tr class="magenta">
			<th>Student Name</th>
			<th>Status</th>
		</tr>
		@foreach($rows[0]['student_progress'] as $row)
		<tr>
			<td>{{ $row->first_name . ' ' . $row->last_name }}</td>
			<td>{{ $row->progress }}</td>
		</tr>
		@endforeach
	</table>

	<h3 class="export-sub-header">Students to Watch</h3>
	<table class="export-table export-table-bordered">
		<tr class="magenta-row class-report">
			<th>Struggling</th>
			<td>{{ $rows[0]['student_watch']['struggling'] }}</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>Excelling</th>
			<td>{{ $rows[0]['student_watch']['excelling'] }}</td>
		</tr>
	</table>
@stop