<div ng-if="tips.active_view || tips.active_edit">
	<div class="col-xs-12" ng-if="tips.errors || tips.success">
		<div class="alert alert-error" ng-if="tips.errors">
			<p ng-repeat="error in tips.errors track by $index">
				{! error !}
			</p>
		</div>

        <div class="alert alert-success" ng-if="tips.success">
            <p>{! tips.success !}</p>
        </div>
    </div>

	<div class="module-container">
		<div class="title-main-content">
			<span>Tip Details</span>
		</div>
	</div>
	
	<div class="form-content col-xs-12">
		{!! Form::open([
				'id' => 'add_admin_form',
				'class' => 'form-horizontal'
			]) 
		!!}
			<fieldset>
				<div class="form-group">
					<div ng-if="tips.record.link_type != futureed.GENERAL">
						<label class="col-xs-2 control-label" id="username">Module <span class="required">*</span></label>
						<div class="col-xs-4">
							{!! Form::text('username', '',
								[
									'placeholder' => 'Module',
									'ng-disabled' => 'true',
									'ng-model' => 'tips.record.module',
									'class' => 'form-control'
								]
							) !!}
						</div>
					</div>
					<label class="col-xs-2 control-label" id="email">Displayed At <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::select('link_type'
							, array(
								'' => '-- Select Type --'
								, 'General' => 'General'
								, 'Content' => 'Content'
								, 'Question' => 'Question'
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
					<label class="col-xs-2 control-label">Subject <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('subject', '',
							[
								'placeholder' => 'Subject',
								'ng-disabled' => 'true',
								'ng-model' => 'tips.record.subject',
								'class' => 'form-control'
							]
						) !!}
					</div>
					<label class="col-xs-2 control-label">Area <span class="required">*</span></label>
					<div class="col-xs-4">
						{!! Form::text('area', '',
							[
								'placeholder' => 'Area',
								'ng-disabled' => 'true',
								'ng-model' => 'tips.record.area',
								'class' => 'form-control'
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
	        		<label class="col-xs-2 control-label">Status <span class="required">*</span></label>
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
	        				<span class="lbl padding-8">Enable</span>
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
	        				<span class="lbl padding-8">Disable</span>
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

	        		<label class="col-xs-2 control-label">Tip Status <span class="required">*</span></label>
	        		<div>
		        		<label class="col-xs-4" ng-if="tips.record.tip_status == 'Accepted'">
		        			<b class="success-icon">
		        				<i class="margin-top-8 fa fa-check-circle-o"></i> {! tips.record.tip_status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="tips.record.tip_status == 'Pending'">
		        			<b class="warning-icon">
		        				<i class="margin-top-8 fa fa-exclamation-circle"></i> {! tips.record.tip_status !}
		        			</b>
		        		</label>

		        		<label class="col-xs-4" ng-if="tips.record.tip_status == 'Rejected'">
		        			<b class="error-icon">
		        				<i class="margin-top-8 fa fa-ban"></i> {! tips.record.tip_status !}
		        			</b>
		        		</label>
	        		</div>
	        	</div>
	        	<div class="form-group" ng-if="tips.record.rating != futureed.NULL">
	        		<label class="control-label col-xs-2">Rating</label>
	        		<div class="col-xs-4 margin-top-5">
	        			<span ng-repeat="i in tips.record.stars track by $index">
							<!-- <img ng-if="!answer.rating" ng-mouseover="help.changeColor($index, answer.id)" ng-src="{! (help.hovered[answer.id][$index])  && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" /> -->
							<!-- <img ng-if="answer.rating" ng-src="{! $index + 1 <= answer.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" /> -->
							<img ng-src="{! $index+1 <= tips.record.rating && '/images/class-student/icon-star_yellow.png' || '/images/class-student/icon-star_white.png' !}" />
						</span>
	        		</div>
	        	</div>
	        	<div class="form-group" ng-if="tips.record.rated_by != futureed.ADMIN && tips.active_view">
	        		<div class="btn-container col-xs-8 col-xs-offset-2">
	        			<button class="btn btn-blue btn-medium" type="button" ng-click="tips.rateTip()" ng-if="tips.record.rating != futureed.NULL">Change Rating</button>

	        			<button class="btn btn-blue btn-medium" type="button" ng-click="tips.rateTip()" ng-if="tips.record.rating == futureed.NULL">Accept</button>
						{!! Form::button('Reject'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "tips.rejectTip()"
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
					<label class="col-xs-3 control-label">Title <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::text('title', '',
							[
								'class' => 'form-control'
								, 'ng-disabled' => 'tips.active_view'
								, 'ng-model' => 'tips.record.title'
								, 'placeholder' => 'Title'
								, 'ng-class' => "{ 'required-field' : tips.fields['title'] }"
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Description <span class="required">*</span></label>
					<div class="col-xs-6">
						{!! Form::textarea('content','',
							[
								'class' => 'form-control'
								, 'ng-disabled' => 'tips.active_view'
								, 'ng-model' => 'tips.record.content'
								, 'placeholder' => 'Description'
								, 'ng-class' => "{ 'required-field' : tips.fields['content'] }"
							]
						) !!}
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-3 control-label">Created By:</label>
					<div class="col-xs-6">
						{!! Form::text('created_by','',
							[
								'class' => 'form-control'
								, 'ng-disabled' => 'true'
								, 'ng-model' => 'tips.record.name'
								, 'placeholder' => 'Description'
							]
						) !!}
					</div>
				</div>
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="tips.active_edit">
						{!! Form::button('Save'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "tips.updateTip()"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "tips.setActive(futureed.ACTIVE_VIEW, tips.record.id)"
							)
						) !!}
				</div>	
				<div class="btn-container col-xs-8 col-xs-offset-2" ng-if="tips.active_view">
						{!! Form::button('Edit'
							, array(
								'class' => 'btn btn-blue btn-medium'
								, 'ng-click' => "tips.setActive(futureed.ACTIVE_EDIT, tips.record.id)"
							)
						) !!}

						{!! Form::button('Cancel'
							, array(
								'class' => 'btn btn-gold btn-medium'
								, 'ng-click' => "tips.setActive()"
							)
						) !!}		
				</div>
			</fieldset>
		{!! Form::close() !!}
	</div>
</div>
<div id="rate_tip" ng-show="tips.rate_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myMediumModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    Rate this tip
                </div>
                <div class="modal-body">
	                <div class="alert alert-error" ng-if="tips.rate_errors">
			            <p ng-repeat="error in tips.rate_errors track by $index" > 
			              	{! error !}
			            </p>
			        </div>
                    {!! Form::select('rate'
						, array(
							'' => '-- Select Rate --'
							, '1' => '1'
							, '2' => '2'
							, '3' => '3'
							, '4' => '4'
							, '5' => '5'
						)
						, ''
						, array(
							'class' => 'form-control'
							, 'ng-model' => 'tips.rating'
						)
					) !!}
                </div>
                <div class="modal-footer">
                    <div class="btncon col-md-8 col-md-offset-4 pull-left">
                        {!! Form::button('Accept'
                            , array(
                                'class' => 'btn btn-blue btn-medium'
                                , 'ng-click' => 'tips.acceptTip()'
                            )
                        ) !!}
                        {!! Form::button('Cancel'
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