<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests\Api\StudentModuleAnswerRequest;
use FutureEd\Models\Repository\AvatarPose\AvatarPoseRepositoryInterface;
use FutureEd\Models\Repository\AvatarQuote\AvatarQuoteRepositoryInterface;
use FutureEd\Models\Repository\AvatarWiki\AvatarWikiRepositoryInterface;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Models\Repository\Quote\QuoteRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface;

class StudentModuleAnswerController extends ApiController{

    protected $avatar_pose;
    protected $avatar_quotes;
    protected $avatar_wiki;
    protected $question_answer;
    protected $quote;
    protected $student;
    protected $student_module;
    protected $student_module_answer;


    public function __construct(AvatarPoseRepositoryInterface $avatar_pose,
                                AvatarQuoteRepositoryInterface $avatar_quotes,
                                AvatarWikiRepositoryInterface $avatar_wiki,
                                QuestionAnswerRepositoryInterface $question_answer,
                                QuoteRepositoryInterface $quote,
                                StudentModuleRepositoryInterface $student_module,
                                StudentModuleAnswerRepositoryInterface $student_module_answer,
                                StudentRepositoryInterface $student){

        $this->avatar_pose = $avatar_pose;
        $this->avatar_quotes = $avatar_quotes;
        $this->avatar_wiki = $avatar_wiki;
        $this->question_answer = $question_answer;
        $this->quote = $quote;
        $this->student = $student;
        $this->student_module = $student_module;
        $this->student_module_answer = $student_module_answer;
    }

    /**
     * Answer a module question.
     * @param StudentModuleAnswerRequest $request
     * @return json
     */
    public function store(StudentModuleAnswerRequest $request){

        $data = $request->all();

        //get student module info.
        $student_module = $this->student_module->getStudentModule($data['student_module_id']);

        if(is_null($student_module)){
            return $this->respondErrorMessage(2142);
        }

        $student_module = $student_module->toArray();
        $student_module_id = $student_module['id'];

        //get correct answer.
        $check_correct_answer = $this->question_answer->getCorrectAnswer($data['question_id'],$data['answer_id']);

        $point = 0;
        $should_interrupt_exam = false;

        //check answer if it's correct/incorrect.
        if (is_null($check_correct_answer)){
            //if incorrect answer, increment the wrong_counter.
            $student_module['wrong_counter'] += 1;

            //if the student gets 3 or more consecutive incorrect answer, it will have a 1 point deduction.
            if($student_module['wrong_counter'] >= 3){
                $point = -1;
            }

            //if the student reaches 10 consecutive incorrect answers, it will be prompt to stop the test and watch again the video tutorials.
            if($student_module['wrong_counter'] == config('futureed.deductions_to_fail_module')){
                $should_interrupt_exam = true;
            }

            $data['answer_status'] = config('futureed.answer_status_wrong');
        }else{ //if correct answer. reset the wrong_counter to zero and increment the correct_counter
            $student_module['wrong_counter'] = 0;
            $student_module['correct_counter'] += 1;
            $point = 1;
            $data['answer_status'] = config('futureed.answer_status_correct');
        }
        $student_module['question_counter'] += 1;
        $student_module['running_points'] = $student_module['points_earned'] += $point;
        $student_module['last_answered_question_id'] = $data['question_id'];
        $student_module['total_time'] = $data['total_time'];

        if( $student_module['running_points'] == config('futureed.points_to_finish_module') ){
            $student_module['module_status'] = config('futureed.module_status_completed');
            $student_module['date_end'] = Carbon::now();
        }

        //update student module.
        $this->student_module->updateStudentModule($student_module_id,$student_module);

        //insert student module answer.
        $this->student_module_answer->addStudentModuleAnswer($data);


        if($should_interrupt_exam){
            return $this->respondErrorMessage(2145);
        }else{
            $student_module['avatar_quote'] = $student_module['avatar_wiki'] = null;
            $question_counter = $student_module['question_counter'];
            $correct_counter = $student_module['correct_counter'];

            if((($question_counter) % 5 ) == 0){// every 5 questions answered, display an avatar quote.
                $student = $this->student->getReferences($data['student_id']);
                $avatar_id = $student->avatar_id;

                $correct_pct = ( $correct_counter / 5 ) * 100;
                $seq_no = $question_counter / 5;

                $quote_id = $this->quote->getQuoteIdByPctAndSeqNo($correct_pct,$seq_no);

                $avatar_pose_id = $this->avatar_quotes->getAvatarPoseIdByAvatarIdAndQuoteId($avatar_id,$quote_id);

                $avatar_pose = $this->avatar_pose->getAvatarPose($avatar_pose_id);

                if(!is_null($avatar_pose)){
                    $avatar_pose = $avatar_pose->toArray();
                    $avatar_pose['avatar_url'] = url().'/'.config('futureed.image_avatar_folder').'/'.$avatar_pose['pose_image'];

                    $student_module['avatar_quote'] = $avatar_pose;
                }

                //set the correct_counter to 0
                $array_correct_counter['correct_counter'] = 0;
                $this->student_module->updateStudentModule($student_module_id,$array_correct_counter);

            }
            if( $student_module['running_points'] == config('futureed.points_to_finish_module') ){
                $student = $this->student->getReferences($data['student_id']);
                $avatar_id = $student->avatar_id;
                $student_module['avatar_wiki'] = $this->avatar_wiki->getAvatarWikiByAvatarId($avatar_id);
            }
            return $this->respondWithData($student_module);
        }
    }
}