<div id="play_game" ng-show="game_messages" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body message-container modal-reward">
                <div class="h1" ng-if="!time_up"><span class="col-xs-12">{!! trans_choice('messages.game',1) !!}</span></div>
                <div class="h1" ng-if="time_up">
                    <span class="col-xs-12">{!! trans_choice('messages.game_lock',1) !!}</span></div>

                <div ng-if="!profile.errors" class="row">
                    <div class="h4">{!! trans('messages.game_time_message',
                    ['BUTTON' => '<b>' . strtoupper(trans('messages.play')) . '</b>']) !!} {! profile.allowedTime(profile.student_game_time.countdown_time_played) !}</div>
                    <div class="h3">{!! trans('messages.game_proceed') !!}</div>
                </div>
                <div ng-if="profile.errors" class="row">
                    <div ng-repeat="error in profile.errors" class="h3">
                        {! error !}
                    </div>
                </div>

            </div>

            <div class="modal-footer modal-reward">
                {{--TODO: on Play, set timer and inform api --}}
                <div class="btn btn-green btn-medium" aria-label="Play"
                     ng-if="!profile.errors"
                     ng-click="profile.countdownTimer(profile.student_game_time.countdown_time_played);">{!! trans('messages.play') !!}</div>
                <div class="btn btn-gray btn-medium" data-dismiss="modal" aria-label="Back"
                     ng-click="profile.setStudentProfileActive(futureed.GAMES)">{!! trans('messages.back') !!}</div>
            </div>
        </div>
    </div>

</div>