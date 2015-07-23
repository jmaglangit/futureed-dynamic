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
            $result = Quote::percent($pct)->seqNo($seq_no)-first();
            return is_null($result) ? null : $result->id;

        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
}