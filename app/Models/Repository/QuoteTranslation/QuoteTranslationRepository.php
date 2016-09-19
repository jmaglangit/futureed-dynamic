<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/13/16
 * Time: 3:10 PM
 */

namespace FutureEd\Models\Repository\QuoteTranslation;


use FutureEd\Models\Core\Quote;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuoteTranslationRepository implements QuoteTranslationRepositoryInterface{

	use LoggerTrait;

	/**
	 * @param $locale
	 * @return bool
	 */
	public function generateInitialLanguageTranslation($locale){
		DB::beginTrasaction();

		try{

			$offset = 0;
			$limit = config('futureed.seeder_record_limit');
			$record_count = $this->quoteCount();

			//process by batch
			for($i=0; $i <= ceil($record_count/$limit);$i++){

				$quote_list = $this->getQuote([],$limit,$offset);

				$offset += $limit;

				$quote_translate = [];

				foreach($quote_list['records'] as $question){

					$data = [
						'quote_id' => $question['id'],
						'quote' => $question['quote'],
						'locale' => $locale
					];

					array_push($quote_translate,$data);
				}

				//delete all existing language
				DB::table('quote_translations')->where('locale','=',$locale)->delete();

				//insert initialize translation
				DB::table('quote_translations')->insert($quote_translate);
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
		return Quote::first()->translate($locale);
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

			$translation = Quote::find($data['quote_id'])->translate($target_lang);

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
		return with(new Quote)->translatedAttributes;
	}

	/**
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array|bool
	 */
	public function getQuote($criteria=[],$limit=0,$offset=0){
		DB::beginTransaction();

		try{

			$quote = new Quote();

			$count = $quote->count();

			if ($limit > 0 && $offset >= 0) {
				$quote = $quote->offset($offset)->limit($limit);
			}

			$response = ['total' => $count, 'records' => $quote->get()->toArray()];
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
	public function quoteCount(){
		return Quote::count();
	}
}