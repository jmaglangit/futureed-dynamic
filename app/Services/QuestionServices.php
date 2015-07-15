<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;

class QuestionServices {

	/**
	 * Initialized variable.
	 * @var QuestionRepositoryInterface
	 */
	protected $question;

	/**
	 * Initialized
	 * @param QuestionRepositoryInterface $questionRepositoryInterface
	 */
	public function __construct(
		QuestionRepositoryInterface $questionRepositoryInterface
	){
		$this->question = $questionRepositoryInterface;

	}

	/**
	 * Get current sequence and remove the seq_no indicated.
	 * @param $module_id
	 * @param $seq_no
	 * @return mixed
	 */
	public function updateSequence($module_id, $seq_no){

		//get sequence number
		$sequence = $this->question->getQuestionSequenceNos($module_id);

		foreach($sequence as $seq => $list){

			if($list->seq_no >= $seq_no && $list->seq_no >= $seq_no){

				$list->seq_no++;
			}
		}

		return $sequence;
	}

	/**
	 * Pull sequence number.
	 * @param $module_id
	 * @param $seq_no
	 */
	public function pullSequenceNo($module_id, $seq_no,$id){

		//get sequence number
		$sequence = $this->question->getQuestionSequenceNos($module_id);


		foreach($sequence as $seq => $list){

			//retrack sequence
			if($list->id == $id){

				$list->seq_no = 0;
			}

			if($list->seq_no > $seq_no){

				$list->seq_no--;
			}
		}

		return $sequence;
	}

}