<?php namespace FutureEd\Models\Repository\BackgroundImage;

use FutureEd\Models\Core\BackgroundImage;

class BackgroundImageRepository implements BackgroundImageRepositoryInterface {

	/**
	 * get list of background images.
	 * @param array $criteria
	 * @param int $limit
	 * @param int $offset
	 * @return array
	 */
	public function getBackgroundImages($criteria = [],$limit = 0, $offset = 0) {

		$background_image = new BackgroundImage();

		if(isset($criteria['status'])){
			$background_image = $background_image->status($criteria['status']);
		}

		if ($limit > 0 && $offset >= 0) {

			$background_image = $background_image->offset($offset)->limit($limit);
		}

		$records = $background_image->get();
		$count = $background_image->get()->count();

		return [
			'total' => $count,
			'records' => $records
		];
	}

	/**
	 * get a background image.
	 * @param $id
	 * @return mixed
	 */
	public function getBackgroundImage($id) {

		return BackgroundImage::whereId($id)->first();
	}
}