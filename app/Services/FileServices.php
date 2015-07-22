<?php namespace FutureEd\Services;

use Illuminate\Support\Facades\File;

class ImageServices {

	/**
	 * Delete image file.
	 * @param $file
	 */
	public function deleteImageFile($file){

		return File::delete($file);

	}

}