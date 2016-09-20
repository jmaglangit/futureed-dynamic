<div ng-if="localization.active_translation" ng-init="localization.translationActive(futureed.LOCALIZATION_MODULE)">
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

    {{--Transfer to partials for different translatables--}}
        <div template-directive template-url="{!! route('admin.manage.localization.translations.module') !!}"></div>

        <div template-directive template-url="{!! route('admin.manage.localization.translations.question') !!}"></div>

        <div template-directive template-url="{!! route('admin.manage.localization.translations.question-answer') !!}"></div>

        <div template-directive template-url="{!! route('admin.manage.localization.translations.answer-explanation') !!}"></div>

        <div template-directive template-url="{!! route('admin.manage.localization.translations.quote') !!}"></div>
</div>