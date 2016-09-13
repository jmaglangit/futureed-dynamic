<div class="panel-group col-xs-12 search-container" id="accordion">
    <div class="panel panel-default">
        <div id="detail_heading" class="panel-heading" data-toggle="collapse" data-parent="#accordion"
             href="#question_translation" aria-expanded="true" aria-controls="question_translation" close-others="true"
             ng-click="localization.translationActive(futureed.LOCALIZATION_QUESTION)">
            <h4 class="panel-title">
                {!! trans('messages.question') !!}

                <span class="pull-right">
                    <i class="fa" ng-class="{ 'fa-angle-double-up' : localization.active_loc_question,
                    'fa-angle-double-down' : !localization.active_loc_question }"></i>
                </span>
            </h4>
        </div>
        <div id="question_translation" class="panel-collapse collapse">
            <div class="panel-body">
                {{--translation activities--}}
                <p>Question translations</p>
            </div>

        </div>

    </div>

</div>