<div class="panel-group col-xs-12 search-container" id="accordion">
    <div class="panel panel-default">
        <div id="detail_heading" class="panel-heading" data-toggle="collapse" data-parent="#accordion"
             href="#module_translation" aria-expanded="true" aria-controls="module_translation" close-others="true"
             ng-click="localization.translationActive(futureed.LOCALIZATION_MODULE)">
            <h4 class="panel-title">
                {!! trans_choice('messages.module',1) !!}

                <span class="pull-right">
                     <i class="fa" ng-class="{ 'fa-angle-double-up' : localization.active_loc_module,
                    'fa-angle-double-down' : !localization.active_loc_module }"></i>
                </span>
            </h4>
        </div>
        <div id="module_translation" class="panel-collapse collapse in">
            <div class="panel-body">
                <div class="accordion-inner">
                    {!! Form::open(array('class' => 'form-horizontal')) !!}
                    <div class="col-xs-12">
                        <fieldset>
                            <div class="form-group">
                                <label class="control-label col-xs-2">{!! trans('messages.language') !!}</label>
                                <div class="col-xs-3" ng-init="localization.getLanguages()">
                                    <select name="language_options" class="form-control"
                                            ng-model="localization.locale_code"
                                            ng-change="localization.setLocale()"
                                            ng-options="lang.code as lang.word for lang in localization.languages">
                                        <option value="" ng-selected="selected">{!! trans('messages.select_language') !!}</option>
                                    </select>
                                </div>

                                <label class="control-label col-xs-2">{!! trans('messages.field') !!}</label>
                                <div class="col-xs-3" ng-init="localization.getTranslatableModuleField()">
                                    <select name="module_field_options" class="form-control"
                                            ng-model="localization.module_field"
                                            ng-change="localization.setModuleField()"
                                            ng-options="field.field for field in localization.module_translated_field">
                                        <option value="" ng-selected="selected">{!! trans('messages.select_field') !!}</option>
                                    </select>
                                </div>
                            </div>

                        </fieldset>
                        <fieldset>
                            <div class="form-group">
                                <div class="btn-container col-xs-12">
                                    <div ng-show="!localization.module_google_translate" class="btn btn-blue btn-medium" ng-click="localization.downloadTranslation()">{!! trans('messages.admin_download') !!}</div>
                                    <div ng-show="!localization.module_google_translate" class="btn btn-blue btn-medium" ngf-select ngf-change="localization.uploadTranslation($files)" accept="text/csv">
                                        {!! trans('messages.upload') !!}
                                    </div>
                                    <div ng-show="localization.module_google_translate" class="btn btn-blue btn-medium" ngf-select ngf-change="localization.uploadTranslation($files)">
                                        {!! trans('messages.google_translate') !!}
                                    </div>
                                    <div ng-show="localization.module_google_translate" class="btn-group" data-toggle="buttons">
                                        <label class="btn btn-success btn-medium active">
                                            <input type="radio" name="options" id="option1" autocomplete="off" checked> Tag
                                        </label>
                                        <label class="btn btn-success btn-medium">
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