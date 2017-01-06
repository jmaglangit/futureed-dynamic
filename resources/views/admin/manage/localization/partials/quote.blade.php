<div class="panel-group col-xs-12 search-container" id="accordion">
    <div class="panel panel-default">
        <div id="detail_heading" class="panel-heading" data-toggle="collapse" data-parent="#accordion"
             href="#quote_translation" aria-expanded="true" aria-controls="quote_translation" close-others="true">
            <h4 class="panel-title">
                {!! trans_choice('messages.quote',1) !!}

                <span class="pull-right"><i class="fa fa-angle-double-down"></i></span>
            </h4>
        </div>
        <div id="quote_translation" class="panel-collapse collapse" >
            <div class="panel-body">
                {{--translation activities--}}
                <div class="accordion-inner">
                    {!! Form::open(array('class' => 'form-horizontal')) !!}
                    <div class="col-xs-12">
                        <fieldset>
                            {{--dropdowns--}}
                            <div class="form-group">
                                <label class="control-label col-xs-2">{!! trans('messages.language') !!}</label>
                                <div class="col-xs-3" ng-init="localization.getQuoteLanguages()">
                                    <select name="language_options" class="form-control"
                                            ng-model="localization.quote_locale_code"
                                            ng-change="localization.setButton(localization.quote_locale_code, localization.quote_field, 4)"
                                            ng-options="lang.code as lang.word for lang in localization.quote_languages">
                                        <option value="" ng-selected="selected">{!! trans('messages.select_language') !!}</option>
                                    </select>
                                </div>

                                <label class="control-label col-xs-2">{!! trans('messages.field') !!}</label>
                                <div class="col-xs-3" ng-init="localization.getTranslatableQuoteField()">
                                    <select name="module_field_options" class="form-control"
                                            ng-model="localization.quote_field"
                                            ng-change="localization.setButton(localization.quote_locale_code, localization.quote_field, 4)"
                                            ng-options="field.field for field in localization.quote_translated_field">
                                        <option value="" ng-selected="selected">{!! trans('messages.select_field') !!}</option>
                                    </select>
                                </div>
                            </div>
                        </fieldset>
                        <fieldset>
                            <div class="from-group">
                                <div class="btn-container col-xs-12">
                                    <div class="btn btn-blue btn-medium"
                                         ng-disabled="localization.quote_is_disabled"
                                         ng-click="localization.quoteGoogleTranslate()">
                                        {!! trans('messages.google_translate') !!}
                                    </div>
                                    <div class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-success btn-medium active" ng-click="localization.quoteActiveTag(futureed.TRUE)">
                                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Tag
                                        </label>
                                        <label class="btn btn-success btn-medium" ng-click="localization.quoteActiveTag(futureed.FALSE)">
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