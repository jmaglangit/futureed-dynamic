<div class="col-xs-12 padding-0">
    <div ng-if="!mod.result.answered && !mod.result.quoted && !mod.result.failed">
        <div class="questions-container col-xs-12 col-md-12" id="snap_main_div_container">
            {{--Header--}}
            <div class="row questions-header col-xs-12">
                <div ng-class="{'col-xs-6':mod.student_module_subject_name != 'Programming', 'col-xs-4':mod.student_module_subject_name == 'Programming'}">
                    <div class="row col-xs-6">
                        <button type="button" class="btn btn-gold next-btn left-0" ng-click="mod.exitModule('{!! route('student.class.index') !!}')">
                            Exit Module
                        </button>
                    </div>
                </div>
                <div ng-class="{'col-xs-6':mod.student_module_subject_name != 'Programming', 'col-xs-8':mod.student_module_subject_name == 'Programming'}">
                    <div class="row col-xs-6 bottom-6">
                        <h3 class="border-radius-10">Progress {! mod.current_points !} / {! mod.points_to_finish !}</h3>
                    </div>
                    <div class="row col-xs-6">
                        <button type="button"
                                class="btn btn-orange next-btn right-0 btn-code-run"
                                ng-click="snap.runCode();"> Run </button>
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
                {{--Main Container--}}
                <div class="col-xs-12"
                     id="loading"
                     ng-if="snap.loading"
                     style="margin-top:40px;"
                >
                    <center>
                        <h1>Loading...</h1>
                    </center>
                </div>
                <div class="col-xs-12"
                     id="snap_container"
                >
                    <center>
                        <div class="content" id="world_container">
                            <canvas id="world" tabindex="1"
                                    style=" border-left: 5px solid #fff;
                                            border-right: 5px solid #fff;
                                    ">
                                <p>Your browser doesn't support canvas.</p>
                            </canvas>
                        </div>
                    </center>
                </div>

            </div>
            <div ng-init="snap.set_IDE();"></div>
        </div>
    </div>

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
                <h3> Question #{! mod.question_counter !} </h3>
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

</div>