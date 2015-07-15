<?php namespace FutureEd\Http\Controllers\FutureLesson\Admin;

use FutureEd\Http\Requests;
use FutureEd\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class ImageController extends Controller{

	public function view() {
		$file_path = Input::only('path');

		try {
			$mime_type = mime_content_type($file_path['path']);
			header('Content-Type: '. $mime_type);

			readfile($file_path['path']);
		} catch (\ErrorException $e) {
			return false;
		}
	}
}