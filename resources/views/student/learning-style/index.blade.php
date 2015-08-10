<div ng-controller="LearningStyleController as learning_style" ng-cloak>
	<div class="wrapr"> 
		<test-directive ng-show="data_loaded">
			<div class="panel panel-brand panel-test" id="lsp_panel">
				<div class="panel-header">
								<div id="section_header">
									<span ng-bind="sections[session.section].name" ng-hide="session.current_state == 'completed'"></span>
									<center ng-show="session.current_state == 'completed'">Test Completed</center>
									<div class="" ng-cloak ng-hide="order_candidate_test.test.time_limit_actual" ng-bind="'This test has no time limit'"></div>
								</div>
				</div>
				<div class="panel-body test">
	
						<h6 class="text-danger ng-hide" ng-show="session.current_state == 'introduction'">Instructions</h6>
						
						<!-- INTRODUCTION -->
						<div id="instructions" class="ng-hide" ng-show="session.current_state == 'introduction'">
							<div ng-bind-html="markups.intro"></div>
						</div>
						<!--// INTRODUCTION -->
	
						<div class="row" ng-show="session.questions.length > 0 && session.current_state != 'introduction' && session.current_state != 'completed'">
							<div id="percentage">
								<div class="progress">
									<div class="progress-bar" style="width: {! session.progress !};"></div>
								</div>
								<div class="progress-labels">
									<div class="percent-text zero">0%</div>
									<div class="percent-text hundred">100%</div>
								</div>
							</div>
	
							<div class="clearfix"></div>
	
							<div class="col-xs-5">
							</div>
								
							<div class="col-xs-2 text-center">
								<p id="time_left" ng-show="order_candidate_test.test.time_limit_actual">
									<b>Time Remaining</b><br>
									<span class="lead" id="stopwatch">
										<span id="minutes" ng-bind="session.remaining.minutes">00</span>:<span id="seconds" ng-bind="session.remaining.seconds">00</span>
									</span>
								</p>
							</div>
	
						</div>
						<div class="ng-hide" ng-show="session.current_state == 'completed'">
							<div ng-bind-html="markups.end"></div>
						</div>
						<div class="ng-hide" ng-show="markups.section.end">
							<div ng-bind-html="markups.section.end"></div>
						</div>
						<div id="instructions" class="ng-hide" ng-show="session.current_state != 'completed' && session.questions.length > 0 && helpers.isMCQMatrixQuestionWithoutIntro(session.questions[0])">
							<p class="intro-paragraph" ng-bind-html="markups.intro"></p>
						</div>
						<div class="actual-pages" ng-show="session.questions.length > 0 && session.current_state != 'introduction' && session.current_state != 'completed'">
							<div ng-repeat="question in session.questions | filter:{ page_no: sections[session.section].page }:isOfCurrentPage" class="row question">
								<div>
								<p class="col-sm-1 text-right fade" ng-bind="question.question_no" ng-class="{in: question.question_no}"></p>
								
							<div class="col-sm-10" ng-class="{'contained': session.current_state == 'sample questions'}">
									<div class="row">
										<div class="q-content" ng-class="{'col-sm-12': !question.ext_question, 'col-sm-3 text-right': question.ext_question}" ng-bind-html="question.question_text ? markdownToHTML(question.question_text): ''"></div>
										
										<div ng-class="{'col-sm-6': question.ext_question, 'hide': !question.ext_question}">
											<table class="table answer-table" ng-show="helpers.isMCQMatrixQuestion(question) && question.ext_question">
												<tr>
													<td ng-repeat="answer_group_detail in question.answer_group.details" class="text-center">
														<div class="answer-radio" ng-class="{selected: question.user_answers[0].answer_id == answer_group_detail.id || (session.current_state == 'sample questions' && sample_question_most_recent_answer == answer_group_detail.id)}" ng-click="answerQuestion(question, answer_group_detail, $parent.$index)">
															<div>
																<i class="fa" ng-class="{'fa-dot-circle-o': question.user_answers[0].answer_id == answer_group_detail.id || (session.current_state == 'sample questions' && sample_question_most_recent_answer == answer_group_detail.id), 'fa-circle-o': question.user_answers[0].answer_id != answer_group_detail.id}"></i>
															</div>
															<span ng-bind="answer_group_detail.answer_text"></span>
														</div>
													</td>
												</tr>
											</table>
										</div>
	
										<div class="q-content" ng-class="{'hide': !question.ext_question, 'col-sm-3': question.ext_question}" ng-bind-html="question.ext_question ? markdownToHTML(question.ext_question): ''"></div>
										</div>
									</div>
								</div>
	
								<div class="clearfix"></div>
								<div>
									<div class="col-sm-10 col-sm-offset-1" ng-class="{'contained-tail': session.current_state == 'sample questions'}">
										<p ng-show="question.ext_question && question.answer_exp" ng-bind="question.answer_exp"></p>
										<ul class="answers" ng-show="question.answers.length && helpers.isMCQMatrixQuestion(question) && question.ext_question">
											<li ng-repeat="answer in question.answers">
												<b ng-bind="answer.label" class="a-no"></b> <span ng-bind="answer.answer_text"></span>
											</li>
										</ul>
										<ul class="answers" ng-show="helpers.isSingleMCQTextQuestion(question)">
											<li ng-repeat="answer in question.answers">
												<a href="javascript: void(0);" ng-class="{selected: question.user_answers[0].answer_id == answer.id}" ng-click="answerQuestion(question, answer, $parent.$index)">
													<i class="fa i-radio" ng-class="{'fa-dot-circle-o': question.user_answers[0].answer_id == answer.id, 'fa-circle-o': question.user_answers[0].answer_id != answer.id}"></i><b ng-bind="answer.label" class="a-no"></b> <span ng-bind="answer.answer_text"></span>
												</a>
											</li>
										</ul>
	
										<div ng-class="{'has-error': session.messages[question.id]}">
											<input type="text" ng-model="question.user_answers[0].answer_text" class="form-control" ng-change="validatePageAnswers(question, question.user_answers[0], sections[session.section])" ng-show="helpers.isInputTextAnswerType(question)">
											<textarea ng-model="question.user_answers[0].answer_text" class="form-control" ng-change="validatePageAnswers(question, question.user_answers[0], sections[session.section])" ng-show="helpers.isLongTextQuestion(question)"></textarea>
											<p class="ng-hide help-block" ng-show="session.messages[question.id]" ng-bind="session.messages[question.id]"></p>
										</div>
	
										<ul class="answer_groups" ng-show="helpers.isMCQMatrixQuestion(question) && !question.ext_question">
											<li ng-repeat="answer_group_detail in question.answer_group.details">
												<a href="javascript: void(0);" ng-class="{selected: question.user_answers[0].answer_id == answer_group_detail.id}" ng-click="answerQuestion(question, answer_group_detail, $parent.$index)">
													<i class="fa" ng-class="{'fa-dot-circle-o': question.user_answers[0].answer_id == answer_group_detail.id, 'fa-circle-o': question.user_answers[0].answer_id != answer_group_detail.id}"></i><b ng-bind="answer_group_detail.label" class="a-no"></b> <span ng-bind="answer_group_detail.answer_text"></span>
												</a>
											</li>
										</ul>
	
										<form class="free_form_answer hg-hide" ng-submit="submitForMultipleAnswerQuestion(question)" ng-show="helpers.isShortTextQuestionMultiple(question)">
											
											<div class="form-group">
												<div class="input-group">
														<input type="text" class="form-control stressor-control" ng-model="session.answer" placeholder="Enter stressor and press enter to add">
														<span class="input-group-btn">
															<button type="submit" class="btn btn-primary btn-block">Add</button>
														</span>
												</div>
											</div>
	
											<div class="free-answer" ng-repeat="answer in question.user_answers">
												<p>
													<span ng-bind="$index+1" class="sequence-no"></span><span ng-bind="answer.answer_text"></span> <span class="close" ng-click="removeAnswer(question, $index)">&times;</span>
												</p>
											</div>
	
											<input type="hidden" ng-repeat="answer in question.free_answers" ng-value="answer">
										</form>
	
										<ul class="answer_groups" ng-show="helpers.isMultipleMCQTextQuestion(question)">
											<li ng-repeat="mcq_answer in sections[session.section].question_code_groups[question.question_code_id].keys" class="col-xs-12 answer-item form-inline">
												<div class="form-group">
													<label ng-bind="mcq_answer.answer_text" class="question-code-group-key"></label>
													<ul class="answers" ng-show="question.answers.length > 0">
														<li ng-repeat="answer in question.answers">
															<a href="javascript: void(0);" ng-class="{selected: helpers.isSelectedMCQAnswer(question, mcq_answer, answer, $parent.$index)}" ng-click="answerMultipleChoiceQuestion(question, mcq_answer, answer, $parent.$index)">
																<i class="fa i-radio" ng-class="{'fa-circle-o': !helpers.isSelectedMCQAnswer(question, mcq_answer, answer, $parent.$index), 'fa-dot-circle-o': helpers.isSelectedMCQAnswer(question, mcq_answer, answer, $parent.$index)}"></i><b ng-bind="answer.label" class="a-no"></b> <span ng-bind="answer.answer_text"></span>
															</a>
														</li>
													</ul>
												</div>
											</li>
										</ul>
									</div>
								</div>
							</div>
							
						</div><!-- actual-pages -->
					
				</div>
	
				<div class="panel-footer">
					<div class="row">
						<div class="col-xs-3">
							<button type="button" id="btn_previous" class="btn btn-brand ng-hide btn-gold" ng-click="previous()" ng-show="session.reversible"><i class="fa fa-chevron-left"></i> <span ng-bind="session.previous">Previous</span></button>
						</div>
	
						<div class="modern-paginator col-xs-6 text-center" ng-class="{fade: !sections[session.section].page || session.current_state == 'introduction' || !session.questions[0].question_no || session.current_state == 'completed' }">
							<ul class="list-inline">
								
								<li ng-repeat="question in session.questions | filter : { page_no: sections[session.section].page }:isOfCurrentPage" ng-class="{active: alreadyAnswered(question)}">
									<a class="page-number" href="javascript: void(0)">{! question.question_no !}</a>
								</li>
							
							</ul>
							<small class="text-center out-of ng-hide" ng-show="session.current_state != 'completed' && session.current_state != 'introduction'">out of {! getNumberOfQuestions() !}</small>
						</div>
	
						<div class="col-xs-3 text-right">
							<div class="btn-wrap"
								tooltip-class="danger"
								tooltip="Please answer all questions first. NEXT button will only be enabled once you complete answering all questions in this page."
								tooltip-placement="top"
								tooltip-trigger="mouseenter"
								tooltip-enable="session.incomplete && session.current_state != 'sample questions'">
								<button type="button" id="btn_proceed" 
									class="btn btn-brand btn-maroon" 
									ng-class="{disabled: session.incomplete && session.current_state != 'sample questions'}" 
									ng-click="proceed()">
									<span ng-bind="session.next"></span> <i class="fa fa-chevron-right"></i>
								</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<p class="ng-hide" ng-show="session.current_state != 'introduction' && session.current_state != 'completed' && session.current_state != 'sample questions'">*Please answer all the questions on this page before proceeding to the next page</p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<p class="ng-hide" ng-show="session.current_state == 'sample questions'">*Please read the examples carefully to understand the instructions before clicking NEXT</p>
						</div>
					</div>
				</div>
			</div>
		</test-directive>
	</div>
</div>