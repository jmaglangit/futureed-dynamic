@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')
    <div class="row">
        <div class="col-xs-12 class-container">
            <h3 class="alert alert-danger">You have no available subjects.</h3>
            
            <div class="no-record-label">    
                <p>You need a Teacher to add you to a Class. </p>
                <p>or</p>
                <p>You can have your Parent buy you a subscription. </p>
                <p ng-if="user.age > 13">or</p>
                <p ng-if="user.age > 13">You can proceed to <a href="{!! route('student.payment.index') !!}">student payment</a> page.</p>
            </div>
        </div>
    </div>
@stop

@section('scripts')

@stop