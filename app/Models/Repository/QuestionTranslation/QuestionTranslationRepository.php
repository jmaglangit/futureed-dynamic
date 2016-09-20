<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/13/16
 * Time: 3:08 PM
 */

namespace FutureEd\Models\Repository\QuestionTranslation;


use FutureEd\Models\Core\Module;
use FutureEd\Models\Core\Question;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class QuestionTranslationRepository implements QuestionTranslationRepositoryInterface{

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
			$record_count = $this->questionCount();

			//process by batch
			for($i=0; $i <= ceil($record_count/$limit);$i++){

				$question_list = $this->getQuestions([],$limit,$offset);

				$offset += $limit;

				$question_translate = [];

				foreach($question_list['records'] as $question){


					$data = [
						'question_id' => $question['id'],
						'questions_text' => $question['questions_text'],
						'answer' => $question['answer'],
						'locale' => $locale
					];

					array_push($question_translate,$data);

				}

				//delete all existing language
				DB::table('question_translations')->where('locale','=',$locale)->delete();

				//insert initialize translation
				DB::table('question_translations')->insert($question_translate);
			}

		}catch (\Exception $e){

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

		return Question::first()->translate($locale);
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

			$translation = Question::find($data['id'])->translate($target_lang);

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
		return with(new Question)->translatedAttributes;
	}

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array|bool
	 */
	public function getCollection($criteria = [],$limit=0,$offset=0){

		try{

			$question = new Question();

			$count = $question->count();

			if ($limit > 0 && $offset >= 0) {
				$question = $question->offset($offset)->limit($limit);
			}

			$response = ['total' => $count, 'records' => $question->get()->toArray()];

		} catch(\Exception $e){

			$this->errorLog($e->getMessage());

			return false;
		}

		return $response;
	}

	/**
	 * @return mixed
	 */
	public function count(){
		return Question::count();
	}
}