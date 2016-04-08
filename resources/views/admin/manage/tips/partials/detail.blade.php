<div ng-if="tips.active_view || tips.active_edit">
	<div class="col-xs-12 success-container" ng-if="tips.errors || tips.success">
		<div class="alert alert-error" ng-if="tips.errors">
			<p ng-repeat="error in tips.errors track by $index">
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="tips.success">
			<p>{! tips.success !}</p>
		</div>
	</div>
	
	<div class="search-container col-xs-12">
		{!! Form::open([
				'id' => 'add_admin_form',
				'class' => 'form-horizontal'
			]) 
		!!}
			<fieldset>
				<legend class="legend-name-mid">
					{!! trans('messages.admin_tip_details') !!}
				</legend>

				<div class="form-group">
					<div ng-if="tips.record.link_type != futureed.GENERAL">
						<label class="col-xs-2 control-label">{!! trans('messages.module') !!} <span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('username', '',
								[
									'placeholder' => trans('messages.module'),
									'ng-disabled' => 'true',
									'ng-model' => 'tips.record.module',
									'class' => 'form-control'
								]
							) !!}
						</div>
					</div>
					<label class="col-xs-2 control-label">{!! trans('messages.displayed_at') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::select('link_type'
							, array(
								'' => trans('messages.admin_select_type')
								, 'General' => trans('messages.general')
								, 'Content' => trans('messages.content')
								, 'Question' => trans('messages.question')
							)
							, ''
							, array(
								'class' => 'form-control'
								, 'ng-model' => 'tips.record.link_type'
								, 'ng-disabled' => 'tips.active_view'
								, 'ng-class' => "{ 'required-field' : tips.fields['link_type'] }"
							)
						) !!}
					</div>
				</div>
				<div class="form-group" ng-if="tips.record.link_type != futureed.GENERAL">
					<label class="col-xs-2 control-label">{!! trans('messages.subject') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('subject', '',
							[
								'placeholder' => trans('messages.subject'),
								'ng-disabled' => 'true',
								'ng-model' => 'tips.record.subject',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label">{!! trans('messages.area') !!} <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('area', '',
							[
								'placeholder' => trans('messages.area'),
								'ng-disabled' => 'true',
								'ng-model' => 'tips.record.area',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-2 control-label">{!! trans('messages.status') !!} <span class="required">*</span></label>
					<div class="col-xs-4" ng-if="tips.active_edit">
						<div class="col-xs-6 checkbox">	                				
							<label>
								{!! Form::radio('status'
									, 'Enabled'
									, true
									, array(
										'class' => 'field'
										, 'ng-model' => 'tips.record.status'
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
										, 'ng-model' => 'tips.record.status'
									)
								) !!}
							<span class="lbl padding-8">{!! trans('messages.disabled') !!}</span>
							</label>
						</div>
					</div>
					<div ng-if="tips.active_view">
						<label class="col-xs-4" ng-if="tips.record.status == 'Enabled'">
							<b class="success-icon">
								<i class="margin-top-8 fa fa-check-circle-o"></i> {! tips.record.status !}
							</b>
						</label>

						<label class="col-xs-4" ng-if="tips.record.status == 'Disabled'">
							<b class="error-icon">
								<i class="margin-top-8 fa fa-ban"></i> {! tips.record.status !}
							</b>
						</label>
					</div>

					<label class="col-xs-2 control-label">{!! trans('messages.admin_tip_status') !!} <span class="required">*</span></label>
					<div>
						<label class="col-xs-4" ng-if="tips.record.tip_status == futureed.ACCEPTED">
							<b class="success-icon">
								<i class="margin-top-8 fa fa-check-circle-o"></i> {! tips.record.tip_status !}
							</b>
						</label>

						<label class="col-xs-4" ng-if="tips.record.tip_status == futureed.PENDING">
							<b class="warning-icon">
								<i class="margin-top-8 fa fa-exclamation-circle"></i> {! tips.record.tip_status !}
							</b>
						</label>

						<label class="col-xs-4" ng-if="tips.record.tip_status == futureed.REJECTED">
							<b class="error-icon">
								<i class="margin-top-8 fa fa-ban"></i> {! tips.record.tip_status !}
							</b>
						</label>
					</div>
				</div>
				<div class="form-group" ng-if="tips.record.tip_status == futureed.ACCEPTED">
					<label class="control-label col-xs-2">{!! trans('messages.rating') !!}</label>
					<div class="col-xs-4 margin-top-5">
						<span ng-repeat="i in tips.record.stars track by $index">
							<img ng-src="{! $index+1 <= tips.record.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
						</span>
					</div>
				</div>
				<div class="form-group" ng-if="tips.record.rated_by != futureed.ADMIN && tips.active_view">
					<div class="btn-container col-xs-8 col-xs-offset-2">
						{!! Form::button(trans('messages.change_rating')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "tips.rateTip()"
								, 'ng-if' => 'tips.record.rating != futureed.NULL'
							)
						) !!}

						{!! Form::button('Accept'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "tips.rateTip()"
								, 'ng-if' => 'tips.record.rating == futureed.NULL'
							)
						) !!}

						{!! Form::button('Reject'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "tips.rejectTip()"
								, 'ng-if' => 'tips.record.rating == futureed.NULL'
							)
						) !!}
					</div>
				</div>
			</fieldset>
			<fieldset>
				<legend class="legend-name-mid">
					Tip Content
				</legend>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.title') !!} <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('title', '',
							[
								'class' => 'form-control'
								, 'ng-disabled' => 'tips.active_view'
								, 'ng-model' => 'tips.record.title'
								, 'placeholder' => trans('messages.title')
								, 'ng-class' => "{ 'required-field' : tips.fields['title'] }"
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.description') !!} <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::textarea('content','',
							[
								'class' => 'form-control disabled-textarea'
								, 'ng-disabled' => 'tips.active_view'
								, 'ng-model' => 'tips.record.content'
								, 'placeholder' => trans('messages.description')
								, 'ng-class' => "{ 'required-field' : tips.fields['content'] }"
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">{!! trans('messages.created_by') !!}:</label>
					<div class="col-xs-6">
						{!! Form::text('created_by','',
							[
								'class' => 'form-control'
								, 'ng-disabled' => 'true'
								, 'ng-model' => 'tips.record.name'
								, 'placeholder' => trans('messages.created_by')
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="tips.active_edit">
							{!! Form::button(trans('messages.save')
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => "tips.updateTip()"
								)
							) !!}

							{!! Form::button(trans('messages.cancel')
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => "tips.setActive(futureed.ACTIVE_VIEW, tips.record.id)"
								)
							) !!}
					</div>	
					<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="tips.active_view">
							{!! Form::button(trans('messages.edit')
								, array(
									'class' => 'btn btn-blue btn-medium'
									, 'ng-click' => "tips.setActive(futureed.ACTIVE_EDIT, tips.record.id)"
								)
							) !!}

							{!! Form::button(trans('messages.cancel')
								, array(
									'class' => 'btn btn-gold btn-medium'
									, 'ng-click' => "tips.setActive()"
								)
							) !!}		
					</div>
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>

	<div id="rate_tip" ng-show="tips.rate_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myMediumModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					{!! trans('messages.admin_rate_tip') !!}
				</div>
				<div class="modal-body">
					<div class="col-xs-12 search-container" ng-if="tips.rate_errors">
						<div class="alert alert-error" ng-if="tips.rate_errors">
							<p ng-repeat="error in tips.rate_errors track by $index">
								{! error !}
							</p>
						</div>
					</div>

					<div class="col-xs-12 table-container">
						<select class="form-control" ng-model="tips.rating">
							<option value="">{!! trans('messages.select_rate') !!}</option>
							<option ng-selected="tips.record.rating == $index+1" ng-repeat="i in tips.record.stars track by $index" ng-value="$index+1">{! $index+1 !}</option>
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<div class="btncon col-xs-8 col-xs-offset-4 pull-left">
						{!! Form::button(trans('messages.accept')
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'tips.acceptTip()'
							)
						) !!}
						{!! Form::button(trans('messages.cancel')
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