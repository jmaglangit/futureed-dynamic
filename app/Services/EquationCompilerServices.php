<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 4/4/17
 * Time: 11:20 AM
 */

namespace FutureEd\Services;

use FutureEd\Models\Repository\QuestionCache\QuestionCacheRepositoryInterface;
use FutureEd\Models\Repository\QuestionTemplate\QuestionTemplateRepositoryInterface;

class EquationCompilerServices {

	protected $question_template;

	protected $question_cache;


	/**
	 * parse and compile equation given
	 * @param QuestionTemplateRepositoryInterface $questionTemplateRepositoryInterface
	 * @param QuestionCacheRepositoryInterface $questionCacheRepositoryInterface
	 */
	public function __construct(
		QuestionTemplateRepositoryInterface $questionTemplateRepositoryInterface,
		QuestionCacheRepositoryInterface $questionCacheRepositoryInterface
	){
		$this->question_template = $questionTemplateRepositoryInterface;
		$this->question_cache = $questionCacheRepositoryInterface;
	}

	public function solve($question_cache_id){

		//Temp values
//		$question_cache_id =

		//TODO: get necessary data on solving the question and comparing with the answer that is in an json format.

		//question cache

		$question_cache = $this->question_cache->getQuestionCache($question_cache_id);

		switch($question_cache->questionTemplate->question_form){
			case 'Series':

				 $return  = $this->seriesQuestion($question_cache);

				break;
			case 'Word':
				$return = 'Word';
				break;
			default:
				//blank
//				return $this->blankQuestion($template->question_equation,$numbers);
				return 'default';
				break;
		}

		return $return;
	}

	//get the correct answer and compare on the question template.
	public function seriesQuestion($question_cache){

		//answer in correct format
		//check question equation on how many steps
		//values and steps
		//

		$question_values = json_decode($question_cache->question_values);



		//Get steps computation variables.
		$equation = [];
		$steps = $question_values->steps;
		$total = 0;

//		//return false if steps is not equal
//		if(count($answer) <> $steps){
//			return 0;
//		}


		foreach($question_values->values as $v => $k){

			$equation[$v] = $this->parseStepsValues($k,$steps);
		}

		//Addition
		$steps_answer = [];
		for($i=0;$i<$steps;$i++){

			$x=0;

			foreach($equation as $q){
				$x += $q[$i];
			}

			$total += $x;
			array_push($steps_answer,$x);
		}


		//compare
		//expecting answer in sequence with expected answer
//		for($i=0;$i<$steps;$i++){
//
//			if($answer[$i] <> $steps_answer[$i]){
//				return 0;
//			}
//		}

		return json_encode([
			'steps_answer' => $steps_answer,
			'total' => $total
		]);
	}


	//parse number
	public function parseStepsValues($number,$steps){

		$container = [];

		for($i=($steps-1),$v=0;$i>=0;$i--,$v++){

			array_push($container,(int)substr(substr($number,$i),0,1)*(int)str_pad('1',($v+1),0));

		}

		return $container;

	}


	public function additionCheckAnswer($question_cached_id,$answer){

		//expected answer
		//{"steps_answer":[7,90,500,4000,120000],"total":124597}

		$question_cache = $this->question_cache->getQuestionCache($question_cached_id);

		//correct answer
		$correct_answer = json_decode($question_cache->answer);
		$correct_steps = json_decode($question_cache->question_values)->steps;

		//answer
		$answer = json_decode($answer);
		$steps = count($answer->steps_answer);
		$steps_answer = ($correct_steps > 1) ? $answer->steps_answer : [$answer->steps_answer];

		if($steps == $correct_steps){

			for($i=0;$i< $correct_steps;$i++){
				if($correct_answer->steps_answer[$i] <> $steps_answer[$i]){
					return 0;
				}
			}

			if($correct_answer->total <> $answer->total){
				return 0;
			}
		} else {
			return 0;
		}

		return 1;
	}




}