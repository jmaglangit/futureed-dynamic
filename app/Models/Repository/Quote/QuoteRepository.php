<?php

namespace FutureEd\Models\Repository\Quote;

use FutureEd\Models\Core\Quote;

class QuoteRepository implements QuoteRepositoryInterface{

    /**
     * Get Quote id by percent and seq_no
     * @param $pct
     * @param $seq_no
     * @return null|string
     *
     */
    public function getQuoteIdByPctAndSeqNo($pct,$seq_no){
        try{
            $result = Quote::percent($pct)->seqNo($seq_no)->first();
            return is_null($result) ? null : $result->id;

        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    
	/**
     * Get Quotes
     * @param $avatar_id
     * @return null|array
     *
     */
    public function getQuotes($avatar_id){
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
				
				return $new_array;
				
			} else {
				return null;
			}
			
            return is_null($result) ? null : $result->toArray();

        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}