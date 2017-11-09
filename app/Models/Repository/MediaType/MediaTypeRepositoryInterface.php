<?php

namespace FutureEd\Models\Repository\MediaType;

interface MediaTypeRepositoryInterface {

	/**
	 * Gets list of MediaTypes.
	 * @param $criteria
	 * @param $limit
	 * @param $offset
	 * @return array
	 */
	public function getMediaTypes($criteria = array(), $limit = 0, $offset = 0);
}