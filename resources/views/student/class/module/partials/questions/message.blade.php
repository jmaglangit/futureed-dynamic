<div id="message_modal" ng-show="mod.module_message.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="title-main-content" ng-if="mod.module_message.skip_module || mod.module_message.no_questions"> {! mod.module_message.name !} </div>
				<div class="title-main-content" ng-if="mod.module_message.module_done"> {! mod.module_message.name !} Module Complete </div>
			</div>
			<div class="modal-body message-container">
				<div ng-if="mod.module_message.skip_module">
					<div class="row">
						<div class="col-xs-12">
							<div class="points-badge-holder row">
								<div class="col-xs-12 reward-message">
									Reward points to earn
								</div>
								<div class="col-xs-6">
									<img ng-src="/images/icons/icon-reward.png" class="image-badge pull-right"/>
								</div>

								<div class="col-xs-6">
									<p class="message-point pull-left">+{! mod.module_message.points_earned !}</p>
								</div>
							</div>
						</div>
						<div class="col-xs-offset-1 col-xs-3 module-icon-holder">
							<img ng-src="{! user.avatar !}" />
						</div>

						<div class="col-xs-6">
							<p class="skip-module-message">{! mod.module_message.description !} <br><br>Let's get started...</p>
						</div>
					</div>
				</div>

				<div ng-if="mod.module_message.no_questions">
					<div class="col-xs-12">
						<div class="col-xs-1"></div>
						<div class="col-xs-3 module-icon-holder">
							<img ng-src="{! user.avatar !}" />
						</div>

						<div class="col-xs-6" >
							<p class="module-message">{!! trans('messages.no_available_modules') !!}</p>
						</div>
					</div>
				</div>

				<div ng-if="mod.module_message.module_done">
					<div class="row">
						<div class="col-xs-1"></div>
						<div class="col-xs-10 wiki-earn-message">
							You have earned {! mod.module_message.points_earned !} point(s).
						</div>
					</div>

					<div class="row">
						<div class="col-xs-12">
							<p class="wiki-title">{! mod.module_message.title !}</p>
						</div>
					</div>

					<div class="col-xs-12">
						<div class="col-xs-3 wiki-icon-holder">
							<img ng-if="mod.module_message.image" ng-src="{! mod.module_message.image !}" />
							<img ng-if="!mod.module_message.image" ng-src="{! user.avatar !}" />
						</div>
						<div class="col-xs-1"></div>
						<div class="col-xs-8">
							<p class="wiki-message" ng-class="{ 'wiki-more-message' : mod.module_message.full_message }">{! mod.module_message.message !}</p>
							<div class="wiki-view-more" ng-if="!mod.module_message.full_message">
								<button type="button" class="btn btn-gold" ng-click="mod.viewMoreWikiMessage()">
									{!! trans('messages.view_more') !!}
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<div class="btn-container">
					<div ng-if="mod.module_message.skip_module">
						{!! Form::button('Proceed'
							, array(
								'class' => 'btn btn-maroon btn-semi-medium'
								, 'data-dismiss' => 'modal'
								, 'ng-click' => 'mod.skipModule()'
							)
						) !!}

					</div>
					<div ng-if="mod.module_message.no_questions">
						{!! Html::link(route('student.dashboard.index'), trans('messages.proceed_to_dashboard')
							, array(
								'class' => 'btn btn-maroon btn-medium'
							)
						) !!}

					</div>
					<div ng-if="mod.module_message.module_done">
						<button class="btn btn-maroon btn-medium" 
							ng-click="mod.exitModule('{!! route('student.class.index') !!}')">
							{!! trans('messages.class_dashboard') !!}
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>