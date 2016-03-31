<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests\Api\TrialModuleRequest;
use Illuminate\Support\Facades\Input;
use League\Csv\Reader;

class StudentTrialModuleController extends ApiController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$question_reader = Reader::createFromPath(storage_path('seeders/trial-module/csv/') . 'questions.csv');
		$question_answer_reader = Reader::createFromPath(storage_path('seeders/trial-module/csv/') . 'question_answer.csv');
		$image_path = url('images/trial-module/images/questions');

		$datum = [];
		$index = 0;

		foreach($question_reader as $data_row) {
			if($data_row[3] === config('futureed.question_type_provide_answer')){
				$datum[$index] = [
					'type' => $data_row[3],
					'question' => $data_row[4],
					'question_image' => $data_row[6] == '' ? 'none' : $image_path.'/'.$data_row[6]
				];
			}
			else if($data_row[3] === config('futureed.question_type_multiple_choice')) {
				$choices_list = [];
				$number_of_choices = [];
				$choices_list_index = 0;

				foreach($question_answer_reader as $choices) {
					if($choices['2'] == $data_row[0]) {
						$choices_list[$choices_list_index]['string_choice'] = $choices[5] != '' ? $choices[5] : 'none';
						$choices_list[$choices_list_index]['image_choice'] = $choices[6] != '' ? $image_path.'/'.$choices[6] : 'none';

						$number_of_choices[$choices_list_index] = $choices_list_index;
						$choices_list_index++;
					}
				}

				$datum[$index] = [
					'type' => $data_row[3],
					'question' => $data_row[4],
					'question_image' => $data_row[6] == '' ? 'none' : $image_path.'/'.$data_row[6],
					'number_of_choices' => $number_of_choices,
					'choices_list' => $choices_list
				];
			}
			else if($data_row[3] === config('futureed.question_type_fill_in_the_blank')) {
				$answer_list = preg_split('/[\W]/',$data_row[7], -1, PREG_SPLIT_NO_EMPTY);
				$number_of_blanks = new \SplFixedArray(count($answer_list));
				$number_of_blanks = array_fill(0, count($number_of_blanks), ' ');

				$datum[$index] = [
					'type' => $data_row[3],
					'question' => $data_row[4],
					'question_image' => $data_row[6] == '' ? 'none' : $image_path.'/'.$data_row[6],
					'number_of_blanks' => $number_of_blanks
				];
			}
			else if($data_row[3] === config('futureed.question_type_ordering')) {
				$unordered_list = preg_split('/[\W]/',$data_row[8], -1, PREG_SPLIT_NO_EMPTY);
				$datum[$index] = [
					'type' => $data_row[3],
					'question' => $data_row[4],
					'question_image' => $data_row[6] == '' ? 'none' : $image_path.'/'.$data_row[6],
					'unordered_list' => $unordered_list
				];
			}
			else if($data_row[3] === config('futureed.question_type_graph'))
			{
				$graph_content = (array)json_decode($data_row[9]);
				$temp = [];
				$max_column = [];

				foreach($graph_content['image'] as $key => $image_prop) {
					$temp[$key] = $image_prop->seq_no;
				}

				for($i = 0; $i < max($temp) ; $i++) {
					$max_column[$i] = $i;
				}

				$datum[$index] = [
					'type' => $data_row[3],
					'question' => $data_row[4],
					'question_image' => $data_row[6] == '' ? 'none' : $image_path.'/'.$data_row[6],
					'orientation' => $graph_content['orientation'],
					'table_image' => $graph_content['image'],
					'number_of_columns' => $max_column
				];
			}
			else if($data_row[3] === config('futureed.question_type_quad'))
			{
				$temp = (json_decode($data_row[7]));
				$coordinates = (array)$temp->answer[0];

				$max = max($coordinates);
				$graph_dimension = $max < 5 ? 5 : intval(round($max, -1));

				foreach($coordinates as $axis => $value) {
					$dimension[$axis] = $graph_dimension;
				}

				$datum[$index] = [
					'type' => $data_row[3],
					'question' => $data_row[4],
					'question_image' => $data_row[6] == '' ? 'none' : $image_path.'/'.$data_row[6],
					'dimension' => $dimension
				];
			}
			$index++;
		}

		return $this->respondWithData($datum);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param TrialModuleRequest $request
	 * @return mixed
	 */
	public function store(TrialModuleRequest $request)
	{
		$question_type = $request->get('question_type');
		$question_number = Input::get('question_number') + 1;
		$question_reader = Reader::createFromPath(storage_path('seeders/trial-module/csv/') . 'questions.csv');
		$question_answer_reader = Reader::createFromPath(storage_path('seeders/trial-module/csv/') . 'question_answer.csv');
		$answer = Input::get('answer');

		if($question_type == config('futureed.question_type_provide_answer'))
		{
			foreach($question_reader as $answer_provide_type) {
				if($question_number == $answer_provide_type[0]) {
					if($answer === $answer_provide_type[7]) {
						return $this->respondWithData(['valid' => true]);
					} else {
						return $this->respondWithData(['valid' => false]);
					}
				}
			}
		}
		else if($question_type == config('futureed.question_type_multiple_choice'))
		{
			$answer[0] = $answer[0] != 'none' ? preg_split('/[\w\W]+\//', $answer[0], -1, PREG_SPLIT_NO_EMPTY) : $answer[0]; //<--- remove url except for file name
			$answer_found = false;

			foreach($question_answer_reader as $answer_MC) {
				if($question_number == $answer_MC[2]) {
					if(($answer[0] == config('futureed.mc_none') && ($answer[1] == $answer_MC[5] && $answer_MC[7] == config('futureed.correct'))) ||
						($answer[1] == config('futureed.mc_none') && ($answer[0][0] == $answer_MC[6] && $answer_MC[7] == config('futureed.correct')))
					){
						$answer_found = true;
						break;
					}
				}
			}

			if($answer_found) {
				return $this->respondWithData(['valid' => true]);
			}

			return $this->respondWithData(['valid' => false]);
		}
		else if($question_type == config('futureed.question_type_fill_in_the_blank'))
		{
			$individual_answer_validation = [];
			$answer_index = 0;
			$answer_list = [];

			foreach($question_reader as $answer_row) {
				if($answer_row[3] === config('futureed.question_type_fill_in_the_blank') && $question_number == $answer_row[0]) {
					$answer_list = preg_split('/[\W]/',$answer_row[7], -1, PREG_SPLIT_NO_EMPTY);
				}
			}

			foreach($answer as $key => $individual_answer_value) {
				if($answer_list[$answer_index] == $individual_answer_value) {
					$individual_answer_validation[$answer_index] = true;
				}
				else {
					$individual_answer_validation[$answer_index] = false;
				}
				$answer_index++;
			}

			if(in_array(false, $individual_answer_validation)) {
				return $this->respondWithData(['valid' => false]);
			} else {
				return $this->respondWithData(['valid' => true]);
			}
		}
		else if($question_type == config('futureed.question_type_ordering'))
		{
			foreach($question_reader as $answer_row) {
				if($question_number == $answer_row[0]){
					if($answer_row[7] === $answer){
						return $this->respondWithData(['valid' => true]);
					}
					return $this->respondWithData(['valid' => false]);
				}
			}
		}
		else if($question_type == config('futureed.question_type_graph'))
		{
			$answer_list = [];
			foreach($question_reader as $answer_row) {
				if($question_number == $answer_row[0]){
					$graph_content = json_decode($answer_row[9]);
					foreach($graph_content->image as $key => $object){
						if($object->seq_no == $answer[$key]){
							$answer_list[$key] = true;
						} else $answer_list[$key] = false;

					}
				}
			}

			if(in_array(false, $answer_list)) {
				return $this->respondWithData(['valid' => false]);
			} else {
				return $this->respondWithData(['valid' => true]);
			}
		}
		else if($question_type == config('futureed.question_type_quad'))
		{
			$individual_answer_validation = [];
			foreach($question_reader as $answer_row) {
				if($question_number == $answer_row[0]) {
					$answer_csv = (json_decode($answer_row[7]));
					$answer_user = (json_decode($answer));
					$coords_csv = $answer_csv->answer;

					foreach($answer_user->answer as $key => $coords) {
						$curr_csv_coords = $coords_csv[$key];
						if($curr_csv_coords->x == $coords->x && $curr_csv_coords->y == $coords->y) $individual_answer_validation[$key] = true;
						else $individual_answer_validation[$key] = false;
					}
				}
			}
			if(in_array(false, $individual_answer_validation)) {
				return $this->respondWithData(['valid' => false]);
			} else {
				return $this->respondWithData(['valid' => true]);
			}
		}
	}
}
