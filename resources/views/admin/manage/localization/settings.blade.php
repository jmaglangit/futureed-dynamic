@extends('admin.app')

@section('navbar')
    @include('admin.partials.main-nav')
@stop

@section('content')
    <div class="container dshbrd-con" ng-controller="ManageLocalizationController as localization"
         ng-controller="ManageLocalizationController as localization"
         ng-init="localization.setActive(futureed.LOCALIZATION_SETTING)" ng-cloak>

        <div template-directive template-url="{!! route('admin.partials.base_url') !!}"></div>

        <div class="wrapr" >
            <div class="client-nav side-nav">
                @include('admin.partials.dshbrd-side-nav')
            </div>

            <div class="client-content" template-directive template-url="{!! route('admin.manage.localization.settings.main') !!}"></div>

        </div>
    </div>
@stop

@section('scripts')
    {!! Html::script('/js/admin/controllers/manage_localization_controller.js') !!}
    {!! Html::script('/js/admin/services/manage_localization_service.js')!!}

    {!! Html::script('/js/common/search_service.js') !!}
    {!! Html::script('/js/common/table_service.js')!!}
    {!! Html::script('/js/common/FileSaver.min.js') !!}
@stop