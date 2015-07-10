<div ng-if="module.active_view || module.active_edit">
    <div class="content-title">
        <div class="title-main-content">
            <span>View Module</span>
        </div>
    </div>

    <div class="panel-group module-container" id="accordion">
        <div class="panel panel-default">
            <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#module_detail" aria-expanded="true" aria-controls="module_detail">
                <h4 class="panel-title">
                    Module Details
                </h4>
            </div>

            <div id="module_detail" class="panel-collapse collapse in">
                <div class="panel-body">
                    {!! Form::open(array('id'=> 'add_module_form', 'class' => 'form-horizontal')) !!}
                        <div class="col-xs-12 form-content">
                            <div class="alert alert-error" ng-if="module.errors">
                                <p ng-repeat="error in module.errors track by $index" > 
                                    {! error !}
                                </p>
                            </div>

                            <div class="alert alert-success" ng-if="module.success">
                                <p>Successfully edit module.</p>
                            </div>
                            <fieldset>
                                <div class="form-group">
                                    <label class="control-label col-xs-2">Subject <span class="required">*</span></label>
                                    <div class="col-xs-4" ng-init="module.getSubject()">
                                        <select ng-disabled="!module.edit" name="subject_id" class="form-control" name="subject_id" ng-model="module.details.subject_id" ng-change="module.setSubject('edit')" ng-class="{'required-field' : module.fields['subject_id']}">
                                            <option ng-selected="module.details.subject.id == futureed.FALSE" value="">-- Select Subject --</option>
                                            <option ng-selected="module.details.subject.name == subject.name" ng-repeat="subject in module.subjects" ng-value="subject.id">{! subject.name!}</option>
                                        </select>
                                    </div>
                                    <label class="col-xs-2 control-label">Status <span class="required">*</span></label>
                                    <div class="col-xs-4" ng-if="module.active_edit">
                                        <div class="col-xs-6 checkbox">                                 
                                            <label>
                                                {!! Form::radio('status'
                                                    , 'Enabled'
                                                    , true
                                                    , array(
                                                        'class' => 'field'
                                                        , 'ng-model' => 'module.details.status'
                                                    ) 
                                                ) !!}
                                            <span class="lbl padding-8">Enabled</span>
                                            </label>
                                        </div>
                                        <div class="col-xs-6 checkbox">
                                            <label>
                                                {!! Form::radio('status'
                                                    , 'Disabled'
                                                    , false
                                                    , array(
                                                        'class' => 'field'
                                                        , 'ng-model' => 'module.details.status'
                                                    )
                                                ) !!}
                                            <span class="lbl padding-8">Disabled</span>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-4" ng-if="module.active_view">
                                        <label class="col-md-5" ng-if="module.details.status == 'Enabled'">
                                            <b class="success-icon">
                                                <i class="margin-top-8 fa fa-check-circle-o"></i> {! module.details.status !}
                                            </b>
                                        </label>

                                        <label class="col-md-5" ng-if="module.details.status == 'Disabled'">
                                            <b class="error-icon">
                                                <i class="margin-top-8 fa fa-ban"></i> {! module.details.status !}
                                            </b>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-2">Area <span class="required">*</span></label>
                                    <div class="col-xs-4">
                                        {!! Form::text('area',''
                                            , array(
                                                'placeHolder' => 'Area'
                                                , 'ng-model' => 'module.details.area'
                                                , 'ng-disabled' => '!module.area_field || !module.edit'
                                                , 'class' => 'form-control'
                                                , 'ng-change' => "module.searchArea('edit')"
                                                , 'ng-class' => "{ 'required-field' : module.fields['subject_area_id'] }"
                                                , 'ng-model-options' => "{ debounce : {'default' : 1000} }"
                                            )
                                        ) !!}
                                        <div class="angucomplete-holder" ng-if="module.areas">
                                            <ul class="col-md-6 angucomplete-dropdown">
                                                <li class="angucomplete-row" ng-repeat="area in module.areas" ng-click="module.selectArea(area)">
                                                    {! area.name !}
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="margin-top-8 center-err"> 
                                            <i ng-if="module.validation.s_loading" class="fa fa-spinner fa-spin"></i>
                                            <span ng-if="module.validation.s_error" class="error-msg-con">{! module.validation.s_error !}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-2">Module <span class="required">*</span></label>
                                    <div class="col-xs-4">
                                        {!! Form::text('module',''
                                            , array(
                                                'placeHolder' => 'Module'
                                                , 'ng-model' => 'module.details.name'
                                                , 'class' => 'form-control'
                                                , 'ng-disabled' => '!module.edit'
                                                , 'ng-class' => "{ 'required-field' : module.fields['name'] }"
                                            )
                                        ) !!}
                                    </div>
                                    <label class="control-label col-xs-3">Points to Unlock <span class="required">*</span></label>
                                    <div class="col-xs-3">
                                        {!! Form::text('points_to_unlock',''
                                            , array(
                                                'placeHolder' => 'Points to Unlock'
                                                , 'ng-model' => 'module.details.points_to_unlock'
                                                , 'class' => 'form-control'
                                                , 'ng-disabled' => '!module.edit'
                                                , 'ng-class' => "{ 'required-field' : module.fields['points_to_unlock'] }"
                                            )
                                        ) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-2">Description <span class="required">*</span></label>
                                    <div class="col-xs-4">
                                        {!! Form::textarea('description',''
                                            , array(
                                                'placeHolder' => 'Description'
                                                , 'ng-model' => 'module.details.description'
                                                , 'class' => 'form-control'
                                                , 'style' => 'resize:vertical'
                                                , 'ng-disabled' => '!module.edit'
                                                , 'ng-class' => "{ 'required-field' : module.fields['description'] }"
                                            )
                                        ) !!}
                                    </div>
                                    <label class="control-label col-xs-3">Points to Finish <span class="required">*</span></label>
                                    <div class="col-xs-3">
                                        {!! Form::text('points_to_finish',''
                                            , array(
                                                'placeHolder' => 'Points to Finish'
                                                , 'ng-model' => 'module.details.points_to_finish'
                                                , 'class' => 'form-control'
                                                , 'ng-disabled' => '!module.edit'
                                                , 'ng-class' => "{ 'required-field' : module.fields['points_to_finish'] }"
                                            )
                                        ) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-xs-3">Common Core Area <span class="required">*</span></label>
                                    <div class="col-xs-3">
                                        {!! Form::text('common_core_area',''
                                            , array(
                                                'placeHolder' => 'Common Core Area'
                                                , 'ng-model' => 'module.details.common_core_area'
                                                , 'class' => 'form-control'
                                                , 'ng-disabled' => '!module.edit'
                                                , 'ng-class' => "{ 'required-field' : module.fields['common_core_area'] }"
                                            )
                                        ) !!}
                                    </div>
                                    <label class="control-label col-xs-3">Common Core URL <span class="required">*</span></label>
                                    <div class="col-xs-3">
                                        {!! Form::text('common_core_url',''
                                            , array(
                                                'placeHolder' => 'Common Core URL'
                                                , 'ng-model' => 'module.details.common_core_url'
                                                , 'class' => 'form-control'
                                                , 'ng-disabled' => '!module.edit'
                                                , 'ng-class' => "{ 'required-field' : module.fields['common_core_url'] }"
                                            )
                                        ) !!}
                                    </div>
                                </div>
                            </fieldset>
                            <div class="col-xs-6 col-xs-offset-3">
                                <div class="btn-container">
                                    {!! Form::button('Save'
                                        , array(
                                            'class' => 'btn btn-blue btn-medium'
                                            , 'ng-if' => 'module.active_edit'
                                            , 'ng-click' => 'module.saveModule()'
                                        )
                                    ) !!}
                                    {!! Form::button('Edit'
                                        , array(
                                            'class' => 'btn btn-blue btn-medium'
                                            , 'ng-if' => 'module.active_view'
                                            , 'ng-click' => "module.setActive('edit', module.details.id)"
                                        )
                                    ) !!}

                                    {!! Form::button('Cancel'
                                        , array(
                                            'class' => 'btn btn-gold btn-medium'
                                            , 'ng-click' => 'module.setActive()'
                                            , 'ng-if' => 'module.active_view'
                                        )
                                    ) !!}
                                    {!! Form::button('Cancel'
                                        , array(
                                            'class' => 'btn btn-gold btn-medium'
                                            , 'ng-click' => "module.setActive('view', module.details.id)"
                                            , 'ng-if' => 'module.active_edit'
                                        )
                                    ) !!}
                                </div>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

        <div class="panel panel-default" ng-if="module.details.id && module.active_view">
            <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" href="#module_tabs" aria-expanded="true" aria-controls="module_tabs">
                <h4 class="panel-title">
                    Module Contents
                </h4>
            </div>

            <div id="module_tabs" class="panel-collapse collapse">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li role="presentation" class="tab active"><a href="#age_group" ng-click="module.setActiveContent(futureed.AGEGROUP)" aria-controls="home" data-toggle="tab">Age Group</a></li>
                        <li role="presentation" class="tab"><a href="#contents" ng-click="module.setActiveContent(futureed.CONTENTS)" aria-controls="profile" data-toggle="tab">Contents</a></li>
                        <li role="presentation" class="tab"><a href="#q_and_a" ng-click="module.setActiveContent(futureed.QANDA)" aria-controls="messages" data-toggle="tab">Q & A</a></li>
                    </ul>

                    <div class="tab-content row">
                        <div class="tab-pane fade in active" id="age_group">
                            <div ng-if="module.active_view" ng-controller="ManageAgeGroupController as age">
                                <div ng-init="age.setActive()" template-directive template-url="{!! route('admin.manage.age_group.partials.list_view_form') !!}"></div>

                                <div template-directive template-url="{!! route('admin.manage.age_group.partials.add_view_form') !!}"></div>
                                <div template-directive template-url="{!! route('admin.manage.age_group.partials.edit_view_form') !!}"></div>
                            </div>
                        </div>

                        <div ng-if="module.details.current_view == futureed.CONTENTS" ng-controller="ManageModuleContentController as content" class="tab-pane fade" ng-init="content.setModule(module.details)" id="contents">
                            <div ng-init="content.setActive()">
                                
                                <div template-directive template-url="{!! route('admin.manage.module.content.partials.list') !!}"></div>

                                <div template-directive template-url="{!! route('admin.manage.module.content.partials.add') !!}"></div>

                                <div template-directive template-url="{!! route('admin.manage.module.content.partials.detail') !!}"></div>

                                <div template-directive template-url="{!! route('admin.manage.module.content.partials.delete') !!}"></div>
                            </div>
                        </div>

                        <div ng-if="module.details.current_view == futureed.QANDA" ng-controller="ManageQuestionAnsController as qa" class="module-container tab-pane fade" ng-init="qa.setModule(module.details)" id="q_and_a">
                            <div ng-if="module.active_view" ng-init="qa.setActive()">
                                <div template-directive template-url="{!! route('admin.manage.question_answer.partials.question_list_form') !!}"></div>

                                <div template-directive template-url="{!! route('admin.manage.question_answer.partials.question_add_form') !!}"></div>

                                <div template-directive template-url="{!! route('admin.manage.question_answer.partials.question_view_form') !!}"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>