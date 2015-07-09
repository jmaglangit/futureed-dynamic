@extends('student.app')

@section('navbar')
    @include('student.partials.main-nav')
@stop

@section('content')


<div id="error_class_modal" ng-show="no_class" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            No Class
        </div>
        <div class="modal-body">
            You do not belong to a class.
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('Back'
                    , array(
                        'class' => 'btn btn-gold btn-medium'
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}
        	</div>
        </div>
    </div>
  </div>
</div>
@stop

@section('scripts')

@stop