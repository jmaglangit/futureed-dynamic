var snap = {
    code                    : 	"",
    correct                 : 	Constants.FALSE,
    finish_count            :   0,
    isSnapExerciseCompleted :   Constants.FALSE,
    isSnapModuleCompleted   :   Constants.FALSE,
    showModal               :   function()
                                {
                                    var wrong_answer = $('.wrong_answer');
                                    var correct_answer = $('.correct_answer');
                                    var exercise_completed = $('.exercise_completed');
                                    var snap_proceed_btn = $('.snap_proceed_btn');
                                    var snap_try_again_btn = $('.snap_try_again_btn');
                                    var snap_skip_btn = $('.snap_skip_btn');
                                    var snap_next_exercise_btn = $('.snap_next_exercise_btn');
                                    var snap_module_done_btn = $('.snap_module_done_btn');
                                    var module_complete = $('.module_complete');
                                    var cur_code = $('.cur_code');
                                    var cur_code_content = $('.cur_code_content');

                                    cur_code.hide();
                                    cur_code_content.text('');

                                    if(snap.isSnapModuleCompleted )
                                    {
                                        exercise_completed.hide();
                                        wrong_answer.hide();
                                        correct_answer.hide();
                                        snap_proceed_btn.hide();
                                        snap_skip_btn.hide();
                                        snap_try_again_btn.hide();
                                        snap_next_exercise_btn.hide();

                                        snap_module_done_btn.show();
                                        module_complete.show();
                                    }
                                    else if(snap.correct == Constants.TRUE && snap.finish_count == 4)
                                    {
                                        exercise_completed.hide();
                                        wrong_answer.hide();
                                        snap_proceed_btn.hide();
                                        snap_try_again_btn.hide();
                                        snap_module_done_btn.hide();
                                        snap_skip_btn.hide();
                                        snap_next_exercise_btn.hide();

                                        module_complete.show();
                                        snap_next_exercise_btn.show();
                                    }
                                    else if(snap.isSnapExerciseCompleted)
                                    {
                                        wrong_answer.hide();
                                        correct_answer.hide();
                                        snap_try_again_btn.hide();
                                        snap_next_exercise_btn.hide();
                                        snap_module_done_btn.hide();
                                        module_complete.hide();

                                        snap.isSnapExerciseCompleted = Constants.FALSE;

                                        snap_proceed_btn.show();
                                        snap_skip_btn.show();
                                        exercise_completed.show();
                                    }
                                    else if(!snap.correct)
                                    {
                                        exercise_completed.hide();
                                        correct_answer.hide();
                                        snap_proceed_btn.hide();
                                        snap_next_exercise_btn.hide();
                                        snap_module_done_btn.hide();
                                        module_complete.hide();

                                        wrong_answer.show();
                                        snap_skip_btn.show();
                                        snap_try_again_btn.show();
                                    }
                                    else if(snap.correct == Constants.TRUE)
                                    {
                                        exercise_completed.hide();
                                        wrong_answer.hide();
                                        snap_proceed_btn.hide();
                                        snap_skip_btn.hide();
                                        snap_try_again_btn.hide();
                                        snap_module_done_btn.hide();
                                        module_complete.hide();

                                        snap.correct = Constants.FALSE;

                                        snap_next_exercise_btn.show();
                                        correct_answer.show();
                                    }

                                    if(snap.code.length > 0) {
                                        cur_code_content.text(snap.code);
                                        cur_code.show();
                                    }

                                    snap.code = '';

                                    $('#snap_message_modal').modal({
                                        backdrop: 'static',
                                        keyboard: Constants.FALSE,
                                        show    : Constants.TRUE
                                    });
                                }
};