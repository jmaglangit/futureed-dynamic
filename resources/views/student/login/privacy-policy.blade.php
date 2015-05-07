<div id="policy_modal" ng-show="show_policy" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            Data Privacy Policy
        </div>
        <div class="modal-body">
            Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam ut erat a erat vehicula pulvinar.
            Vivamus vitae justo consectetur, molestie justo ut, suscipit nibh. Pellentesque accumsan elit.
        </div>
        <div class="modal-footer">
        	<div class="btncon col-md-8 col-md-offset-4 pull-left">
                {!! Form::button('Close'
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