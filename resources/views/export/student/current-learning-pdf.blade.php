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
			<th rowspan="3"  style="width:100px;">
				<img src="{{ base_path().'/public/' . config('futureed.thumbnail') . '/'.$additional_information['avatar_thumbnail'] }}" alt=" ">
			</th>
			<td colspan="{{ count($column_header)-1 }}">Student : {{ $additional_information['first_name'].' '.$additional_information['last_name'] }}</td>
		</tr>
		<tr class="export-header">
			<td colspan="{{ count($column_header)-1 }}">Subject : {{ $additional_information['subject_name'] }}</td>
		</tr>
	</table>

	<table class="report-data">
		<tr>
			<th>{{ $column_header['grade_level'] }}</th>
			<th>{{ $column_header['curriculum_category'] }}</th>
			<th>{{ $column_header['percent_completed'] }}</th>
		</tr>
		<?php $var = '' ?>
		@foreach($rows as $row)
			<tr>
				@if( $row->grade_name === $var)
					<td>{{ '' }}</td>
				@else
					<td>{{ $row->grade_name }}</td>
				@endif
				<?php $var = $row->grade_name ?>
					<td>
						@if(!is_null($row->icon_image))
							<img class="category-icon" src="{{$row->icon_image}}" />
						@else
							<img class="category-icon" src="{{ base_path().'/public/images/icons/default-module-icon.png' }}" />
						@endif
						{{ $row->name }}
					</td>
				@if($row->progress > 0)
					<td>{{ $row->progress }}</td>
				@else
					<td>{{ '' }}</td>

				@endif


			</tr>
		@endforeach

	</table>
</div>
@stop