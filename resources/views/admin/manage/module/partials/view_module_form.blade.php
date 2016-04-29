<div ng-if="module.active_view || module.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_view_module') !!}</span>
		</div>
	</div>

	<div class="panel-group search-container" id="accordion">
		<div class="panel panel-default">
			<div id="detail_heading" class="panel-heading" data-toggle="collapse" ng-click="module.toggleDetail()" data-parent="#accordion" href="#module_detail" aria-expanded="true" aria-controls="module_detail">
				<h4 class="panel-title">
					{!! trans('messages.admin_module_details') !!}

					<span class="pull-right"><i class="fa"
						ng-class="{ 'fa-angle-double-up' : module.detail_hidden,  'fa-angle-double-down' : !module.detail_hidden }"></i></span>
				</h4>
			</div>

			<div id="module_detail" class="panel-collapse collapse in">
				<div class="panel-body">
					<div class="col-xs-12" ng-if="module.errors || module.success">
						<div class="alert alert-error" ng-if="module.errors">
							<p ng-repeat="error in module.errors track by $index" > 
								{! error !}
							</p>
						</div>
						<div class="alert alert-success" ng-if="module.success">
							<p> {! module.success !} </p>
						</div>
					</div>

					{!! Form::open(array('class' => 'form-horizontal')) !!}
						<div class="col-xs-12">
							<fieldset>
								<div class="form-group">
									<label class="control-label col-xs-2">{!! trans('messages.subject') !!} <span class="required">*</span></label>
									<div class="col-xs-4" ng-init="module.getSubject()">
										<select ng-disabled="module.active_view" name="subject_id" class="form-control" name="subject_id" ng-model="module.record.subject_id" ng-change="module.setSubject()" ng-class="{'required-field' : module.fields['subject_id']}">
											<option ng-selected="module.record.subject.id == futureed.FALSE" value="">{!! trans('messages.select_subject') !!}</option>
											<option ng-selected="module.record.subject.name == subject.name" ng-repeat="subject in module.subjects" ng-value="subject.id">{! subject.name!}</option>
										</select>
									</div>
									
									<label class="col-xs-2 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
									<div class="col-xs-4" ng-if="module.active_edit">
										<div class="col-xs-6 checkbox">                                 
											<label>
												{!! Form::radio('status'
													, 'Enabled'
													, true
													, array(
														'class' => 'field'
														, 'ng-model' => 'module.record.status'
													) 
												) !!}
											<span class="lbl padding-8">{!! trans('messages.enabled') !!}</span>
											</label>
										</div>
										<div class="col-xs-6 checkbox">
											<label>
												{!! Form::radio('status'
													, 'Disabled'
													, false
													, array(
														'class' => 'field'
														, 'ng-model' => 'module.record.status'
													)
												) !!}
											<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
											</label>
										</div>
									</div>
									<div class="col-xs-3" ng-if="module.active_view">
										<label ng-if="module.record.status == 'Enabled'">
											<b class="success-icon">
												<i class="margin-top-8 fa fa-check-circle-o"></i> {! module.record.status !}
											</b>
										</label>

										<label ng-if="module.record.status == 'Disabled'">
											<b class="error-icon">
												<i class="margin-top-8 fa fa-ban"></i> {! module.record.status !}
											</b>
										</label>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-xs-2">{!! trans('messages.subject_area') !!} <span class="required">*</span></label>
									<div class="col-xs-4">
										{!! Form::text('area',''
											, array(
												'placeHolder' => trans('messages.subject_area')
												, 'ng-model' => 'module.record.area'
												, 'ng-disabled' => 'module.active_view'
												, 'class' => 'form-control'
												, 'ng-change' => "module.searchArea()"
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

									<div class="form-group" ng-if="module.active_edit">
										<label class="control-label col-xs-2">{!! trans('messages.image') !!}</label>
										<div class="col-xs-3">
											<div class="btn btn-blue" ngf-select ngf-change="module.upload($files, module.record)">{!! trans('messages.choose_image') !!}</div>
										</div>

										<div class="margin-top-8" ng-if="module.record.uploaded">
											<a href="" ng-click="module.removeImage(module.record)"><i class="fa fa-trash"></i></a>
										</div>
									</div>

									<div ng-if="module.active_view">
										<label class="col-xs-2 control-label">{!! trans('messages.image') !!} </label>
										<div class="col-xs-3" ng-if="module.record.icon_image != 'None'">
						                    <a href="javascript:void(0);" class="top-5" ng-click="module.viewImage(module.record)">{!! trans('messages.view_image') !!}</a>
										</div>

										<div class="col-xs-3" ng-if="module.record.icon_image == 'None'">
						                    <span class="upload-label label label-info">{! module.record.icon_image !}</span>
										</div>
									</div>
								</div>

								<div class="form-group" ng-if="module.active_edit && module.record.uploaded">
					                <div class="col-xs-6"></div>
					                <div class="col-xs-6">
										<div class="col-xs-2"></div>
										<span class="col-xs-5 upload-label label label-info">{!! trans('messages.image_uploaded') !!}</span>
										<a href="" class="control-label col-xs-5" ng-click="module.viewImage(module.record)">{!! trans('messages.view_image') !!}</a>
					                </div>
					            </div>

								<div class="form-group">
									<label class="control-label col-xs-2">{!! trans('messages.module') !!} <span class="required">*</span></label>
									<div class="col-xs-4">
										{!! Form::text('module',''
											, array(
												'placeHolder' => trans('messages.module')
												, 'ng-model' => 'module.record.name'
												, 'class' => 'form-control'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-class' => "{ 'required-field' : module.fields['name'] }"
											)
										) !!}
									</div>
									<label class="control-label col-xs-3">{!! trans('messages.admin_points_to_unlock') !!} <span class="required">*</span></label>
									<div class="col-xs-3">
										{!! Form::text('points_to_unlock',''
											, array(
												'placeHolder' => trans('messages.admin_points_to_unlock')
												, 'ng-model' => 'module.record.points_to_unlock'
												, 'class' => 'form-control'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-class' => "{ 'required-field' : module.fields['points_to_unlock'] }"
											)
										) !!}
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-xs-2">{!! trans('messages.description') !!} <span class="required">*</span></label>
									<div class="col-xs-4">
										{!! Form::textarea('description',''
											, array(
												'placeHolder' => trans('messages.description')
												, 'ng-model' => 'module.record.description'
												, 'class' => 'form-control disabled-textarea'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-class' => "{ 'required-field' : module.fields['description'] }"
												, 'rows' => '5'
											)
										) !!}
									</div>
									<label class="control-label col-xs-3">{!! trans('messages.admin_points_to_finish') !!} <span class="required">*</span></label>
									<div class="col-xs-3">
										{!! Form::text('points_to_finish',''
											, array(
												'placeHolder' => trans('messages.admin_points_to_finish')
												, 'ng-model' => 'module.record.points_to_finish'
												, 'class' => 'form-control'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-class' => "{ 'required-field' : module.fields['points_to_finish'] }"
											)
										) !!}
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-xs-3">{!! trans('messages.admin_common_core_area') !!} <span class="required">*</span></label>
									<div class="col-xs-3"></div>

									<label class="control-label col-xs-3">{!! trans('messages.admin_common_core_url') !!} <span class="required">*</span></label>
									<div class="col-xs-3"></div>
								</div>

								<div class="form-group">
									<div class="col-xs-1"></div>
									<div class="col-xs-5">
										{!! Form::text('common_core_area',''
											, array(
												'placeHolder' => trans('messages.admin_common_core_area')
												, 'ng-model' => 'module.record.common_core_area'
												, 'class' => 'form-control'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-class' => "{ 'required-field' : module.fields['common_core_area'] }"
											)
										) !!}
									</div>

									<div class="col-xs-1"></div>
									<div class="col-xs-5">
										{!! Form::text('common_core_url',''
											, array(
												'placeHolder' => trans('messages.admin_common_core_url')
												, 'ng-model' => 'module.record.common_core_url'
												, 'class' => 'form-control'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-class' => "{ 'required-field' : module.fields['common_core_url'] }"
											)
										) !!}
									</div>
								</div>
							</fieldset>

							<fieldset>
								<div class="form-group">
									<div class="btn-container col-xs-9 col-xs-offset-2">
										{!! Form::button(trans('messages.update')
											, array(
												'class' => 'btn btn-blue btn-medium'
												, 'ng-if' => 'module.active_edit'
												, 'ng-click' => 'module.update()'
											)
										) !!}

										{!! Form::button(trans('messages.edit')
											, array(
												'class' => 'btn btn-blue btn-medium'
												, 'ng-if' => 'module.active_view'
												, 'ng-click' => "module.setActive(futureed.ACTIVE_EDIT, module.record.id)"
											)
										) !!}

										{!! Form::button(trans('messages.cancel')
											, array(
												'class' => 'btn btn-gold btn-medium'
												, 'ng-click' => 'module.setActive()'
												, 'ng-if' => 'module.active_view'
											)
										) !!}

										{!! Form::button(trans('messages.cancel')
											, array(
												'class' => 'btn btn-gold btn-medium'
												, 'ng-click' => "module.setActive(futureed.ACTIVE_VIEW, module.record.id)"
												, 'ng-if' => 'module.active_edit'
											)
										) !!}
									</div>
								</div>
							</fieldset>
						</div>
					{!! Form::close() !!}
				</div>

				<div id="view_image_modal" ng-show="module.view_image.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
			        <div class="modal-dialog modal-lg">
			            <div class="modal-content">
			                <div class="modal-header">
			                    {! module.view_image.teaching_module !}
			                </div>
			                <div class="modal-body">
			                    <div class="modal-image">
			                        <img ng-src="{! module.view_image.image_path !}"/>
			                    </div>
			                </div>
			                <div class="modal-footer">
			                    <div class="btncon col-xs-8 col-xs-offset-4 pull-left">
			                        {!! Form::button(trans('messages.close')
			                            , array(
			                                'class' => 'btn btn-gold btn-medium'
			                                , 'data-dismiss' => 'modal'
			                            )
			                        ) !!}
			                    </div>
			                </div>
			            </div>
			        </div>
			    </div>
			</div>
		</div>

		<div class="panel panel-default" ng-if="module.record.id && module.active_view">
			<div id="content_heading" class="panel-heading" data-toggle="collapse" ng-click="module.toggleContent()" data-parent="#accordion" href="#module_tabs" aria-expanded="false" aria-controls="module_tabs">
				<h4 class="panel-title">
					{!! trans('messages.admin_module_content') !!}

					<span class="pull-right"><i class="fa"
						ng-class="{ 'fa-angle-double-up' : module.content_hidden,  'fa-angle-double-down' : !module.content_hidden }"></i></span>
				</h4>
			</div>

			<div id="module_tabs" class="panel-collapse collapse">
				<div class="panel-body">
					<ul class="nav nav-pills nav-admin">
						<li role="presentation" class="tab active"><a href="#age_group" ng-click="module.setActiveContent(futureed.AGEGROUP)" aria-controls="home" data-toggle="tab">{{ trans('messages.admin_age_group') }}</a></li>
						<li role="presentation" class="tab"><a href="#contents" ng-click="module.setActiveContent(futureed.CONTENTS)" aria-controls="profile" data-toggle="tab">{{ trans('messages.content') }}</a></li>
						<li role="presentation" class="tab"><a href="#q_and_a" ng-click="module.setActiveContent(futureed.QANDA)" aria-controls="messages" data-toggle="tab">{{ trans('messages.admin_q_and_a') }}</a></li>
					</ul>

					<div class="tab-content row">
						<div ng-if="module.record.current_view == futureed.AGEGROUP" ng-controller="ManageAgeGroupController as age" class="tab-pane fade in active" ng-init="age.setModule(module.record)" id="age_group">
							<div ng-init="age.setActive()">

								<div template-directive template-url="{!! route('admin.manage.age_group.partials.list_view_form') !!}"></div>

								<div template-directive template-url="{!! route('admin.manage.age_group.partials.add_view_form') !!}"></div>
								
								<div template-directive template-url="{!! route('admin.manage.age_group.partials.edit_view_form') !!}"></div>
							</div>
						</div>

						<div ng-if="module.record.current_view == futureed.CONTENTS" ng-controller="ManageModuleContentController as content" class="tab-pane fade" ng-init="content.setModule(module.record)" id="contents">
							<div ng-init="content.setActive()">
								
								<div template-directive template-url="{!! route('admin.manage.module.content.partials.list') !!}"></div>

								<div template-directive template-url="{!! route('admin.manage.module.content.partials.add') !!}"></div>

								<div template-directive template-url="{!! route('admin.manage.module.content.partials.detail') !!}"></div>

								<div template-directive template-url="{!! route('admin.manage.module.content.partials.delete') !!}"></div>
							</div>
						</div>

						<div ng-if="module.record.current_view == futureed.QANDA" ng-controller="ManageQuestionAnsController as qa" class="tab-pane fade" ng-init="qa.setModule(module.record)" id="q_and_a">
							<div ng-init="qa.setActive()">

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