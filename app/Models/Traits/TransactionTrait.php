<?php namespace FutureEd\Models\Traits;

trait TransactionTrait {

	protected static function boot() {
		parent::boot();
	
		static::creating(function($model){
	
			$model->created_by = (session()->has('current_user'))? session('current_user') : 1;
	
		});
	
		static::updating(function($model){
	
			$model->updated_by = (session()->has('current_user'))? session('current_user') : 1;
	
		});
	}
	
}