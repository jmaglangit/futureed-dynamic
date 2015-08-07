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
use FutureEd\Services\StudentModuleServices;
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
	protected $student_module_services;


	public function __construct(
		AvatarPoseRepositoryInterface $avatar_pose,
		AvatarQuoteRepositoryInterface $avatar_quotes,
		AvatarWikiRepositoryInterface $avatar_wiki,
		QuestionRepositoryInterface $question,
		QuestionAnswerRepositoryInterface $question_answer,
		QuoteRepositoryInterface $quote,
		StudentModuleRepositoryInterface $student_module,
		StudentModuleAnswerRepositoryInterface $student_module_answer,
		StudentRepositoryInterface $student,
		ModuleContentRepositoryInterface $moduleContentRepositoryInterface,
		TeachingContentRepositoryInterface $teachingContentRepositoryInterface,
		StudentModuleServices $studentModuleServices
	)
	{

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
		$this->student_module_services = $studentModuleServices;
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

	/**
	 * New Student Module Answer
	 * @param StudentModuleAnswerRequest $request
	 * @return mixed
	 */
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

		//check if module has been completed.
		if($this->student_module->getStudentModuleStatus($data['student_module_id']) == config('futureed.module_status_completed')){

			return $this->respondErrorMessage(2055);
		}

		//check if wrong is equal to 10.
		if($this->student_module->getStudentModuleStatus($data['student_module_id']) == config('futureed.module_status_failed')){

			return $this->respondErrorMessage(2056);
		}


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


			$data['answer_status'] = (strcasecmp(trim($data['answer_text']),trim($question_answer)) == 0) ?
				config('futureed.answer_status_correct') :
				config('futureed.answer_status_wrong');

			$data['points_earned'] = (strcasecmp(trim($data['answer_text']),trim($question_answer)) == 0) ?
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

		//CURRENT UPDATE

		//question counter
		$student_module->question_counter++;

		//wrong counter
		if($student_answer->answer_status == config('futureed.answer_status_wrong')){

			//increment wrong counter.
			$student_module->wrong_counter++;




			//starting 3 consecutive wrongs to minus 1 to correct points.
			if($student_module->wrong_counter >= 3){
				$student_module->running_points--;;
			}

		}

		//Date update
		$student_module->date_end = $data['date_end'];
		$student_module->total_time = Carbon::parse($student_module->date_start)->diffInSeconds(Carbon::parse($data['date_end']));

		//correct counter
		if($student_answer->answer_status == config('futureed.answer_status_correct')){

			$student_module->running_points += $student_answer->points_earned;
			$student_module->correct_counter++;
			$student_module->wrong_counter = 0;

		}

		//points just earned
		$student_module->points_earned = $student_answer->points_earned;

		//last_viewed_content_id -- get current content_id
		$student_module->last_viewed_content_id = $this->teaching_content->getTeachingContentId($data['module_id']);

		//last_answered_question_id
		//$student_module->last_answered_question_id = $data['module_id'];

		//update module_status
		if($student_module->running_points >= $points_to_finish){

			$student_module->module_status = config('futureed.module_status_completed');

		} //when 10 wrong answer set status to Failed.
		elseif($student_module->wrong_counter >= 10){

			$student_module->module_status = config('futureed.module_status_failed');

		} else {

			$student_module->module_status = config('futureed.module_status_ongoing');
		}

		//progress correct_counter/ points_to_finish
		$progress = ($student_module->running_points /$points_to_finish) * 100 ;
		$student_module->progress = ($progress < 0 )? 0 : $progress;

		$return = $this->student_module->updateStudentModule($student_module->id,$student_module);

		//next question sets
		$return->next_question = $this->student_module_services->getNextQuestion($data['student_module_id'],$data['module_id']);


		return $this->respondWithData($return);



	}
}