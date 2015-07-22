<?php namespace FutureEd\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Filesystem\Filesystem;


class FileServices {

	protected $file_system;

	public function __construct(
		Filesystem $filesystem
	){

		$this->file_system = $filesystem;

	}

	/**
	 * Delete image file.
	 * @param $file
	 */
	public function deleteDirectory($file){

		//get file



		if($this->file_system->exists($file)){

			$file_dir = dirname($file);

			$clean = $this->file_system->deleteDirectory($file_dir);

			return $clean;
		}

		return false;

	}

}