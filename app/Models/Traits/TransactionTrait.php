<?php namespace FutureEd\Models\Traits;

trait TransactionTrait {

	protected static function boot() {
		parent::boot();
	
		static::creating(function($model){
	
			$model->created_by = 1;
	
		});
	
		static::updating(function($model){
	
			$model->updated_by = 1;
	
		});
	}
	
}