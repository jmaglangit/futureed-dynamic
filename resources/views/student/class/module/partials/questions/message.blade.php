<div id="message_modal" ng-show="mod.module_message.show" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="title-main-content" ng-if="mod.module_message.skip_module || mod.module_message.no_questions"> {! mod.module_message.name +' '+ mod.record.grade.name  !} </div>
				<div class="title-main-content" ng-if="mod.module_message.module_done"> {! mod.module_message.name +' '+ mod.record.grade.name !} Module Complete </div>
			</div>
			<div class="modal-body message-container">
				<div ng-if="mod.module_message.skip_module">
					<div class="row">
						<div class="col-xs-12">
							<div class="points-badge-holder row">
								<div class="col-xs-12 reward-message">
									{{ trans('messages.rewards_points_earn') }}
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
							<p class="skip-module-message">{! mod.module_message.description !} <br><br>{{ trans('messages.lets_get_started') }}.</p>
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
					<div class="row wiki-earn-msg">
						<div class="col-xs-15 wiki-earn-msg-block">
							<div class="h3 msg-congrats">{{ trans('messages.module_complete_message') }}</div>
							<div class="h4 msg-point">
								{{ trans('messages.you_earned') }} {! mod.module_message.points_earned !} {{ trans('messages.point_s') }}.
							</div>
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
							<div class="wiki-link">
								<div class="col-lg-4 h5">Wikipedia Source :</div>
								<div class="col-lg-6 h5"><a target="__blank" href="{! mod.module_message.source !}">{! mod.module_message.source !}</a></div>
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
								'class' => 'btn btn-green btn-semi-medium'
								, 'data-dismiss' => 'modal'
								, 'ng-click' => 'mod.skipModule()'
							)
						) !!}

					</div>
					<div ng-if="mod.module_message.no_questions">
						{!! Html::link(route('student.dashboard.index'), trans('messages.proceed_to_dashboard')
							, array(
								'class' => 'btn btn-green btn-medium'
							)
						) !!}

					</div>
					<div ng-if="mod.module_message.module_done">
						<button class="btn btn-green btn-medium"
								ng-click="mod.viewRewards()">
							{!! trans('messages.continue_to_rewards') !!}
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{--Snap--}}
<div id="snap_message_modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-body message-container">
				<div ng-if="mod.module_message.skip_module">
					<div class="row">
						<div class="col-xs-offset-1 col-xs-3 module-icon-holder">
							<img ng-src="{! user.avatar !}" />
						</div>

						<div class="col-xs-6">
							<p hidden class="skip-module-message exercise_completed">{{ trans('messages.snap_modal_msg_1') }} <br> {{ trans('messages.snap_modal_msg_2') }}</p>
							<p hidden class="skip-module-message correct_answer">{{ trans('messages.snap_modal_msg_3') }} <br>{{ trans('messages.snap_modal_msg_4') }}</p>
							<p hidden class="skip-module-message wrong_answer">{{ trans('messages.snap_modal_msg_5') }}<br> {{ trans('messages.snap_modal_msg_6') }}</p>
							<p hidden class="skip-module-message module_complete">{{ trans('messages.snap_modal_msg_7') }}</p>
							<center>
								<div class="cur_code_tabs">
									<ul class="nav nav-tabs">
										<li class="active">
											<a data-toggle="tab" href="#js_pane">Java Script</a>
										</li>
										<li>
											<a data-toggle="tab" href="#java_pane">Java</a>
										</li>
										<li>
											<a data-toggle="tab" href="#python_pane">Python</a>
										</li>
									</ul>
									<div class="tab-content">
										<div id="js_pane" class="tab-pane fade in active">
											<pre></pre>
										</div>
										<div id="java_pane" class="tab-pane fade">
											<pre></pre>
										</div>
										<div id="python_pane" class="tab-pane fade">
											<pre></pre>
										</div>
									</div>
								</div>
							</center>
							<div class="snap_proceed_btn" hidden >
								{!! Form::button(trans('messages.client_proceed')
									, array(
										'class' => 'btn btn-maroon btn-semi-medium exercise_completed'
										, 'data-dismiss' => 'modal'
										, 'type' => 'button'
									)
								) !!}
							</div>
							<div class="snap_try_again_btn" hidden >
								{!! Form::button(trans('messages.snap_modal_msg_8')
									, array(
										'class' => 'btn btn-maroon btn-semi-medium'
										, 'data-dismiss' => 'modal'
										, 'type' => 'button'
									)
								) !!}
							</div>
							<br>
							<div class="snap_skip_btn" hidden >
								{!! Form::button(trans('messages.skip')
									, array(
										'class' => 'btn btn-maroon btn-semi-medium'
										, 'data-dismiss' => 'modal'
										, 'ng-click' => 'mod.skipSnapQuestion()'
									)
								) !!}
							</div>
							<div class="snap_next_exercise_btn" hidden >
								{!! Form::button(trans('messages.skip')
									, array(
										'class' => 'btn btn-maroon btn-semi-medium'
										, 'data-dismiss' => 'modal'
										, 'ng-click' => 'mod.continueToNextSnapExercise()'
									)
								) !!}
							</div>
							<div class="snap_module_done_btn" hidden >
								{!! Form::button(trans('messages.client_proceed')
									, array(
										'class' => 'btn btn-maroon btn-semi-medium'
										, 'data-dismiss' => 'modal'
										, 'ng-click' => 'mod.nextQuestion()'
									)
								) !!}
							</div>
							<center>
								<div style="border-top: 1px solid #e5e5e5; margin-top: 20px;width: 80%; align-self: center;"></div>
							</center>
							<div class="share_btn" style="margin-top:20px;">
								<a href="{{ 'https://www.facebook.com/sharer/sharer.php?u='.urlencode(url('/')) }}"
								   target="_blank"
								   style="text-decoration: none;"
								>
									<img src="{{ url('/images/facebook.png') }}" border="0" alt="Facebook"/>
								</a>
								<a href="{{ 'https://twitter.com/intent/tweet?url='.urlencode(url('/')).'&text='.urlencode("I've written my first program. Try FutureEd Now!") }}"
								   target="_blank"
								   style="text-decoration: none;"
								>
									<img src="{{ url('/images/twitter.png') }}" border="0" alt="Twitter"/>
								</a>
								<a href="{{ 'https://plus.google.com/share?url='.urlencode(url('/')) }}"
								   target="_blank"
								   style="text-decoration: none;"
								>
									<img src="{{ url('/images/google_plusone_share.png') }}" border="0" alt="Twitter"/>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>