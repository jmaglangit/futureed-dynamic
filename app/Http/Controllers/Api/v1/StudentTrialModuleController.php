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
		$reader = Reader::createFromPath(storage_path('seeders/trial-module/csv/') . 'questions.csv');
		$image_path = url('images/trial-module/images/questions');
		$datum = [];
		$index = 0;

		foreach($reader as $data) {
			if( $data[0] === config('futureed.question_type_provide_answer') ||
				$data[0] === config('futureed.question_type_fill_in_the_blank'))
			{
				$col = [];
				if($data[0] === config('futureed.question_type_fill_in_the_blank'))
				{
					for($i = 0 ; $i < $data[3]; $i++) {
						$col[$i] = $i; // <------ $col is to be used in ng-repeat for FIB question type : ng-repeat bases on array
					}
				}

				$datum[$index] = [
					'type'                      => $data[0],
					'image'                     => $data[1] === '' ? 'none' : $image_path.'/'.$data[1],
					'question'                  => $data[2],
					'number_of_possible_answers'=>  $data[0] === config('futureed.question_type_fill_in_the_blank') ? $col : $data[3]
				];
			}
			else if($data[0] === config('futureed.question_type_multiple_choice') ||
					$data[0] === config('futureed.question_type_ordering'))
			{
				$questionStringImage = array_slice($data, count($data) - $data[3]);
				$haystackIndex = 0;

				$string = [];
				$image = [];
				$col = [];

				foreach($questionStringImage as $haystack) {
					if(strpos($haystack, '.png') == true || strpos($haystack, '.jpg') == true) {
						$image[$haystackIndex] = $image_path.'/'.$haystack;
					} else if($haystack === '') {
						$image[$haystackIndex] = 'none';
					} else {
						$string[$haystackIndex] = $haystack;
					}
					$haystackIndex++;
				}

				for($i = 0 ; $i < $data[3] ; $i++) {
					$col = array_merge($col, [$i]);
				}

				$datum[$index] = [
					'type'                      => $data[0],
					'image'                     => $data[1] === '' ? 'none' : $image_path.'/'.$data[1],
					'question'                  => $data[2],
					'number_of_possible_answers'=> $data[0] === config('futureed.question_type_multiple_choice') ? $col : $data[3],
					'string_question'           => $data[0] === config('futureed.question_type_multiple_choice') ? $string : '',
					'image_question'            => $data[0] === config('futureed.question_type_multiple_choice') ? $image : '',
					'answer_string'             => $data[0] === config('futureed.question_type_ordering') ? $string : '',
					'answer_image'              => $data[0] === config('futureed.question_type_ordering') ? $image : ''
				];
			}
			else if($data[0] === config('futureed.question_type_graph'))
			{
				$images = array_slice($data, count($data) - $data[5]);
				$haystackIndex = 0;
				$col = [];

				foreach($images as $haystack) {
					if(strpos($haystack, '.png') == true || strpos($haystack, '.jpg') == true) {
						$images[$haystackIndex] = $image_path.'/'.$haystack;
					} else if($haystack === '') {
						$image[$haystackIndex] = 'none';
					}
					$haystackIndex++;
				}

				for($i = 0 ; $i < $data[3] ; $i++) {
					$col = array_merge($col, [$i]);
				}

				$datum[$index] = [
					'type' => $data[0],
					'image' => $data[1] === '' ? 'none' : $image_path.'/'.$data[1],
					'question' => $data[2],
					'number_of_possible_answers' => $data[5],
					'orientation' => $data[4],
					'number_of_columns' => $col,
					'table_image' => $images,
				];
			}
			else if($data[0] === config('futureed.question_type_quad'))
			{
				$coords = preg_split('/[,:xy]+/', $data[3], -1, PREG_SPLIT_NO_EMPTY);

				$max = max($coords);
				$graph_dimension = $max < 5 ? 5 : intval(round($max, -1));

				foreach($coords as $axis => $value) {
					$coords[$axis] = $graph_dimension;
				}

				$datum[$index] = [
					'type'          => $data[0],
					'image'         => $data[1],
					'question'      => $data[2],
					'coordinates'   => $coords
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
		$question_type = Input::get('question_type');
		$question_number = Input::get('question_number');
		$reader = Reader::createFromPath(storage_path('seeders/trial-module/csv/') . 'answer.csv');
		$answer = $request->get('answer');

		if( $question_type === config('futureed.question_type_provide_answer') ||
			$question_type === config('futureed.question_type_multiple_choice'))
		{
			foreach($reader as $data){
				if($question_number == $data[0]){
					if ($answer === $data[1]) {
						return $this->respondWithData(['valid' => true]);
					} else {
						return $this->respondWithData(['valid' => false]);
					}
				}
			}
		}
		else if($question_type === config('futureed.question_type_fill_in_the_blank') ||
				$question_type === config('futureed.question_type_ordering') ||
				$question_type === config('futureed.question_type_graph') ||
				$question_type === config('futureed.question_type_quad'))
		{
			$index = 0;

			foreach($reader as $data){
				if($question_number == $data[0]) {
					$answer_list = array_slice($data, 1);
					break;
				}
			}

			foreach($answer_list as $csv_answer_value) {
				if( $question_type === config('futureed.question_type_ordering') ||
					$question_type === config('futureed.question_type_fill_in_the_blank'))
				{
					if($index < count($answer)) {
						if((string)$answer[$index] === $csv_answer_value) {
							$temp[$index] = true;
						} else {
							$temp[$index] = false;
						}
					}
				}
				else if($question_type === config('futureed.question_type_graph'))
				{
					if((string)$answer[$index] === $csv_answer_value) {
						$temp[$index] = true;
					} else {
						$temp[$index] = false;
					}
				}
				else if($question_type === config('futureed.question_type_quad'))
				{
					$csv_coords =  $this->CoordStringToArray($csv_answer_value);

					if($csv_coords['x'] === (string)$answer[$index]['x'] && $csv_coords['y'] === (string)$answer[$index]['y']){
						$temp[$index] = true;
					} else {
						$temp[$index] = false;
					}
				}
				$index++;
			}

			if(in_array(false, $temp)) {
				return $this->respondWithData(['valid' => false]);
			} else {
				return $this->respondWithData(['valid' => true]);
			}
		}
	}


	/**
	 * Converts string coords to array with delimiter of
	 * "|" for every axis   ex: y:5|x:5
	 * ":" for the axis     ex: x:5
	 * returns ex: [x=>5,y=>5]
	 *
	 * @param $string
	 * @return array
	 */
	private function CoordStringToArray($string) {
		$finalArray = [];
		$asArr = explode( '|', $string );

		foreach( $asArr as $val ){
			$tmp = explode( ':', $val );
			$finalArray[ $tmp[0] ] = $tmp[1];
		}
		return $finalArray;
	}

}
