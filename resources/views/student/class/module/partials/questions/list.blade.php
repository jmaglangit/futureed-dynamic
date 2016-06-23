<div class="col-xs-12 padding-0">
	<div ng-if="!mod.result.answered && !mod.result.quoted && !mod.result.failed">
		{{--mod.current_question.question_type != futureed.CODING--}}
		<div class="questions-container col-xs-12 col-md-12" id="snap_main_div_container">
			{{--Header--}}
			<div class="row questions-header col-xs-12">
				<div ng-class="{'col-xs-6':mod.current_question.question_type != futureed.CODING,'col-xs-4':mod.current_question.question_type == futureed.CODING}">
					<div class="row col-xs-6">
						<button type="button" class="btn btn-gold next-btn left-0" ng-click="mod.exitModule('{!! route('student.class.index') !!}')">
							{{ trans('messages.exit_module') }}
						</button>
					</div>
					<div class="row col-xs-6"
						 ng-if="mod.current_question.question_type != futureed.CODING"
					>
						<div><h3> {{ trans('messages.question') }} #{! mod.question_counter !} </h3></div>
					</div>
				</div>
				<div ng-class="{'col-xs-6':mod.current_question.question_type != futureed.CODING,'col-xs-8':mod.current_question.question_type == futureed.CODING}"
				>
					<div class="header-progress col-xs-6 bottom-6" ng-if="mod.current_question.question_type != futureed.CODING">
						<h3 class="border-radius-30">{{ trans('messages.progress') }} {! mod.current_points !} / {! mod.points_to_finish !}</h3>
					</div>
					<div class="header-progress col-xs-6 bottom-6" ng-if="mod.current_question.question_type == futureed.CODING">
						<h3 class="border-radius-30">{! mod.current_question.questions_text !}</h3>
					</div>
					<div class="row col-xs-6">
						<button ng-if="!mod.result.answered && !mod.result.quoted && !mod.result.failed && mod.current_question.question_type != futureed.CODING"
								type="button"
								class="btn btn-orange next-btn right-0"
								ng-click="mod.checkAnswer()"> {{ trans('messages.submit') }} </button>
						<button type="button"
								ng-if="mod.current_question.question_type == futureed.CODING"
								class="btn btn-orange next-btn right-0 btn-code-run"
								ng-click="mod.runCode();"> {{ trans('messages.run') }} </button>
					</div>
				</div>
			</div>
			{{--Contents--}}
			<div class="question-contents">
				{{--Error Messages--}}
				<div class="col-xs-12">
					<div class="alert alert-error" ng-if="mod.errors">
						<p ng-repeat="error in mod.errors track by $index">
							{! error !}
						</p>
					</div>

					<div class="alert alert-success" ng-if="mod.success">
						<p>{! mod.success !}</p>
					</div>
				</div>
				{{--Snap Table loading--}}
				<div class="col-xs-12"
					 id="loading"
					 ng-if="mod.loading && mod.current_question.question_type == futureed.CODING"
					 style="margin-top:40px;"
				>
					<center>
						<h1>{{ trans('messages.loading') }}</h1>
					</center>
				</div>
				{{--Main Question Contents--}}
				<div class="col-xs-6"
					 ng-if="mod.current_question.question_type != futureed.CODING"
				>
					{{--Image--}}
					<div class="col-xs-12">
						<div class="questions-image">
							<img ng-if="mod.current_question.questions_image != 'None' " ng-src="{! mod.current_question.questions_image !}"/>
						</div>
					</div>
					{{--Message--}}
					<div class="col-xs-12">
						<div class="questions-message">
							<p ng-bind-html="mod.current_question.questions_text | trustAsHtml"></p>
						</div>
					</div>
					{{--Tips--}}
					<div class="col-xs-12">
						<div class="questions-tips"
							 ng-class="{'question-tip-pos-top-10' : mod.current_question.questions_image != 'None', 'question-tip-pos-top-130' : mod.current_question.questions_image == 'None'}"
							 ng-if="mod.current_question.question_type == futureed.ORDERING">
							<p> <img ng-src="{! user.avatar !}" /> <span>{{ trans('messages.drag_items_reorder') }}</span></p>
						</div>
					</div>

				</div>
				{{--Answers--}}
				<div class="col-xs-6"
					 ng-if="mod.current_question.question_type != futureed.CODING"
				>
					<div class="questions-answers">
						{{--mod.current_question.question_type == futureed.MULTIPLECHOICE--}}
						<div class="margin-top-30">
							<a ng-if="mod.current_question.question_type == futureed.MULTIPLECHOICE" href="" class="choices" ng-repeat="choices in mod.current_question.question_answers"
								ng-click="mod.selectAnswer(choices)" ng-class="{ 'selected-choice' : mod.current_question.answer_id == choices.id }">
								<div ng-if="choices.answer_text != '' ">{! choices.answer_text !}</div>
								<img ng-if="choices.answer_image != 'None' " ng-src="{! choices.answer_image !}" />
							</a>
						</div>
						{{--mod.current_question.question_type == futureed.FILLINBLANK--}}
						<div class="margin-top-30">
							<div ng-if="mod.current_question.question_type == futureed.FILLINBLANK" class="form-group">
								<div ng-class="{ 'fib-text-fields' : mod.current_question.answer_text_field_count.length > 1 }">
									<input ng-repeat="n in mod.current_question.answer_text_field_count track by $index"
										   ng-model="mod.current_question.answer_text[n]"
										   name="answer_text"
										   type="text" class="form-control question-text-answer form-control-lg" placeholder="Answer {! $index + 1 !}"
									/>
								</div>
							</div>
						</div>
						{{--mod.current_question.question_type == futureed.PROVIDE--}}
						<div class="margin-top-30">
							<div ng-if="mod.current_question.question_type == futureed.PROVIDE" class="form-group">
							<input ng-model="mod.current_question.answer_text"
								   name="answer_text"
								   type="text"
								   class="form-control question-text-answer form-control-lg" placeholder="Answer"/>
							</div>
						</div>
						{{--mod.current_question.question_type == futureed.ORDERING--}}
						<div class="margin-top-30">
							<div ng-if="mod.current_question.question_type == futureed.ORDERING">
								<ul as-sortable="mod.dragControlListeners" ng-model="mod.current_question.answer_text">
									<li ng-repeat="item in mod.current_question.answer_text" as-sortable-item class="as-sortable-item">
										<div as-sortable-item-handle class="as-sortable-item-handle">
											<span data-ng-bind="item"></span>
										</div>
									</li>
								</ul>
							</div>
						</div>
						{{--mod.current_question.question_type == futureed.GRAPH--}}
						<div class="margin-top-30">
							<div ng-if="mod.current_question.question_type == futureed.GRAPH">
								<div ng-init="mod.getGraph(mod.current_question.id)">
									{{--Horizontal--}}
									<table id="horizontalTable" class="table" ng-if="mod.question_graph_content.orientation == futureed.HORIZONTAL">
										<tr ng-repeat="item in mod.question_graph_content.image" class="{! item.field !}">
											<th class="origin-container" ng-init="mod.initDrag()">
												<div class="origin {! item.field !}">
													<img ng-src="{! item.path !}" />
												</div>
											</th>
											<td ng-init="mod.initDrop()" class="drop first">
											</td>
											<td ng-init="mod.initDrop()" class="drop disabled" ng-repeat="col in mod.graph_layout" ng-if="$index > 0">
											</td>
										</tr>
									</table>
									{{--Vertical--}}
									<table id="verticalTable" class="table" ng-if="mod.question_graph_content.orientation == futureed.VERTICAL">
										<tr>
											<th ng-repeat="item in mod.question_graph_content.image" class="{! item.field !}" ng-init="mod.initDrag()">
												<div class="origin {! item.field !}">
													<img ng-src="{! item.path !}" />
												</div>
											</th>
										</tr>
										<tr>
											<td ng-repeat="item in mod.question_graph_content.image" ng-init="mod.initDrop()" class="drop first">
											</td>
										</tr>
										<tr ng-repeat="col in mod.graph_layout" ng-if="$index > 0">
											<td ng-repeat="item in mod.question_graph_content.image" ng-init="mod.initDrop()" class="drop disabled">
											</td>
										</tr>

									</table>
									<div class="col-xs-3 pull-right reset-graph">
										<button class="btn btn-gold" ng-click="mod.resetGraph()">{{ trans('messages.reset_caps') }}</button>
									</div>
								</div>
							</div>
						</div>
						{{--mod.current_question.question_type == futureed.QUADRANT--}}
						<div class="margin-top-30">
							<div ng-if="mod.current_question.question_type == futureed.QUADRANT">
								<div ng-init="mod.getQuadrant(mod.current_question.id)">
									<div id="placeholder" style="width:300px;height:300px;margin:0 auto;"></div>
									<div class="col-xs-3 pull-right reset-graph">
										<button class="btn btn-gold" ng-click="mod.resetGraph()">{{ trans('messages.reset_caps') }}</button>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				{{--Snap--}}
				<div class="col-xs-12"
					 id="snap_container"
					 ng-if="mod.current_question.question_type == futureed.CODING"
				>
					<center>
						<div class="content" id="world_container">
							<canvas id="world" tabindex="1"
									style=" border-left: 5px solid #fff;
											border-right: 5px solid #fff;
									"
							>
								<p>{{ trans('messages.canvas_not_supported') }}</p>
							</canvas>
						</div>
					</center>
				</div>
				<div ng-init="mod.set_IDE();" ng-if="mod.current_question.question_type == futureed.CODING"></div>
			</div>
		</div>
	</div>
	{{--Resultant--}}
	<div ng-if="mod.result.answered">
		<div class="questions-container col-xs-12">
			<div class="questions-header">
				<h3> Question #{! mod.question_counter !} </h3>
			</div>
			<div class="col-xs-12 col-md-12">
				<span class="result-message col-xs-3"
					 ng-class="{ 'result-correct' : mod.result.points_earned, 'result-incorrect' : !mod.result.points_earned }">
					<h2 ng-if="mod.result.points_earned > 0">
						{{ trans('messages.correct') }}
					</h2>

					<h2 ng-if="mod.result.points_earned <= 0" >
						{{ trans('messages.wrong') }}
					</h2>
				</span>
				<span class="result-image col-xs-3">
					<i class="fa fa-5x img-rounded text-center"
					   ng-class="{ 'fa-times' : !mod.result.points_earned, 'fa-check' : mod.result.points_earned }"></i>
				</span>
			</div>
			<div class="result-tip col-xs-12" ng-if="mod.result.points_earned <= 0"
				 ng-init="mod.getAnswerExplanation()">
				<span ng-if="mod.answer_explanation.answer_explanation"><img src="/images/icon-tipbulb.png">   </span>
				<span class="h4" ng-if="mod.answer_explanation.answer_explanation">{! mod.answer_explanation.answer_explanation !}</span>
			</div>
			<div class="proceed-btn-container btn-container">
				<button type="button" class="btn btn-maroon btn-medium" ng-click="mod.nextQuestion()">
					{{ trans('messages.proceed_to_next_questions') }}
				</button>
			</div>
		</div>
	</div>
	<div ng-if="mod.result.quoted">
		<div class="questions-container col-xs-12">
			<div class="questions-header">
				<h3> {{ trans('messages.question') }} #{! mod.question_counter !} </h3>
			</div>
			<div class="quote-message"
				ng-class="{ 'result-correct' : mod.result.points_earned, 'result-incorrect' : !mod.result.points_earned }">
					<p ng-if="mod.result.points_earned > 0">
						{{ trans('messages.correct') }}
					</p>

					<p ng-if="mod.result.points_earned <= 0">
						{{ trans('messages.wrong') }}
					</p>
			</div>

			<div class="message-container">
				<div class="col-xs-12">
					<div class="col-xs-2"></div>
					<div class="quoted-module-icon-holder col-xs-3">
						<img ng-src="{! mod.avatar_quote_info.avatar_pose && '/images/avatar/' + mod.avatar_quote_info.avatar_pose.pose_image || user.avatar !}" />
					</div>

					<div class="col-xs-5">
						<p class="quoted-module-message">
							{! mod.avatar_quote_info.quote !}
						</p>

						<div class="proceed-btn-container btn-container">
							<button type="button" class="btn btn-maroon btn-large" ng-click="mod.nextQuestion()">
								{{ trans('messages.proceed_to_next_questions') }}
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div ng-if="mod.result.failed">
		<div class="questions-container col-xs-12">
			<div class="questions-header">
				<h3> {{ trans('messages.question') }} #{! mod.question_counter !} </h3>
			</div>

			<div class="result-failed message-container">
				<div class="col-xs-12">
					<div class="col-xs-2"></div>
					<div class="failed-module-icon-holder col-xs-3">
						<img ng-src="{! user.avatar !}" />
					</div>

					<div class="col-xs-5">
						<p class="failed-module-message">
							{{ trans('messages.review_and_retake_test') }}
						</p>

						<div class="proceed-btn-container btn-container">
							<button type="button" class="btn btn-maroon btn-large"
									ng-click="mod.reviewContent()"
							>
								{{ trans('messages.retake_test') }}
							</button>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>