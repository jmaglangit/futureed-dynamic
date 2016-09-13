<?php
/**
 * Created by PhpStorm.
 * User: jason
 * Date: 9/13/16
 * Time: 3:08 PM
 */

namespace FutureEd\Models\Repository\QuestionTranslation;


use Illuminate\Support\Facades\DB;

class QuestionTranslationRepository {

	public function generateInitialLanguageTranslation($locale){

		DB::beginTransaction();

		try{


		}catch (\Exception $e){
			DB::rollback();

			return false;
		}

		DB::commit();

		return true;
	}

	public function checkLanguageAvailability($locale){}

	public function updatedTranslation($data,$target_lang,$field){}

	public function getModuleTranslations($locale){}

	public function getTranslatedAttributes(){}

	public function getQuestions($criteria,$limit,$offset){}

	public function questionCount(){}
}