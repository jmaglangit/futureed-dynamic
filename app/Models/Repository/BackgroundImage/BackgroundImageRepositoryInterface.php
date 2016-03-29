<?php namespace FutureEd\Models\Repository\BackgroundImage;

interface BackgroundImageRepositoryInterface {

	public function getBackgroundImages($criteria = [], $limit = 0, $offset = 0);

	public function getBackgroundImage($id);
}