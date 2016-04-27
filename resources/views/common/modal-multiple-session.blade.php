{{-- Modal for Multiple Sessions --}}
<div id="multiple_session" ng-show="multiple_session" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                Logged out
            </div>
            <div class="modal-body">
                This user is currently logged-in on another device.
            </div>
            <div class="modal-footer">
                <div class="col-md-8 col-md-offset-4 pull-left">
                    {!! Html::link($link, 'Ok'
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                        )
                    ) !!}
                </div>
            </div>
        </div>
    </div>
</div>