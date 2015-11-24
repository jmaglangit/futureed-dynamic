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
				<p>Teacher: {{ $additional_information['teacher_first_name'] . ' ' . $additional_information['teacher_last_name'] }}</p>
			</td>
		</tr>
		<tr>
			<td colspan="6">
				<h3 class="export-sub-header">Teacher Details</h3>
			</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>Class Name</th>
			<td colspan="5">{{ $additional_information['class_name'] }}</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>Class Level</th>
			<td colspan="5">{{ $additional_information['grade_name'] }}</td>
		</tr>
	</table>
	<table>
		<tr>
			<td colspan="6">
				<h3 class="export-sub-header">Student Status</h3>
			</td>
		</tr>
		<tr>
			<th style="background-color:#AC2A4E; color:#fff;" >Student Name</th>
			<th style="background-color:#AC2A4E; color:#fff;"  colspan="5">Status</th>
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
				<h3 class="export-sub-header">Students to Watch</h3>
			</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>Struggling</th>
			<td colspan="5">{{ $rows[0]['student_watch']['struggling'] }}</td>
		</tr>
		<tr class="magenta-row class-report">
			<th>Excelling</th>
			<td colspan="5">{{ $rows[0]['student_watch']['excelling'] }}</td>
		</tr>
	</table>
@stop