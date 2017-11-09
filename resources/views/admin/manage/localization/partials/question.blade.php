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
                <div class="accordion-inner">
                    {!! Form::open(array('class' => 'form-horizontal')) !!}
                    <div class="col-xs-12">
                        <fieldset>
                            {{--dropdowns--}}
                            <div class="form-group">
                                <label class="control-label col-xs-2">{!! trans('messages.language') !!}</label>
                                <div class="col-xs-3" ng-init="localization.getQuestionLanguages()">
                                    <select name="language_options"
                                            class="form-control"
                                            ng-change="localization.setButton(localization.question_locale_code, localization.question_field, 1)"
                                            ng-model="localization.question_locale_code"
                                            ng-options="lang.code as lang.word for lang in localization.question_languages">
                                        <option value="" ng-selected="selected">{!! trans('messages.select_language') !!}</option>
                                    </select>
                                </div>

                                <label class="control-label col-xs-2">{!! trans('messages.field') !!}</label>
                                <div class="col-xs-3" ng-init="localization.getTranslatableQuestionField()">
                                    <select name="module_field_options"
                                            class="form-control"
                                            ng-change="localization.setButton(localization.question_locale_code, localization.question_field, 1)"
                                            ng-model="localization.question_field"
                                            ng-options="field.field for field in localization.question_translated_field">
                                        <option value="" ng-selected="selected">{!! trans('messages.select_field') !!}</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="from-group">
                                <div class="btn-container col-xs-12">
                                    <div class="btn btn-blue btn-medium"
                                         ng-disabled="localization.question_is_disabled"
                                         ng-click="localization.questionGoogleTranslate()">
                                        {!! trans('messages.google_translate') !!}
                                    </div>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-success btn-medium active" ng-click="localization.questionActiveTag(futureed.TRUE)">
                                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Tag
                                        </label>
                                        <label class="btn btn-success btn-medium" ng-click="localization.questionActiveTag(futureed.FALSE)">
                                            <input type="radio" name="options" id="option2" autocomplete="off"> All
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>

    </div>

</div>