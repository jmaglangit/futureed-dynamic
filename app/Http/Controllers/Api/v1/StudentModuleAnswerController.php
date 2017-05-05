<?php namespace FutureEd\Http\Controllers\Api\v1;

use Carbon\Carbon;
use FutureEd\Http\Requests\Api\StudentModuleAnswerRequest;
use FutureEd\Models\Repository\AvatarPose\AvatarPoseRepositoryInterface;
use FutureEd\Models\Repository\AvatarQuote\AvatarQuoteRepositoryInterface;
use FutureEd\Models\Repository\AvatarWiki\AvatarWikiRepositoryInterface;
use FutureEd\Models\Repository\Classroom\ClassroomRepositoryInterface;
use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\QuestionAnswer\QuestionAnswerRepositoryInterface;
use FutureEd\Models\Repository\Quote\QuoteRepositoryInterface;
use FutureEd\Models\Repository\SnapExerciseDetails\SnapExerciseDetailsRepositoryInterface;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface;
use FutureEd\Models\Repository\StudentModule\StudentModuleRepositoryInterface;
use FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface;
use FutureEd\Models\Repository\TeachingContent\TeachingContentRepositoryInterface;
use FutureEd\Services\BadgeServices;
use FutureEd\Services\EquationCompilerServices;
use FutureEd\Services\ModuleContentServices;
use FutureEd\Services\QuestionCacheServices;
use FutureEd\Services\QuestionServices;
use FutureEd\Services\StudentModuleServices;

class StudentModuleAnswerController extends ApiController{

    protected $avatar_pose;
    protected $avatar_quotes;
    protected $avatar_wiki;
    protected $question;
    protected $question_answer;
	protected $question_service;
    protected $quote;
    protected $student;
    protected $student_module;
    protected $student_module_answer;
	protected $module;
	protected $teaching_content;
	protected $student_module_services;
	protected $module_content;
	protected $module_content_services;
	protected $badge_services;
	protected $snap_exercise_details;
	protected $equation_compiler;
	protected $question_cache_service;

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
		StudentModuleServices $studentModuleServices,
		ModuleContentServices $moduleContentServices,
		QuestionServices $questionServices,
		BadgeServices $badgeServices,
		ModuleRepositoryInterface $moduleRepositoryInterface,
		SnapExerciseDetailsRepositoryInterface $snapExerciseDetailsRepositoryInterface,
		EquationCompilerServices $equationCompilerServices,
		QuestionCacheServices $questionCacheServices
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
		$this->module_content = $moduleContentRepositoryInterface;
		$this->teaching_content = $teachingContentRepositoryInterface;
		$this->student_module_services = $studentModuleServices;
		$this->module_content_services = $moduleContentServices;
		$this->question_service = $questionServices;
		$this->badge_services = $badgeServices;
		$this->module = $moduleRepositoryInterface;
		$this->snap_exercise_details = $snapExerciseDetailsRepositoryInterface;
		$this->equation_compiler = $equationCompilerServices;
		$this->question_cache_service = $questionCacheServices;
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
			'date_end',
			'is_dynamic'
		);

		//check if module has complete setup.
		if(!$this->module_content_services->checkModuleComplete($data['module_id']) && is_null($data['is_dynamic'])){

			return $this->respondErrorMessage(2058);
		}

		//TODO check if dynamic module has complete required no of questions.


		//check if module has been completed.
		if($this->student_module->getStudentModuleStatus($data['student_module_id']) == config('futureed.module_status_completed')){

			return $this->respondErrorMessage(2055);
		}

		//check if wrong is equal to 10.
		if($this->student_module->getStudentModuleStatus($data['student_module_id']) == config('futureed.module_status_failed')){

			return $this->respondErrorMessage(2056);
		}

		//check if questions


		//ADD ANSWER

		//check module
		$module = $this->module->getModule($data['module_id']);

		//check type of question
		$question_type = $this->question->getQuestionType($data['question_id']);

		//check answer and points
		//check if module is dynamic or not
		if($module->is_dynamic){
			//output answer if correct or not
			$dynamic_response = $this->equation_compiler->additionCheckAnswer($data['question_id'],$data['answer_text']);

			$data['seq_no'] = 0	;
			$data['points_earned'] = 1;
			$data['answer_status'] = ($dynamic_response)
				? config('futureed.answer_status_correct') :
				config('futureed.answer_status_wrong');
			//output correct or wrong based on boolean output of dynamic.
		} elseif($question_type == config('futureed.question_type_multiple_choice')){

			//Get answer and point from question_answers.
			$answer = $this->question_answer->getQuestionCorrectAnswer($data['answer_id']);

			$data['answer_status'] = ($answer == config('futureed.yes')) ?
				config('futureed.answer_status_correct') :
				config('futureed.answer_status_wrong');

			$data['points_earned'] = $this->question_answer->getQuestionPointEquivalent($data['answer_id']);


		}elseif($question_type == config('futureed.question_type_graph')){
			//if question is graph

			//check answer graph if correct
			//check answer if valid
			if(!json_decode($data['answer_text'])){

				return $this->respondErrorMessage(2069);
			}

			//get answer
			$answer = $this->question->getQuestionAnswer($data['question_id']);


			//compare answers
			$graph_result = $this->question_service->validateGraphAnswer($data['answer_text'],$answer);


			//designate points and results
			$data['answer_status'] = ($graph_result) ?
				config('futureed.answer_status_correct') :
				config('futureed.answer_status_wrong');

			$data['points_earned'] = ($graph_result) ?
				$this->question->getQuestionPointsEarned($data['question_id'])
				: 0;


		}elseif($question_type == config('futureed.question_type_quad')){
			//if question is quad (quadrant)

			//validate json format.
			if(!json_decode($data['answer_text'])){

				return $this->respondErrorMessage(2069);
			}

			//get answer
			$answer = $this->question->getQuestionAnswer($data['question_id']);

			//compare answers
			$graph_result = $this->question_service->validateQuadrantAnswer($data['answer_text'],$answer);

			//designate points and results
			$data['answer_status'] = ($graph_result) ?
				config('futureed.answer_status_correct') :
				config('futureed.answer_status_wrong');

			$data['points_earned'] = ($graph_result) ?
				$this->question->getQuestionPointsEarned($data['question_id'])
				: 0;


		}
		else if($question_type == config('futureed.question_type_coding'))
		{
			$class_id = $this->student_module->getStudentModuleClassId($data['student_module_id']);
			$order_id = $this->snap_exercise_details->findOrderIdByClassroomId($class_id);
			$completed_exercise = $this->snap_exercise_details->getCompletedExercisesByOrder($order_id);
			$data['question_id'] = $this->snap_exercise_details->getFirstCompletedExercises($order_id);
			$data['total_time'] = 0;

			foreach($completed_exercise as $exercise)
			{
				$data['total_time'] += $exercise->date_start->diffInSeconds($exercise->date_end);
			}

			$data['points_earned'] = 0;
			$data['answer_status'] = config('futureed.answer_status_correct');
			$data['seq_no'] = $completed_exercise->first()->question_seq_no;

		} else if(in_array($question_type,[config('futureed.question_type_fill_in_the_blank'),config('futureed.question_type_provide_answer')])){

			//Get answer and point from Question.
			$question_answer = $this->question->getQuestionAnswer($data['question_id']);

			if(empty($question_answer) || is_null($question_answer)){

				//return error to contact admin
				return $this->respondErrorMessage(2055);

			} else {

				//decode answer of FIB and N
				$question_answer = json_decode($question_answer);

				//check if ordering or interchange
				if($question_answer->type == 1){
					//answer in order
					$result =  $this->student_module_services->answerOrdering($data['answer_text'],$question_answer->answer);
				} else{
					//answer can interchange
					$result = $this->student_module_services->answerInterchange($data['answer_text'],$question_answer->answer);
				}

				$data['answer_status'] = ($result) ? config('futureed.answer_status_correct') :
					config('futureed.answer_status_wrong');

				$data['points_earned'] = ($result) ?
					$this->question->getQuestionPointsEarned($data['question_id'])
					: 0;
			}

		} else {
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

		if($question_type != config('futureed.question_type_coding')){
			$data['total_time'] = Carbon::parse($data['date_start'])->diffInSeconds(Carbon::parse($data['date_end']));
		}

		//to be computed
		// points_earned, total_time, answer_status

		//Adding to record to student_module_answer table
		$student_answer = $this->student_module_answer->addStudentModuleAnswer($data);


		//UPDATE STUDENT MODULE SCORES

		//get necessary data to compare.
		$student_module  = $this->student_module->getStudentModule($data['student_module_id']);
		$points_to_finish = $this->module_content->getModulePointsToFinish($data['module_id']);
		$module = $this->module->getModule($data['module_id']);


		//CURRENT UPDATE

		//question counter
		if($question_type != config('futureed.question_type_coding')) {
			$student_module->question_counter++;
		}

		//wrong counter
		if($student_answer->answer_status == config('futureed.answer_status_wrong') && !$module->no_difficulty){

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
		if($student_answer->answer_status == config('futureed.answer_status_correct'))
		{
			if($question_type != config('futureed.question_type_coding'))
			{
				$student_module->running_points += $student_answer->points_earned;
				$student_module->correct_counter++;
			}
			$student_module->wrong_counter = 0;
		}

		//points just earned
		$student_module->points_earned = $student_answer->points_earned;

		//last_viewed_content_id -- get current content_id
		$student_module->last_viewed_content_id = $this->teaching_content->getTeachingContentId($data['module_id']);

		//last_answered_question_id
		//$student_module->last_answered_question_id = $data['module_id'];

		//update module_status
		//check if student reaches the end of the questions and set completed, else continue
		if($student_module->running_points >= $points_to_finish ||
			!$module->no_difficulty && !$this->student_module_services->getNextQuestion(
				$data['student_module_id'],
				$data['module_id'],
				$student_answer
			)){

			$student_module->module_status = config('futureed.module_status_completed');

			//get module to get subject and grade
			$module = $this->module->getModule($data['module_id']);

			//Nominate for badge.
			$this->badge_services->checkBadgeCandidate($data['student_id'],$module->subject_id,$module->grade_id);

			//update student can play
			$this->student->updateStudentDetails($data['student_id'],['can_play' => config('futureed.true')]);


		} //when 10 wrong answer set status to Failed.
		elseif($student_module->wrong_counter >= 10 && !$this->module->getModuleDifficulty($data['module_id'])){

			$student_module->module_status = config('futureed.module_status_failed');

		} else {

			$student_module->module_status = config('futureed.module_status_ongoing');
		}

		//progress correct_counter/ points_to_finish
		$progress = ($student_module->running_points /$points_to_finish) * 100 ;
		$student_module->progress = ($progress < 0 )? 0 : $progress;

		//update student module details
		$return = $this->student_module->updateStudentModule($student_module->id,$student_module);

		//next question sets
		if(is_null($data['is_dynamic'])){
			$next_question = $this->student_module_services->getNextQuestion(
				$data['student_module_id'],
				$data['module_id'],
				$student_answer
			);
		} else {

			//TODO set dynamic next questions
			$next_question = $this->question_cache_service->dynamicNextQuestion(
				$data['student_module_id'],
				$data['module_id'],
				$student_answer
			);
			// question is question_cache table
//			dd($next_question);
		}


		//Check if next question is equal to -1
		if($module->no_difficulty && $next_question == -1){

			$student_module->module_status = config('futureed.module_status_completed');
			//once completed percentage automatically 100%
			$student_module->progress = 100;
			$this->student_module->updateStudentModule($student_module->id,$student_module);
			$return->next_question = $next_question;
			$return->module_status = $student_module->module_status;
			return $this->respondWithData($return);


		} elseif ($next_question == -1 || is_null($next_question) ){

			//Set student Module to failed.
			$student_module->module_status = config('futureed.module_status_failed');
			$this->student_module->updateStudentModule($student_module->id,$student_module);

			return $this->respondErrorMessage(2056);

		} else {

			$return->next_question = $next_question;
			if($question_type === config('futureed.question_type_coding')) {
				$return->snap_module_completed = config('futureed.true');
			}
			return $this->respondWithData($return);
		}

	}
}