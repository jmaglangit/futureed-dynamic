<div id="delete_teacher_modal" ng-show="teacher.record.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            {!! trans('messages.client_delete_teacher') !!}
        </div>
        <div class="modal-body">
            {!! trans('messages.client_delete_teacher_msg') !!}
        </div>
        <div class="modal-footer">
        	<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
                {!! Form::button('trans('messages.yes')'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => 'teacher.delete()'
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}

                {!! Form::button('trans('messages.no')'
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