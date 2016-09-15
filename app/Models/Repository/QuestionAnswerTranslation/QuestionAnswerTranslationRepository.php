<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/15/16
 * Time: 2:09 PM
 */

namespace FutureEd\Models\Repository\QuestionAnswerTranslation;


use FutureEd\Models\Core\QuestionAnswer;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuestionAnswerTranslationRepository implements QuestionAnswerTranslationRepositoryInterface {

	use LoggerTrait;

	/**
	 * @param $locale
	 * @return bool
	 */
	public function generateInitialLanguageTranslation($locale){

		DB::beginTransaction();

		try{

			$offset = 0;
			$limit = config('futureed.seeder_record_limit');

			//process by batch
			for($i=0; $i <= ceil($this->questionAnswerCount()/$limit);$i++){

				$answer_list = $this->getQuestionsAnswer([],$limit,$offset);

				$offset += $limit;

				$answer_translate = [];

				foreach($answer_list['records'] as $answer){

					$data = [
						'question_answer_id' => $answer['id'],
						'answer_text' => $answer['answer_text'],
						'locale' => $locale
					];

					array_push($answer_translate,$data);
				}

				//delete all existing language
				DB::table('question_answer_translations')->where('locale','=',$locale)->delete();

				//insert initialize translation
				DB::table('question_answer_translations')->insert($answer_translate);

			}

		} catch(\Exception $e){

			$this->errorLog($e->getMessage());

			DB::rollback();

			return false;
		}

		DB::commit();

		return true;
	}

	/**
	 * @param $locale
	 * @return mixed
	 */
	public function checkLanguageAvailability($locale){
		return QuestionAnswer::first()->translate($locale);
	}

	/**
	 * @param $data
	 * @param $target_lang
	 * @param $field
	 * @return bool
	 */
	public function updatedTranslation($data,$target_lang,$field){
		DB::beginTransaction();

		try{

			$translation = QuestionAnswer::find($data['question_answer_id'])->translate($target_lang);

			$translation->{$field} = $data['string'];

			$translation->save();

		} catch(\Exception $e){

			$this->errorLog($e->getMessage());

			DB::rollback();

			return false;
		}

		DB::commit();

		return true;
	}

	/**
	 * @return mixed
	 */
	public function getTranslatedAttributes(){

		return with(new QuestionAnswer)->translatedAttributes;
	}

	/**
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array|bool
	 */
	public function getQuestionsAnswer($criteria,$limit,$offset){
		DB::beginTransaction();

		try{

			$question_answer = new QuestionAnswer();

			$count = $question_answer->count();

			if ($limit > 0 && $offset >= 0) {
				$question_answer = $question_answer->offset($offset)->limit($limit);
			}

			$response = ['total' => $count, 'records' => $question_answer->get()->toArray()];

		} catch(\Exception $e){

			$this->errorLog($e->getMessage());

			DB::rollback();

			return false;
		}

		DB::commit();

		return $response;

	}

	/**
	 * @return mixed
	 */
	public function questionAnswerCount(){

		return QuestionAnswer::count();
	}

}