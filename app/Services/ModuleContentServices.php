<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\ModuleContent\ModuleContentRepositoryInterface;
use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;

class ModuleContentServices
{

	/**
	 * @var ModuleContentRepositoryInterface
	 */
	protected $module_content;

	protected $question;

	/**
	 * @param ModuleContentRepositoryInterface $moduleContentRepositoryInterface
	 * @param QuestionRepositoryInterface $questionRepositoryInterface
	 */
	public function __construct(
		ModuleContentRepositoryInterface $moduleContentRepositoryInterface,
		QuestionRepositoryInterface $questionRepositoryInterface

	)
	{
		$this->module_content = $moduleContentRepositoryInterface;
		$this->question = $questionRepositoryInterface;
	}

	/**
	 * Sort sequence by adding.
	 * @param $module_id
	 * @param $seq_no
	 * @return mixed
	 */
	public function updateSequence($module_id, $seq_no)
	{

		//get sequence number
		$sequence = $this->module_content->getModuleContentSequenceNos($module_id);


		foreach ($sequence as $seq => $list) {

			if ($list->seq_no >= $seq_no && $list->seq_no >= $seq_no) {

				$list->seq_no++;
			}
		}

		return $sequence;
	}

	/**
	 * @param $module_id
	 * @param $seq_no
	 * @param $id
	 * @return mixed
	 */
	public function pullSequenceNo($module_id,$seq_no, $id){

		//get sequence number
		$sequence = $this->module_content->getModuleContentSequenceNos($module_id);


		foreach ($sequence as $seq => $list) {

			//retrack sequence
			if ($list->id == $id) {

				$list->seq_no = 0;
			}

			if ($list->seq_no > $seq_no) {

				$list->seq_no--;
			}
		}

		return $sequence;
	}

	/**
	 * Check module if it has complete setup.
	 * @param $module_id
	 * @return bool
	 */
	public function checkModuleComplete($module_id){

		//get question modules
		$questions = $this->question->getQuestionLevelsByModule($module_id);


		//Check module if it has complete difficulty level.
		$difficulty_levels = [1,2,3];

		foreach($questions as $data){

			if(!in_array($data->difficulty, config('futureed.question_difficulty_levels'))){
				if(!($data->question_type === config('futureed.question_type_coding'))) {
					return false;
				}
			}
		}

		//Check each level has minimum 4 questions.
		foreach($difficulty_levels as $level){

			$question_count = $this->question->countQuestions($module_id,$level);

			if($question_count < config('futureed.question_minimum_count')){

				return false;
			}
		}

		return true;

	}


}