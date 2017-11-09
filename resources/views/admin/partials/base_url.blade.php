{!! Form::open(
	array(
		'id' => 'base_url_form'
	)
) !!}

	{!! Form::hidden('base_url', url()) !!}

{!! Form::close() !!}