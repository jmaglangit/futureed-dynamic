<div ng-if="profile.active_play_game">
    <div class="col-md-12">
        <div class="form-class">
            {{-- TODO: pop-up modal--}}
            {{-- TODO: display timer--}}
            <div class="pull-right h3">Game Time Left : <span id="countdown" class="countdown">00:00</span></div>
            <iframe class="play-game-box" src="{! profile.selected_game.game_url !}" ></iframe>
        </div>
    </div>
</div>
