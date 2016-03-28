<div id="delete_admin_modal" ng-show="admin.delete_confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            {!! trans('messages.admin_delete') !!}
        </div>
        <div class="modal-body">
            {!! trans('messages.admin_delete_confirm_msg') !!}
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('trans('messages.yes')'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => 'admin.deleteModeAdmin()'
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