<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Module\ModuleRepositoryInterface;
use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use FutureEd\Models\Repository\StudentModuleAnswer\StudentModuleAnswerRepositoryInterface;

class StudentModuleServices {

	protected $module;

	protected $question;

	protected $student_module_answer;



	public function __construct(
		ModuleRepositoryInterface $moduleRepositoryInterface,
		QuestionRepositoryInterface $questionRepositoryInterface,
		StudentModuleAnswerRepositoryInterface $studentModuleAnswerRepositoryInterface
	){
		$this->module = $moduleRepositoryInterface;

		$this->question = $questionRepositoryInterface;

		$this->student_module_answer = $studentModuleAnswerRepositoryInterface;

	}

	//TODO: get answers from db
	public function getModuleQuestions($module_id){

		//parse by
		return $this->question->getQuestionsByModule($module_id);
	}

	//TODO: parse; get modules questions and levels


	//TODO: merge module answer


	//TODO: output questions to take.

}