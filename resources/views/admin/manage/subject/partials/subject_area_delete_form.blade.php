<div id="delete_subject_area_modal" ng-show="area.record.confirm" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            Delete Subject Area
        </div>
        <div class="modal-body">
            Are you sure you want to delete this subject area?
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('Yes'
                    , array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => 'area.delete()'
                        , 'data-dismiss' => 'modal'
                    )
                ) !!}

                {!! Form::button('No'
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