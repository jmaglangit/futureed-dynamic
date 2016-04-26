{{-- Modal for Inactive/Session Time Expired --}}
<div id="session_expire" ng-show="session_expire" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                Inactive
            </div>
            <div class="modal-body">
                You have been logged out due to inactivity. Please login again.
            </div>
            <div class="modal-footer">
                <div class="col-md-8 col-md-offset-4 pull-left">
                    {!! Html::link($link, 'Login'
                        , array(
                            'class' => 'btn btn-gold btn-medium'
                        )
                    ) !!}
                </div>
            </div>
        </div>
    </div>
</div>