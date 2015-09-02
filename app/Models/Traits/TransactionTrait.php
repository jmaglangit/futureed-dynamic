<?php namespace FutureEd\Models\Traits;

trait TransactionTrait {

	protected static function boot() {
		parent::boot();
	
		static::creating(function($model){
	
			$model->created_by = session('current_user');
	
		});
	
		static::updating(function($model){
	
			$model->updated_by = session('current_user');
	
		});
	}
	
}