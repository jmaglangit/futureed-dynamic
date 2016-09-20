<?php namespace FutureEd\Models\Repository\ModuleTranslation;


interface ModuleTranslationRepositoryInterface {

	public function generateInitialLanguageTranslation($locale);

	public function checkLanguageAvailability($locale);

	public function updatedTranslation($data,$target_lang,$field);

	public function getModuleTranslations($locale);

	public function getTranslatedAttributes();

	public function getCollection($criteria,$limit,$offset);

	public function count();
}