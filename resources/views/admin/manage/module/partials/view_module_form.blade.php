<div ng-if="module.active_view || module.active_edit">
	<div class="content-title">
		<div class="title-main-content">
			<span>{!! trans('messages.admin_view_module') !!}</span>
		</div>
	</div>

	<div class="panel-group search-container-view" id="accordion">
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

									<label class="col-xs-2 col_radio_label control-label ">{!! trans('messages.status') !!} <span class="required">*</span></label>
									<div class="col-xs-4 col_radio_fields" ng-if="module.active_edit">
										<div class="col-xs-6 checkbox mod_radio_fields">
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
										<div class="col-xs-6 checkbox mod_radio_fields">
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
										<div class="center-err">
											<i ng-if="module.validation.s_loading" class="fa fa-spinner fa-spin"></i>
											<span ng-if="module.validation.s_error" class="error-msg-con">{! module.validation.s_error !}</span>
										</div>
									</div>

									<label class="control-label col_radio_label col-xs-2 ">{!! trans('messages.dynamic') !!} <span class="required">*</span></label>
									<!-- <div class="col-xs-4">
										<select  ng-disabled="module.active_view" name="is_dynamic" class="form-control"
												 ng-model="module.record.is_dynamic">
											<option ng-selected="module.record.is_dynamic == ''" value="">{!! trans('messages.select') !!}</option>
											<option ng-selected="module.record.is_dynamic == futureed.TRUE" value="1">{!! trans('messages.yes') !!}</option>
											<option ng-selected="module.record.is_dynamic == futureed.FALSE" value="0">{!! trans('messages.no') !!}</option>
										</select>
									</div> -->
									<div class="col-xs-4 col_radio_fields" ng-if="module.active_edit">
										<div class="col-xs-6 checkbox mod_radio_fields">
											<label>
												{!! Form::radio('is_dynamic'
													, 1
													, true
													, array(
														'class' => 'field'
														, 'ng-model' => 'module.record.is_dynamic'
													)
												) !!}
												<span class="lbl padding-8">{!! trans('messages.yes') !!}</span>
											</label>
										</div>
										<div class="col-xs-6 checkbox mod_radio_fields">
											<label>
												{!! Form::radio('is_dynamic'
													, 0
													, false
													, array(
														'class' => 'field'
														, 'ng-model' => 'module.record.is_dynamic'
													)
												) !!}
												<span class="lbl padding-8">{!! trans('messages.no') !!}</span>
											</label>
										</div>
									</div>

									<div class="col-xs-3" ng-if="module.active_view">
										<label ng-if="module.record.is_dynamic == futureed.TRUE">
											<b class="success-icon">
												<i class="margin-top-8 fa fa-check-circle-o"></i> {!! trans('messages.yes') !!}
											</b>
										</label>

										<label ng-if="module.record.is_dynamic == futureed.FALSE">
											<b class="error-icon">
												<i class="margin-top-8 fa fa-ban"></i> {!! trans('messages.no') !!}
											</b>
										</label>
									</div>
								</div>

								<div class="form-group">
									<label class="control-label col-xs-2">{!! trans_choice('messages.module', 1) !!} <span class="required">*</span></label>
									<div class="col-xs-4">
										{!! Form::text('module',''
											, array(
												'placeHolder' => trans_choice('messages.module', 1)
												, 'ng-model' => 'module.record.name'
												, 'class' => 'form-control'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-class' => "{ 'required-field' : module.fields['name'] }"
											)
										) !!}
									</div>
									<label class="control-label col_radio_label col-xs-2">{!! trans('messages.has_difficulty') !!} <span class="required">*</span></label>
									<!-- <div class="col-xs-3 m-top-20">
										<select ng-disabled="module.active_view" name="has_difficulty" class="form-control"
												ng-model="module.record.no_difficulty">
											<option ng-selected="module.record.is_dynamic == ''" value="">{!! trans('messages.select') !!}</option>
											<option ng-selected="module.record.is_dynamic == futureed.FALSE" value="0">{!! trans('messages.yes') !!}</option>
											<option ng-selected="module.record.is_dynamic == futureed.TRUE" value="1">{!! trans('messages.no') !!}</option>
										</select>
									</div> -->
									<div class="col-xs-4 col_radio_fields" ng-if="module.active_edit">
										<div class="col-xs-6 checkbox mod_radio_fields">
											<label>
												{!! Form::radio('no_difficulty'
													, 1
													, true
													, array(
														'class' => 'field'
														, 'ng-model' => 'module.record.no_difficulty'
													)
												) !!}
												<span class="lbl padding-8">{!! trans('messages.yes') !!}</span>
											</label>
										</div>
										<div class="col-xs-6 checkbox mod_radio_fields">
											<label>
												{!! Form::radio('no_difficulty'
													, 0
													, false
													, array(
														'class' => 'field'
														, 'ng-model' => 'module.record.no_difficulty'
													)
												) !!}
												<span class="lbl padding-8">{!! trans('messages.no') !!}</span>
											</label>
										</div>
									</div>
									<div class="col-xs-3" ng-if="module.active_view">
										<label ng-if="module.record.no_difficulty == futureed.TRUE">
											<b class="success-icon">
												<i class="margin-top-8 fa fa-check-circle-o"></i> {!! trans('messages.yes') !!}
											</b>
										</label>

										<label ng-if="module.record.no_difficulty == futureed.FALSE">
											<b class="error-icon">
												<i class="margin-top-8 fa fa-ban"></i> {!! trans('messages.no') !!}
											</b>
										</label>
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
												, 'rows' => '6'
											)
										) !!}
									</div>
									<label class="col-xs-2 col_radio_label control-label ">{!! trans('messages.translatable') !!} <span class="required">*</span></label>
									<div class="col-xs-4 col_radio_fields" ng-if="module.active_edit">
										<div class="col-xs-6 checkbox mod_radio_fields">
											<label>
												{!! Form::radio('yes'
													, 1
													, true
													, array(
														'class' => 'field'
														, 'ng-model' => 'module.record.translatable'
														, 'checked' => 'checked'
													)
												) !!}
												<span class="lbl padding-8">{!! trans('messages.yes') !!}</span>
											</label>
										</div>
										<div class="col-xs-6 checkbox mod_radio_fields">
											<label>
												{!! Form::radio('no'
													, 0
													, false
													, array(
														'class' => 'field'
														, 'ng-model' => 'module.record.translatable'
														, 'checked' => 'module.record.translatable'
													)
												) !!}
												<span class="lbl padding-8">{!! trans('messages.no') !!}</span>
											</label>
										</div>
									</div>
									<div class="col-xs-3" ng-if="module.active_view">
										<label ng-if="module.record.translatable == futureed.TRUE">
											<b class="success-icon">
												<i class="margin-top-8 fa fa-check-circle-o"></i> {!! trans('messages.yes') !!}
											</b>
										</label>

										<label ng-if="module.record.translatable == futureed.FALSE">
											<b class="error-icon">
												<i class="margin-top-8 fa fa-ban"></i> {!! trans('messages.no') !!}
											</b>
										</label>
									</div>
									<div class="col-xs-6 control-label"></div>

									<label class="control-label col_radio_label col-xs-2 ">{!! trans('messages.admin_points_to_unlock') !!} <span class="required">*</span></label>
									<div class="col-xs-3 col_radio_fields">
										{!! Form::text('points_to_unlock',''
											, array(
												'placeHolder' => trans('messages.admin_points_to_unlock')
												, 'ng-model' => 'module.record.points_to_unlock'
												, 'class' => 'form-control'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-maxlength' => '4'
												, 'ng-click' => 'module.validateMaxLength()'
												, 'ng-class' => "{ 'required-field' : module.fields['points_to_unlock'] }"
											)
										) !!}
									</div>
									<div class="col-xs-6 control-label"></div>
									<label class="control-label col_radio_label col-xs-2 m-top-10">{!! trans('messages.admin_points_to_finish') !!} <span class="required">*</span></label>
									<div class="col-xs-3 col_radio_fields m-top-10">
										{!! Form::text('points_to_finish',''
											, array(
												'placeHolder' => trans('messages.admin_points_to_finish')
												, 'ng-model' => 'module.record.points_to_finish'
												, 'class' => 'form-control'
												, 'ng-disabled' => 'module.active_view'
												, 'ng-maxlength' => '4'
												, 'ng-click' => 'module.validateMaxLength()'
												, 'ng-class' => "{ 'required-field' : module.fields['points_to_finish'] }"
											)
										) !!}
									</div>
								</div>
								<div class="form-group">
									<div ng-if="module.active_edit">
										<label class="control-label col-xs-2">{!! trans('messages.image') !!}</label>
										<div class="col-xs-3" ng-if="module.record.icon_image == 'None' && !module.record.uploaded">
											<div class="btn btn-blue" ngf-select ngf-change="module.upload($files, module.record)">{!! trans('messages.choose_image') !!}</div>
										</div>
									</div>
									<div class="form-group" ng-if="module.active_edit && module.record.uploaded || module.active_edit && module.record.icon_image != 'None'">
						                <div class="col-xs-6">
											<!-- <div class="col-xs-2"></div> -->
											<!-- <span class="col-xs-5 upload-label label label-info">{!! trans('messages.image_uploaded') !!}</span> -->
											<a href="" class="control-label col-xs-1" style="right:14px;" ng-click="module.viewImage(module.record)">{!! trans('messages.view') !!}</a>
											<a href="" class="control-label col-xs-1" style="left:-5px;" ng-click="module.removeImage(module.record)"><i class="fa fa-trash"></i></a>
											<div class="col-xs-6" style="right:15px;">
												<div class="btn btn-blue" ngf-select ngf-change="module.upload($files, module.record)">{!! trans('messages.change_image') !!}</div>
											</div>
						                </div>
						            </div>

									<div ng-if="module.active_view">
										<label class="col-xs-2 control-label">{!! trans('messages.image') !!} </label>
										<div class="col-xs-3" ng-if="module.record.icon_image != 'None'">
											<a href="javascript:void(0);" class="top-5" ng-click="module.viewImage(module.record)">{!! trans('messages.view') !!}</a>
										</div>

										<div class="col-xs-1 control-label" ng-if="module.record.icon_image == 'None'">
											<span class="upload-label label label-info">{! module.record.icon_image !}</span>
										</div>
									</div>
								</div>
								<div class="form-group">
									<label class="control-label col-xs-3">{!! trans('messages.admin_common_core_area') !!}</label>
									<div class="col-xs-3"></div>

									<label class="control-label col-xs-3">{!! trans('messages.admin_common_core_url') !!}</label>
									<div class="col-xs-3"></div>
								</div>

								<div class="form-group">
									<!-- <div class="col-xs-1"></div> -->
									<div class="col-xs-6">
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

									<!-- <div class="col-xs-1"></div> -->
									<div class="col-xs-6">
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

								<div class="form-group">
									<label class="col-xs-3 control-label">{!! 'Curriculum Country' !!} <span class="required">*</span></label>
								</div>
								<div class="form-group" ng-if="module.curr_country_fields">
									<span style="margin-left:40px;" class="control-label alert alert-error">{! module.curr_country_fields !}</span>
								</div>
								<div id="curr_country_fields" class="form-group" ng-init="module.packageCountries();getGrades()">
									<div class="col-xs-3 padding-right-10"  ng-if="module.active_edit">
										{{--drop down and seq no text--}}
										<select  name="curr_country" class="form-control" name="curr_country"
												 ng-model="module.curr_country"
												 ng-change="getGradeLevel(module.curr_country)">
											<option value="">{!! trans('messages.select_country') !!}</option>
											<option ng-repeat="curr in module.curriculum_country" ng-value="curr.country.id"
													ng-show="module.checkCountryList(curr.country.id) == futureed.TRUE">{! curr.country.name !}</option>
										</select>
									</div>
									<div class="col-xs-3 padding-right-10"  ng-if="module.active_edit">
										{!! Form::text('curr_seq_no',''
                                            , array(
                                                'placeHolder' => 'Sequence'
                                                , 'ng-model' => 'module.curr_seq_no'
                                                , 'class' => 'form-control'
                                            )
                                        ) !!}
									</div>
									<div class="col-xs-3 padding-right-10"  ng-if="module.active_edit">
										{{--drop down and seq no text--}}
										<select  name="curr_grade" class="form-control" name="curr_grade"
												 ng-model="module.curr_grade">
											<option value="">{!! trans('messages.select_level') !!}</option>
											<option ng-repeat="grade in grades" ng-value="grade.id">{! grade.name !}</option>
										</select>
									</div>
									<div class="col-xs-3"  ng-if="module.active_edit">
										<div class="btn btn-blue col-xs-2"
											 ng-click="module.addCurriculumCountry(module.curr_country,module.curr_seq_no,module.curr_grade);module.curr_country='';module.curr_seq_no='';module.curr_grade='';"
												>{!! trans('messages.add_curriculum') !!}</div>
									</div>

								</div>
								<div class="form-group">
									{{--list file with x to remove--}}
									<div class="col-xs-12">
										<table class="table table-striped table-bordered">
											<thead>
											<th>{!! trans('messages.curriculum_country') !!}</th>
											<th>{!! trans('messages.sequence_no') !!}</th>
											<th>{!! trans('messages.level') !!}</th>
											<th class="col-xs-4 h5" ng-if="!module.active_view">{!! trans('messages.level') !!}</th>
											</thead>
											<tbody>
											{{--country and sequence selected--}}
											<tr ng-repeat="curr in module.curr_country_list">
												{{--curriculum country--}}
												<td>{! module.getCountryName(curr.country_id) !}</td>
												{{--sequence no--}}
												<td>{! curr.seq_no !}</td>
												{{--Grade Level--}}
												<td>{! module.getGrade(curr.grade_id) !}</td>
												{{--remove--}}
												<td ng-click="module.removeCurriculumCountry(curr.country_id)"  ng-if="module.active_edit"><a>{!! trans('messages.remove') !!}</a></td>
											</tr>
											<tr class="odd" ng-if="!module.curr_country_list.length && !module.table.loading">
												<td valign="top" colspan="7">
													{!! trans('messages.no_records_found') !!}
												</td>
											</tr>
											</tbody>
										</table>
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
												, 'ng-click' => 'module.setActive(futureed.HIDE_MODULE)'
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

						<div ng-if="module.record.current_view == futureed.QANDA" class="tab-pane fade" id="q_and_a">
							<div ng-if="!module.record.is_dynamic" ng-controller="ManageQuestionAnsController as qa" ng-init="qa.setModule(module.record);qa.setActive()">

								<div template-directive template-url="{!! route('admin.manage.question_answer.partials.question_list_form') !!}"></div>

								<div template-directive template-url="{!! route('admin.manage.question_answer.partials.question_add_form') !!}"></div>

								<div template-directive template-url="{!! route('admin.manage.question_answer.partials.question_view_form') !!}"></div>
							</div>
							{{-- insert adding dynamic question--}}
							<div ng-if="module.record.is_dynamic" ng-controller="ManageQuestionTempController as template" ng-init="template.setActive()">
								<div template-directive template-url="{!! route('admin.manage.module.partials.dynamic_setup') !!}"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>