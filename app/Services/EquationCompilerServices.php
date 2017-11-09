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

		$question_values = json_decode($question_cache->question_values,1);


		//Get steps computation variables.
		$equation = [];
		$steps = $question_values['steps'];

//		//return false if steps is not equal
//		if(count($answer) <> $steps){
//			return 0;
//		}


		//TODO add condition for multiple operations
		switch($question_cache->questiontemplate->operation){
			case config('futureed.addition'):
				$answer = $this->solveAddition($question_values,$steps);
				break;
			case config('futureed.subtraction'):
				$answer = $this->solveSubtraction($question_values,$steps);
				break;
			case config('futureed.multiplication'):
				$answer = $this->solveMultiplication($question_values,$steps);
				break;
			case config('futureed.division'):
				break;
			default:
				break;
		}

		return json_encode($answer);
	}

	public function answerChecker($question_cached_id,$answer){

		$question_cache = $this->question_cache->getQuestionCache($question_cached_id);

		$result = 0;

		//check kind of operation
		switch($question_cache->questiontemplate->operation){
			case config('futureed.addition'):
				$result = $this->additionCheckAnswer($question_cache,$answer);
				break;
			case config('futureed.subtraction'):
				$result = $this->subtractionCheckAnswer($question_cache,$answer);
				break;
			case config('futureed.multiplication'):
				$result = $this->multiplicationCheckAnswer($question_cache,$answer);
				break;
			case config('futureed.division'):
				break;
			default:
				break;
		}

		return $result;
	}

	//ADDITION

	public function solveAddition($question_values,$steps){

		$total = 0;
		$equation = [];
		foreach($question_values['values'] as $v => $k){

			$equation[$v] = $this->parseStepsValuesAddition($k,$steps);
		}

		$steps_answer = [];
		for($i=0;$i<$steps;$i++){

			$x=0;

			foreach($equation as $q){
				$x += $q[$i];
			}

			$total += $x;
			array_push($steps_answer,$x);
		}

		return [
			'steps_answer' => $steps_answer,
			'total' => $total
		];
	}

	//parse number
	public function parseStepsValuesAddition($number,$steps){

		$container = [];

		for($i=($steps-1),$v=0;$i>=0;$i--,$v++){

			array_push($container,(int)substr(substr($number,$i),0,1)*(int)str_pad('1',($v+1),0));
		}

		return $container;
	}

	public function additionCheckAnswer($question_cache,$answer){

		//expected answer
		//{"steps_answer":[7,90,500,4000,120000],"total":124597}

		//correct answer
		$correct_answer = json_decode($question_cache->answer);
		$correct_steps = json_decode($question_cache->question_values)->steps;

		//answer
		$answer = json_decode($answer,true);
		$steps = ($correct_steps > 1) ? count($answer['steps_answer']) : 1 ;
		$steps_answer = ($correct_steps > 1) ? $answer['steps_answer'] : [$answer['total']];

		if($steps == $correct_steps){

			for($i=0;$i< $correct_steps;$i++){
				if($correct_answer->steps_answer[$i] <> $steps_answer[$i]){
					return 0;
				}
			}

			if($correct_answer->total <> $answer['total']){
				return 0;
			}
		} else {
			return 0;
		}

		return 1;
	}

	//SUBTRACTION
	//accepts 2 numbers only
	// minuend should be greater than subtrahend
	public function solveSubtraction($question_values,$steps){

		//parse to the value
		$total = 0;
		$equation = [];
		foreach($question_values['values'] as $v => $k){

			$total = ($total > 0 ) ? $total - $k : $k;

			$equation[$v] = $this->parseStepsValuesSubtraction($k,$steps);
		}

		// pop first element for minuend
		$minuend = array_shift($equation);

		//pop second element for subtrahend
		$subtrahend = array_shift($equation);

		$steps_answer = [];
		for($i=0;$i<$steps;$i++){

			//check if subtraction is negative
			if(($minuend[$i] - $subtrahend[$i]) < 0 ){
				//call borrow function
				// process $minuend, $i,
				$minuend = $this->subtractionBorrower($minuend,$i);
				$i--;
			} else {
				//implement subtraction
				array_push($steps_answer,($minuend[$i] - $subtrahend[$i]));
			}
		}

		return [
			'steps_answer' => $steps_answer,
			'total' => $total
		];
	}

	public function subtractionBorrower($minuend,$flag){

		//add 10s to the target minuend
		$minuend[$flag] = (int) "1$minuend[$flag]";

		//deduct 1 to the next digit
		$minuend[$flag+1] = $minuend[$flag+1] - 1;

		return $minuend;
	}

	public function parseStepsValuesSubtraction($number,$steps){

		$container = [];

		for($i=($steps-1),$v=0;$i>=0;$i--,$v++){

			array_push($container,(int)substr(substr($number,$i),0,1));

		}

		return $container;
	}

	public function subtractionCheckAnswer($question_cache,$answer){

		$correct_answer = json_decode($question_cache->answer);
		$correct_steps = json_decode($question_cache->question_values)->steps;

		//answer
		$answer = json_decode($answer,true);
		$steps = ($correct_steps > 1) ? count($answer['steps_answer']) : 1 ;
		$steps_answer = ($correct_steps > 1) ? $answer['steps_answer'] : [$answer['total']];

		if($steps == $correct_steps){

			for($i=0;$i< $correct_steps;$i++){
				if($correct_answer->steps_answer[$i] <> $steps_answer[$i]){
					return 0;
				}
			}

			if($correct_answer->total <> $answer['total']){
				return 0;
			}
		} else {
			return 0;
		}

		return 1;
	}

	//MULTIPLICATION
	public function solveMultiplication($question_values,$steps){

		//parse to the value

		//get first factor
		$factor1 = array_shift($question_values['values']);
		$factor2 = array_shift($question_values['values']);
		$factor_steps = $this->parseStepsValuesMultiplication($factor2);
		//get second factor and separate by array


		$steps_answer = [];
		foreach($factor_steps as $second_factor){
			array_push($steps_answer,$factor1 * $second_factor);
		}

		$total = $factor1 * $factor2;

		return [
			'steps_answer' => $steps_answer,
			'total' => $total
		];
	}

	public function parseStepsValuesMultiplication($number){

		//parse each digit into array
		return str_split($number);
	}

	public function multiplicationCheckAnswer($question_cache,$answer){

		$correct_answer = json_decode($question_cache->answer);
		$correct_steps = json_decode($question_cache->question_values)->steps;

		//answer
		$answer = json_decode($answer,true);
		$steps = ($correct_steps > 1) ? count($answer['steps_answer']) : 1 ;
		$steps_answer = ($correct_steps > 1) ? $answer['steps_answer'] : [$answer['total']];

		if($steps == $correct_steps){

			for($i=0;$i< $correct_steps;$i++){
				if($correct_answer->steps_answer[$i] <> $steps_answer[$i]){
					return 0;
				}
			}

			if($correct_answer->total <> $answer['total']){
				return 0;
			}
		} else {
			return 0;
		}

		return 1;
	}



}