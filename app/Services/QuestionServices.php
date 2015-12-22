<?php namespace FutureEd\Services;


use FutureEd\Models\Repository\Question\QuestionRepositoryInterface;
use Illuminate\Filesystem\Filesystem;

class QuestionServices {

	/**
	 * Initialized variable.
	 * @var QuestionRepositoryInterface
	 */
	protected $question;

	/**
	 * Initialized file.
	 * @var
	 */
	protected $file;

	/**
	 * Initialized
	 * @param QuestionRepositoryInterface $questionRepositoryInterface
	 */
	public function __construct(
		QuestionRepositoryInterface $questionRepositoryInterface,
		Filesystem $filesystem
	){
		$this->question = $questionRepositoryInterface;
		$this->file = $filesystem;

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

	/**
	 * Update Graph Image Content.
	 * @param $content
	 * @param array $images
	 * @return string
	 */
	public function updateGraphContentImage($content, $images = []){

		$graph_content = json_decode($content);

		$graph_content->image = $images;

		return json_encode($graph_content);

	}

	/**
	 * Transfer graph image files.
	 * @param $id
	 * @param $answers
	 * @return array
	 */
	public function graphImageFileTransfer($id,$answers) {

		$graph_answer = json_decode($answers);
		$image_seq = 1;
		$graph_content = [];

		foreach ($graph_answer->answer as $answer) {

			$image_content = new \stdClass();

			//check image if it is in temp location
			$path_check = strstr(base_path() . '/public' . $answer->image, config('futureed.question_image_path'));
			$temp_file = base_path() . '/public' . $answer->image;

			if ($path_check) {

				//get file extension.
				$file = explode('.', $answer->image);

				//generate filename
				$filename = str_replace(' ', '-', $answer->field . '.' . $file[1]);

				//local destination file
				$destination = config('futureed.question_image_path_final') . '/' . $id . '/' . $filename;

				//app destination file.
				$app_path = config('futureed.question_image_path_final_public') . '/' . $id . '/' . $filename;

				//check if file exists.
				if ($this->file->exists($destination)) {

					//delete file
					$this->file->delete($destination);
				}

				//copy files from temp to destination question folder.
				if ($this->file->copy($temp_file, $destination)) {

					$answer->image = $app_path;
				}
			}

			//content image
			$image_content->field = $answer->field;
			$image_content->path = $answer->image;
			$image_content->seq_no = $image_seq++;

			array_push($graph_content, $image_content);

		}

		return [
			'answer' => json_encode($graph_answer),
			'content' => $graph_content
		];
	}

	/**
	 * Update Orientation.
	 * @param $content
	 * @param null $orientation
	 * @return string
	 */
	public function updateContentOrientation($content, $orientation = NULL){

		$graph_content = json_decode($content);

		$graph_content->orientation = $orientation;

		return json_encode($graph_content);
	}

	/**
	 * Validate Graph Answer.
	 * @param $input
	 * @param $source
	 * @return bool
	 */
	public function validateGraphAnswer($input, $source){

		$input = (array) json_decode($input);

		$source = (array) json_decode($source);

		//check input if has answer
		if(!isset($input['answer'])){
			return false;
		}elseif(count($input['answer']) <> count($source['answer'])){
			return false;
		}

		//parse source answer
		foreach($input['answer'] as $answer){

			foreach($source['answer'] as $correct){


				if($answer->field == $correct->field && $answer->count == $correct->count && $answer->count_objects == $correct->count_objects){

					array_shift($input['answer']);
				}
			}
		}

		return (empty($input['answer'])) ? true : false;
	}

	/**
	 * Get Orientation.
	 * @param $content
	 * @return string
	 */
	public function getGraphOrientation($content){

		$graph_content = json_decode($content);
		$response = '';

		if(isset($graph_content->orientation)){
			$response = $graph_content->orientation;
		}

		return $response;
	}
}