@extends('export.student.index')

@section('content')
<div class="export-report">
	<table>
		<tr class="export-logo">
			<td colspan="{{ $format['column_header_count'] }}">
				<img src="{{ base_path().'/public/images/logo-md.png' }}">
			</td>
		</tr>
		<tr class="export-header">
			<th rowspan="3" >
				<img src="{{ base_path().'/public/' . config('futureed.thumbnail') . '/'.$additional_information['avatar_thumbnail'] }}" alt=" ">
			</th>
			<td colspan="{{ $format['column_header_neg'] }}">Student : {{ $additional_information['first_name'].' '.$additional_information['last_name'] }}</td>
		</tr>
		<tr class="export-header">
			<td colspan="{{ $format['column_header_neg'] }}">Grade : {{ $additional_information['grade_name'] }}</td>
		</tr>
		<tr class="export-header">
			<td colspan="{{ $format['column_header_neg'] }}">Subject : {{ $additional_information['subject_name'] }}</td>
		</tr>

		<!-- progress bar -->
		<tr>
			<td colspan="13"><hr/></td>
		</tr>
		<tr class="progress-container">
			<td colspan="{{ $format['column_header_floor'] }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['earned_badges'] }}</p>
					</div>
					<p>Badges earned</p>
				</div>
			</td>
			<td colspan="{{ $format['column_header_floor'] }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['earned_medals'] }}</p>
					</div>
					<p>Number of medals earned</p>
				</div>
			</td>
			<td colspan="{{ $format['column_header_ceil'] }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['completed_lessons'] }}</p>
					</div>
					<p>Lessons completed</p>
				</div>
			</td>
			<td colspan="{{ $format['column_header_floor'] }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['written_tips'] }}</p>
					</div>
					<p>Tips written</p>
				</div>
			</td>
			<td colspan="{{ $format['column_header_floor'] }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['week_hours'] }}</p>
					</div>
					<p>Hours spent in last 7 days</p>
				</div>
			</td>
			<td colspan="{{ $format['column_header_ceil'] }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['total_hours'] }}</p>
					</div>
					<p>Total hours spend</p>
				</div>
			</td>
		</tr>
		<tr>
			<td colspan="13"><hr/></td>
		</tr>
		<!-- progress bar -->
	</table>

	<table class="report-data">
		<tr>
			@foreach( $column_header as $column)
				<th>{{ $column['name'] }}</th>
			@endforeach
		</tr>
		@foreach($rows as $row)
			<tr>
				<td>{{ $row->curriculum_name }}</td>
				@foreach($row->curriculum_data as $data)
					@if(!empty($data))
						<td style=" background-color:
						@if($data['progress'] > $format['progress_pass'])
								#5cb85c;
						@elseif($data['progress'] > $format['progress_above_ave_floor'] && $data['progress'] <= $format['progress_above_ave_ceil'])
								#5bc0de;
						@elseif($data['progress'] > $format['progress_below_ave_floor'] && $data['progress'] <= $format['progress_below_ave_ceil'])
								#f0ad4e;
						@elseif($data['progress'] > $format['progress_below_fail_floor'] && $data['progress'] <= $format['progress_below_fail_ceil'])
								#d9534f;
						@else
								#ffffff;
						@endif
								">{{ (($data['progress'] > 0) ? $data['progress'] . '%' : '')}}</td>
					@else
						<td>{{ ''}}</td>
					@endif
				@endforeach
			</tr>
		@endforeach
	</table>
</div>
@stop

