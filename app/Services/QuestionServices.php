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
	public function updateSequence($module_id, $seq_no, $difficulty){

		//get sequence number
		$sequence = $this->question->getQuestionSequenceNos($module_id, $difficulty);

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
	public function pullSequenceNo($module_id, $seq_no,$id,$difficulty){

		//get sequence number
		$sequence = $this->question->getQuestionSequenceNos($module_id,$difficulty);


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

	/**
	 * Get graph dimension based on the highest answer count.
	 * @param $answers
	 * @return int
	 */
	public function getGraphDimension($answers){

		$dimension = 5;

		foreach($answers as $data){
			if($data->count > $dimension){
				$count_mod = $data->count % config('futureed.graph_divisible');
				$dimension = $data->count + (config('futureed.graph_divisible') - $count_mod);
			}
		}

		return $dimension;
	}

	/**
	 * Get quadrant dimension based on the answer coordinates.
	 * @param $answers
	 * @return int|number
	 */
	public function getQuadDimension($answers){

		$dimension = 5;

		foreach($answers as $data){
			foreach($data as $d){
				$axes = abs($d);
				if($axes > $dimension){
					$count_mod = $axes % config('futureed.graph_divisible');
					$dimension = $axes + (config('futureed.graph_divisible') - $count_mod);
				}
			}
		}

		return $dimension;
	}

	/**
	 * Generate Graph answers in json format.
	 * @param array $answer
	 * @return string
	 */
	public function getGraphAnswerJson(array $answer = []){

		$answers = new \stdClass();

		$answers->answers = $answer;

		return json_encode($answers);
	}

	/**
	 * Generate Graph Content in json format.
	 * @param null $orientation
	 * @param array $images
	 * @return string
	 */
	public function getGraphContentJson($orientation = NULL, $images = []){

		$contents = new \stdClass();

		$contents->orientation = $orientation;

		$contents->image = (empty($images)) ? [] : $images;

		return json_encode($contents);

	}



}