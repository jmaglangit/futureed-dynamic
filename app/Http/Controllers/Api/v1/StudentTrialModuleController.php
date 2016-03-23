<?php namespace FutureEd\Http\Controllers\Api\v1;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;

use Illuminate\Http\Request;
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
		$reader = Reader::createFromPath(storage_path('trial-module/csv/') . 'questions.csv');
		$image_path = url('/trial-module/images/questions');
		$datum = [];
		$index = 0;
		foreach($reader as $data) {
			if($data[0] === config('futureed.question_type_provide_answer')) {
				$datum[$index] = [
					'type' => $data[0],
					'image' => $data[1] === '' ? 'none' : $image_path.'/'.$data[1],
					'question' => $data[2],
					'number_of_possible_answers' => $data[3]
				];
			}
			else if($data[0] === config('futureed.question_type_multiple_choice'))
			{
				$questionStringImage = array_slice($data, count($data) - $data[3]);
				$string = [];
				$image = [];
				$haystackIndex = 0;
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
				$datum[$index] = [
					'type' => $data[0],
					'image' => $data[1] === '' ? 'none' : $image_path.'/'.$data[1],
					'question' => $data[2],
					'number_of_possible_answers' => $data[3],
					'string_question' => $string,
					'image_question' => $image
				];
			}
			else if($data[0] === config('futureed.question_type_fill_in_the_blank') || $data[0] === config('futureed.question_type_ordering'))
			{
				$datum[$index] = [
					'type' => $data[0],
					'image' => $data[1] === '' ? 'none' : $image_path.'/'.$data[1],
					'question' => $data[2],
					'number_of_possible_answers' => $data[3]
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
				$coords = preg_split('/[\s,:xy]+/', $data[3]);
				$datum[$index] = [
					'type' => $data[0],
					'image' => $data[1],
					'question' => $data[2],
					'coordinates' => $coords
				];
			}
			$index++;
		}
		return $this->respondWithData($datum);
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$question_type = Input::get('question_type');
		$question_number = Input::get('question_number');
		$reader = Reader::createFromPath(storage_path('trial-module/csv/') . 'answer.csv');

		if($question_type === config('futureed.question_type_provide_answer') || $question_type === config('futureed.question_type_multiple_choice'))
		{
			$answer = Input::get('answer');
			foreach($reader as $data){
				if($question_number == $data[0]){
					if ($answer === $data[1]) {
						return $this->respondWithData(['valid' => true]);
					} else {
						return $this->respondWithData(['valid' => false]);
					}
				}
			}
		} else if($question_type === config('futureed.question_type_fill_in_the_blank')) {
			$answer = Input::get('answer');
			dd($answer);
			foreach($reader as $data){
				if($question_number == $data[0]) {
					$answer_list = array_slice($data, 1);
				}
			}
		}
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
