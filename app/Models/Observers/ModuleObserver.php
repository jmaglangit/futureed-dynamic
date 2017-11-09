<?php namespace FutureEd\Models\Observers;

use FutureEd\Models\Core\Module;
use FutureEd\Models\Traits\TranslationTrait;

class ModuleObserver {

	use TranslationTrait;

	public function created($model){

		//add new translation
		$this->addModuleTranslation([
			'module_id' => $model->id,
			'name' => $model->name,
			'description' => $model->description
		]);

	}

}