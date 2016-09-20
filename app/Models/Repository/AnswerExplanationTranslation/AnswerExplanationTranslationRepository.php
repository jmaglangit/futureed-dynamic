<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/13/16
 * Time: 3:02 PM
 */

namespace FutureEd\Models\Repository\AnswerExplanationTranslation;


use FutureEd\Models\Core\AnswerExplanation;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class AnswerExplanationTranslationRepository implements AnswerExplanationTranslationRepositoryInterface {

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
			$record_count = $this->answerExplanationCount();

			//process by batch
			for($i=0; $i <= ceil($record_count/$limit);$i++){

				$explanation_list = $this->getAnswerExplanation([],$limit,$offset);

				$offset += $limit;

				$explanation_translate = [];

				foreach($explanation_list['records'] as $explanation){

					$data = [
						'answer_explanation_id' => $explanation['id'],
						'answer_explanation' => $explanation['answer_explanation'],
						'locale' => $locale
					];

					array_push($explanation_translate,$data);
				}

				//delete all existing language
				DB::table('answer_explanation_translations')->where('locale','=',$locale)->delete();

				//insert initialize translation
				DB::table('answer_explanation_translations')->insert($explanation_translate);
			}

		} catch( \Exception $e){

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
		return AnswerExplanation::first()->translate($locale);
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

			$translation = AnswerExplanation::find($data['answer_explanation_id'])->translate($target_lang);

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
		return with(new AnswerExplanation)->translatedAttributes;
	}

	/**
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array|bool
	 */
	public function getAnswerExplanation($criteria = [] ,$limit = 0 ,$offset = 0){

		try{
			$explanation = new AnswerExplanation();

			$count = $explanation->count();

			if ($limit > 0 && $offset >= 0) {
				$explanation = $explanation->offset($offset)->limit($limit);
			}

			$response = ['total' => $count, 'records' => $explanation->get()->toArray()];

		} catch(\Exception $e){

			$this->errorLog($e->getMessage());

			return false;
		}

		return $response;
	}

	/**
	 * @return mixed
	 */
	public function answerExplanationCount(){
		return AnswerExplanation::count();
	}
}