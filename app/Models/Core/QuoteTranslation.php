<?php namespace FutureEd\Models\Core;

use FutureEd\Models\Traits\TransactionTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuoteTranslation extends Model{

	use SoftDeletes;

	use TransactionTrait;

	protected $table = 'quote_translations';

	protected $date = [
		'created_at','updated_at','deleted_at'
	];

	protected $fillable = [
		'quote_id',
		'quote',
		'locale',
	];
}