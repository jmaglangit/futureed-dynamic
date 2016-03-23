<div class="row module-container" ng-if="answer.active_view || answer.active_edit">
	<div class="title-mid">
		<span>{!! trans('messages.help_request_answer_details') !!}</span>		
	</div>

	<div class="form-content col-xs-12">
		{!! Form::open(
			array(
				'id' => 'tip_detail_form'
				, 'class' => 'form-horizontal'
			)
		) !!}
		<div class="alert alert-error" ng-if="answer.errors">
			<p ng-repeat="error in answer.errors track by $index" > 
				{! error !}
			</p>
		</div>

		<div class="alert alert-success" ng-if="answer.success">
			<p>{! answer.success !}</p>
		</div>

		<fieldset>
			<div class="form-group" ng-if="answer.record.link_type != futureed.GENERAL && answer.record.subject">
				<label class="control-label col-xs-3">{!! trans('messages.subject') !!}</label>
				<div class="col-md-5">
					{!! Form::text('subject', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'answer.record.subject'
							, 'placeholder' => 'trans('messages.subject')'
						)
					) !!}
				</div>
			</div>
			<div class="form-group" ng-if="answer.record.link_type != futureed.GENERAL && answer.record.subject_area">
				<label class="control-label col-xs-3">{!! trans('messages.subject_area') !!}</label>
				<div class="col-md-5">
					{!! Form::text('subject', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'answer.record.subject_area'
							, 'placeholder' => 'trans('messages.subject_area')'
						)
					) !!}
				</div>
			</div>
			<div class="form-group" ng-if="answer.record.link_type != futureed.GENERAL && answer.record.module">
				<label class="control-label col-xs-3">{!! trans('messages.module') !!}</label>
				<div class="col-md-5">
					{!! Form::text('subject', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'answer.record.module'
							, 'placeholder' => 'trans('messages.module')'
						)
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.title') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::text('title', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'answer.record.title'
							, 'placeholder' => 'trans('messages.title')'
						)
					) !!}
				</div>
			</div>
			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.answer') !!} <span class="required">*</span></label>
				<div class="col-xs-5">
					{!! Form::textarea('search_content', ''
						, array(
							'ng-disabled'=>'answer.active_view'
							, 'class' => 'form-control disabled-textarea'
							, 'ng-class' => "{ 'required-field' : answer.fields['content'] }"
							, 'ng-model' => 'answer.record.content'
							, 'placeholder' => 'trans('messages.answer')'
						)
					) !!}
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.date_created') !!}</label>
				<div class="col-xs-5">
					<input type="text" ng-disabled="true" class="form-control" placeholder="Date Created" 
						value="{! answer.record.created_at | ddMMyy : '-' !}" />
				</div>
			</div>

			<div class="form-group">
				<label class="control-label col-xs-3">{!! trans('messages.created_by') !!}</span></label>
				<div class="col-xs-5">
					{!! Form::text('search_name', ''
						, array(
							'ng-disabled'=>'true'
							, 'class' => 'form-control'
							, 'ng-model' => 'answer.record.created_by'
							, 'placeholder' => 'trans('messages.created_by')'
						)
					) !!}
				</div>
			</div>
			<div class="form-group" ng-if="answer.active_view && answer.record.request_answer_status == futureed.PENDING">
				<div class="btn-container col-xs-8 col-xs-offset-1">
					{!! Form::button('trans('messages.approve')'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "answer.rateAnswer()"
						)
					) !!}
					{!! Form::button('trans('messages.reject')'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "answer.updateStatus(answer.record.id, futureed.FALSE)"
						)
					) !!}
				</div>
			</div>

			<div class="form-group" ng-if="answer.active_view">
				<div class="btn-container col-xs-8 col-xs-offset-1">
					{!! Form::button('trans('messages.edit')'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "answer.setActive(futureed.ACTIVE_EDIT, answer.record.id)"
						)
					) !!}
					{!! Form::button('trans('messages.cancel')'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "answer.setActive(futureed.ACTIVE_LIST)"
						)
					) !!}
				</div>
			</div>

			<div class="form-group" ng-if="answer.active_edit">
				<div class="btn-container col-xs-8 col-xs-offset-1">
					{!! Form::button('trans('messages.save')'
						, array(
							'class' => 'btn btn-blue btn-medium'
							, 'ng-click' => "answer.update()"
						)
					) !!}
					{!! Form::button('trans('messages.cancel')'
						, array(
							'class' => 'btn btn-gold btn-medium'
							, 'ng-click' => "answer.setActive(futureed.ACTIVE_VIEW, answer.record.id)"
						)
					) !!}
				</div>
			</div>
		</fieldset>
		{!! Form::close() !!}
	</div>

	<div id="rate_answer" ng-show="answer.rate_answer" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myMediumModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					{!! trans('messages.rate_this_answer') !!}
				</div>	
				<div class="modal-body">
					<div class="alert alert-error" ng-if="answer.rate_errors">
						<p ng-repeat="error in answer.rate_errors track by $index" > 
							{! error !}
						</p>
					</div>
					{!! Form::select('rate'
						, array(
							'' => 'trans('messages.select_rate')'
							, '1' => '1'
							, '2' => '2'
							, '3' => '3'
							, '4' => '4'
							, '5' => '5'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'answer.rating'
						)
					) !!}
				</div>
				<div class="modal-footer">
					<div class="btncon col-md-8 col-md-offset-4 pull-left">
						{!! Form::button('trans('messages.accept')'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => 'answer.updateStatus(answer.record.id, futureed.TRUE)'
							)
						) !!}
						{!! Form::button('trans('messages.cancel')'
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
