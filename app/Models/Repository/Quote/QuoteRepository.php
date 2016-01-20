<?php

namespace FutureEd\Models\Repository\Quote;

use FutureEd\Models\Core\Quote;
use FutureEd\Models\Traits\LoggerTrait;
use Illuminate\Support\Facades\DB;

class QuoteRepository implements QuoteRepositoryInterface{

	use LoggerTrait;

    /**
     * Get Quote id by percent and seq_no
     * @param $pct
     * @param $seq_no
     * @return null|string
     *
     */
    public function getQuoteIdByPctAndSeqNo($pct,$seq_no){

		DB::beginTransaction();

        try{
            $result = Quote::percent($pct)->seqNo($seq_no)->first();
            $response = is_null($result) ? null : $result->id;

        }catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
    }
    
	/**
     * Get Quotes
     * @param $avatar_id
     * @return null|array
     *
     */
    public function getQuotes($avatar_id){

		DB::beginTransaction();

        try{
        	$new_array = array();
        
            $result = Quote::with(['avatarQuote' => function($query) use ($avatar_id)
						{
						    $query->where('avatar_id', '=', $avatar_id);
						
						}])->orderBy('seq_no')->orderBy('percent')->get();
			
			if(!is_null($result)) {
				$quotes = $result->toArray();
			
				foreach($quotes as $quote) {
					
					if(!isset($new_array[$quote['seq_no']])) {
						$new_array[$quote['seq_no']] = array();
					}
				
					$new_array[$quote['seq_no']][$quote['percent']] = $quote;
				
				}
				
				$response = $new_array;
				
			} else {
				$response = null;
			}

        } catch (\Exception $e) {

			DB::rollback();

			$this->errorLog($e->getMessage());

			return false;
		}

		DB::commit();

		return $response;
    }
}