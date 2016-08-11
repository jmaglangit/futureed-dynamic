<?php namespace FutureEd\Models\Repository\ModuleTranslation;


interface ModuleTranslationRepositoryInterface {

	public function generateInitialLanguageTranslation($locale);

	public function checkLanguageAvailability($locale);

	public function updatedTranslation($data,$target_lang);

	public function getModuleTranslations($locale);
}