{{--dynamic active--}}

<div class="col-xs-12 search-container">
    {!! Form::open(['class' => 'form-horizontal']) !!}
    <fieldset>
        <legend class="legend-name-mid">
            {!! trans('messages.admin_module_details') !!}
        </legend>
        <div class="form-group">
            <label class="control-label col-xs-2">{!! trans_choice('messages.module', 1) !!} <span class="required">*</span></label>
            <div class="col-xs-4">
                {!! Form::text('module', '',
                    [
                        'placeholder' => trans_choice('messages.module', 1),
                        'ng-disabled' => 'true',
                        'ng-model' => 'module.record.name',
                        'class' => 'form-control'
                    ]
                ) !!}
            </div>
            <label class="control-label col-xs-2">{!! trans('messages.subject') !!} <span class="required">*</span></label>
            <div class="col-xs-4">
                {!! Form::text('subject', '',
                    [
                        'placeholder' => trans('messages.subject'),
                        'ng-disabled' => 'true',
                        'ng-model' => 'module.record.subject.name',
                        'class' => 'form-control'
                    ]
                ) !!}
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-2">{!! trans('messages.area') !!} <span class="required">*</span></label>
            <div class="col-xs-4">
                {!! Form::text('area', '',
                    [
                        'placeholder' => trans('messages.area'),
                        'ng-disabled' => 'true',
                        'ng-model' => 'module.record.subjectarea.name',
                        'class' => 'form-control'
                    ]
                ) !!}
            </div>
        </div>
    </fieldset>
    {!! Form::close() !!}
</div>
<div class="col-xs-12 search-container">
    {!! Form::open(['class' => 'form-horizontal']) !!}
    <fieldset>
        <legend class="legend-name-mid">
            {!! 'Question Template' !!}
        </legend>

        <div class="form-search">
            <div class="form-group">
                <div class="col-xs-4" ng-init="">
                    <select  name="question_type" class="form-control" ng-model="template.search.type">
                        <option value="">{!! trans('messages.admin_select_question_type') !!}</option>
                        {{--<option ng-repeat="style in content.styles" ng-value="style.id">{! style.name!}</option>--}}
                    </select>
                </div>

                <div class="col-xs-4" ng-init="">
                    <select  name="question_form" class="form-control" ng-model="template.search.question_form">
                        <option value="">{!! trans('messages.admin_select_question_form') !!}</option>
                        {{--<option ng-repeat="style in content.styles" ng-value="style.id">{! style.name!}</option>--}}
                    </select>
                </div>

                <div class="col-xs-4">
                    {!! Form::button(trans('messages.search')
                        ,array(
                            'class' => 'btn btn-blue'
                            , 'ng-click' => 'template.searchFnc($event)'
                        )
                    )!!}
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-4" ng-init="">
                    <select  name="question_operation" class="form-control" ng-model="template.search.operation">
                        <option value="">{!! trans('messages.admin_select_operation') !!}</option>
                        {{--<option ng-repeat="style in content.styles" ng-value="style.id">{! style.name!}</option>--}}
                    </select>
                </div>
                <div class="col-xs-4">
                    {!! Form::text('search_question_text', ''
                        ,array(
                            'placeholder' => trans('messages.admin_question_text')
                            , 'ng-model' => 'template.search.question_text'
                            , 'class' => 'form-control'
                        )
                    )!!}
                </div>
                <div class="col-xs-4">

                    {!! Form::button(trans('messages.clear')
                        ,array(
                            'class' => 'btn btn-gold'
                            , 'ng-click' => 'template.clearFnc($event)'
                        )
                    )!!}
                </div>
            </div>
        </div>
    </fieldset>


    {!! Form::close() !!}
</div>
<div class="col-xs-12">
    {!! Form::open(['class' => 'form-horizontal']) !!}

    <fieldset>
        <div class="col-xs-12 table-container" ng-init="template.list()">
            <div class="list-container"  ng-init="template.getModuleTemplates(module.record)" ng-cloak>
                <div class="col-xs-6 title-mid">
                    {!! trans('messages.admin_question_details') !!}
                </div>

                <div class="col-xs-6 size-container">
                    {!! Form::select('size'
                        , array(
                              '10' => '10'
                            , '20' => '20'
                            , '50' => '50'
                            , '100' => '100'
                        )
                        , '10'
                        , array(
                            'ng-model' => 'template.table.size'
                            , 'ng-change' => 'template.paginateBySize()'
                            , 'ng-if' => "template.records.length"
                            , 'class' => 'form-control paginate-size pull-right'
                        )
                    ) !!}
                </div>

                <table class="col-xs-12 table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th class="col-xs-1"><div class="checkbox">
                                <label class="template_checkbox"><input type="checkbox" name="template_checkbox_all" ng-model="template.checkbox_all" >{!! 'All' !!}</label>
                            </div></th>
                        <th>{!! 'Templates' !!}</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr ng-repeat="record in template.records track by $index">
                        <td class="template_checkbox"><input type="checkbox" ng-checked="template.checkbox_all || template.checkedTemplates(record.id,template.module_templates.records)" ng-model="template.checkbox_value[record.id]" ></td>
                        <td class="wide-column">{! record.question_template_format !}</td>
                    </tr>
                    <tr class="odd" ng-if="!template.records.length && !template.table.loading">
                        <td valign="top" colspan="7">
                            {!! trans('messages.no_records_found') !!}
                        </td>
                    </tr>
                    <tr class="odd" ng-if="template.table.loading">
                        <td valign="top" colspan="7">
                            {!! trans('messages.loading') !!}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="pull-right" ng-if="template.records.length">
                    <pagination
                            total-items="template.table.total_items"
                            ng-model="template.table.page"
                            max-size="3"
                            items-per-page="template.table.size"
                            previous-text = "&lt;"
                            next-text="&gt;"
                            class="pagination"
                            boundary-links="true"
                            ng-change="template.paginateByPage()">
                    </pagination>
                </div>
            </div>
        </div>
    </fieldset>
    <fieldset>
        <div class="form-group">
            {{-- TODO ADD selected and CLEAR selected --}}
            <div class="btn-container col-xs-9 col-xs-offset-2">
                {!! Form::button(trans('messages.add')
                    ,array(
                        'class' => 'btn btn-blue btn-medium'
                        , 'ng-click' => 'template.addSelectedTemplates(module.record)'
                    )
                )!!}
                {!! Form::button(trans('messages.clear')
                    ,array(
                        'class' => 'btn btn-gold btn-medium'
                        , 'ng-click' => 'template.unSelectQuestionTemplate()'
                    )
                )!!}
            </div>
        </div>
    </fieldset>
    {!! Form::close() !!}

</div>


