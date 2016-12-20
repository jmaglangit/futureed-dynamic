<div id="play_game" ng-show="game_messages" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body message-container modal-reward">
                <div class="h1"><span class="col-xs-12">{!! trans_choice('messages.game',1) !!}</span></div>

                <div class="row">
                    <div class="h4">{!! trans('messages.game_time_message',
                    ['BUTTON' => '<b>' . strtoupper(trans('messages.play')) . '</b>', 'TIME' => config('futureed.game_time')]) !!} </div>
                    <div class="h3">{!! trans('messages.game_proceed') !!}</div>
                </div>
            </div>

            <div class="modal-footer modal-reward">
                {{--TODO: on Play, set timer and inform api --}}
                <div class="btn btn-maroon btn-medium" data-dismiss="modal" aria-label="Play"
                     ng-click="">{!! trans('messages.play') !!}</div>
                <div class="btn btn-maroon btn-medium" data-dismiss="modal" aria-label="Back"
                     ng-click="profile.setStudentProfileActive(futureed.GAMES)">{!! trans('messages.back') !!}</div>
            </div>
        </div>
    </div>

</div>