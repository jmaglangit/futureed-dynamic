{{--Games List--}}
<div ng-if="profile.active_games">
    <div class="col-md-12">
        <div class="form-class">
            <div class="clearfix">
                <ul class="nav navbar-nav">
                    <li class="nav-label">{!! trans('messages.points') !!}</li>
                    <li class="nav-points-rewards accessory-user-points">
                        {!! Html::image('/images/icons/icon-reward.png', ''
                            , array(
                                'class' => 'nav-icon-holder'
                            )
                        ) !!} <span>{! user.cash_points !}</span>
                    </li>
                </ul>
            </div>
            <div class="col-xs-12">
                <ul class="avatar_list list-unstyled list-inline" ng-init="profile.getGamesList()">
                    <li class="item game-box"
                        ng-repeat="game in profile.games_list"
                            {{--ng-class="{ 'accessory-bought' : accessory.is_bought }"--}}
                            >
                        <a href="{! game.game_image !}" alt="{! game.name !}" class="game-box-image">
                            <img ng-src="{! game.game_image !}">
                        </a>
                        <p>{! game.name !}</p>
                        <p>{! game.points_price !}</p>
                        {!! Form::button(trans('messages.buy')
                        , array(
                        'class' => 'btn btn-maroon btn-medium center-block'
                        , 'ng-click' => 'profile.confirmBuyGame(game.id)'
                        , 'ng-if' => '!game.student_game.length'
                        )
                        ) !!}
                        {!! Form::button(trans('messages.play')
                        , array(
                        'class' => 'btn btn-blue btn-medium center-block'
                        , 'ng-click' => 'profile.playGame(game.id); displayGameModal()'
                        , 'ng-if' => 'game.student_game.length'
                        )
                        ) !!}
                    </li>
                </ul>

            </div>
            <div class="pull-right" ng-if="profile.games_list.length">
                <pagination
                        total-items="profile.table.total_items"
                        ng-model="profile.table.page"
                        max-size="profile.table.paging_size"
                        items-per-page="profile.table.size"
                        previous-text = "&lt;"
                        next-text="&gt;"
                        class="pagination"
                        boundary-links="true"
                        ng-change="profile.paginateByPage()">
                </pagination>
            </div>
        </div>
    </div>
</div>

<div id="buy_game_modal" ng-show="profile.buy_game_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                {!! trans('messages.buy_game') !!}
            </div>
            <div class="modal-body center-date">
                <div class="alert alert-error" ng-if="profile.errors">
                    <p>
                        {! error !}
                    </p>
                </div>
                <div ng-if="!profile.errors">
                    <p>{!! trans('messages.are_you_sure_you_want_to_buy_game') !!}</p>
                </div>
            </div>
            <div class="modal-footer">
                <div class="btncon col-md-8 col-md-offset-4 pull-left">
                    {!! Form::button(trans('messages.buy')
                        , array(
                            'class' => 'btn btn-blue btn-medium'
                            , 'ng-click' => 'profile.buyGame(profile.buy_game_id)'
                        )
                    ) !!}

                    {!! Form::button(trans('messages.cancel_caps')
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