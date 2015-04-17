@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')

Heeeello {!! Session::get('user') !!}
  
@stop

@section('footer')

@overwrite

@section('scripts')

@stop