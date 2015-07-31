<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use FutureEd\Http\Requests\Api\StudentModuleAnswerRequest;
use FutureEd\Models\Repository\AvatarPose\AvatarPoseRepositoryInterface;
use FutureEd\Models\Repository\AvatarQuote\AvatarQuoteRepositoryInterface;
use FutureEd\Models\Repository\AvatarWiki\AvatarWikiRepositoryInterface;
use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Models\Repository\Quote\QuoteRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface;
use FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface;
use Illuminate\Support\Facades\Input;

class StudentModuleAnswerController extends ApiController{

    protected $avatar_pose;
    protected $avatar_quotes;
    protected $avatar_wiki;
    protected $question;
    protected $question_answer;
    protected $quote;
    protected $student;
    protected $student_module;
    protected $student_module_answer;
	protected $module;
	protected $teaching_content;


    public function __construct(AvatarPoseRepositoryInterface $avatar_pose,
                                AvatarQuoteRepositoryInterface $avatar_quotes,
                                AvatarWikiRepositoryInterface $avatar_wiki,
                                QuestionRepositoryInterface $question,
                                QuestionAnswerRepositoryInterface $question_answer,
                                QuoteRepositoryInterface $quote,
                                StudentModuleRepositoryInterface $student_module,
                                StudentModuleAnswerRepositoryInterface $student_module_answer,
                                StudentRepositoryInterface $student,
								ModuleContentRepositoryInterface $moduleContentRepositoryInterface,
								TeachingContentRepositoryInterface $teachingContentRepositoryInterface){

        $this->avatar_pose = $avatar_pose;
        $this->avatar_quotes = $avatar_quotes;
        $this->avatar_wiki = $avatar_wiki;
        $this->question = $question;
        $this->question_answer = $question_answer;
        $this->quote = $quote;
        $this->student = $student;
        $this->student_module = $student_module;
        $this->student_module_answer = $student_module_answer;
		$this->module = $moduleContentRepositoryInterface;
		$this->teaching_content = $teachingContentRepositoryInterface;
    }

    /**
     * Answer a module question.
     * @param StudentModuleAnswerRequest $request
     * @return json
     */
    public function stores(StudentModuleAnswerRequest $request){

        $data = $request->all();

        //get student module info.
        $student_module = $this->student_module->getStudentModule($data['student_module_id']);

        if(is_null($student_module)){
            return $this->respondErrorMessage(2144);
        }

        $student_module = $student_module->toArray();
        $student_module_id = $student_module['id'];

        //get question details.
        $question = $this->question->viewQuestion($data['question_id']);
        $is_correct_answer = false;
        //get correct answer.
        if(!is_null($question)){
            switch($question->question_type){
                case config('futureed.question_type_fill_in_the_black'):
                case config('futureed.question_type_provide_answer'):
                case config('futureed.question_type_ordering'):
                    $is_correct_answer = ( strtolower($question->answer) == strtolower($data['answer_text']) );
                    break;
                case config('futureed.question_type_multiple_choice'):
                    $is_correct_answer = $this->question_answer->getCorrectAnswer($data['question_id'],$data['answer_id']);
            }
        }

        $point = 0;
        $should_interrupt_exam = false;

        //check answer if it's correct/incorrect.
        if (!$is_correct_answer){

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
        }else{
        //if correct answer. reset the wrong_counter to zero and increment the correct_counter
            $student_module['wrong_counter'] = 0;
            $student_module['total_correct_answer'] = $student_module['correct_counter'] += 1;
            $point = 1;
            $data['answer_status'] = config('futureed.answer_status_correct');

            //Levels of difficulty, 3 levels, must get 4 right per level minimum.
            if( ($student_module['total_correct_answer'] % 4) == 0 ){
                $student_module['current_difficulty_level'] += 1;
            }
        }
        $student_module['progress'] = $student_module['question_counter'] += 1;
        $student_module['running_points'] = $student_module['points_earned'] += $point;
        $student_module['last_answered_question_id'] = $data['question_id'];
        $student_module['total_time'] = $data['total_time'];

        if( $student_module['running_points'] == config('futureed.points_to_finish_module') ){
            $student_module['module_status'] = config('futureed.module_status_completed');
            $student_module['date_end'] = Carbon::now();
        }

        //update student module.
        $return = $this->student_module->updateStudentModule($student_module_id,$student_module);

		dd($return);

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
//+-------------------+-------------------------+------+-----+---------------------+----------------+
//| Field             | Type                    | Null | Key | Default             | Extra          |
//+-------------------+-------------------------+------+-----+---------------------+----------------+
//| id                | int(10) unsigned        | NO   | PRI | NULL                | auto_increment |
//| student_module_id | bigint(20)              | NO   |     | NULL                |                |
//| module_id         | bigint(20)              | NO   |     | NULL                |                |
//| seq_no            | bigint(20)              | NO   |     | NULL                |                |
//| question_id       | bigint(20)              | NO   |     | NULL                |                |
//| answer_id         | bigint(20)              | NO   |     | NULL                |                |
//| answer_text       | text                    | NO   |     | NULL                |                |
//| points_earned     | int(11)                 | NO   |     | NULL                |                |
//| date_start        | timestamp               | NO   |     | 0000-00-00 00:00:00 |                |
//| date_end          | timestamp               | NO   |     | 0000-00-00 00:00:00 |                |
//| total_time        | int(11)                 | NO   |     | NULL                |                |
//| answer_status     | enum('Correct','Wrong') | NO   |     | NULL                |                |
//| created_by        | bigint(20)              | NO   |     | NULL                |                |
//| updated_by        | bigint(20)              | NO   |     | NULL                |                |
//| created_at        | timestamp               | NO   |     | 0000-00-00 00:00:00 |                |
//| updated_at        | timestamp               | NO   |     | 0000-00-00 00:00:00 |                |
//| deleted_at        | timestamp               | YES  |     | NULL                |                |
//+-------------------+-------------------------+------+-----+---------------------+----------------+


	public function store(StudentModuleAnswerRequest $request){


		$data = $request->only(
			'student_module_id',
			'module_id',
			'seq_no',
			'question_id',
			'answer_id',
			'answer_text',
			'student_id',
			'date_start',
			'date_end'
		);

		//ADD ANSWER



		//check type of question
		$question_type = $this->question->getQuestionType($data['question_id']);

		//check answer and points
		if($question_type == config('futureed.question_type_multiple_choice')){

			//Get answer and point from question_answers.
			$answer = $this->question_answer->getQuestionCorrectAnswer($data['answer_id']);

			$data['answer_status'] = ($answer == config('futureed.yes')) ?
				config('futureed.answer_status_correct') :
				config('futureed.answer_status_wrong');

			$data['points_earned'] = $this->question_answer->getQuestionPointEquivalent($data['answer_id']);


		}else {

			//Get answer and point from Question.
			$question_answer = $this->question->getQuestionAnswer($data['question_id']);


			$data['answer_status'] = ($data['answer_text'] == $question_answer) ?
				config('futureed.answer_status_correct') :
				config('futureed.answer_status_wrong');

			$data['points_earned'] = ($data['answer_text'] == $question_answer) ?
				//get points earned from question
				$this->question->getQuestionPointsEarned($data['question_id'])
				  : 0 ;
		}

		//check total_time
		$data['date_start'] = Carbon::parse($data['date_start']);
		$data['date_end'] = Carbon::parse($data['date_end']);
		$data['total_time'] = Carbon::parse($data['date_start'])->diffInSeconds(Carbon::parse($data['date_end']));


		//to be computed
		// points_earned, total_time, answer_status


		//Adding to record.
		$student_answer = $this->student_module_answer->addStudentModuleAnswer($data);


		//UPDATE STUDENT MODULE SCORES

		//get necessary data to compare.
		$student_module  = $this->student_module->getStudentModule($data['student_module_id']);
		$points_to_finish = $this->module->getModulePointsToFinish($data['module_id']);


/*
		"id" => 1
  "class_id" => 1
  "student_id" => 1
  "module_id" => 18
  "module_status" => "On Going" -- check if points to finish is satisfied.


  "date_start" => "-0001-11-30 00:00:00"
  "date_end" => "-0001-11-30 00:00:00" -- if points to finish is satisfied. $data['date_end']
  "total_time" => 0 -- $data['date_end'] - date_start

 --"progress" => 0 -- correct answer / points to finish for over all. leave it.
  --"question_counter" => 0 -- how many question taken
  --"wrong_counter" => 0 -- if equals to 3 = minus points reset value.
  --"correct_counter" => 0 -- how many correct
  --"running_points" => 0 -- minus 1 point
  --"points_earned" => 0 -- how points you just earned

  "last_viewed_content_id" => null -- get teaching_content id
  "last_answered_question_id" => 56

  "total_correct_answer" => 0
  "current_difficulty_level" => 0

ADDTIONAL OUTPUT
quote trigger with avatar pose
next question

*/
		//CURRENT UPDATE

		//question counter
		$student_module->question_counter++;

		//wrong counter
		if($student_answer->answer_status == config('futureed.answer_status_wrong')){

			$student_module->wrong_counter++;

			if($student_module->wrong_counter == 3){

				$student_module->running_points--;
			}
		}

		//correct counter
		if($student_answer->answer_status == config('futureed.answer_status_correct')){
			$student_module->correct_counter++;
		}

		//points just earned
		$student_module->points_earned = $student_answer->points_earned;

		//last_viewed_content_id -- get current content_id
		$student_module->last_viewed_content_id = $this->teaching_content->getTeachingContentId($data['module_id']);

		//last_answered_question_id
		$student_module->last_answered_question_id = $data['module_id'];

		//update module_status
		if($student_module->running_points >= $points_to_finish){

			$student_module->module_status = config('futureed.module_status_completed');

		} else {

			$student_module->module_status = config('futureed.module_status_ongoing');

		}

		$this->student_module->updateStudentModule($data['module_id'],$student_module);

		return $this->respondWithData($student_module->toArray());
		//Quote Trigger
		//next question sets

	}
}