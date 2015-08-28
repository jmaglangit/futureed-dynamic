<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Services\IAssessServices as iAssess;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use FutureEd\Http\Requests\Api\LearningStyleRequest;

use FutureEd\Models\Repository\StudentLsScore\StudentLsScoreRepositoryInterface as StudentLsScore;
use FutureEd\Models\Repository\StudentLsAnswer\StudentLsAnswerRepositoryInterface as StudentLsAnswer;
use FutureEd\Models\Repository\LearningStyle\LearningStyleRepositoryInterface as LearningStyle;
use FutureEd\Models\Repository\Student\StudentRepositoryInterface as Student;

use FutureEd\Services\StudentServices;

class AssessController extends ApiController {

	/**
     *   holds the iAssess Service
     */
	protected $iassess;
	
	/**
     *   holds the StudentLsScoreRepositoryInterface
     */
	protected $student_ls_score;
	
	/**
     *   holds the StudentLsAnswerRepositoryInterface
     */
	protected $student_ls_answer;
	
	/**
     *   holds the LearningStyleRepositoryInterface
     */
	protected $learning_style;


	/**
     *   holds the StudentRepositoryInterface
     */
	protected $student;

	
	/**
     *   holds the Student Services
     */
	protected $student_service;

	/**
	 * Assess Controller constructor
	 *
	 * @param IAssessServices
	 * @return void
	 */
	public function __construct(iAssess $iassess,
		StudentLsScore $student_ls_score,
		StudentLsAnswer $student_ls_answer,
		LearningStyle $learning_style,
		Student $student,
		StudentServices $student_service) 
	{
		$this->iassess = $iassess;
		$this->student_ls_score = $student_ls_score;
		$this->student_ls_answer = $student_ls_answer;
		$this->student_service = $student_service;
		$this->learning_style = $learning_style;
		$this->student = $student;
	}

	/**
	 * get Test data
	 *
	 * @param void
	 * @return Resource
	 */
	 public function getTest(){
		
		$is_adult = false;
		
		if($student_id = Input::get('student_id')) {
			if($this->student_service->getAge($student_id) >= config('futureed.lsp_for_adult_age')) {
				$is_adult = true;
			}
		}
		
		if($this->iassess->getTestData($is_adult)) {
		
			$data = $this->iassess->data;
			
			return $this->respondWithData($data);
			
		} else {
		
			return $this->respondWithError();
			
		}

    }

	/**
	 * save Test data
	 *
	 * @param void
	 * @return Resource
	 */
	 public function saveTest(LearningStyleRequest $request){

		$input = Input::all();
		
		$student_id = $input['student_id'];
				
		if($this->iassess->saveTestData($input)) {
		
			#save answers
			if($input['user_answers']) {
				$sequence_no = 1;
				foreach($input['user_answers'] as $answer) {
				
					if($answer['answers'] && count($answer['answers']) > 0) {
						$answer_data = array();
					
						$answer_data['student_id'] = $student_id;
						$answer_data['ls_test_id'] = $input['test_id'];
						$answer_data['ls_section_id'] = $input['section_id'];
						$answer_data['ls_seq_no'] = $sequence_no;
						$answer_data['ls_test_question_id'] = $answer['test_question_id'];
						$answer_data['ls_question_code_id'] = $answer['question_code_id'];
						$answer_data['ls_question_code_detail_id'] = $answer['question_code_detail_id'];
						$answer_data['ls_question_answer_id'] = $answer['answers'][0]['answer_id'];
						$answer_data['ls_answer_text'] = $answer['answers'][0]['answer_text'];
						$answer_data['ls_raw_score'] = 0;
						
						$added_answer = $this->student_ls_answer->addAnswer($answer_data);
						
						$sequence_no++;
					}
				}
			}
		
			$data = $this->iassess->data;
			
			foreach($data as $score) {
				#save scores
				
				$save_data = array();
				
				$save_data['student_id'] = $score['student_id'];
				$save_data['ls_test_id'] = $score['test_id'];
				$save_data['ls_group'] = $score['group'];
				$save_data['ls_name'] = $score['name'];
				$save_data['ls_seq_no'] = $score['seq_no'];
				$save_data['ls_std_score'] = $score['std_score'];
				$save_data['ls_percentile'] = $score['percentile'];
				$save_data['ls_banding'] = $score['banding'];
				
				if(strcmp($score['name'], config('futureed.lsp_result_name')) == 0) {
					$matched_learning_style =  $this->learning_style->getLearningStyleByBanding($score['banding']);
					
					if($matched_learning_style) {
						$this->student->updateLearningStyle($student_id, $matched_learning_style->id);
					} else {
						$this->student->updateLearningStyle($student_id, config('futureed.default_lsp'));
					}
				}
				
				$score = $this->student_ls_score->addScore($save_data);
			}
			
			return $this->respondWithData($data);
			
		} else {
		
			return $this->respondWithError();
			
		}

    }


}