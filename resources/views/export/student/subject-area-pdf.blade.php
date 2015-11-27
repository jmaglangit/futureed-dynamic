@extends('export.student.index')

@section('content')
<div class="export-report">
	<table>
		<tr class="export-logo">
			<td colspan="{{ count($column_header) }}">
				<img src="{{ base_path().'/public/images/logo-md.png' }}">
			</td>
		</tr>
		<tr class="export-header">
			<th rowspan="3" >
				<img src="{{ base_path().'/public/' . config('futureed.thumbnail') . '/'.$additional_information['avatar_thumbnail'] }}" alt=" ">
			</th>
			<td colspan="{{ count($column_header)-1 }}">Student : {{ $additional_information['first_name'].' '.$additional_information['last_name'] }}</td>
		</tr>
		<tr class="export-header">
			<td colspan="{{ count($column_header)-1 }}">Grade : {{ $additional_information['grade_name'] }}</td>
		</tr>
		<tr class="export-header">
			<td colspan="{{ count($column_header)-1 }}">Subject : {{ $additional_information['subject_name'] }} {{ count($column_header)-1 }}</td>
		</tr>

		<!-- progress bar -->
		<tr>
			<td colspan="13"><hr/></td>
		</tr>
		<tr class="progress-container">
			<td colspan="{{ floor(count($column_header)/6) }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['earned_badges'] }}</p>
					</div>
					<p>Badges earned</p>
				</div>
			</td>
			<td colspan="{{ floor(count($column_header)/6) }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['earned_medals'] }}</p>
					</div>
					<p>Number of medals earned</p>
				</div>
			</td>
			<td colspan="{{ ceil(count($column_header)/6) }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['completed_lessons'] }}</p>
					</div>
					<p>Lessons completed</p>
				</div>
			</td>
			<td colspan="{{ floor(count($column_header)/6) }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['written_tips'] }}</p>
					</div>
					<p>Tips written</p>
				</div>
			</td>
			<td colspan="{{ floor(count($column_header)/6) }}">
				<div class="progress-item">
					<div class="circle">
						<p>{{ $additional_information['week_hours'] }}</p>
					</div>
					<p>Hours spent in last 7 days</p>
				</div>
			</td>
			<td colspan="{{ ceil(count($column_header)/6) }}">
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
				@for($i = 1; $i < (count($column_header)); $i++)
					@if(empty($row->curriculum_data->toArray()))
						<td>{{ '' }}</td>
					@else
						@foreach($row->curriculum_data as $data)
							@if($data->grade_id == $i)
								<td>{{ (($data->progress > 0) ? $data->progress . '%' : '')}}</td>
							@else
								<td>{{ ''}}</td>
							@endif
						@endforeach
					@endif
				@endfor
			</tr>
		@endforeach
	</table>
</div>
@stop

