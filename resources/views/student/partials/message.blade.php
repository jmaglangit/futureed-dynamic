<div id="message_rewards" ng-show="messages" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-body message-container modal-reward">
                <div class="h1"><span class="col-xs-12">{!! ucfirst(trans('messages.rewards_to_buy')) !!}</span></div>

                <div class="row modal-rewards-items">
                    <div class="col-xs-6">
                        <a ng-click="redirectRewards('{!! route('student.profile.index') !!}',futureed.AVATAR_ACCESSORY)" class="btn">
                            <img src="/images/shopping_bag.png">
                        </a>
                        <br>
                        <span class="h4">{!! trans('messages.accessories_for_avatar') !!}</span></div>
                    <div class="col-xs-6 reward-games">
                        <a ng-click="redirectRewards('{!! route('student.profile.index') !!}', futureed.GAMES)" class="btn">
                            <img src="/images/input_gaming.png">
                        </a>
                        <br>
                        <span class="h4">{!! trans_choice('messages.game',2) !!}</span>
                    </div>
                </div>
            </div>

            <div class="modal-footer modal-reward">
                <div class="btn btn-maroon btn-medium" data-dismiss="modal" aria-label="Close">{!! trans('messages.close') !!}</div>
            </div>
        </div>
    </div>

</div>
