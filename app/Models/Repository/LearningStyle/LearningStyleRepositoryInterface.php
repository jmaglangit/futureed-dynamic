<?php namespace FutureEd\Models\Repository\LearningStyle;

interface LearningStyleRepositoryInterface {

	public function getLearningStyles($criteria = array(), $limit = 0, $offset = 0);
	
	public function getLearningStyleByBanding($ls_banding);

}