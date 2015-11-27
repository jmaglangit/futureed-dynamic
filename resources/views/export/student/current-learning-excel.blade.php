@extends('export.student.index')

@section('content')
	<table>

		<tr><td></td>
			<td colspan="4" style="align: middle;">
				<img src="{{ base_path().'/public/images/logo-md.png' }}">
			</td>
		</tr>
		<tr></tr>
		<tr>
			<th valign="middle"><img src="{{ base_path().'/public/' . config('futureed.thumbnail') . '/'.$additional_information['avatar_thumbnail'] }}" alt=" "></th>
		</tr>
		<tr>
			<td>Student
				: {{ $additional_information['first_name'].' '.$additional_information['last_name'] }}</td>
		</tr>
		<tr>
			<td>Subject : {{ $additional_information['subject_name'] }}</td>
		</tr>
		{{-- Column Headers --}}
		<tr>
			<th style="width: 100px; text-align: center; border: 1px solid black;">{{ $column_header['grade_level'] }}</th>
			<th style="width: 100px; text-align: center; border: 1px solid black;" colspan="2">{{ $column_header['curriculum_category'] }}</th>
			<th style="width: 100px; text-align: center; border: 1px solid black;">{{ $column_header['percent_completed'] }}</th>
		</tr>
		<?php $var = '' ?>
		@foreach($rows as $row)
			<tr>
				@if( $row->grade_name === $var)
					<td style="text-align: center; border: 1px solid black;">{{ '' }}</td>
				@else
					<td style="text-align: center; border: 1px solid black;">{{ $row->grade_name }}</td>
				@endif

				<?php $var = $row->grade_name ?>
					<td style="text-align: center; border: 1px solid black;">
						@if(!is_null($row->icon_image))
							<img class="category-icon" src="{{$row->icon_image}}" width="30" />
						@else
							<img class="category-icon" src="{{ base_path().'/public/images/icons/default-module-icon.png' }}" width="30" />
						@endif
					</td>
					<td style="text-align: center; border: 1px solid black;">{{ $row->name }}</td>

				@if($row->progress > 0)
					<td style="text-align: center; border: 1px solid black;">{{ $row->progress }}</td>
				@else
					<td style="text-align: center; border: 1px solid black;">{{ '' }}</td>

				@endif


			</tr>
		@endforeach

	</table>
@stop