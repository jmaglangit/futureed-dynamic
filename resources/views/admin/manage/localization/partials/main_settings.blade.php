<div ng-if="localization.active_setting">
    <div class="content-title">
        <div class="title-main-content">
            <span>{!! trans('messages.translation_settings') !!}</span>
        </div>
    </div>
    <div class="col-xs-12 search-container" ng-show="localization.errors || localization.success">
        <div class="alert alert-error" ng-if="localization.errors">
            <p ng-repeat="error in localization.errors track by $index">
                {! error !}
            </p>
        </div>
        <div class="alert alert-success" ng-if="localization.success">
            <p>{! localization.success !}</p>
        </div>
    </div>
    <div class="col-xs-12 search-container">
        <div class="title-mid">{!! trans('messages.initialize_language') !!}</div>
        <div class="form-group">
            <label class="col-xs-2 h5">{!! trans('messages.language') !!}</label>

            <div class="col-xs-4" ng-init="localization.getAllLanguages()">
                <select name="language_options" class="form-control"
                        ng-model="localization.locale_code"
                        ng-change="localization.setLocale()"
                        ng-options="lang.code as lang.word for lang in localization.all_languages">
                    <option value="" ng-selected="selected">{!! trans('messages.select_language') !!}</option>
                </select>
            </div>
            <div class="btn btn-blue btn-small" ng-click="localization.initializeTranslation()">{!! trans('messages.initialize') !!}</div>
        </div>
    </div>
</div>