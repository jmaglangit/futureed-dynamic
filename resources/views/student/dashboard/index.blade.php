@extends('student.app')

@section('content')

Heeeello {!! Session::get('user') !!}
  
@stop

@section('footer')

@overwrite

@section('scripts')

@stop