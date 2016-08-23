<div ng-if="localization.active_translation">
    <div class="content-title">
        <div class="title-main-content">
            <span>{!! trans_choice('messages.translation',1) !!}</span>
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

    <div class="panel-group col-xs-12 search-container" id="accordion">
        <div class="panel panel-default">
            <div id="detail_heading" class="panel-heading" data-toggle="collapse" data-parent="#accordion"
                 href="#module_translation" aria-expanded="true" aria-controls="module_translation" close-others="true">
                <h4 class="panel-title">
                   {!! trans_choice('messages.module',1) !!}

                    <span class="pull-right"><i class="fa fa-angle-double-down"></i></span>
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
                                        <div class="col-xs-4" ng-init="localization.getLanguages()">
                                            <select name="language_options" class="form-control"
                                                    ng-model="localization.locale_code"
                                                    ng-change="localization.setLocale()"
                                                    ng-options="lang.code as lang.word for lang in localization.languages">
                                                <option value="" ng-selected="selected">{!! trans('messages.select_language') !!}</option>
                                            </select>
                                        </div>
                                    </div>

                                </fieldset>
                                <fieldset>
                                    <div class="form-group">
                                        <div class="btn-container col-xs-12">
                                            <div class="btn btn-blue btn-medium" ng-click="localization.downloadTranslation()">{!! trans('messages.admin_download') !!}</div>
                                            <div class="btn btn-blue btn-medium" ngf-select ngf-change="localization.uploadTranslation($files)" accept="text/csv">
                                               {!! trans('messages.upload') !!}
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
</div>