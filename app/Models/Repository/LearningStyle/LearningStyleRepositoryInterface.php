<?php namespace FutureEd\Models\Repository\LearningStyle;

interface LearningStyleRepositoryInterface {

	/**
	 * Gets list of LearningStyle.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getLearningStyles($criteria = array(), $limit = 0, $offset = 0);
}