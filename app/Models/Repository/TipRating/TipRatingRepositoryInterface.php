<?php

namespace FutureEd\Models\Repository\TipRating;

interface TipRatingRepositoryInterface {

	public function addTipRating($data);

	public function getAverageRating($tip_id);

}