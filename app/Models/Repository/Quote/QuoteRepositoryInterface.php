<?php

namespace FutureEd\Models\Repository\Quote;

interface QuoteRepositoryInterface {
    public function getQuoteIdByPctAndSeqNo($pct,$seq_no);
}